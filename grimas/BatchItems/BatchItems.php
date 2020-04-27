<?php

require_once("../grima-lib.php");

class BatchItems extends GrimaTask {
	public $holdinglist = array();
	
	function do_task() {
		$this->holdings = preg_split('/\r\n|\r|\n/',$this['mfhd']);
		foreach ($this->holding as $holding) {
			$holding = new Holding();
			$holding->loadFromAlma('holding_id');
			$this->holdinglist[] = $holding;
		}
		
		$this->splatVars['holdinglist'] = $this->holdinglist;
		$this->splatVars['body'] = array( 'list', 'messages' );
	}

}
BatchItems::RunIt();
