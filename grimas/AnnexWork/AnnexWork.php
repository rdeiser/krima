<?php

require_once("../grima-lib.php");

class AnnexWork extends GrimaTask {

	function do_task() {
		{$item = new Item();
		$item->loadFromAlmaBarcode($this['unboxed_barcode']);
		$item->addInventoryDate(date("Y-m-d"));
		$item->updateAlma();
		}
		{if ($item['statistics_note_3'] == 'ANNEX ingest') {
			$holding = new Holding();
			$holding->loadFromAlma($item['mms_id'],$item['holding_id']);

			if ($holding['location_code'] == 'main') {
				$holding->deleteControlField("001");
				$holding->deleteControlField("004");
				$holding->setFieldindicators("852","0","0");
				$holding->deleteSubfieldMatching("014","9","/[0-9]?/");
				$holding->deleteSubfieldMatching("014","a","/^[A-z]/");
				$holding->setHldr("c","x","2","n");
				$holding->setH008("2","8","4","001","a","a","   ","0");
				$holding['library_code'] = 'ANNEX';
				$holding['location_code'] = 'annex';
				}
				$holding->updateAlma();
		}
		}
		
		{if ($item['statistics_note_3'] == 'AHD ANNEX ingest') {
			$holding = new Holding();
			$holding->loadFromAlma($item['mms_id'],$item['holding_id']);

			if ($holding['location_code'] == 'main') {
				$holding->deleteControlField("001");
				$holding->deleteControlField("004");
				$holding->setFieldindicators("852","0","0");
				$holding->deleteSubfieldMatching("014","9","/[0-9]?/");
				$holding->deleteSubfieldMatching("014","a","/^[A-z]/");
				$holding->setHldr("c","x","2","n");
				$holding->setH008("2","8","4","001","a","a","   ","0");
				$holding['library_code'] = 'ANNEX';
				$holding['location_code'] = 'annex';
				}
				$holding->updateAlma();
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
