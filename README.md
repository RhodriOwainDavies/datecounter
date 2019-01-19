# A Date Calculator Exercise

## Pre-requisites

Webserver e.g. Apache
PHP
Composer (to run tests)

## Installation

1. Clone the repository visit the webroot in your browser, you should see a form
1. Choose a date in both date fields using the calendar
1. Choose a timezone in both timezone select fields
1. Choose an unit for additional output
1. Submit form and check values below

## The Challenge

1. Find out the number of days between two datetime parameters.
1. Find out the number of weekdays between two datetime parameters.
1. Find out the number of complete weeks between two datetime parameters.
1. Accept a third parameter to convert the result of (1, 2 or 3) into one of seconds, minutes, hours, years.
1. Allow the specification of a timezone for comparison of input parameters from different timezones.

## The Solution

1. PHP / Web front-end using JS calendar plug-in
1. Submit form to perform calculation
1. Instantiate DateCalulator Class
1. Call relevant functions

## Run tests

1. Navigate in terminal to webroot
1. Run `composer install`
1. Run `vendor/phpunit/phpunit/phpunit tests/DateCalculatorTest.php`

## Possible improvements

1. Further PHPUnit Tests
1. PHPDoc
1. Re-visit algorithm to improve performance
1. Improve interface with CSS
1. Read default values from a configuration file
