<?php

require_once("../grima-lib.php");

class WDGovDocUpdate extends GrimaTask {
	public $holdinglist = array();

	function do_task() {
		$item = new Item();
		$item->loadFromAlmaBCorX($this['barcode']);
		$item['inventory_date'] = date("Y-m-d");
		if($item['location_code'] == 'main') {
			$item['library_code'] = 'WITHDRAW';
			$item['location_code'] = 'wdgov';
		}
		if($item['location_code'] == 'wdmain') {
			$item['location_code'] = 'wdgov';
		}
		if($item['location_code'] == 'gov') {
			$item['library_code'] = 'WITHDRAW';
			$item['location_code'] = 'wdgov';
		}
		if($item['location_code'] == 'govcen') {
			$item['library_code'] = 'WITHDRAW';
			$item['location_code'] = 'wdgovcen';
		}
		if($item['location_code'] == 'govelect') {
			$item['library_code'] = 'WITHDRAW';
			$item['location_code'] = 'wdgovelect';
		}
		if($item['location_code'] == 'govmap') {
			$item['library_code'] = 'WITHDRAW';
			$item['location_code'] = 'wdgovmap';
		}
		if($item['location_code'] == 'govmfile') {
			$item['library_code'] = 'WITHDRAW';
			$item['location_code'] = 'wdgovmfile';
		}
		if($item['location_code'] == 'govmic') {
			$item['library_code'] = 'WITHDRAW';
			$item['location_code'] = 'wdgovmic';
		}
		if($item['location_code'] == 'govover') {
			$item['library_code'] = 'WITHDRAW';
			$item['location_code'] = 'wdgovover';
		}
		if($item['location_code'] == 'govref') {
			$item['library_code'] = 'WITHDRAW';
			$item['location_code'] = 'wdgovref';
		}
		if($item['location_code'] == 'govmindex') {
			$item['library_code'] = 'WITHDRAW';
			$item['location_code'] = 'wgovmindex';
		}
		if($item['location_code'] == 'govoffmap') {
			$item['library_code'] = 'WITHDRAW';
			$item['location_code'] = 'wgovoffmap';
		}
		if($item['location_code'] == 'govposter') {
			$item['library_code'] = 'WITHDRAW';
			$item['location_code'] = 'wgovposter';
		}
		$item['statistics_note_3'] = 'GOV UNBOXING review';
		//$item->InternalNote1();
		//$item['internal_note_1'] = 'Gov unboxing review';
		$item->updateAlma();
				
		$this->addMessage('success',"Successfully updated Barcode: {$item['barcode']}");
	}
}

WDGovDocUpdate::RunIt();
