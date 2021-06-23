<?php

require_once("../grima-lib.php");

class AnnexltdJob extends GrimaTask {

	function do_task() {
		$job = new Job();
		$job->jobScheduled591();
		$this->addMessage('success',"Alma Job is running");
	}
}

AnnexltdJob::RunIt();
