<?php
require_once("../grima-lib.php");

class ScanInReturn extends GrimaTask {

	function do_task() {
		$item = new Item();
		$item->loadFromAlmaBarcode($this['barcode']);
		
		$item->scan_in($item['mms_id'],$item['holding_id'],$item['pid']);
		//scan_in($this->item['mms_id'],$this->item['holding_id'],$this->item['pid']);
	}
}

ScanInReturn::RunIt();

$item->addToAlmaHolding($this['mms_id'],$holdingid);