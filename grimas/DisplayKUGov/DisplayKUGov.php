<?php

require_once("../grima-lib.php");

class DisplayKUGov extends GrimaTask {

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
		//unset($item['alt_number_source']);
		//$item['due_back_date'] = '';
		if (!empty($item['due_back_date'])) {
			unset($item['due_back_date']);
		}
		
		if ($item['statistics_note_3'] == '') {
			if($item['location_code'] == 'gov'||'govcen'||'govelect'||'govmap'||'govmfile'||'govmic'||'govover'||'govref'||'govmindex'||'govoffmap'||'govposter') {
				if ($item['statistics_note_1'] == '') {
					$item['statistics_note_1'] = 'WITHDRAWN';
				}
				if ($item['statistics_note_2'] == '') {
					$item['statistics_note_2'] = 'FIRE 2018 OZONE';
				}
				$item['library_code'] = 'WITHDRAW';
			}
			if($item['location_code'] == 'gov') {
				$item['location_code'] = 'wdgov';
			}
			if($item['location_code'] == 'govcen') {
				$item['location_code'] = 'wdgovcen';
			}
			if($item['location_code'] == 'govelect') {
				$item['location_code'] = 'wdgovelect';
			}
			if($item['location_code'] == 'govmap') {
				$item['location_code'] = 'wdgovmap';
			}
			if($item['location_code'] == 'govmfile') {
				$item['location_code'] = 'wdgovmfile';
			}
			if($item['location_code'] == 'govmic') {
				$item['location_code'] = 'wdgovmic';
			}
			if($item['location_code'] == 'govover') {
				$item['location_code'] = 'wdgovover';
			}
			if($item['location_code'] == 'govref') {
				$item['location_code'] = 'wdgovref';
			}
			if($item['location_code'] == 'govmindex') {
				$item['location_code'] = 'wgovmindex';
			}
			if($item['location_code'] == 'govoffmap') {
				$item['location_code'] = 'wgovoffmap';
			}
			if($item['location_code'] == 'govposter') {
				$item['location_code'] = 'wgovposter';
			}
		}
		if ($item['statistics_note_3'] == 'KU FDLP REQUEST') {
			if($item['location_code'] == 'gov'||'govcen'||'govelect'||'govmap'||'govmfile'||'govmic'||'govover'||'govref'||'ovmindex'||'govoffmap'||'govposter') {
				if ($item['statistics_note_1'] == '') {
					$item['statistics_note_1'] = 'WITHDRAWN';
				}
				if ($item['statistics_note_2'] == '') {
					$item['statistics_note_2'] = 'FIRE 2018 OZONE';
				}
				$item['library_code'] = 'WITHDRAW';
				$item['location_code'] = 'wdgovKU';
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

DisplayKUGov::RunIt();
