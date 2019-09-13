<?php

namespace login\view;

class DateTimeView {


	public function show() {

		$dayOfWeek = date('l');
		$currentDateOfMonth = date('dS');
		$currentMonth = date('F');
		$currentYear = date('Y');
		$currentTime = date('H:i:s');

		$timeString = "$dayOfWeek, the $currentDateOfMonth of $currentMonth $currentYear, The time is $currentTime";

		return '<p>' . $timeString . '</p>';
	}
}