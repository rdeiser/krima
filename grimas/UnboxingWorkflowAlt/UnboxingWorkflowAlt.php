<?php

require_once("../grima-lib.php");

class UnboxingWorkflowAlt extends GrimaTask {

	function do_task() {
		$item = new Item();
		$item->loadFromAlmaBarcode($this['barcode']);
		/*$item['inventory_date'] = date("Y-m-d H:00:00");*/
		/*$item['internal_note_3'] = date("m/d/Y");*/
		$item->updateAlma();
}
	function print_success(){
			GrimaTask::call('DisplayItem', array('barcode' => $this['barcode']));
	}
}

UnboxingWorkflowAlt::RunIt();
