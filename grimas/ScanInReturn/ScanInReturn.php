<?php
require_once("../grima-lib.php");

class ScanInReturn extends GrimaTask {

	function do_task() {
		$item = new Item();
		$item->loadFromAlmaBarcode($this['barcode']);
		$item->fulfillmentscan($item['mms_id'],$item['holding_id'],$item['item_pid']);
		//sleep(2);
		//$this->addMessage('success',"Successfully Scanned In: {$item['barcode']} {$item['mms_id']} {$item['holding_id']} {$item['item_pid']} Process: {$item['process_type']}");
		$this->addMessage('success',"Successfully Scanned In: {$item['barcode']} {$item['mms_id']} {$item['holding_id']} {$item['item_pid']} Process: {$item['process_type']} Additional Information: {$item['additional_info']} {$item['copy_id']}");
	}
}

ScanInReturn::RunIt();

class AdditionalInfo extends AlmaObject {
}