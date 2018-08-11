<?php
namespace Encounting\DolBls\Shared\DolBls;

use Encounting\DolBls\Shared\DolBls\Models\DolBlsLatestResults;
use Encounting\DolBls\Shared\DolBls\Models\DolBlsPopularSeriesResults;
use Encounting\DolBls\Shared\DolBls\Models\DolBlsResponse;
use Encounting\DolBls\Shared\DolBls\Models\DolBlsResults;
use Encounting\DolBls\Shared\DolBls\Models\DolBlsSeriesResults;
use Encounting\DolBls\Shared\DolBls\Models\DolBlsSurveyResults;
use Encounting\DolBls\Shared\DolBls\Models\DolBlsSurveysResults;

use SimpleXMLElement;

/**
 * I belong to a class
 */
class DolBlsApi {
    const BASE_URL = 'https://api.bls.gov/publicAPI/v2/';

    const REQUEST_FAIL = 'REQUEST_NOT_PROCESSED';
    const REQUEST_SUCCESS = 'REQUEST_SUCCESS';

    const JSON = 'json';
    const XML = 'xml';

    private $_errors = false;

    private $_keys = false;

    private $_useJson = false;
    private $_useXml = false;

    /**
     * DolBlsApi constructor.
     *
     * @param string|string[]|false $keys The API key provided by DOL BLS
     * @param string|false          $use  Return results in a specific format; options 'json', 'xml', or false for a stdClass
     *
     * @return void
     */
    public function __construct($keys = false, $use = false) {
        $this->_setKeys($keys);
        $this->_setUse($use);
    }

    /**
     * Remove all errors
     *
     * @return void
     */
    private function _clearErrors() {
        $this->_setErrors(false);
    }

    /**
     * @param DolBlsResponse|bool $response
     *
     * @return DolBlsResults|bool
     *
     * @return void
     */
    private function _filterResults($response) {
        $this->_clearErrors();

        if (is_string($response)) {
            $response = json_decode($response);
        }

        if ($response || is_null($response)) {
            if (isset($response->status)) {
                if ($response->status === DolBlsApi::REQUEST_SUCCESS) {
                    if (isset($response->Results)) {
                        return $response->Results;
                    }
                } else if ($response->status === DolBlsApi::REQUEST_FAIL) {
                    error_log('Request failed to DOL BLS.');
                }
            }

            if (isset($response->message) && is_array($response->message) && count($response->message) > 0) {
                return $this->_setErrors(
                    $response->message,
                    function() use ($response) {
                        return $this->_filterResults($response);
                    }
                );
            }
        } else {
            $this->_setErrors('Unable to decode response.');
        }

        return false;
    }

    /**
     * Get the API key
     *
     * @return false|string
     *
     * @return void
     */
    private function _getKey() {
        if (is_array($this->_keys) && count($this->_keys) > 0) {
            return $this->_keys[0];
        }

        return false;
    }

    /**
     * Check if an API key has been set
     *
     * @return bool
     *
     * @return void
     */
    private function _hasKey() {
        return is_array($this->_keys) && count($this->_keys) > 0;
    }

    /**
     * Delete the current key from the array so that the next one is used by default (or none if there are not any left)
     *
     * @return void
     */
    private function _nextKey() {
        if ($this->_hasKey()) {
            array_splice($this->_keys, 0, 1);
        }
    }

    /**
     * Make a request for data from data.bls.gov
     *
     * @param string $url     The data to append to the URL
     * @param string $method  GET, POST, or PUT
     * @param array  $params  The params to pass
     *
     * @return bool|DolBlsResults|mixed
     */
    private function _request($url, $method = "GET", $params = []) {
        $url = DolBlsApi::BASE_URL.$url;

        $params = json_encode($params);

        $contentType = "Content-Type: application/json";
        $contentLength = "Content-Length: " . strlen($params);

        $header = $contentType . "\r\n" . $contentLength . "\r\n";

        $results = file_get_contents(
            $url, null, stream_context_create(
                [
                    "http" => [
                        "method"  => $method,
                        "header"  => $header,
                        "content" => $params
                    ],
                ]
            )
        );

        /** @var DolBlsResponse|bool $results */
        $results = $this->_filterResults($results);

        if ($this->_useJson) {
            $results = json_encode($results);
        } else if ($this->_useXml) {
            $xml = new SimpleXMLElement('<root/>');

            array_walk_recursive(
                json_decode(json_encode($results), true),
                [
                    $xml,
                    'addChild'
                ]
            );

            $results = $xml->asXML();
        }

        return $results;
    }

    /**
     * Set error messages
     *
     * @param bool           $messages The error message(s) to add
     * @param callable|false $callback The function to call on retry
     *
     * @return bool|mixed
     */
    private function _setErrors($messages = false, $callback = false) {
        if (is_bool($messages)) {
            $messages = false;
        } else if (!is_array($messages)) {
            $messages = [ $messages ];
        }

        $this->_errors = $messages;

        if (is_array($this->_errors)) {
            foreach ($this->_errors as $error) {
                error_log($error);

                if (strstr($error, 'daily threshold') && strstr($error, 'reached')) {
                    if ($this->_hasKey() && $callback !== false) {
                        $this->_nextKey();

                        return $callback();
                    } else {
                        die('DAILY THRESHOLD FOR REQUESTS HAS BEEN EXCEEDED. TRY AGAIN TOMORROW OR WITH A NEW KEY');
                    }
                }
            }
        }

        return $this->_errors !== false;
    }

    /**
     * Set the keys
     *
     * @param false|string|string[] $keys
     *
     * @return void
     */
    private function _setKeys($keys) {
        if (!is_bool($keys) && !is_array($keys)) {
            $keys = explode(',', $keys);
        }

        $this->_keys = $keys;
    }

    /**
     * Set whether to use stdClass, JSON, or XML
     *
     * @param string|false $use
     *
     * @return void
     */
    private function _setUse($use) {
        if (is_string($use) && strtolower($use) === DolBlsApi::JSON) {
            $this->_useJson = true;
        } else if (is_string($use) && strtolower($use) === DolBlsApi::XML) {
            $this->_useXml = true;
        }
    }

    /**
     * Get errors
     *
     * @return bool|string[]
     */
    public function getErrors() {
        return $this->_errors;
    }

    /**
     * Get the most recent data point for a given BLS series ids
     *
     * @param string $seriesId The series id to be requested
     *
     * @return bool|DolBlsLatestResults|mixed
     */
    public function getLatest($seriesId) {
        return $this->_request(
            "timeseries/data/{$seriesId}?latest=true"
        );
    }

    /**
     * Get a list of series IDs for the 25 most popular BLS and survey-specific series
     *
     * @param string $surveyAbbreviation The survey abbreviation to get popular series for
     *
     * @return bool|DolBlsPopularSeriesResults|mixed
     */
    public function getPopularSeries($surveyAbbreviation) {
        return $this->_request(
            "timeseries/popular?survey={$surveyAbbreviation}"
        );
    }

    /**
     * Get data for more than one timeseries for the past three years. Registered users can include up to 50 series IDs, each separated with a comma, in the body of a request.
     *
     * @param string|string[] $ids
     * @param string|integer  $startYear
     * @param string|integer  $endYear
     * @param bool            $includeAnnualAverage
     * @param bool            $includeCalculations
     * @param bool            $includeCatalog
     *
     * @return bool|DolBlsSeriesResults|mixed
     */
    public function getSeries($ids, $startYear, $endYear, $includeAnnualAverage = false, $includeCalculations = false, $includeCatalog = false) {
        if (!is_array($ids)) {
            $ids = [ $ids ];
        }

        $params = [
            "seriesid"      => $ids,
            "startyear"     => $startYear,
            "endyear"       => $endYear,
            "annualaverage" => $includeAnnualAverage,
            "calculations"  => $includeCalculations,
            "catalog"       => $includeCatalog
        ];

        if ($this->_hasKey()) {
            $params["registrationkey"] = $this->_getKey();
        }

        return $this->_request(
            "timeseries/data/",
            "POST",
            $params
        );
    }

    /**
     * Get the metadata associated with a single BLS survey. Be sure to include the specific survey abbreviation.
     *
     * @param string $surveyAbbreviation The survey abbreviation to load
     *
     * @return bool|DolBlsSurveyResults|mixed
     */
    public function getSurvey($surveyAbbreviation) {
        return $this->_request(
            "surveys/survey={$surveyAbbreviation}"
        );
    }

    /**
     * Get a list of all BLS surveys.
     *
     * @return false|DolBlsSurveysResults|mixed
     */
    public function getSurveys() {
        return $this->_request(
            "surveys/"
        );
    }

    /**
     * Check if there are any errors
     *
     * @return bool
     */
    public function hasErrors() {
        return !is_bool($this->_errors);
    }
}