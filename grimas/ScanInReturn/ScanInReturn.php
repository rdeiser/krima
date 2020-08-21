<?php
require_once("../grima-lib.php");

class ScanInReturn extends GrimaTask {

	function do_task() {
		$item = new Item();
		$item->loadFromAlmaBarcode($this['barcode']);

		$this->item = new Item();
		$this->item->loadFromAlmaX($item['item_pid']);
		$this->item->fulfillmentscan($item['mms_id'],$item['holding_id'],$item['item_pid']);

		$this->addMessage('success',"Successfully Scanned In: {$item['barcode']} Additional Information: {$this->item['additional_info']}");
	}


}

ScanInReturn::RunIt();
