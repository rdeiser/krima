<?php

require_once("../grima-lib.php");

class BatchItems extends GrimaTask {
	//public $holdinglist = array();
	
	function do_task() {
		$this->holdings = preg_split('/\r\n|\r|\n/',$this['holding_id']);
		foreach ($this->holding as $mfhd) {
			$holding = new Holding();
			$holding->loadFromAlma('mfhd');
			$this->holdinglist[] = $holding;
		}
		$this->splatVars['width'] = 12;
		$this->splatVars['holdinglist'] = $this->holdinglist;
		$this->splatVars['body'] = array( 'list', 'messages' );
	}
}
BatchItems::RunIt();
