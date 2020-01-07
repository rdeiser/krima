<?php

require_once("../grima-lib.php");

class DisplayItem extends GrimaTask {

	function do_task() {

		$this->item = new Item();
		$this->item->loadFromAlmaBarcode($this['unboxed_barcode']);
		
		if (isset($this['adding']) and ($this['adding'] == "true")) {
			$this->item = new Item();
			$this->item->loadFromAlmaBarcode($this['unboxed_barcode']);
			$item['internal_note_3'] = ('Inventory Date:').date("m/d/Y");
			$item['inventory_number'] = ('Inventory Date:').date("m/d/Y");
			$item['inventory_date'] = date("Y-m-d");
			$ret = $item->updateAlma();
			$this->item = new Item();
			$this->item->exml = $ret;
		}
		
		$this->splatVars['item'] = $this->item;
	}

}

DisplayItem::RunIt();
