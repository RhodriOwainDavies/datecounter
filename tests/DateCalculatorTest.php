<?php
include_once("DateCalculator.class.php");
//include_once('../vendor/phpunit/phpunit/src/Framework/TestCase.php');

//  use Framework\TestCase;
use PHPUnit\Framework\TestCase;

class DateCalculatorTest extends TestCase{

    public function testCountDays() {
        $dateCalculator = new DateCalculator(
            date('U', strtotime('yesterday')),
            date('U', strtotime('today'))
        );

        $this->assertEquals(2, $dateCalculator->getNumberOfDays());
    }

    public function testGetWeekdays(){
        $dateCalculator = new DateCalculator(
            date('U', strtotime('01/01/2019')),
            date('U', strtotime('01/14/2019'))
        );
        echo $dateCalculator->getWeekDays();
        $this->assertEquals(10, $dateCalculator->getWeekDays());    
    }

    public function testGetCompleteWeeks(){
        $dateCalculator = new DateCalculator(
            date('U', strtotime('01/01/2019')),
            date('U', strtotime('01/14/2019'))
        );

        $this->assertEquals(2, $dateCalculator->getCompleteWeeks());           
    }
}