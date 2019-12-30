<?php

require_once("../grima-lib.php");

class UnboxingWorkflowAlt extends GrimaTask {

	function do_task() {
		$item = new Item();
		$item->loadFromAlmaBarcode($this['unboxed_barcode']);
		$item['inventory_date'] = date("Y-m-d");
		$item->updateAlma();
}
	function print_success(){
			GrimaTask::call('DisplayItem', array('unboxed_barcode' => $this['unboxed_barcode']));
	}
}

UnboxingWorkflowAlt::RunIt();
