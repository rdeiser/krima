<?php
require_once("../grima-lib.php");
class AnnexWork extends GrimaTask {
	function do_task() {
		$item = new Item();
		$item->loadFromAlmaBarcode($this['unboxed_barcode']);
		if ($this['location'] === 'annex') {
			if ($item['statistics_note_3'] == 'ANNEX ingest'||$item['statistics_note_3'] == 'AHD ANNEX ingest') {
				$holding = new Holding();
				$holding->loadFromAlma($item['mms_id'],$item['holding_id']);
				if ($holding['location_code'] == 'nich' || $holding['location_code'] == 'main' || $holding['location_code'] == 'over' || $holding['location_code'] == 'overplus') {
					$holding->deleteControlField("001");
					$holding->deleteControlField("004");
					$holding->setFieldindicators("852","0","0");
					$holding->deleteSubfieldMatching("014","9","/[0-9]?/");
					$holding->deleteSubfieldMatching("014","a","/^[A-z]/");
					$holding->setHldr("c","x","2","n");
					$holding->setH008("2","8","4","001","a","a","   ","0");
					$holding['library_code'] = 'ANNEX';
					$holding['location_code'] = 'annex';
					$holding->updateAlma();
				
					$item = new Item();
					$item->loadFromAlmaBarcode($this['unboxed_barcode']);
					if ($item['item_policy'] !== 'book/ser') {
						$item['item_policy'] = 'book/ser';
					}
					$item->addInventoryDate(date("Y-m-d"));
					$item->updateAlma();
				} else {
					$item = new Item();
					$item->loadFromAlmaBarcode($this['unboxed_barcode']);
					$item->addInventoryDate(date("Y-m-d"));
					$item->updateAlma();
				}
			} else {
				$item = new Item();
				$item->loadFromAlmaBarcode($this['unboxed_barcode']);
				$item->addInventoryDate(date("Y-m-d"));
				$item->updateAlma();
			}
		}
		if ($this['location'] == 'govstorks') {
			if ($item['statistics_note_3'] == 'ANNEX ingest'||$item['statistics_note_3'] == 'AHD ANNEX ingest') {
				$holding = new Holding();
				$holding->loadFromAlma($item['mms_id'],$item['holding_id']);
				if ($holding['location_code'] == 'govks' || $holding['location_code'] == 'govksover' || $holding['location_code'] == 'govrefks') {
					$holding->deleteControlField("001");
					$holding->deleteControlField("004");
					$holding->setFieldindicators("852","8","0");
					$holding->deleteSubfieldMatching("014","9","/[0-9]?/");
					$holding->deleteSubfieldMatching("014","a","/^[A-z]/");
					$holding->setHldr("c","x","2","n");
					$holding->setH008("2","8","4","001","a","a","   ","0");
					$holding['library_code'] = 'ANNEX';
					$holding['location_code'] = 'govstorks';
					$holding->updateAlma();
				
					$item = new Item();
					$item->loadFromAlmaBarcode($this['unboxed_barcode']);
					if ($item['item_policy'] !== 'book/ser') {
						$item['item_policy'] = 'book/ser';
					}
					$item->addInventoryDate(date("Y-m-d"));
					$item->updateAlma();
				}
			} else {
				$item = new Item();
				$item->loadFromAlmaBarcode($this['unboxed_barcode']);
				$item->addInventoryDate(date("Y-m-d"));
				$item->updateAlma();
			}
		}
		
		if ($this['location'] == 'annexltd') {
			$holding = new Holding();
			$holding->loadFromAlma($item['mms_id'],$item['holding_id']);
			if ($holding['library_code'] == 'SPEC' || $holding['location_code'] == 'annexltd')) {
				$holding->deleteControlField("001");
				$holding->deleteControlField("004");
				$holding->setFieldindicators("852","0","0");
				$holding->deleteSubfieldMatching("014","9","/[0-9]?/");
				$holding->deleteSubfieldMatching("014","a","/^[A-z]/");
				$holding->setHldr("c","x","2","n");
				$holding->setH008("2","8","4","001","b","a","   ","0");
				$holding['library_code'] = 'ANNEX';
				$holding['location_code'] = 'annexltd';
				$holding->updateAlma();
				
				$item = new Item();
				$item->loadFromAlmaBarcode($this['unboxed_barcode']);
				if ($item['item_policy'] !== 'no loan') {
					$item['item_policy'] = 'no loan';
				}
				if ($item['statistics_note_2'] == '') {
					$item['statistics_note_2'] = 'FIRE 2018 SPECIAL COLLECTIONS';
				}
				$item->addInventoryDate(date("Y-m-d"));
				$item->updateAlma();
			} else {
				$item = new Item();
				$item->loadFromAlmaBarcode($this['unboxed_barcode']);
				$item->addInventoryDate(date("Y-m-d"));
				$item->updateAlma();
			}
		}
		
		if ($this['location'] == 'KS-Extension') {
			if ($item['statistics_note_3'] == 'ANNEX ingest'||$item['statistics_note_3'] == 'AHD ANNEX ingest') {
				if ($item['library_code'] == 'ANNEX') {
					$item->fulfillmentscan($item['mms_id'],$item['holding_id'],$item['item_pid'],$op = 'scan',$library = 'ANNEX',$circ_desk = 'DEFAULT_CIRC_DESK',$work_order_type = '',$status = '',$done = 'false',$place_on_hold_shelf = 'false',$register_in_house_use = 'false');
					if ($item['item_policy'] !== 'book/ser') {
						$item['item_policy'] = 'book/ser';
					}
					$item['statistics_note_3'] = 'HALE return';
					$item->addInventoryDate(date("Y-m-d"));
					$item->updateAlma();
				}
				if ($item['library_code'] == 'MAIN') {
					$item->fulfillmentscan($item['mms_id'],$item['holding_id'],$item['item_pid'],$op = 'scan',$library = 'MAIN',$circ_desk = 'DEFAULT_CIRC_DESK',$work_order_type = '',$status = '',$done = 'false',$place_on_hold_shelf = 'false',$register_in_house_use = 'false');
					if ($item['item_policy'] !== 'book/ser') {
						$item['item_policy'] = 'book/ser';
					}
					$item['statistics_note_3'] = 'HALE return';
					$item->addInventoryDate(date("Y-m-d"));
					$item->updateAlma();
				}
			}
		}
{
		$this->item = new Item();
		$this->item->loadFromAlmaBarcode($this['unboxed_barcode']);
		$this->splatVars['item'] = $this->item;
}
}
}
AnnexWork::RunIt();