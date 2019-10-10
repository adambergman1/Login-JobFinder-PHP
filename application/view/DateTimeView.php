<?php

namespace application\view;

class DateTimeView {

	public function show() {
		date_default_timezone_set("Europe/Stockholm");
		$dayOfWeek = date('l');
		$currentDateOfMonth = date('jS');
		$currentMonth = date('F');
		$currentYear = date('Y');
		$currentTime = date('H:i:s');

		$timeString = "$dayOfWeek, the $currentDateOfMonth of $currentMonth $currentYear, The time is $currentTime";

		return '<p>' . $timeString . '</p>';
	}
}