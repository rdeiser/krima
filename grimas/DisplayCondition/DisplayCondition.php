<?php
require_once("../grima-lib.php");
class DisplayCondition extends GrimaTask {
	function do_task() {
		$item = new Item();
		$item->loadFromAlmaBarcode($this['unboxed_barcode']);
		//uncomment the following coding when moving to production.
		/*$item->addInventoryDate(date("Y-m-d"));
		$item->updateAlma();*/
{
		$this->item = new Item();
		$this->item->loadFromAlmaBarcode($this['unboxed_barcode']);
		$this->splatVars['item'] = $this->item;
}
}
}
DisplayCondition::RunIt();