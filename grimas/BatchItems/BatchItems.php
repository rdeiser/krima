<?php

require_once("../grima-lib.php");

class BatchItems extends GrimaTask {
	public $holdinglist = array();

	function do_task() {
		$this->holdings = preg_split('/\r\n|\r|\n/',$this['holding_id']);

		foreach ($this->holdings as $holdingid) {
			$this->holding = new Holding();
			$this['mms_id'] = Holding::getMmsFromHoldingID($holdingid);
			$this->holding->loadFromAlma($this['mms_id'],$holdingid);
			//$this->holding->getItems();
			$this->holdinglist[] = $holding;
		}

		foreach ($this->holdinglist as $holding) {
			$newItem->addToAlmaHolding($this->item['mms_id'],$this->item[$holdingid]);
			$this->item = new Item();
			$holding->updateAlma();
		}
			$this->splatVars['holding'] = $this->holding;
		/*$this->splatVars['width'] = 12;
		$this->splatVars['holdinglist'] = $this->holdinglist;
		$this->splatVars['body'] = array( 'list', 'messages' );*/
	}
}
BatchItems::RunIt();
