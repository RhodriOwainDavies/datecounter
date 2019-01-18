<?php

/**
 * Class DateCalculator
 * 
 * @author Rhodri Davies <texasradioband@hotmail.com>
 */
class DateCalculator{
	
    /**
     * Number of seconds in a minute
     * 
     * int
     */
    const SECONDS_IN_MINUTE = 60;
    
    /**
     * Number of seconds in an hour
     * 
     * int
     */    
    const SECONDS_IN_HOUR = 3600;
    
    /**
     * Number of seconds in a day
     * 
     * int
     */    
    const SECONDS_IN_DAY = 86400;
    
    /**
     * Number of seconds in a week
     * 
     * int
     */    
    const SECONDS_IN_WEEK = 604800;
    
    /**
     * Number of seconds in a year
     * 
     * int
     */    
    const SECONDS_IN_YEAR = 31557600;
    
    /**
     * Number of week days in a week
     * 
     * int
     */
    const WEEKDAYS_IN_WEEK = 5;

    /**
     * Number of days in a week
     * 
     * int
     */
    const DAYS_IN_WEEK = 7;
    
    /**
     * First day of the week in PHP date('N') format (Sunday)
     * 
     * int
     */
    const FIRST_DAY_OF_WEEK = 7;

    /**
     * Start date time in unix epoch
     * 
     * int
     */
    private $start;

    /**
     * End date time in unix epoch 
     * 
     * int
     */
    private $end;

    /**
     * DateCalculator class constructor
     * 
     * @param string $start start date in the PHP date format d/m/Y
     * @param string $end end date in the PHP date format d/m/Y
     * @param string $startTimezone name of start timezone
     * @param string $endTimezone name of end timezone
     */
    function __construct($start, $end, $startTimezone, $endTimezone) {
        //use utc to figure out individual offsets
        $utc = new DateTime();
        
        $startOffset = timezone_offset_get(timezone_open($startTimezone), $utc);
        $endOffset = timezone_offset_get(timezone_open($endTimezone), $utc);
        
        $startParts = explode('/', $start);
        $endParts = explode('/', $end);
        
        $startTimestamp = mktime(0, 0, $startOffset, $startParts[1], $startParts[0], $startParts[2]);
        $endTimestamp = mktime(0, 0, $endOffset, $endParts[1], $endParts[0], $endParts[2]);

        //allow date values to be passed in, in either order
        if ($startTimestamp < $endTimestamp){
            $this->start = $startTimestamp;
            $this->end = $endTimestamp;
        } else {
            $this->start = $endTimestamp;
            $this->end = $startTimestamp;
        }
    }
	
    /**
     * Get number of days between start and end date
     * 
     * @param string $unit
     * @return int
     */
    public function getNumberOfDays($unit = 'days'){
        //incremement by one to make it inclusive of both dates
        return $this->convertTimeUnit(
            ($this->end - $this->start) + self::SECONDS_IN_DAY,
            $unit
        );
    }

    /**
     * Get number of week days between start and end date
     * 
     * @param string $unit
     * @return int
     */
    public function getNumberOfWeekdays($unit = 'days') {
        $difference = $this->end - $this->start;
        if ($difference < self::SECONDS_IN_WEEK) {
            //less than one week +1 to be inclusive of start and end dates
            $noOfWeekdays = ($difference / (self::SECONDS_IN_DAY)) + 1;
        } else {
            //find first monday after start date
            $startDayOfWeek = date('N', $this->start);
            if ($startDayOfWeek != 1) {
                $firstMonday = $this->start 
                    + ((8 - $startDayOfWeek) * self::SECONDS_IN_DAY);
            } else {
                $firstMonday = $this->start;
            }

            //find the last Friday before end date
            $endDayOfWeek = date('N', $this->end);
            if ($endDayOfWeek != 5) {
                $lastFriday = $this->end
                    + ((-2 - $endDayOfWeek) * self::SECONDS_IN_DAY);
            } else {
                $lastFriday = $this->end;
            }

            $startSunday = $firstMonday - self::SECONDS_IN_DAY;
            $endSunday = $lastFriday + (2 * self::SECONDS_IN_DAY);
            
            $noOfWeekdays = self::WEEKDAYS_IN_WEEK * 
                    ((($endSunday - $startSunday) / self::SECONDS_IN_DAY)) 
                    / self::DAYS_IN_WEEK;

            if (date('N', $this->start) != 1) {
                $noOfWeekdays += (6 - date('N', $this->start)) ;
            }
            if (date('N', $this->end) != 5) {
                $noOfWeekdays += (date('N', $this->end));
            }
        }
        return $this->convertTimeUnit(
            $noOfWeekdays * self::SECONDS_IN_DAY,
            $unit
        );
    }

    /**
     * Get number of complete weeks between start and end date
     * 
     * @param string $unit
     * @return int
     */
    public function getNumberOfCompleteWeeks($unit = 'weeks') {
        $weeks = floor($this->getNumberOfDays() / self::DAYS_IN_WEEK);
        //return $weeks;
        return $this->convertTimeUnit(
            $weeks * self::SECONDS_IN_WEEK,
            $unit
        );
    }
    
    /**
     * Convert time unit
     * 
     * @param int $time 
     * @param string $unit
     * @return int
     */
    public function convertTimeUnit($time, $unit='seconds'){
        switch($unit){
            default:
                return $time;
                break;
            case 'minutes':
                return $time / self::SECONDS_IN_MINUTE;
                break;
            case 'hours':
                return $time / self::SECONDS_IN_HOUR;
                break;
            case 'days':
                return $time / self::SECONDS_IN_DAY;
                break;
            case 'weeks':
                return $time / self::SECONDS_IN_WEEK;
                break;
            case 'years':
                return $time / self::SECONDS_IN_YEAR;
                break;
        } 
    }   
}