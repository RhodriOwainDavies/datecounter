<?php

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
		//find number of complete work weeks
		$noOfWorkWeeks = $this->getCompleteWorkWeeks();
		
		//both dates in same week
		if ($noOfWorkWeeks == 0) {
			$noOfWeekdays = date('N', $this->end) - date('N', $this->start) + 1;
		} else {
			$noOfWeekdays = (5 * $noOfWorkWeeks);

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
				return $weeks * 24;
				break;				
			case 'years':
				return $weeks / 365;
				break;
		}
	}

	public function getCompleteWorkWeeks($unit = 'weeks') {
		//find the first Monday after $start
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
				- (7 * self::SECONDS_IN_DAY)
				+ ((5 - $endDayOfWeek) * self::SECONDS_IN_DAY);
			$lastFriday = $this->end
				+ ((-2 - $endDayOfWeek) * self::SECONDS_IN_DAY);

		} else {
			$lastFriday = $this->end;
		}
	
		$startSunday = $firstMonday - self::SECONDS_IN_DAY;
	
		$endSunday = $lastFriday + (2 * self::SECONDS_IN_DAY);
	
		if (($lastFriday - $firstMonday) <= 0) {
			return 0;
		}
		$workWeeks = ((($endSunday - $startSunday) / self::SECONDS_IN_DAY)) / 7;
		 
		switch($unit){
			default:
				return $workWeeks;
				break;
			case 'seconds':
				return $workWeeks * 60 * 60 * 24;
				break;
			case 'minutes':
				return $workWeeks * 60 * 24;
				break;
			case 'hours':
				return $workWeeks * 24;
				break;				
			case 'years':
				return $workWeeks / 365;
				break;
		} 
	}
}