<?php

require_once("../grima-lib.php");

class UnboxingWorkflowAlt extends GrimaTask {

	function do_task() {
		$item = new Item();
		$item->loadFromAlmaBarcode($this['unboxed_barcode']);
		$item['inventory_date'] = date("Y-m-d H:00:00");
		$item->updateAlma();
}
}

UnboxingWorkflowAlt::RunIt();
