<?php

require_once("../grima-lib.php");

class BatchItemsMMS extends GrimaTask {
	public $biblist = array();

	function do_task() {
		$this->bibs = preg_split('/\r\n|\r|\n/',$this['mms']);

		foreach ($this->bibs as $mmsid) {
			$bib = new Bib();
			$this['holding_id'] = Bib::getHoldingIDFromMms($mmsid);
			if ($this['holding_id']) {
				$holding->loadFromAlma($mmsid,$this['holding_id']);
				$item = new Item();
				$item['barcode'] = '';
				//$item['inventory_date'] = '1976-01-01';
				$item['statistics_note_2'] = 'FIRE 2018 OZONE';
				$item['statistics_note_3'] = 'HALE return';
				$item->addToAlmaHolding($mmsid,$this['holding_id']);
				$this->addMessage('success',"Successfully added an Item Record to {$holding['holding_id']}");
			} else {
				$this->addMessage('error',"Holding Record Suppressed or no longer active in Alma {$mmsid}");
			}
			$this->biblist[] = $bib;
		}
	}
}
BatchItemsMMS::RunIt();
