<?php

require_once("../grima-lib.php");

class NewItem extends GrimaTask {

	function do_task() {
		$this->holdings = preg_split('/\r\n|\r|\n/',$this['holding_id']);
		foreach ($this->holdings as $holdingid) {
			$holding = new Holding();
			$holding->loadFromAlma($holdingid,$this['mms_id']);
			$this['mms_id'] = Holding::getMmsFromHoldingID($holdingid);
			if ($this['mmsid']) {
				$holding->loadFromAlma($this['mms_id'],$holdingid);
				$holding->loadFromAlma($this['mms_id'],$holdingid);
				$item = new Item();
				//$item['copy_id'] = $this['copyid'];
				$item['item_policy'] = $this['itempolicy'];
				$item['pieces'] = $this['pieces'];
				$item['public_note'] = $this ['pubnote'];
				$item['fulfillment_note'] = $this['fulnote'];
				$item['statistics_note_2'] = $this['statnote2'];
				$item['statistics_note_3'] = $this['statnote3'];
				$item['barcode'] = $this['barcode'];
				$item->addToAlmaHolding($mmsid,$this['holding_id']);
				$this->addMessage('success',"Successfully added an Item Record to {$holdingid} with Barcode: {$item['barcode']}");
			} else {
				$this->addMessage('error',"Holding Record Suppressed or no longer active in Alma {$holdingid}");
			}
		}
	}
}

NewItem::RunIt();
