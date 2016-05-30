<?php namespace Sukohi\Ceasar;

use Carbon\Carbon;
use Sukohi\Ceasar\Calendar;

class Ceasar {

	private $dt, $tz = null;
	private $render_closure = null;
	private $first_day_of_week = 0;

	public function make($date, $time_zone = null) {

		$this->tz = $time_zone;
		$this->dt = new Carbon($date, $time_zone);
		return $this;

	}

	public function firstDayOfWeek($day_of_week = 0) {

		$this->first_day_of_week =$day_of_week;

	}

	public function render($closure) {

		$this->render_closure = $closure;
		$view = '';

		// Start

		$view .= $this->getCalendarView($this->dt, 'Start');

		// Header

		$view .= $this->getCalendarView($this->dt, 'StartRow');
		$view .= $this->getCalendarView($this->dt, 'Header');
		$view .= $this->getCalendarView($this->dt, 'EndRow');

		// Days of Week

		$week_dt = $this->dt->copy()->startOfMonth();
		$week_dt->subDay($week_dt->dayOfWeek)->addDays($this->first_day_of_week);

		$view .= $this->getCalendarView($week_dt, 'StartRow');

		for($i = 0 ; $i < 7 ; $i++) {

			$view .= $this->getCalendarView($week_dt, 'DayOfWeek');
			$week_dt->addDay();

		}

		$view .= $this->getCalendarView($week_dt, 'EndRow');

		// Days

		$cal_dt = $this->dt->copy()->startOfMonth();
		$sub_days = $cal_dt->dayOfWeek ;

		if($this->first_day_of_week > 0) {

			$sub_days -= $this->first_day_of_week;

			if($sub_days < $this->first_day_of_week) {

				$sub_days += 7;

			}

		}

		$add_days = 5 - $this->dt->copy()->endOfMonth()->dayOfWeek;

		if($this->first_day_of_week > 0) {

			$add_days += $this->first_day_of_week;

		}

		$days_in_month = $cal_dt->daysInMonth;
		$count = $sub_days + $days_in_month + $add_days;
		$cal_dt->subDay($sub_days);
		$days = 0;

		for($i = 0 ; $i <= $count ; $i++) {

			if($days == 0) {

				$view .= $this->getCalendarView($cal_dt, 'StartRow');

			}

			if($this->dt->month == $cal_dt->month) {

				$view .= $this->getCalendarView($cal_dt, 'Day');

			} else {

				if($cal_dt->day == 1 && $cal_dt->dayOfWeek == $this->first_day_of_week) {

					break;

				}

				$view .= $this->getCalendarView($cal_dt, 'Empty');

			}

			$cal_dt->addDay();
			$days++;

			if($days == 7) {

				$days = 0;
				$view .= $this->getCalendarView($cal_dt, 'EndRow');

			}

		}

		// End

		$view .= $this->getCalendarView($this->dt, 'End');
		return $view;

	}

	private function getCalendarView($dt, $type) {

		$closure = $this->render_closure;
		$cal = new Calendar($dt, $type, $this->tz);

		if(is_callable($closure)) {

			return $closure($cal)->getView() ."\n";

		}

		throw new \Exception('This closure is not callable.');

	}

}