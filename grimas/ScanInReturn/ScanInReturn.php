<?php
require_once("../grima-lib.php");

class ScanInReturn extends GrimaTask {

	function do_task() {
		$item = new Item();
		$item->loadFromAlmaBarcode($this['barcode']);
		
		$item->ScanIn($item['mms_id'],$item['holding_id'],$item['item_pid']);
		//scan_in($this->item['mms_id'],$this->item['holding_id'],$this->item['pid']);
	}
	$this->addMessage('success',"Successfully Scanned In: {$item['barcode']}");
}

ScanInReturn::RunIt();
