<?php

/**
 *
 */
class DateCalculator{
	
    /**
     *
     */
    const SECONDS_IN_MINUTE = 60;
    const SECONDS_IN_HOUR = 3600;
    const SECONDS_IN_DAY = 86400;
    const SECONDS_IN_WEEK = 604800;
    const SECONDS_IN_YEAR = 31557600;
    
    const WEEKDAYS_IN_WEEK = 5;
    const DAYS_IN_WEEK = 7;
    
    /**
     *
     */
    const FIRST_DAY_OF_WEEK = 7;//Sunday in date('N')

    /**
     * 
     */
    private $start;

    /**
     *
     */
    private $end;

    /**
     *
     */
    function __construct($start, $end, $startTimezone, $endTimezone) {
        //use utc to figure out individual offsets
        $utc = new DateTime();

        $startOffset = timezone_offset_get(timezone_open($startTimezone), $utc);
        $endOffset = timezone_offset_get(timezone_open($endTimezone), $utc);
        
        $startParts = explode('/', $start);
        $endParts = explode('/', $end);
        
        //assumme date passed in correctly as dd/mm/yyyy
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
        echo "<h6>Start</h6><p>".date('H:i:s d/m/Y', $this->start)."</p>";
        echo "<h6>End</h6><p>".date('H:i:s d/m/Y', $this->end)."</p>";
    }
	
    /**
     * Get number of days between start and end date
     * 
     * @param type $unit
     * @return type
     */
    public function getNumberOfDays($unit = 'days'){
        //incremement by one to make it inclusive of both dates
        $numberOfDays = (($this->end - $this->start) / self::SECONDS_IN_DAY) + 1;
        
        return $this->convertTimeUnit(
            ($this->end - $this->start) + self::SECONDS_IN_DAY,
            $unit
        );
    }

    /**
     * Get number of week days between start and end date
     * 
     * @param type $unit
     * @return type
     */
    public function getWeekdays($unit = 'days') {
        $difference = $this->end - $this->start;
        if ($difference < self::SECONDS_IN_WEEK) {
            //less than one week +1 to be inclusive of start and end dates
            $noOfWeekdays = ($difference / (self::SECONDS_IN_DAY)) + 1;
        } else {
            //find first monday after start date
            $startDayOfWeek = date('N', $this->start);
            if ($startDayOfWeek != 1) {
                    $firstMonday = $this->start + ((8 - $startDayOfWeek) * self::SECONDS_IN_DAY);
            } else {
                    $firstMonday = $this->start;
            }

            //find the last Friday before end date
            $endDayOfWeek = date('N', $this->end);
            if ($endDayOfWeek != 5) {
                $lastFriday = $this->end + ((-2 - $endDayOfWeek) * self::SECONDS_IN_DAY);
            } else {
                $lastFriday = $this->end;
            }

            $startSunday = $firstMonday - self::SECONDS_IN_DAY;
            $endSunday = $lastFriday + (2 * self::SECONDS_IN_DAY);

            $noOfWeekdays = (self::WEEKDAYS_IN_WEEK * ((($endSunday - $startSunday) / self::SECONDS_IN_DAY)) / 7);

            if (date('N', $this->start) != 1) {
                $noOfWeekdays += (6 - date('N', $this->start)) ;
            }
            if (date('N', $this->end) != 5) {
                $noOfWeekdays += (date('N', $this->end));
            }
        }
        
        return $this->convertTimeUnit($noOfWeekdays * self::SECONDS_IN_WEEK, $unit);
    }

    /**
     * get number of complete weeks between start and end date
     * 
     * @param type $unit
     * @return type
     */
    public function getCompleteWeeks($unit = 'weeks') {
        return $this->convertTimeUnit(
            floor($this->getNumberOfDays('seconds') / self::DAYS_IN_WEEK),
            $unit
        );
    }
    
    /**
     * 
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
            case 'years':
                return $time / self::SECONDS_IN_YEAR;
                break;
        } 
    }   
}