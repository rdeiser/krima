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
				
				$holding = new Holding();
				$holding->getItemList();
				$item = $holding->itemList->items[0];
				$item['statistics_note_3'] = $this['statnote3'];
					
				$this->addMessage('success',"Successfully added an Item Record to {$holdingid} with Barcode: {$item['barcode']}");
			} else {
				$this->addMessage('error',"Holding Record Suppressed or no longer active in Alma {$holdingid}");
			}
		}
	}
}

NewItem::RunIt();
