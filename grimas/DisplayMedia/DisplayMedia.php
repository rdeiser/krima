<?php

require_once("../grima-lib.php");

class DisplayMedia extends GrimaTask {

	function do_task() {
		{$item = new Item();
		$item->loadFromAlmaBarcode($this['unboxed_barcode']);
		$item->addInventoryDate(date("Y-m-d"));
		//$item['inventory_date'] = date("Y-m-d");
		if ($item['in_temp_location'] = 'true') {
			$item['in_temp_location'] = 'false';
		}
		unset($item['temp_location']);
		unset($item['temp_call_number_type']);
		unset($item['temp_call_number']);
		unset($item['temp_policy']);
		if ($item['process_type'] = 'MISSING') {
			unset($item['process_type']);
		}
		$item['process_type'] = '';
		//unset($item['alt_number_source']);
		//$item['due_back_date'] = '';
		if (!empty($item['due_back_date'])) {
			unset($item['due_back_date']);
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

DisplayMedia::RunIt();
