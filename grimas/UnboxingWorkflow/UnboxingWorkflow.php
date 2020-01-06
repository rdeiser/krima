<?php

require_once("../grima-lib.php");

class UnboxingWorkflow extends GrimaTask {

	function do_task() {
		$item = new Item();
		$item->loadFromAlmaBarcode($this['unboxed_barcode']);
		$item['internal_note_3'] = "Inventory Date:"date("m/d/Y");
		$item['inventory_number'] = date("\I\n\v\e\n\t\o\r\y \D\a\t\e\: m/d/Y");
		/*$item['inventory_date'] = new date("Y-m-d");*/
		$item->updateAlma();
}
	function print_success(){
			GrimaTask::call('DisplayItem', array('unboxed_barcode' => $this['unboxed_barcode']));
	}
}

UnboxingWorkflow::RunIt();
