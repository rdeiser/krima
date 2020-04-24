<?php

require_once("../grima-lib.php");

class BatchItems extends GrimaTask {
	public $biblist = array();
	
	function do_task() {
		$this->bibs = preg_split('/\r\n|\r|\n/',$this['mms']);

		# BIBS
		foreach ($this->bibs as $mmsid) {
			$bib = new Bib();
			$bib->loadFromAlma($mmsid);
			$this->biblist[] = $bib;
		}

	}

}

BatchItems::RunIt();
