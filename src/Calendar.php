<?php namespace Sukohi\Ceasar;

use Carbon\Carbon;

class Calendar extends Carbon {

	private $calendar_type,
			$view = '';

	public function __construct($time, $type, $tz)
	{
		parent::__construct($time, $tz);
		$this->calendar_type = $type;
	}

	public function getView() {

		return $this->view;

	}

	// Override

	public function __set($name, $value)
	{
		try {

			parent::__set($name);

		} catch (\Exception $e) {

			if($name == 'view') {

				$this->view = $value;

			} else {

				throw new \InvalidArgumentException(sprintf("Unknown setter '%s'", $name));

			}

		}

	}

	public function __get($name) {

		try {

			return parent::__get($name);

		} catch (\Exception $e) {

			return ($name == 'is'. $this->calendar_type);
			throw new \InvalidArgumentException(sprintf("Unknown getter '%s'", $name));

		}

	}

}