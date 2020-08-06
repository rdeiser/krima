<?php
require_once("../grima-lib.php");

class ScanInReturn extends GrimaTask {

	function do_task() {
		$item = new Item();
		$item->ScanInFulfillment($this['barcode']);
		//$item->loadFromAlmaBarcode($this['barcode']);
		
		//$this['barcode'] = scan_in($item['mms_id'],$item['holding_id'],$item['item_pid']);
		$item->updateAlma();
		//scan_in($this->item['mms_id'],$this->item['holding_id'],$this->item['pid']);
			$this->addMessage('success',"Successfully Scanned In: {$item['barcode']} Process: {$item['process_type']}");
	}
}

ScanInReturn::RunIt();
