<?php

require_once("../grima-lib.php");

class DisplayItemB extends GrimaTask {

	function do_task() {
		{$item = new Item();
		$item->loadFromAlmaBarcode($this['unboxed_barcode']);
		$item['internal_note_3'] = ('Inventory Date:').date("m/d/Y");
		$item['inventory_number'] = ('Inventory Date:').date("m/d/Y");
		$item['inventory_date'] = date("Y-m-d");
		$item->updateAlma();}
{
		$this->item = new Item();
		$this->item->loadFromAlmaBarcode($this['unboxed_barcode']);
		$this->splatVars['item'] = $this->item;
}
}

DisplayItemB::RunIt();
