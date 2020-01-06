<?php

require_once("../grima-lib.php");

class DisplayItem extends GrimaTask {

	function do_task() {
		$item = new Item();
		$item->loadFromAlmaBarcode($this['unboxed_barcode']);
		foreach ($item as $item){
		$item['internal_note_3'] = ('Inventory Date:').date("m/d/Y");
		$item['inventory_number'] = ('Inventory Date:').date("m/d/Y");
		$item['inventory_date'] = date("Y-m-d");
		$item->updateAlma();
		}
		$this->splatVars['item'] = $this->item;
	}
}

DisplayItem::RunIt();
