<?php

require_once("../grima-lib.php");

class DisplayItempp extends GrimaTask {

	function do_task() {
		{$item = new Item();
		$item->loadFromAlmaBarcode($this['unboxed_barcode']);
		$item->addInventoryDate(date("Y-m-d"));
		//$item['inventory_date'] = date("Y-m-d");
		if ($item['statistics_note_3'] == 'ANNEX ingest') {
			$item['in_temp_location'] = 'false';
		}
		if ($item['statistics_note_3'] == 'HALE return') {
			$item['in_temp_location'] = 'false';
		}
		if ($item['statistics_note_3'] == 'To be WITHDRAWN') {
			$item['in_temp_location'] = 'false';
		}
		if ($item['statistics_note_3'] == 'AHD HALE return') {
			$item['in_temp_location'] = 'false';
		}
		if ($item['statistics_note_3'] == 'AHD ANNEX ingest') {
			$item['in_temp_location'] = 'false';
		}
		if ($item['statistics_note_3'] == 'AHD To be WITHDRAWN') {
			$item['in_temp_location'] = 'false';
		}
		//$item['inventory_date'] = date("Y-m-d g:i:s A");
		/*if ($item['in_temp_location'] == 'true') {
			$item['in_temp_location'] = 'false';
		}*/
		$item->updateAlma();
		}
{
		$this->item = new Item();
		$this->item->loadFromAlmaBarcode($this['unboxed_barcode']);
		$this->splatVars['item'] = $this->item;
}
}
}

DisplayItempp::RunIt();
