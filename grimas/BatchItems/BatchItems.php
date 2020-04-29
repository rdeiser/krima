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
			$this->holding->getItems();
			//$this->addToAlmaHolding($this['mms_id'],$holdingid,$item);
			//$this->holding->postItem();
			//$this->holding->getItems();
			$this->holdinglist[] = $holding;
		}
		//foreach ($holding->items as $item) LOOK AT THIS!!!
		/*foreach ($this->holdinglist as $newItem) {
			unset($newItem['item_pid']);
			$newItem->addToAlmaHolding($this['mms_id'],$holdingid,$item);
			$this->item = new Item();*/
			//$item->updateAlma();
		}
		//$this->holding->getItems();
		//$this->splatVars['holding'] = $this->holding;
		//$this->splatVars['width'] = 12;
		$this->splatVars['holdinglist'] = $this->holdinglist;
		$this->splatVars['body'] = array( 'list', 'messages' );*/
	}
}
BatchItems::RunIt();
