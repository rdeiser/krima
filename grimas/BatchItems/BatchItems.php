<?php

require_once("../grima-lib.php");

class BatchItems extends GrimaTask {
	public $holdinglist = array();
	
	function do_task() {
		$this->holdings = preg_split('/\r\n|\r|\n/',$this['mfhd']);
		foreach ($this->holding as $holdingid) {
			$holding = new Holding();
			$holding->loadFromAlma($holdingid);
			$this->holdinglist[] = $holding;
		}
		
		$this->splatVars['holding'] = $this->holding;
	}

}
BatchItems::RunIt();
