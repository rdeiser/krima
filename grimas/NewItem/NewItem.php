<?php

require_once("../grima-lib.php");

class NewItem extends GrimaTask {

	function do_task() {
			$holding = new Holding();
			$holding->loadFromAlma($this['mmsid'],$THIS['holding_id']);
			/*$this['mms_id'] = Holding::getMmsFromHoldingID($holdingid);*/
			if ($this['mmsid']) {
				//$holding->loadFromAlma($this['mms_id'],$holdingid);
				$item = new Item();
				$item['copy_id'] = $this['copyid'];
				$item['item_policy'] = $this['itempolicy'];
				$item['fulfillment_note'] = $this['fulnote'];
				$item['statistics_note_2'] = $this['statnote2'];
				$item['statistics_note_3'] = $this['statnote3'];
				$item['barcode'] = $this['barcode'];
				$item->addToAlmaHolding($this['mms_id'],$holdingid);
				$this->addMessage('success',"Successfully added an Item Record to {$holdingid} with Barcode: {$item['barcode']}");
			} else {
				$this->addMessage('error',"Holding Record Suppressed or no longer active in Alma {$holdingid}");
			}
	}
}
NewItem::RunIt();
