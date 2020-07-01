<?php

require_once("../grima-lib.php");

class NewItem extends GrimaTask {
	public $holdinglist = array();

	function do_task() {
		$this->holdings = preg_split('/\r\n|\r|\n/',$this['holding_id']);

		foreach ($this->holdings as $holdingid) {
			$holding = new Holding();
			$holding->loadFromAlma($this['mms'],$holdingid);
			if ($this['mms']) {
				$holding->loadFromAlma($this['mms'],$holdingid);
				$item = new Item();
				$item->addToAlmaHoldingNBC($this['mms'],$holdingid);
				
				$this->addMessage('success',"Successfully added an Item Record to {$holdingid} with PID: {$item['item_pid]}");
			} else {
				$this->addMessage('error',"Holding Record Suppressed or no longer active in Alma {$holdingid}");
			}
		}
	}
}

NewItem::RunIt();
