<?php

require_once("../grima-lib.php");

class CallnumberSearch extends GrimaTask {

	function do_task() {
		$this->holding = new Holding();
		$this['holding_id'] = Holding::getHoldingIDFromMms($this['call_number']);
		if ($this['holding_id']) {
			$this->holding->loadFromAlma($this['holding_id'],$this['holding_id']);
			$this->holding->getItems();
			$this->splatVars['holding'] = $this->holding;
		} else {
			GrimaTask::call('ShowItemsFromHoldingsB', array('holding_id' => $this['holding_id']));
		}
	}
}

CallnumberSearch::RunIt();
