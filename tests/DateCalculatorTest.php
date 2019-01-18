<?php
include_once("DateCalculator.class.php");
//include_once('../vendor/phpunit/phpunit/src/Framework/TestCase.php');

//  use Framework\TestCase;
use PHPUnit\Framework\TestCase;

class DateCalculatorTest extends TestCase{

    public function testCountDays() {
        $dateCalculator = new DateCalculator(
            '01/01/2019',
            '02/01/2019',
            'UTC',
            'UTC'
        );

        $this->assertEquals(2, $dateCalculator->getNumberOfDays());
    }

    public function testGetWeekdays(){
        $dateCalculator = new DateCalculator(
            '01/01/2019',
            '14/01/2019',
            'UTC',
            'UTC'
        );
        $this->assertEquals(10, $dateCalculator->getNumberOfWeekDays());    
    }

    public function testGetCompleteWeeks(){
        $dateCalculator = new DateCalculator(
            '01/01/2019',
            '14/01/2019',
            'UTC',
            'UTC'
        );

        $this->assertEquals(2, $dateCalculator->getNumberOfCompleteWeeks());           
    }
    
}