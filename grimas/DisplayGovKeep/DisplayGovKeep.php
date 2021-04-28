<?php

require_once("../grima-lib.php");

class DisplayGovKeep extends GrimaTask {

	function do_task() {
		{$item = new Item();
		$item->loadFromAlmaBarcode($this['unboxed_barcode']);
		$item->addInventoryDate(date("Y-m-d"));
		$item->updateAlma();
		}
{
		$this->item = new Item();
		$this->item->loadFromAlmaBarcode($this['unboxed_barcode']);
		$this->splatVars['item'] = $this->item;
}
}
}

DisplayGovKeep::RunIt();
