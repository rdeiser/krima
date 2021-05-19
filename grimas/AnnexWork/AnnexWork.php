<?php

require_once("../grima-lib.php");

class AnnexWork extends GrimaTask {

	function do_task() {
		{$item = new Item();
		$item->loadFromAlmaBarcode($this['unboxed_barcode']);
		$item->addInventoryDate(date("Y-m-d"));
		$item->updateAlma();
		}
		{$holding = new Holding();
		$holding->loadFromAlma($item['mms_id'],$item['holding_id']);

		if ($holding['location_code'] == 'main') {
			$holding->deleteControlField("001");
			$holding->deleteControlField("004");
			$holding->setFieldindicators("852","0","0");
			$holding->deleteSubfieldMatching("014","9","/[0-9]?/");
			$holding->deleteSubfieldMatching("014","a","/^[A-z]/");
			/*$holding->setHldr5("c");
			$holding->setHldr6("x");*/
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
			$holding->set008p25("0");
			$holding['library_code'] = 'ANNEX';
			$holding['location_code'] = 'annex';
		}
		$holding->updateAlma();
		/*
		if ($leader[5] == '') {
			$leader[5] = 'c';
		appendField($tag,$ind1,$ind2,$subfields)
		$holding->appendField("014","","",array('a' => content));
		deleteField($tag)
		
		$leader[6]
		leader? may need to develop this within grima-lib.php similar to inventory_date?*/
		}
{
		$this->item = new Item();
		$this->item->loadFromAlmaBarcode($this['unboxed_barcode']);
		$this->splatVars['item'] = $this->item;
}
}
}

AnnexWork::RunIt();
