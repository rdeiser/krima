<?php

require_once("../grima-lib.php");

class CallnumberSearch extends GrimaTask {

	function do_task() {
		$this->holding = new Holding();
		$holdingid = Holding::getHoldingIDFromMms($this['call_number']);
		if ($holdingid]) {
			$this->holding->loadFromAlma($holdingid,$holdingid);
			$this->holding->getItems();
			$this->splatVars['holding'] = $this->holding;
		} else {
			GrimaTask::call('ShowItemsFromHoldingsB', array('holding_id' => $holdingid));
		}
	}
}

CallnumberSearch::RunIt();
