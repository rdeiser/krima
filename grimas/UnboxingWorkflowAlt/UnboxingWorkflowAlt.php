<?php

require_once("../grima-lib.php");

class UnboxingWorkflow extends GrimaTask {

	function do_task() {
		$item = new Item();
		$item->loadFromAlmaBarcode($this['barcode']);
		$item['inventory_date'] = date("m/d/Y");
		$item->updateAlma();
		$this->splatVars['item'] = $this->item;
}
}
UnboxingWorkflow::RunIt();
