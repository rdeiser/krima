<?php

require_once("../grima-lib.php");

class BatchItemsB extends GrimaTask {
	public $biblist = array();
	
	function do_task() {
		$this->bibs = preg_split('/\r\n|\r|\n/',$this['mms']);

		# BIBS
		foreach ($this->bibs as $mmsid) {
			$bib = new Bib();
			$bib->loadFromAlma($mmsid);
			$bib->getHoldings();
			$this->biblist[] = $bib;
			if($holding['library_code']=='MAIN') {
				$item = new Item();
				$item['barcode'] = '';
				//$item['inventory_date'] = '1976-01-01';
				$item['statistics_note_2'] = 'FIRE 2018 OZONE';
				$item['statistics_note_3'] = 'HALE return';
				$item->addToAlmaHolding($mmsid,$this['holding_id'];
			}
			else {}
		}
		/*## HOLDING
		$this->biblist[0]->getHoldings();
		$mfhd = $this->biblist[0]->holdings[0];

		foreach ($this->biblist as */

		//$this->holding->getItems();
		//$this->splatVars['holding'] = $this->holding;
		//$this->splatVars['width'] = 12;
		$this->splatVars['biblist'] = $this->biblist;
		$this->splatVars['body'] = array( 'list', 'messages' );
	}
}
BatchItemsB::RunIt();
