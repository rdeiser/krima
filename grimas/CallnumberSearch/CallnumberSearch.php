<?php

require_once("../grima-lib.php");

class CallnumberSearch extends GrimaTask {

	function do_task() {
		$this->item = new Item();
		//$this->holding = new Holding();
		//$this['holding_id'] = Holding::getHoldingIDFromCallnumber($this['callnumber']);
		//$this['mms_id'] = Holding::getMMSIDFromCallnumber($this['callnumber']);
		$itemid = $item->getHoldingIDFromCallnumber($this['callnumber']);
		$this->item->loadFromAlmaX($itemid);
		if ($this['callnumber']) {
			$this->holding = new Holding();
			$this->holding->loadFromAlma($item['mms_id'],$item['holding_id']);
			//$this->holding->loadFromAlma($this['mms_id'],$this['holding_id']);
			$this->holding->getItems();
			$this->splatVars['holding'] = $this->holding;
		} else {
			GrimaTask::call('ShowItemsFromHoldingsB', array('holding_id' => ($item['holding_id'])));
		}
	}
}

CallnumberSearch::RunIt();
