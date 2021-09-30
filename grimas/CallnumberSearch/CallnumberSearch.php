<?php

require_once("../grima-lib.php");

class CallnumberSearch extends GrimaTask {

	function do_task() {
		$this->holding = new Holding();
		$this['holding_id'] = Holding::getHoldingIDFromCallnumber($this['callnumber']);
		$this['mms_id'] = Holding::getHoldingIDFromCallnumber($this['holding_id']);
		//$this->holding->getHoldingIDFromCallnumber($this['callnumber']);
		if ($this['callnumber']) {
			$this->holding->loadFromAlma($this['mms_id'],$this['holding_id']);
			$this->holding->getItems();
			$this->splatVars['holding'] = $this->holding;
		} else {
			GrimaTask::call('ShowItemsFromHoldingsB', array('holding_id' => ($this['holding_id']));
		}
	}
}

CallnumberSearch::RunIt();
