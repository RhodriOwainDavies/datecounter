<?php

/**
 *
 */
class DateCalculator{
	
	/**
	 *
	 */
	const SECONDS_IN_DAY = 86400;
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
	function __construct($start, $end) {
        $this->start = $start;
        $this->end = $end;
    }
	
	/**
	 *
	 */
	public function getNumberOfDays($unit = 'days'){
		//Incremement by one to make it inclusive of both dates
		$numberOfDays = (($this->end - $this->start) / self::SECONDS_IN_DAY) + 1;
		switch($unit){
			default:
				return $numberOfDays;
				break;
			case 'seconds':
				return $numberOfDays * 60 * 60 * 24;
				break;
			case 'minutes':
				return $numberOfDays * 60 * 24;
				break;
			case 'hours':
				return $numberOfDays * 24;
				break;				
			case 'years':
				return $numberOfDays / 365;
				break;
		}
	}

	/**
	 *
	 */
	public function getWeekdays($unit = 'days') {
		
		if ($this->end - $this->start < (self::SECONDS_IN_DAY * 7)) {
			//less than one week
			$noOfWeekdays = (($this->end - $this->start) / (self::SECONDS_IN_DAY)) + 1;
		} else {
			//find first monday after $this->start
			$startDayOfWeek = date('N', $this->start);
			if ($startDayOfWeek != 1) {
				$firstMonday = $this->start + ((8 - $startDayOfWeek) * self::SECONDS_IN_DAY);
			} else {
				$firstMonday = $this->start;
			}

			//find the last Friday before $end
			$endDayOfWeek = date('N', $this->end);
			if ($endDayOfWeek != 5) {
				$lastFriday = $this->end
					+ ((-2 - $endDayOfWeek) * self::SECONDS_IN_DAY);

			} else {
				$lastFriday = $this->end;
			}
			
			$startSunday = $firstMonday - self::SECONDS_IN_DAY;
			$endSunday = $lastFriday + (2 * self::SECONDS_IN_DAY);
				
			$noOfWeekdays = (5 * ((($endSunday - $startSunday) / self::SECONDS_IN_DAY)) / 7);

			if (date('N', $this->start) != 1) {
				$noOfWeekdays += (6 - date('N', $this->start)) ;
			}
			if (date('N', $this->end) != 5) {
				$noOfWeekdays += (date('N', $this->end));
			}
		}

		switch($unit){
			default:
				return $noOfWeekdays;
				break;
			case 'seconds':
				return $noOfWeekdays * 60 * 60 * 24;
				break;
			case 'minutes':
				return $noOfWeekdays * 60 * 24;
				break;
			case 'hours':
				return $noOfWeekdays * 24;
				break;				
			case 'years':
				return $noOfWeekdays / 365;
				break;
		}
	}

	/**
	 *
	 */
	public function getCompleteWeeks($unit = 'weeks') {
		$weeks = floor($this->getNumberOfDays() / 7);

		switch($unit){
			default:
				return $weeks;
				break;
			case 'seconds':
				return $weeks * 60 * 60 * 24;
				break;
			case 'minutes':
				return $weeks * 60 * 24;
				break;
			case 'hours':
				return $weeks * 24 * 7;
				break;				
			case 'years':
				return $weeks / 365;
				break;
		}
	}
}