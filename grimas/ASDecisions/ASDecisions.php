<?php

require_once("../grima-lib.php");

class ASDecisions extends GrimaTask {
	public $barcodelist = array();

	function do_task() {
		//$set = new Set();
		//$set->createSet($this['setName']);
		//$set->postSetManageMembers($set['set_id']);

		$this->barcodes = preg_split('/\r\n|\r|\n/',$this['barcodes']);

		foreach ($this->barcodes as $barcode) {

			$item = new Item();
			$item->loadFromAlmaBarcode($barcode);
			$item->addInventoryDate("1976-01-01");
			//unset($item['barcode']);
			if ($this['whichnote']=='AHD HALE return'){
				$item['statistics_note_3'] = $this['whichnote'];
			}
			if ($this['whichnote']=='AHD ANNEX ingest'){
				$item['statistics_note_3'] = $this['whichnote'];
			}
			if ($this['whichnote']=='AHD To be WITHDRAWN'){
				$item['statistics_note_3'] = $this['whichnote'];
				$library_code = 'WITHDRAW';
				$library = 'WITHDRAW';
				$item->changeItemLibrary($library_code,$library);
				if ($item['location'] == 'main') {
					$location_code = 'wdmain';
					$location = 'wdmain';
					$item->changeItemLocation($location_code,$location);
				}
				if ($item['location'] == 'over') {
					$item['location'] = 'wdover';
					$item['location_code'] = 'wdover';
				}
				if ($item['location'] == 'overplus') {
					$item['location'] = 'wdoverplus';
					$item['location_code'] = 'wdoverplus';
				}
			}
			if ($item['statistics_note_2'] == '') {
				$item['statistics_note_2'] = 'FIRE 2018 OZONE';
			} else {}/*elseif ($item['statistics_note_2'] != '') {}*/
			//$item['statistics_note_3'] = $this['whichnote'];
			if ($item['statistics_note_3'] == '') {
				$item['statistics_note_3'] = $this['whichnote'];
			} else {}
			if ($this['whichnote'] == 'To be WITHDRAWN') {
				$item['statistics_note_3'] = $this['whichnote'];
				$item['library'] = 'WITHDRAW';
				$item['library_code'] = 'WITHDRAW';
				if ($item['location'] == 'main') {
					$item['location'] = 'wdmain';
					$item['location_code'] = 'wdmain';
				}
				if ($item['location'] == 'over') {
					$item['location'] = 'wdover';
					$item['location_code'] = 'wdover';
				}
				if ($item['location'] == 'overplus') {
					$item['location'] = 'wdoverplus';
					$item['location_code'] = 'wdoverplus';
				}
			}
			$item->updateAlma();
			$this->addMessage('success',"Successfully updated Item Recored for: {$item['barcode']}");
			//$this->addMessage('success',"Successfully updated Item Recored for:{$item['barcode']} and set#{$set['set_id']}");
		}
	}
}
ASDecisions::RunIt();