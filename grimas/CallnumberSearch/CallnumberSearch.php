<?php

require_once("../grima-lib.php");

class CallnumberSearch extends GrimaTask {

	function do_task() {
		$this->holding = new Holding();
		$this['holding_id'] = Holding::getMmsFromHoldingID($this['callnumber']);
		if ($this['callnumber']) {
			GrimaTask::call('ShowItemsFromHoldings', array('holding_id' => $this['holding_id']));
		} else {
			GrimaTask::call('ShowItemsFromHoldingsB', array('holding_id' => $this['holding_id']));
		}
	}
}

CallnumberSearch::RunIt();
