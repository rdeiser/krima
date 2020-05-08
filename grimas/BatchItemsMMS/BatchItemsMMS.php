<?php

require_once("../grima-lib.php");

class BatchItemsMMS extends GrimaTask {
	public $biblist = array();

	function do_task() {
		$this->bibs = preg_split('/\r\n|\r|\n/',$this['mms']);

		foreach ($this->bibs as $mmsid) {
			$bib = new Bib();
			$bib->loadFromAlma($mmsid);
			$bib->getHoldings();
			if ($holding['library_code'] = 'MAIN') {
				$holding = $bib->holdings[0];
				if ($holding['holding_suppress'] = 'true') {
					$this->addMessage('warn', "Holdings record is suppressed for {$bib['mms_id']}");
					continue;
				} else {
				//	$holding = $bib->holdings[0];
				//	$holding->getItemList();
				//if (count($holding->itemList->items) = 0) {
					$item = new Item();
					$item['barcode'] = '';
					//$item['inventory_date'] = '1976-01-01';
					$item['statistics_note_2'] = 'FIRE 2018 OZONE';
					$item['statistics_note_3'] = 'HALE return';
					$item->addToAlmaHolding($mmsid,$this['holding_id']);
					$this->addMessage('success',"Successfully added an Item Record to {$holding['holding_id']}");
					continue;
				} else {
					$this->addMessage('warn',"Holding Record  for bib {$mmsid} has an Item Record");
				//}
			}
				continue;
			} else {
				$this->addMessage('warn',"Bib {$mmsid} does not have a MAIN holdings record");
			}
			$this->biblist[] = $bib;
}
}
}
BatchItemsMMS::RunIt();
