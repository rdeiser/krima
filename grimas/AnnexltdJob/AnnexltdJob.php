<?php

require_once("../grima-lib.php");

class AnnexltdJob extends GrimaTask {

	function do_task() {
		//global $grima;
		$job = new Job();
		$job->jobScheduled591();
		$job->addToAlma();
		$this->addMessage('success',"Alma Job is running");
	}
}

AnnexltdJob::RunIt();
