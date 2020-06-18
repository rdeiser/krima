<?php

require_once("../grima-lib.php");

class DisplayItem extends GrimaTask {

	function do_task() {
		{$item = new Item();
		$item->loadFromAlmaBarcode($this['unboxed_barcode']);
		//$item['internal_note_3'] = ('Inventory Date:').date("m/d/Y");
		//$item['inventory_number'] = ('Inventory Date:').date("m/d/Y");
		$item['inventory_date'] = date("Y-m-d");
		//$item['inventory_date'] = date("Y-m-d g:i:s A");
		if (isset($item['statistics_note_3'])) {
			if ($item['in_temp_location'] == 'true') {
				$item['in_temp_location'] = 'false';
			}
		}
		$item->updateAlma();
		}
{
		$this->item = new Item();
		$this->item->loadFromAlmaBarcode($this['unboxed_barcode']);
		$this->splatVars['item'] = $this->item;
}
}
}

DisplayItem::RunIt();
