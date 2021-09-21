<?php

require_once("../grima-lib.php");

class PhysicalCondition extends GrimaTask {

	function do_task() {
		{$item = new Item();
		$item->loadFromAlmaBarcode($this['unboxed_barcode']);
		$item['inventory_date'] = date("Y-m-d");
		
		$item->updateAlma();
		}
{
		$this->item = new Item();
		$this->item->loadFromAlmaBarcode($this['unboxed_barcode']);
		$this->splatVars['item'] = $this->item;
}
}
}

PhysicalCondition::RunIt();
