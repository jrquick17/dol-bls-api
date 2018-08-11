## Synopsis

Basic wrapper for collecting statistics from the Department of Labor: Bureau of Labor Statistics. 
[See a demo here](https://www.dol-bls-api.jrquick.com)

> Apply for a developer key @ https://data.bls.gov/registrationEngine/

## Code Example

##### Create Instance of API Wrapper
```php
$key = ''; // TODO: Apply for a developer key @ https://data.bls.gov/registrationEngine/
$api = new DolBlsAPi($keys);
```

##### Get List of Surveys
```php
$results = $this->_api->getSurveys();

if ($results) {
    foreach ($results->survey as $survey) {
        // TODO: DO STUFF
    }
} else {
    $errors = $api->getErrors();
}
```

##### Get Survey
```php
$results = $this->_api->getSurvey($abbreviation);

if ($results) {
     $survey = $results->survey[0];
} else {
    $errors = $api->getErrors();
}
 ```

##### Get List of Popular Series
```php
$surveyAbbreviation = 'LA';

$results = $this->_api->getPopularSeries($surveyAbbreviation);
```

##### Get Series
```php
$ids = [
    ''
];

$startYear = 2008; 
$endYear = 2012;

$results = $this->_api->getSeries(
    $ids,
    $startYear,
    $endYear,
    true,
    true
);

if ($results) {
    foreach ($results->series as $series) {
        $catalog = $series->catalog;
        $data = $series->data;
    }
} else {
    $errors = $api->getErrors();
}
```

##### Get Latest of Series
```php
$results = getLatest($seriesId);
if ($results) {
    foreach ($results->series as $series) {
        // TODO: DO STUFF
    }
} else {
    $errors = $api->getErrors();
}
```

## Motivation

I made this project out of personal curiosity, feel free to contribute or send me ideas/improvements (though I cannot promise I will get to it ~~very quickly~~ ever).

## Installation

Provide code examples and explanations of how to get the project.

## API Reference

More to come...

##### To generate documentation:

* [Install composer](https://getcomposer.org/download/)
* composer install
* phpdoc-md generate src/

## Tests

I know, I know. I will get to it _eventually_.

## Contributors

I currently maintain this project alone, you can find more of my projects and contact me on [my website](https://www.jrquick.com). If you would like to be a contributor then please do!

## License

MIT License

>Copyright (c) 2018 Jeremy Quick

>Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

>The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

>THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

## Upcoming

* Generate documentation
* Create demo
* Add to composer
* Install in dol-bls-pull
* Unit tests