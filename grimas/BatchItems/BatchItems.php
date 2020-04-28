<?php

require_once("../grima-lib.php");

class BatchItems extends GrimaTask {
	public $biblist = array();

	function do_task() {
		$this->holdings = preg_split('/\r\n|\r|\n/',$this['holding_id']);

		foreach ($this->holdings as $holdingid) {
			$this->holding = new Holding();
			$this['mms_id'] = Holding::getMmsFromHoldingID($holdingid);
			$this->holding->loadFromAlma($this['mms_id'],$holdingid);
			$this->holding->getItems();
			$this->splatVars['holding'] = $this->holding;
			$this->holdinglist[] = $holding;
		}
		/*$this->splatVars['width'] = 12;
		$this->splatVars['holdinglist'] = $this->holdinglist;
		$this->splatVars['body'] = array( 'list', 'messages' );*/
	}
}
BatchItems::RunIt();
