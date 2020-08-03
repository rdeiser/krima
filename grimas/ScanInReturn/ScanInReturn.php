<?php
require_once("../grima-lib.php");

class ScanInReturn extends GrimaTask {

	function do_task() {
		$item = new Item();
		$item->loadFromAlmaBarcode($this['barcode']);
		
		scan_in($this->item['mms_id'],$this->item['holding_id'],$this->item['pid']);
	}
}

ScanInReturn::RunIt();