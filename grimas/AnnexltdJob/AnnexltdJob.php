<?php

require_once("../grima-lib.php");

class AnnexltdJob extends GrimaTask {

	function do_task() {
		//global $grima;
		$job = new Job();
		$job->runAlmaJob('M16545998330002401','run');
		$this->addMessage('success',"Alma Job is running: {$job['additional_info']}");
		$msg = $job['additional_info'];
		mail("rdeiser@ksu.edu","Annexlt Grima",$msg);
		//regex to remove data before and after the Alma Job Number ^(Job no)\.\s|(\s(triggered)\s(on)\s(\w){3}\D\s\d{2}\s(\w){3}\s\d{4}\s(\d{2}\:\d{2}\:\d{2})\s(GMT))
	}
}

AnnexltdJob::RunIt();
