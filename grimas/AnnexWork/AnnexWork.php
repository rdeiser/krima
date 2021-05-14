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
			$holding->appendField("852","0","0","c");
			//$holding->appendFieldfirstind("852","0");
			//$holding->appendFieldsecondind("852","0");
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
