<?php

require_once("../grima-lib.php");

class DisplayItem extends GrimaTask {

	function do_task() {

		$this->item = new Item();
		$this->item->loadFromAlmaBarcode($this['unboxed_barcode']);
		//For future testing to combine both grimas into one file-red 01/2020
		/*if (isset($this['adding']) and ($this['adding'] == "true")) {
			foreach ($this->item as $barcode) {
			$this->item = new Item();
			$this->item->loadFromAlmaBarcode($this['next_barcode']);
			$item['internal_note_3'] = ('Inventory Date:').date("m/d/Y");
			$item['inventory_number'] = ('Inventory Date:').date("m/d/Y");
			$item['inventory_date'] = date("Y-m-d");
			$item->updateAlma();
	}
		}*/
		$this->splatVars['item'] = $this->item;
}
}

DisplayItem::RunIt();
