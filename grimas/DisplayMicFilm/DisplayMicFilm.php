<?php

require_once("../grima-lib.php");

class DisplayMicFilm extends GrimaTask {

	function do_task() {
		$item = new Item();
		$item->loadFromAlmaBarcode($this['unboxed_barcode']);
		if ($item['physical_material_type_code'] !== 'FILM') {
			$this->splatVars['item'] = $this->item;
		} else {
		$item->addInventoryDate(date("Y-m-d"));
		//$item['inventory_date'] = date("Y-m-d");
		if ($item['in_temp_location'] = 'true') {
			$item['in_temp_location'] = 'false';
		}
		unset($item['temp_location']);
		unset($item['temp_call_number_type']);
		unset($item['temp_call_number']);
		unset($item['temp_policy']);
		//unset($item['alt_number_source']);
		//$item['due_back_date'] = '';
		if (!empty($item['due_back_date'])) {
			unset($item['due_back_date']);
		}

		$item->updateAlma();
		}
		{
		$holding = new Holding();
		$holding->loadFromAlma('1234',$item['holding_id']);
		
		if ($holding['location_code'] == 'mic') {
			$holding['location_code'] = 'microfilm';
		}
		/*$subfield_k = "Raymond";
		$holding->appendField("852","","",array('k' => $subfield_k));*/
		$holding->deleteSubfieldMatching("852","k",'/(MICROFILM)/');
		$holding->updateAlma();
		}
{
		$this->item = new Item();
		$this->item->loadFromAlmaBarcode($this['unboxed_barcode']);
		$this->splatVars['item'] = $this->item;
}
}
}

DisplayMicFilm::RunIt();
