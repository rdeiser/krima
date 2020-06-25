<?php

require_once("../grima-lib.php");

class RemoveBarcode extends GrimaTask {
	
	function do_task() {
		$this->$item->item = new Item();
		$this->$item->loadFromAlmaBarcode($this['barcode']);
		
		$item->deleteBarcode();
		$item->updateAlma();

	}

	function print_success() {
		GrimaTask::call('ViewXmlItem', array('item_pid' => $item['item_pid']));
	}
		
}

RemoveBarcode::RunIt();
