<?php

require_once("../grima-lib.php");

class DisplayItem extends GrimaTask {

	function do_task() {

		$this->item = new Item();
		$this->item->loadFromAlmaBarcode($this['unboxed_barcode']);
		$item->updateAlma();
		
		if (isset($this['adding']) and ($this['adding'] == "true")) {
			$this->item = new Item();
			$this->item->loadFromAlmaBarcode($this['unboxed_barcode']);
			$item['internal_note_3'] = ('Inventory Date:').date("m/d/Y");
			$item['inventory_number'] = ('Inventory Date:').date("m/d/Y");
			$item['inventory_date'] = date("Y-m-d");
		}
		
		$this->splatVars['item'] = $this->item;
	}

}

DisplayItem::RunIt();
