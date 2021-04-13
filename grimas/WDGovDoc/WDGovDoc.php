<?php

require_once("../grima-lib.php");

class WDGovDoc extends GrimaTask {
	public $holdinglist = array();

	function do_task() {
		$this->holdings = preg_split('/\r\n|\r|\n/',$this['holding_id']);

		foreach ($this->holdings as $holdingid) {
			$holding = new Holding();
			$this['mms_id'] = Holding::getMmsFromHoldingID($holdingid);
			if ($this['mms_id']) {
				$holding->loadFromAlma($this['mms_id'],$holdingid);
				if (isset($this['barcode'])) {
					$item = new Item();
					$item['barcode'] = $this['barcode'];
					$item['item_policy'] = 'book/ser';
					$item['pieces'] = '1';
					$item['inventory_date'] = date("Y-m-d");
					$item['receiving_operator'] = 'Grima';
					$item['statistics_note_3'] = $this['whichnote'];
					$item->addToAlmaHolding($this['mms_id'],$holdingid);
				}
				if ($this['whichnote'] == 'KU FDLP REQUEST') {
					$item['statistics_note_1'] = 'WITHDRAWN';
					$item['statistics_note_2'] = 'FIRE 2018 OZONE';
					$item['statistics_note_3'] = $this['whichnote'];
					$this->item['library_code'] = 'WITHDRAW';
					$this->item['location_code'] = 'wdgovKU';
					$item->addToAlmaHolding($this['mms_id'],$holdingid);
				}
				if ($this['whichnote'] == 'NOT KU FDLP REQUEST') {
					$item['statistics_note_1'] = 'WITHDRAWN';
					$item['statistics_note_2'] = 'FIRE 2018 OZONE';
					$item['statistics_note_3'] = '';
					$this->item['library_code'] = 'WITHDRAW';
					$this->item['location_code'] = 'wdgov';
					$item->addToAlmaHolding($this['mms_id'],$holdingid);
				}
				/* else {
					$item = new Itemnbc();
					$item['item_policy'] = 'book/ser';
					$item['pieces'] = '1';
					$item['inventory_date'] = date("Y-m-d");
					$item['receiving_operator'] = 'Grima';
					$item['statistics_note_2'] = 'FIRE 2018 OZONE';
					$item['statistics_note_3'] = 'GOV UNBOXING review';
					$item->addToAlmaHolding($this['mms_id'],$holdingid);
				}*/

				$this->item = new Item();
				$this->item->loadFromAlmaX($item['item_pid']);
				$item['barcode'] = $this['barcode'];
				//$this->item['internal_note_1'] = 'Gov unboxing review';
				if ($this->item['statistics_note_3'] == 'KU FDLP REQUEST') {
					$this->item['library_code'] = 'WITHDRAW';
					$this->item['location_code'] = 'wdgovKU';
				}
				
				if($this->item['location_code'] == 'main') {
					$this->item['library_code'] = 'WITHDRAW';
					$this->item['location_code'] = 'wdgov';
				}
				if($this->item['location_code'] == 'ref') {
					$this->item['library_code'] = 'WITHDRAW';
					$this->item['location_code'] = 'wdgov';
				}
				if($this->item['location_code'] == 'wdmain') {
					$this->item['location_code'] = 'wdgov';
				}
				if($this->item['location_code'] == 'gov') {
					$this->item['library_code'] = 'WITHDRAW';
					$this->item['location_code'] = 'wdgov';
				}
				if($this->item['location_code'] == 'govcen') {
					$this->item['library_code'] = 'WITHDRAW';
					$this->item['location_code'] = 'wdgovcen';
				}
				if($this->item['location_code'] == 'govelect') {
					$this->item['library_code'] = 'WITHDRAW';
					$this->item['location_code'] = 'wdgovelect';
				}
				if($this->item['location_code'] == 'govmap') {
					$this->item['library_code'] = 'WITHDRAW';
					$this->item['location_code'] = 'wdgovmap';
				}
				if($this->item['location_code'] == 'govmfile') {
					$this->item['library_code'] = 'WITHDRAW';
					$this->item['location_code'] = 'wdgovmfile';
				}
				if($this->item['location_code'] == 'govmic') {
					$this->item['library_code'] = 'WITHDRAW';
					$this->item['location_code'] = 'wdgovmic';
				}
				if($this->item['location_code'] == 'govover') {
					$this->item['library_code'] = 'WITHDRAW';
					$this->item['location_code'] = 'wdgovover';
				}
				if($this->item['location_code'] == 'govref') {
					$this->item['library_code'] = 'WITHDRAW';
					$this->item['location_code'] = 'wdgovref';
				}
				if($this->item['location_code'] == 'govmindex') {
					$this->item['library_code'] = 'WITHDRAW';
					$this->item['location_code'] = 'wgovmindex';
				}
				if($this->item['location_code'] == 'govoffmap') {
					$this->item['library_code'] = 'WITHDRAW';
					$this->item['location_code'] = 'wgovoffmap';
				}
				if($this->item['location_code'] == 'govposter') {
					$this->item['library_code'] = 'WITHDRAW';
					$this->item['location_code'] = 'wgovposter';
				}
				
				$this->item->updateAlma();
				
				$this->addMessage('success',"Successfully added an Item Record to {$holdingid} with Barcode: {$this->item['barcode']}");
			} else {
				$this->addMessage('error',"Holding Record Suppressed or no longer active in Alma {$holdingid}");
			}
			$this->holdinglist[] = $holding;
		}
	}
}
WDGovDoc::RunIt();
