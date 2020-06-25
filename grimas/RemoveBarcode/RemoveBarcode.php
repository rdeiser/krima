<?php

require_once("../grima-lib.php");

class RemoveBarcode extends GrimaTask {
	
	function do_task() {
		$this->barcodex = $this['barcode_remove'];
		foreach ($this->barcodex as $barcode) {
			$item = new Item();
			$item->loadFromAlmaBarcode($barcode);
			$item['statistics_note_2'] = 'FIRE 2018 OZONE';
			$item->deleteBarcode($barcode);
			$item->updateAlma();
		}

	}

	function print_success() {
		GrimaTask::call('ViewXmlItem', array('item_pid' => $item['item_pid']));
	}
		
}

RemoveBarcode::RunIt();
