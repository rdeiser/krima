<?php

require_once("../grima-lib.php");

class RemoveBarcode extends GrimaTask {
	
	function do_task() {
		$item = new Item();
		$item->loadFromAlmaBarcode($this['barcode_remove']);
			$item['statistics_note_2'] = 'FIRE 2018 OZONE';
		$item->deleteBarcode($this['barcode_remove']);
		$item->updateAlma();


	}

	function print_success() {
		GrimaTask::call('ViewXmlItem', array('item_pid' => $item['item_pid']));
	}
		
}

RemoveBarcode::RunIt();
