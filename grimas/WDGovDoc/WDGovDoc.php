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
					$item['statistics_note_2'] = 'FIRE 2018 OZONE';
					$item['statistics_note_3'] = '';
					$item->addToAlmaHolding($this['mms_id'],$holdingid);
				} else {
					$item = new Itemnbc();
					$item['item_policy'] = 'book/ser';
					$item['pieces'] = '1';
					$item['inventory_date'] = date("Y-m-d");
					$item['receiving_operator'] = 'Grima';
					$item['statistics_note_2'] = 'FIRE 2018 OZONE';
					$item['statistics_note_3'] = '';
					$item->addToAlmaHolding($this['mms_id'],$holdingid);
				}

				$this->item = new Item();
				$this->item->loadFromAlmaX($item['item_pid']);
				$item['barcode'] = $this['barcode'];
				//$this->item['internal_note_1'] = 'Gov unboxing review';
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
				
				$this->item->updateAlma();
				
				$this->addMessage('success',"Successfully added an Item Record to {$holdingid} with Barcode: {$item['barcode']}");
			} else {
				$this->addMessage('error',"Holding Record Suppressed or no longer active in Alma {$holdingid}");
			}
			$this->holdinglist[] = $holding;
		}
	}
}
WDGovDoc::RunIt();
