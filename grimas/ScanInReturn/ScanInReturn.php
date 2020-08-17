<?php
require_once("../grima-lib.php");

class ScanInReturn extends GrimaTask {

	function do_task() {
		$item = new Item();
		$item->loadFromAlmaBarcode($this['barcode']);
		$item->fulfillmentscan($item['mms_id'],$item['holding_id'],$item['item_pid']);
		$this->addMessage('success',$item->addInfo());
		//echo $item['additional_info'];
		//function print_success() {
			GrimaTask::call('ViewXmlItem', array('item_pid' => $this['item_pid']));
		}
		//$this->addMessage('success',"Successfully Scanned In: {$item['barcode']} with a Process Type of: {$item['process_type']}");
		//$this->addMessage('success',"Successfully Scanned In: {$item['barcode']} {$item['mms_id']} {$item['holding_id']} {$item['item_pid']} Process: {$item['process_type']} Additional Information: {$item['additional_info']}");
	}
}

ScanInReturn::RunIt();
