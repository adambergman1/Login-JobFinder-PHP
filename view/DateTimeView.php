<?php

class DateTimeView {


	public function show() {

		$timeString = date('Y-m-d - H:i');

		return '<p>' . $timeString . '</p>';
	}
}