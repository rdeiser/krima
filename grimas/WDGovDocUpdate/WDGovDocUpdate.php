<?php

require_once("../grima-lib.php");

class WDGovDocUpdate extends GrimaTask {

	function do_task() {
		$item = new Item();
		$item->loadFromAlmaBarcode($this['unboxed_barcode']);

		$holding = new Holding();
		$holding->loadFromAlma($item['mms_id'],$item['holding_id']);
		$holding['library_code'] = 'ANNEX';
		$holding['location_code'] = 'ANNEX';
		$holding->updateAlma();

$this->addMessage('success',"Successfully  modified {$this['unboxed_barcode']} to {$holding['location_code']}");

/*{
		$this->item = new Item();
		$this->item->loadFromAlmaBarcode($this['unboxed_barcode']);
		$this->splatVars['item'] = $this->item;
}*/
}
}

WDGovDocUpdate::RunIt();
