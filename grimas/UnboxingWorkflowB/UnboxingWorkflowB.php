<?php

require_once("../grima-lib.php");

class UnboxingWorkflowB extends GrimaTask {

	function do_task() {
		$item = new Item();
		$item->loadFromAlmaBarcode($this['unboxed_barcode']);
		$item['internal_note_3'] = ('Inventory Date:').date("m/d/Y");
		$item['inventory_number'] = ('Inventory Date:').date("m/d/Y");
		if (empty($item['inventory_date']-> null)){
			$item['inventory_date'] == date("Y-m-d");
		}
			else if ($item['inventory_date']==''){
				$item['inventory_date'] == date("Y-m-d");
			}
		$item->updateAlma();
}
	function print_success(){
			GrimaTask::call('DisplayItemB', array('unboxed_barcode' => $this['unboxed_barcode']));
	}
}

UnboxingWorkflowB::RunIt();
