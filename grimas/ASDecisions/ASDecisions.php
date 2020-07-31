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
			if ($item['inventory_date'] == '') {
				$item->addInventoryDate("1976-01-01");
			}
			//unset($item['barcode']);
			if ($this['whichnote']=='AHD HALE return'){
				$item['statistics_note_3'] = $this['whichnote'];
			}
			if ($this['whichnote']=='AHD ANNEX ingest'){
				$item['statistics_note_3'] = $this['whichnote'];
			}
			if ($this['whichnote']=='AHD To be WITHDRAWN'){
				$item['statistics_note_3'] = $this['whichnote'];
			}
			if ($this['whichnote']=='PHYSICAL CONDITION REVIEW For Possible Withdraw'){
				$item['statistics_note_3'] = $this['whichnote'];
			}
			if ($item['statistics_note_2'] == '') {
				$item['statistics_note_2'] = 'FIRE 2018 OZONE';
			} else {}/*elseif ($item['statistics_note_2'] != '') {}*/
			$item['statistics_note_3'] == $this['whichnote'];
			/*if ($item['statistics_note_3'] == '') {
				$item['statistics_note_3'] = $this['whichnote'];
			} else {}*/
			if ($item['statistics_note_3'] == 'AHD To be WITHDRAWN') {
				if($item['location_code'] == 'cmc') {
					$item['library_code'] = 'WITHDRAW';
					$item['location_code'] = 'wdcmc';
				}
				if($item['location_code'] == 'juv') {
					$item['library_code'] = 'WITHDRAW';
					$item['location_code'] = 'wdjuv';
				}
				if($item['location_code'] == 'main') {
					$item['library_code'] = 'WITHDRAW';
					$item['location_code'] = 'wdmain';
				}
				if($item['location_code'] == 'over') {
					$item['library_code'] = 'WITHDRAW';
					$item['location_code'] = 'wdover';
				}
				if($item['location_code'] == 'overplus') {
					$item['library_code'] = 'WITHDRAW';
					$item['location_code'] = 'wdoverplus';
				}
				if($item['location_code'] == 'ref') {
					$item['library_code'] = 'WITHDRAW';
					$item['location_code'] = 'wdref';
				}
			}
			if ($item['statistics_note_3'] == 'To be WITHDRAWN') {
				if($item['location_code'] == 'cmc') {
					$item['library_code'] = 'WITHDRAW';
					$item['location_code'] = 'wdcmc';
				}
				if($item['location_code'] == 'juv') {
					$item['library_code'] = 'WITHDRAW';
					$item['location_code'] = 'wdjuv';
				}
				if($item['location_code'] == 'main') {
					$item['library_code'] = 'WITHDRAW';
					$item['location_code'] = 'wdmain';
				}
				if($item['location_code'] == 'over') {
					$item['library_code'] = 'WITHDRAW';
					$item['location_code'] = 'wdover';
				}
				if($item['location_code'] == 'overplus') {
					$item['library_code'] = 'WITHDRAW';
					$item['location_code'] = 'wdoverplus';
				}
				if($item['location_code'] == 'ref') {
					$item['library_code'] = 'WITHDRAW';
					$item['location_code'] = 'wdref';
				}
			}
			if ($item['statistics_note_3'] == 'PHYSICAL CONDITION REVIEW For Possible Withdraw') {
				if($item['location_code'] == 'cmc') {
					$item['library_code'] = 'WITHDRAW';
					$item['location_code'] = 'wdcmc';
				}
				if($item['location_code'] == 'juv') {
					$item['library_code'] = 'WITHDRAW';
					$item['location_code'] = 'wdjuv';
				}
				if($item['location_code'] == 'main') {
					$item['library_code'] = 'WITHDRAW';
					$item['location_code'] = 'wdmain';
				}
				if($item['location_code'] == 'over') {
					$item['library_code'] = 'WITHDRAW';
					$item['location_code'] = 'wdover';
				}
				if($item['location_code'] == 'overplus') {
					$item['library_code'] = 'WITHDRAW';
					$item['location_code'] = 'wdoverplus';
				}
				if($item['location_code'] == 'ref') {
					$item['library_code'] = 'WITHDRAW';
					$item['location_code'] = 'wdref';
				}
			}
			$item->updateAlma();
			$this->addMessage('success',"Successfully updated Item Recored for: {$item['barcode']}");
			//$this->addMessage('success',"Successfully updated Item Recored for:{$item['barcode']} and set#{$set['set_id']}");
		}
	}
}
ASDecisions::RunIt();