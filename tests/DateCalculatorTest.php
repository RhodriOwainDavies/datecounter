<?php
include_once("DateCalculator.class.php");

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
    
    public function testArbitraryTimezones(){
        //could do more complex daylight savings tests here too
        $dateCalculator = new DateCalculator(
            '01/01/2019',
            '01/01/2019',
            'Africa/Cairo',
            'Asia/Bangkok'
        );

        //29 because 24 hours in one day + 5 hours time difference
        $this->assertEquals(29, $dateCalculator->getNumberOfDays('hours'));
    }
    
    public function testLocalTimezones(){
        //pass dates in reverse order as additional test
        $dateCalculator = new DateCalculator(
            '31/12/2018',
            '01/01/2018',
            'Europe/Dublin',
            'Europe/London'
        );

        $this->assertEquals(365, $dateCalculator->getNumberOfDays());
    }
    
}