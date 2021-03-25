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
			if($item['location_code'] == 'gov') {
				if ($item['statistics_note_1'] == '') {
					$item['statistics_note_1'] = 'WITHDRAWN';
				}
				if ($item['statistics_note_2'] == '') {
					$item['statistics_note_2'] = 'FIRE 2018 OZONE';
				}
				$item['library_code'] = 'WITHDRAW';
				$item['location_code'] = 'wdgov';
			}
			if($item['location_code'] == 'govcen') {
				if ($item['statistics_note_1'] == '') {
					$item['statistics_note_1'] = 'WITHDRAWN';
				}
				if ($item['statistics_note_2'] == '') {
					$item['statistics_note_2'] = 'FIRE 2018 OZONE';
				}
				$item['library_code'] = 'WITHDRAW';
				$item['location_code'] = 'wdgovcen';
			}
			if($item['location_code'] == 'govelect') {
				if ($item['statistics_note_1'] == '') {
					$item['statistics_note_1'] = 'WITHDRAWN';
				}
				if ($item['statistics_note_2'] == '') {
					$item['statistics_note_2'] = 'FIRE 2018 OZONE';
				}
				$item['library_code'] = 'WITHDRAW';
				$item['location_code'] = 'wdgovelect';
			}
			if($item['location_code'] == 'govmap') {
				if ($item['statistics_note_1'] == '') {
					$item['statistics_note_1'] = 'WITHDRAWN';
				}
				if ($item['statistics_note_2'] == '') {
					$item['statistics_note_2'] = 'FIRE 2018 OZONE';
				}
				$item['library_code'] = 'WITHDRAW';
				$item['location_code'] = 'wdgovmap';
			}
			if($item['location_code'] == 'govmfile') {
				if ($item['statistics_note_1'] == '') {
					$item['statistics_note_1'] = 'WITHDRAWN';
				}
				if ($item['statistics_note_2'] == '') {
					$item['statistics_note_2'] = 'FIRE 2018 OZONE';
				}
				$item['library_code'] = 'WITHDRAW';
				$item['location_code'] = 'wdgovmfile';
			}
			if($item['location_code'] == 'govmic') {
				if ($item['statistics_note_1'] == '') {
					$item['statistics_note_1'] = 'WITHDRAWN';
				}
				if ($item['statistics_note_2'] == '') {
					$item['statistics_note_2'] = 'FIRE 2018 OZONE';
				}
				$item['library_code'] = 'WITHDRAW';
				$item['location_code'] = 'wdgovmic';
			}
			if($item['location_code'] == 'govover') {
				if ($item['statistics_note_1'] == '') {
					$item['statistics_note_1'] = 'WITHDRAWN';
				}
				if ($item['statistics_note_2'] == '') {
					$item['statistics_note_2'] = 'FIRE 2018 OZONE';
				}
				$item['library_code'] = 'WITHDRAW';
				$item['location_code'] = 'wdgovover';
			}
			if($item['location_code'] == 'govref') {
				if ($item['statistics_note_1'] == '') {
					$item['statistics_note_1'] = 'WITHDRAWN';
				}
				if ($item['statistics_note_2'] == '') {
					$item['statistics_note_2'] = 'FIRE 2018 OZONE';
				}
				$item['library_code'] = 'WITHDRAW';
				$item['location_code'] = 'wdgovref';
			}
			if($item['location_code'] == 'govmindex') {
				if ($item['statistics_note_1'] == '') {
					$item['statistics_note_1'] = 'WITHDRAWN';
				}
				if ($item['statistics_note_2'] == '') {
					$item['statistics_note_2'] = 'FIRE 2018 OZONE';
				}
				$item['library_code'] = 'WITHDRAW';
				$item['location_code'] = 'wgovmindex';
			}
			if($item['location_code'] == 'govoffmap') {
				if ($item['statistics_note_1'] == '') {
					$item['statistics_note_1'] = 'WITHDRAWN';
				}
				if ($item['statistics_note_2'] == '') {
					$item['statistics_note_2'] = 'FIRE 2018 OZONE';
				}
				$item['library_code'] = 'WITHDRAW';
				$item['location_code'] = 'wgovoffmap';
			}
			if($item['location_code'] == 'govposter') {
				if ($item['statistics_note_1'] == '') {
					$item['statistics_note_1'] = 'WITHDRAWN';
				}
				if ($item['statistics_note_2'] == '') {
					$item['statistics_note_2'] = 'FIRE 2018 OZONE';
				}
				$item['library_code'] = 'WITHDRAW';
				$item['location_code'] = 'wgovposter';
			}
		}
		if ($item['statistics_note_3'] == 'KU FDLP REQUEST') {
			if($item['location_code'] == 'gov') {
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
