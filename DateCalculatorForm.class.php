<?php

/**
 * 
 */
class DateCalculatorForm{

    const UTC_TIMEZONE_VALUE = 424;
    const DEFAULT_UNIT_VALUE = 'seconds';
    
    const DEFAULT_START_DATE = '01/01/2018';
    const DEFAULT_END_DATE = '01/01/2019';
    
    public $startDate;
    public $endDate;
    public $startTimezone;
    public $endTimezone;
    
    public $timezones;
    
    /**
     * DateCalculatorForm Constructor
     * 
     * @param type $startDate
     * @param type $endDate
     * @param string $startTimezone
     * @param string $endTimezone
     */
    function __construct(
        $startDate = null,
        $endDate = null,
        $startTimezone = null,
        $endTimezone = null,
        $unit = null
    ) {
        if(!isset($startDate)) {
            $startDate = date('d/m/Y', strtotime('01/01/2019'));
        }
        if(!isset($endDate)) {
            $endDate = date('d/m/Y', strtotime('today'));
        }
        if(!isset($startTimezone)) {
            $startTimezone = self::UTC_TIMEZONE_VALUE;
        }
        if(!isset($endTimezone)) {
            $endTimezone = self::UTC_TIMEZONE_VALUE;
        }
        if(!isset($unit)){
            $unit = self::DEFAULT_UNIT_VALUE;
        }
        
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->startTimezone = $startTimezone;
        $this->endTimezone = $endTimezone;
        $this->unit = $unit;
    }
    
    function getStartDate(){
        return $this->startDate;
    }
    
    function getEndDate(){
        return $this->endDate;
    }
    
    function getStartTimezone($return = 'key'){
        if($return == 'key'){
            return $this->startTimezone;
        } else {
            return $this->timezones[$this->startTimezone];
        }
    }
    
    function getEndTimezone($return = 'key'){
        if($return == 'key'){
            return $this->endTimezone;
        } else {
            return $this->timezones[$this->endTimezone];
        }
    }
    
    function getUnit(){
        return $this->unit;
    }
    
    function getTimezones(){
        if(!isset($this->timezones)){
            $this->timezones = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
        }
        return $this->timezones;
    }
}