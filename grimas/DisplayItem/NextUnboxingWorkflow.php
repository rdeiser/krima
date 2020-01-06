<?php

require_once("../grima-lib.php");

class UnboxingWorkflow extends GrimaTask {

	function do_task() {
		$item = new Item();
		$item->loadFromAlmaBarcode($this['next_barcode']);
		$item['internal_note_3'] = ('Inventory Date:').date("m/d/Y");
		$item['inventory_number'] = ('Inventory Date:').date("m/d/Y");
		$item['inventory_date'] = date("Y-m-d");
		$item->updateAlma();
}
	function print_success(){
			GrimaTask::call('DisplayItem', array('unboxed_barcode' => $this['next_barcode']));
	}
}

UnboxingWorkflow::RunIt();
