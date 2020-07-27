<?php
require_once("../grima-lib.php");

class ScanInReturn extends GrimaTask {

	function do_task() {
		$item = new Item();
		$item->loadFromAlmaBarcode($this['barcode']);
		
		scan_in($this->item->barcode);
	}
}

ScanInReturn::RunIt();