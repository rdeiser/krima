<?php

require_once("../grima-lib.php");

class WDGovDocUpdate extends GrimaTask {
	public $holdinglist = array();

	function do_task() {
		$item = new Item();
		$item->loadFromAlmaBCorX($this['barcode']);
		$item['inventory_date'] = date("Y-m-d");
		$item['library_code'] = 'WITHDRAW';
		$item['location_code'] = 'wdgov';
		$item->InternalNote1();
		//$item['internal_note_1'] = 'Gov unboxing review';
		$item->updateAlma();
				
		$this->addMessage('success',"{$item['internal_note_1']}Successfully updated Barcode: {$item['barcode']}");
	}
}

WDGovDocUpdate::RunIt();
