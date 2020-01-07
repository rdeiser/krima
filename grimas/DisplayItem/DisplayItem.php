<?php

require_once("../grima-lib.php");

class DisplayItem extends GrimaTask {

	function do_task() {

		$this->item = new Item();
		$this->item->loadFromAlmaBarcode($this['unboxed_barcode']);
		$this->splatVars['item'] = $this->item;
	}

}

DisplayItem::RunIt();
