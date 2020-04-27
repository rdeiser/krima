<?php

require_once("../grima-lib.php");

class BatchItems extends GrimaTask {
	public $holdinglist = array();
	
	function do_task() {
		$this->mfhd = preg_split('/\r\n|\r|\n/',$this['mfhd']);

		# BIBS
		foreach ($this->holdings as $mfhd) {
			$holding = new Holding();
			$holding->loadFromAlma($this['holding_id']);
			$this->holdinglist[] = $holding;
		}

		$this->splatVars['holding'] = $this->holding;


	}
}
BatchItems::RunIt();
