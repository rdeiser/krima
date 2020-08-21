<?php
require_once("../grima-lib.php");

class ScanInReturn extends GrimaTask {

	function do_task() {
		$item = new Item();
		$item->loadFromAlmaBarcode($this['barcode']);
		/*if $this['library'] == 'MAIN' {
			$circ_desk = 'DEFAULT_CIRC_DESK';
			}*/

		$this->item = new Item();
		$this->item->loadFromAlmaX($item['item_pid']);
		$this->item->fulfillmentscan($item['mms_id'],$item['holding_id'],$item['item_pid'],$this['library']);

		$this->addMessage('success',"Successfully Scanned In: {$item['barcode']} Additional Information: {$this->item['additional_info']}");
	}


}

ScanInReturn::RunIt();
