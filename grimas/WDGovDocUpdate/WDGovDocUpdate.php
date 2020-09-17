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
		if (!empty($item['internal_note_1'])) {
			/*$pattern = "/^";
			$replace = "Gov unboxing review--";
			preg_replace($pattern, $replace, $item['process_type']);*/
			substr_replace("Gov unboxing review--",$item['internal_note_1'],21);
		} /*else {
			$item['internal_note_1'] = 'Gov unboxing review';
		}*/
		//$item['internal_note_1'] = 'Gov unboxing review';
		$item->updateAlma();
				
		$this->addMessage('success',"{$item['internal_note_1']}Successfully updated Barcode: {$item['barcode']}");
	}
}

WDGovDocUpdate::RunIt();
