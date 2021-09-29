<?php

require_once("../grima-lib.php");

class CallnumberSearch extends GrimaTask {

	function do_task() {
		$this->holding = new Holding();
		//$this['holding_id'] = Holding::getHoldingIDFromCallnumber($this['callnumber']);
		$this->holding->getHoldingIDFromCallnumber($this['callnumber']);
		$mmsid = Holding::getHoldingIDFromCallnumber($this['callnumber']);
		if ($this['callnumber']) {
			$this->holding->loadFromAlma($mmsid,$this->holding->getHoldingIDFromCallnumber($this['callnumber']));
			$this->holding->getItems();
			$this->splatVars['holding'] = $this->holding;
		} else {
			GrimaTask::call('ShowItemsFromHoldingsB', array('holding_id' => $this['callnumber']));
		}
	}
}

CallnumberSearch::RunIt();
