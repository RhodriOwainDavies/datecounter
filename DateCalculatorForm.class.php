<?php

/**
 * Class DateCalculatorForm
 * 
 * @author Rhodri Davies <texasradioband@hotmail.com>
 */
class DateCalculatorForm{

    
    const UTC_TIMEZONE_VALUE = 424;
    const DEFAULT_UNIT_VALUE = 'seconds';

    const DEFAULT_START_DATE = '01/01/2018';
    const DEFAULT_END_DATE = '01/01/2019';
    
    const DATE_FORMAT_REGEX = "/^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/[0-9]{4}$/";
    
    public $startDate;
    public $endDate;
    public $startTimezone;
    public $endTimezone;
    
    public $timezones;
    
    public $dateCalculator;
    
    /**
     * DateCalculatorForm class constructor
     * 
     * @param string $startDate
     * @param string $endDate
     * @param string $startTimezone
     * @param string $endTimezone
     * @param string $unit
     */
    function __construct(
        $startDate = null,
        $endDate = null,
        $startTimezone = null,
        $endTimezone = null,
        $unit = null
    ) {
        if(!isset($startDate)) {
            $startDate = date('d/m/Y', strtotime(self::DEFAULT_START_DATE));
        }
        if(!isset($endDate)) {
            $endDate = date('d/m/Y', strtotime(self::DEFAULT_END_DATE));
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
        
        $this->timezones = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
        
        if($this->validate()){
            $this->dateCalculator = new DateCalculator(
                $this->getStartDate(),
                $this->getEndDate(),
                $this->getStartTimezone('value'),
                $this->getEndTimezone('value'),
                $this->getUnit()
            );
        }
    }

    /**
     * Get end date
     * 
     * @return string
     */
    function getStartDate(){
        return $this->startDate;
    }
    
    /**
     * Get end date
     * 
     * @return string
     */
    function getEndDate(){
        return $this->endDate;
    }

    /**
     * Get timezone of start date
     * 
     * @param string $return
     * @return int|string
     */
    function getStartTimezone($return = 'key'){
        if($return == 'key'){
            return $this->startTimezone;
        } else {
            return $this->timezones[$this->startTimezone];
        }
    }
    
    /**
     * Get timezone of end date
     * 
     * @param string $return
     * @return int|string
     */
    function getEndTimezone($return = 'key'){
        if($return == 'key'){
            return $this->endTimezone;
        } else {
            return $this->timezones[$this->endTimezone];
        }
    }
    
    /**
     * Get form unit of measurement
     *
     * @return string
     */
    function getUnit(){
        return $this->unit;
    }

    /**
     * Get timezone data DateTimeZone::listIdentifiers(DateTimeZone::ALL)
     * 
     * @return array
     */
    function getTimezones(){
        return $this->timezones;
    }
    
    /**
     * Validate form data
     *
     * @return bool
     */
    function validate(){
        if(!preg_match(self::DATE_FORMAT_REGEX, $this->getStartDate())){
            return false;
        }
        if(!preg_match(self::DATE_FORMAT_REGEX, $this->getEndDate())){
            return false;
        }
        return true;
    }
    
    /**
     * Get units of time measurement
     * 
     * @return array
     */
    function getUnits(){
        $units = array();
        
        $units['seconds'] = "Seconds";
        $units['minutes'] = "Minutes";
        $units['hours'] = "Hours";
        $units['years'] = "Years";
        
        return $units;
    }
    
    /**
     * Get date calculation data
     * 
     * @return array
     */
    function getDateCalculationData(){
        $data = array();
        
        $data['no_of_days'] = array();
        $data['no_of_week_days'] = array();
        $data['no_of_complete_weeks'] = array();
        
        $noOfDays['label'] = "Number of days";
        $noOfDays['value'] = $this->dateCalculator->getNumberOfDays();
        $noOfDays['default_unit'] = "days";
        $noOfDays['value_in_unit'] =
            $this->dateCalculator->getNumberOfDays($this->getUnit());
        
        $noOfWeekDays['label'] = "Number of week days";
        $noOfWeekDays['value'] = $this->dateCalculator->getNumberOfWeekdays();
        $noOfWeekDays['default_unit'] = "days";
        $noOfWeekDays['value_in_unit'] = 
            $this->dateCalculator->getNumberOfWeekdays($this->getUnit());
        
        $noOfCompleteWeeks['label'] = "Number of complete weeks";
        $noOfCompleteWeeks['value'] = 
            $this->dateCalculator->getNumberOfCompleteWeeks();
        $noOfCompleteWeeks['default_unit'] = "weeks";
        $noOfCompleteWeeks['value_in_unit'] =
            $this->dateCalculator->getNumberOfCompleteWeeks($this->getUnit());
        
        $data['no_of_days'] = $noOfDays;
        $data['no_of_week_days'] = $noOfWeekDays;
        $data['no_of_complete_weeks'] = $noOfCompleteWeeks;
        
        return $data;
    }
}