<?php

require_once("../grima-lib.php");

class AnnexltdJob extends GrimaTask {

	function do_task() {
		//global $grima;
		$job = new Job();
		$job->runAlmaJob('M16545998330002401','run');
		function print_success() {
			XMLtoWeb($this-job->xml);
		}
		//$job->addToAlma();
		//$this->addMessage('success',"Alma Job is running");
	}
}

AnnexltdJob::RunIt();
