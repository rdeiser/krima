<?php
require_once("../grima-lib.php");
class AnnexWork extends GrimaTask {
	function do_task() {
		$item = new Item();
		$item->loadFromAlmaBarcode($this['unboxed_barcode']);
		
		{if ($item['statistics_note_3'] == 'ANNEX ingest'||$item['statistics_note_3'] == 'AHD ANNEX ingest') {
			$holding = new Holding();
			$holding->loadFromAlma($item['mms_id'],$item['holding_id']);
			if ($this['location'] == 'annex') {
				if ($holding['location_code'] == 'main' || $holding['location_code'] == 'nich') {
					$holding->deleteControlField("001");
					$holding->deleteControlField("004");
					$holding->setFieldindicators("852","0","0");
					$holding->deleteSubfieldMatching("014","9","/[0-9]?/");
					$holding->deleteSubfieldMatching("014","a","/^[A-z]/");
					$holding->setHldr("c","x","2","n");
					$holding->setH008("2","8","4","001","a","a","   ","0");
					/*$holding->setHldr5("c");
					$holding->setHldr6("x");
					$holding->setHldr17("2");
					$holding->setHldr18("n");
					$holding->set008p6("2");
					$holding->set008p7("u");
					$holding->set008p12("8");
					$holding->set008p16("4");
					$holding->set008p17("001");
					$holding->set008p20("a");
					$holding->set008p21("a");
					$holding->set008p22("###");
					$holding->set008p25("0");*/
					$holding['library_code'] = 'ANNEX';
					$holding['location_code'] = 'annex';
					$holding->updateAlma();
				
				$item = new Item();
				$item->loadFromAlmaBarcode($this['unboxed_barcode']);
				if ($item['item_policy'] !== 'book/ser') {
					$item['item_policy'] = 'book/ser';
					//$item->updateAlma();
				}
				$item->addInventoryDate(date("Y-m-d"));
				$item->updateAlma();
				}
			}
			/*if ($this['location'] == 'annexltd') {
				if ($holding['location_code'] == 'spec') {
					$holding->deleteControlField("001");
					$holding->deleteControlField("004");
					$holding->setFieldindicators("852","0","0");
					$holding->deleteSubfieldMatching("014","9","/[0-9]?/");
					$holding->deleteSubfieldMatching("014","a","/^[A-z]/");
					$holding->setHldr("c","x","2","n");
					$holding->setH008("2","8","4","001","b","a","   ","0");
					$holding['library_code'] = 'ANNEX';
					$holding['location_code'] = 'annexltd';
				}
				$holding->updateAlma();
				$item = new Item();
				$item->loadFromAlmaBarcode($this['unboxed_barcode']);
				if ($item['item_policy'] !== 'no loan') {
					$item['item_policy'] = 'no loan';
					//$item->updateAlma();
				}
				$item->addInventoryDate(date("Y-m-d"));
				$item->updateAlma();
			}*/
			if ($this['location'] == 'govstorks') {
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
					//$item->updateAlma();
				}
				$item->addInventoryDate(date("Y-m-d"));
				$item->updateAlma();
				}
			}
		} elseif ($this['location'] == 'annexltd') {
			$holding = new Holding();
			$holding->loadFromAlma($item['mms_id'],$item['holding_id']);
			if ($holding['library_code'] == 'SPEC') {
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
			}
			
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
				$item->addInventoryDate(date("Y-m-d"));
				$item->updateAlma();
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