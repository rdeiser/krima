<?php

require_once("../grima-lib.php");

class NewItem extends GrimaTask {

	function do_task() {
		$holding = new Holding();
		$holding->loadFromAlma($this['holding_id'],$this['holding_id']);
		$item = new Item();
		if (empty($this['copyid'])) {
			$item['copy_id'] = '0';
			} else {
				$item['copy_id'] = $this['copyid'];
			}
			$item['item_policy'] = $this['itempolicy'];
			if (empty($this['pieces'])) {
				$item['pieces'] = '1';
			} else {
				$item['pieces'] = $this['pieces'];
			}
		$item['physical_material_type_code'] = $this['materialtype'];
		$item['inventory_date'] = date("Y-m-d");
		$item['receiving_operator'] = 'Grima';
		$item['public_note'] = $this ['pubnote'];
		$item['fulfillment_note'] = $this['fulnote'];
		$item['statistics_note_1'] = $this['statnote1'];
		$item['statistics_note_2'] = $this['statnote2'];
		$item['statistics_note_3'] = $this['statnote3'];
		$item['barcode'] = $this['barcode'];
		$item->addToAlmaHolding($this['holding_id'],$this['holding_id']);
		// $this->addMessage('success',"Successfully added an Item Record to {$this['holding_id']} with Barcode: {$item['barcode']}");
		$this->splatVars['item'] = $this->item;
	}
}
NewItem::RunIt();
