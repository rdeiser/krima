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
			//$item->loadFromAlmaBarcode($barcode);
			$item->loadFromAlmaBCorX($barcode);
			
			//$item->addInventoryDate(date("Y-m-d"));
			if ($item['inventory_date'] == '') {
				$item->addInventoryDate("1976-01-01");
			}
			//unset($item['barcode']);
			/*if ($this['whichnote']=='AHD HALE return'){
				$item['statistics_note_3'] = $this['whichnote'];
			}
			if ($this['whichnote']=='AHD ANNEX ingest'){
				$item['statistics_note_3'] = $this['whichnote'];
			}
			if ($this['whichnote']=='AHD To be WITHDRAWN'){
				$item['statistics_note_3'] = $this['whichnote'];
			}*/
			if ($this['whichnote']=='PHYSICAL CONDITION REVIEW For Possible Withdraw'){
				$item['statistics_note_3'] = $this['whichnote'];
			}
			if ($item['statistics_note_2'] == '') {
				//$item['statistics_note_2'] = $this['whichnote2'];
				$item['statistics_note_2'] = 'FIRE 2018 OZONE';
			} else {}/*elseif ($item['statistics_note_2'] != '') {}*/
			
			$item['statistics_note_3'] = $this['whichnote'];
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
				if($item['location_code'] == 'annex') {
					$item['library_code'] = 'WITHDRAW';
					$item['location_code'] = 'wdmain';
				}
				if($item['location_code'] == 'musart') {
					$item['library_code'] = 'WITHDRAW';
					$item['location_code'] = 'wdmusart';
				}
				if($item['location_code'] == 'musartover') {
					$item['library_code'] = 'WITHDRAW';
					$item['location_code'] = 'wdmusartov';
				}
				if($item['location_code'] == 'musscore') {
					$item['library_code'] = 'WITHDRAW';
					$item['location_code'] = 'wdmusscore';
				}
				if($item['location_code'] == 'musartref') {
					$item['library_code'] = 'WITHDRAW';
					$item['location_code'] = 'wdmusartre';
				}
				if($item['location_code'] == 'muscd') {
					$item['library_code'] = 'WITHDRAW';
					$item['location_code'] = 'wdmuscd';
				}
				if($item['location_code'] == 'muscdover') {
					$item['library_code'] = 'WITHDRAW';
					$item['location_code'] = 'wdmuscdove';
				}
				if($item['location_code'] == 'mediacoll') {
					$item['library_code'] = 'WITHDRAW';
					$item['location_code'] = 'wdmediacol';
				}
				if($item['location_code'] == 'medialp') {
					$item['library_code'] = 'WITHDRAW';
					$item['location_code'] = 'wdmedialp';
				}
				if($item['location_code'] == 'mediaover') {
					$item['library_code'] = 'WITHDRAW';
					$item['location_code'] = 'wdmediaove';
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
				if($item['location_code'] == 'annex') {
					$item['library_code'] = 'WITHDRAW';
					$item['location_code'] = 'wdmain';
				}
				if($item['location_code'] == 'musart') {
					$item['library_code'] = 'WITHDRAW';
					$item['location_code'] = 'wdmusart';
				}
				if($item['location_code'] == 'musartover') {
					$item['library_code'] = 'WITHDRAW';
					$item['location_code'] = 'wdmusartov';
				}
				if($item['location_code'] == 'musscore') {
					$item['library_code'] = 'WITHDRAW';
					$item['location_code'] = 'wdmusscore';
				}
				if($item['location_code'] == 'musartref') {
					$item['library_code'] = 'WITHDRAW';
					$item['location_code'] = 'wdmusartre';
				}
				if($item['location_code'] == 'muscd') {
					$item['library_code'] = 'WITHDRAW';
					$item['location_code'] = 'wdmuscd';
				}
				if($item['location_code'] == 'muscdover') {
					$item['library_code'] = 'WITHDRAW';
					$item['location_code'] = 'wdmuscdove';
				}
				if($item['location_code'] == 'mediacoll') {
					$item['library_code'] = 'WITHDRAW';
					$item['location_code'] = 'wdmediacol';
				}
				if($item['location_code'] == 'medialp') {
					$item['library_code'] = 'WITHDRAW';
					$item['location_code'] = 'wdmedialp';
				}
				if($item['location_code'] == 'mediaover') {
					$item['library_code'] = 'WITHDRAW';
					$item['location_code'] = 'wdmediaove';
				}
			}
			if ($item['statistics_note_3'] == 'GOV UNBOXING review') {
				if($item['location_code'] == 'main') {
					$item['library_code'] = 'WITHDRAW';
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
			}
			$item->updateAlma();
			$this->addMessage('success',"Successfully updated Item Recored for: {$item['barcode']}");
			//$this->addMessage('success',"Successfully updated Item Recored for:{$item['barcode']} and set#{$set['set_id']}");
		}
	}
}
ASDecisions::RunIt();