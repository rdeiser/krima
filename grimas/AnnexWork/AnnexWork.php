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
		$holding->loadFromAlma($this->item['mms_id'],$this->item['holding_id']);
		$holding['library_code'] = 'ANNEX';
		$holding['location_code'] = 'ANNEX';
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
