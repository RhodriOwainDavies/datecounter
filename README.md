# A Date Calculator Exercise

## Pre-requisites

LAMP stack

## Installation

Clone the repository visit the webroot in your browser

## The Challenge

1. Find out the number of days between two datetime parameters.
1. Find out the number of weekdays between two datetime parameters.
1. Find out the number of complete weeks between two datetime parameters.
1. Accept a third parameter to convert the result of (1, 2 or 3) into one of seconds, minutes, hours, years.
1. Allow the specification of a timezone for comparison of input parameters from different timezones.

## The Solution

1. PHP / Web front-end using JS calendar plug-in
1. Submit form (no validation!) to perform calculation
1. Instantiate DateCalulator Class
1. Call relevant functions

## Run tests

1. run `composer install`
1. run `vendor/phpunit/phpunit/phpunit tests/DateCalculatorTest.php`

## Possible improvements

1. Further Testing
1. General refactor
1. PHPDoc
1. Re-visit algorithm to improve performance
1. Improve interface
1. Implement code re-use for calculating different units 
1. PHPUnit tests
1. Read default values from a configuration file
