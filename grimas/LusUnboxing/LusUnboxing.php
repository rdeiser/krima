<?php

require_once("../grima-lib.php");

class LusUnboxing extends GrimaTask {

	function do_task() {
		{$item = new Item();
		$item->loadFromAlmaBarcode($this['unboxed_barcode']);
		$item->addInventoryDate(date("Y-m-d"));
		if ($item['in_temp_location'] = 'true') {
			$item['in_temp_location'] = 'false';
		}
		
		unset($item['temp_location']);
		unset($item['temp_call_number_type']);
		unset($item['temp_call_number']);
		unset($item['temp_policy']);
		if (!empty($item['due_back_date'])) {
			unset($item['due_back_date']);
		}

		$item->updateAlma();
		}
		$this->item = new Item();
		$this->item->loadFromAlmaX($item['item_pid']);
		$this->item->fulfillmentscan($item['mms_id'],$item['holding_id'],$item['item_pid'],$op = 'scan',$library = $library = $this['library'],$circ_desk = 'DEFAULT_CIRC_DESK',$work_order_type = '',$status = '',$done = 'false',$place_on_hold_shelf = 'false',$register_in_house_use = 'false');

{
		$this->item = new Item();
		$this->item->loadFromAlmaBarcode($this['unboxed_barcode']);
		$this->splatVars['item'] = $this->item;
}
}
}

LusUnboxing::RunIt();
