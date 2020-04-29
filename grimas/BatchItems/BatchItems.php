<?php

require_once("../grima-lib.php");

class BatchItems extends GrimaTask {
	public $holdinglist = array();

	function do_task() {
		$this->holdings = preg_split('/\r\n|\r|\n/',$this['holding_id']);

		foreach ($this->holdings as $holdingid) {
			$holding = new Holding();
			$this['mms_id'] = Holding::getMmsFromHoldingID($holdingid);
			$holding->loadFromAlma($this['mms_id'],$holdingid);
			//$this->addToAlmaHolding($this['mms_id'],$holdingid,$item);
			//$this->holding->postItem();
			$this->holdinglist[] = $holding;
		}
		foreach ($this->holdinglist as $item{
			//$item = new Item();
			//$item['barcode'] = '';
			$item->addToAlmaHolding($this['mms_id'],$holding['holding_id']);
		}

		/*foreach ($this->holdinglist as $holding){
			$this->holding->getItems();
		}*/

		//foreach ($holding->items as $item) LOOK AT THIS!!!
		/*foreach ($this->holdinglist as $newItem) {
			unset($newItem['item_pid']);
			$newItem->addToAlmaHolding($this['mms_id'],$holdingid,$item);
			$this->item = new Item();
			//$item->updateAlma();
		}*/
		//$this->holding->getItems();
		//$this->splatVars['holding'] = $this->holding;
		//$this->splatVars['width'] = 12;
		$this->splatVars['holdinglist'] = $this->holdinglist;
		$this->splatVars['body'] = array( 'holding', 'messages' );
	}
}
BatchItems::RunIt();
