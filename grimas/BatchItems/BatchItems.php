<?php

require_once("../grima-lib.php");

class BatchItems extends GrimaTask {

	function do_task() {
		$this->holdings = preg_split('/\r\n|\r|\n/',$this['holding_id']);
		foreach ($this->holdings as $mfhd) {
			$holding = new Holding();
			$holding['mms_id'] = Holding::getMmsFromHoldingID($holding['holding_id']);
			$holding->holding->loadFromAlma($this['mms_id'],$this[$mfhd]);
			$this->holdinglist[] = $holding;
		}
		/*$this->splatVars['width'] = 12;
		$this->splatVars['holdinglist'] = $this->holdinglist;
		$this->splatVars['body'] = array( 'list', 'messages' );*/
	}
}
BatchItems::RunIt();
