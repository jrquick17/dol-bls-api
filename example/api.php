<?php
use Encounting\DolBls\DolBlsApi;

function error($error) {
    return response(
        [
            'error' => $error
        ]
    );
}

function response($response) {
    return json_encode($response);
}

function handle() {
    if (array_key_exists('keys', $_GET)) {
        $api = new DolBlsApi($_GET['keys']);

        if (array_key_exists('action', $_GET)) {
            switch($_GET['action']) {
                case 'latest':
                    if (array_key_exists('series', $_GET)) {
                        $response = $api->getLatest($_GET['series']);
                    } else {
                        return error('Series ID is required.');
                    }
                    break;
                case 'popular':
                    if (array_key_exists('abbreviation', $_GET)) {
                        $response = $api->getPopularSeries($_GET['abbreviation']);
                    } else {
                        return error('Survey abbreviation is required.');
                    }
                    break;
                case 'series':
                    if (array_key_exists('series', $_GET)) {
                        $response = $api->getSeries($_GET['abbreviation'], 2018, 2018);
                    } else {
                        return error('Series ID is required.');
                    }
                    break;
                case 'survey':
                    if (array_key_exists('abbreviation', $_GET)) {
                        $response = $api->getSurvey($_GET['abbreviation']);
                    } else {
                        return error('Survey abbreviation is required.');
                    }
                    break;
                case 'surveys':
                default:
                    $response = $api->getSurveys();
                    break;
            }

            if ($api->hasErrors()) {
                return error($api->getErrors());
            } else if ($response === false) {
                return error('Someting went wrong.');
            } else {
                return response($response);
            }
        } else {
            return error('Invalid route. Go complain on GitHub; or even better, go fix it yourself.');
        }
    } else {
        return error('Please enter one or more keys before making a request.');
    }
}

echo json_encode(handle());