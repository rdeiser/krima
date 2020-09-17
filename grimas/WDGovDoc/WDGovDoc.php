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

				$item = new Itemnbc();
				//$item['fulfillment_note'] = $this['fulnote'];
				$item['item_policy'] = 'book/ser';
				$item['pieces'] = '1';
				$item['inventory_date'] = date("Y-m-d");
				$item['receiving_operator'] = 'Grima';
				$item['statistics_note_2'] = 'FIRE 2018 OZONE';
				$item->addToAlmaHolding($this['mms_id'],$holdingid);
				
				$this->item = new Item();
				$this->item->loadFromAlmaX($item['item_pid']);
				$this->item['internal_note_1'] = 'Gov unboxing review';
				$this->item['library_code'] = 'WITHDRAW';
				$this->item['location_code'] = 'wdgov';
				
				$this->item->updateAlma();
				
				$this->addMessage('success',"Successfully added an Item Record to {$holdingid} with item PID: {$item['item_pid']}");
			} else {
				$this->addMessage('error',"Holding Record Suppressed or no longer active in Alma {$holdingid}");
			}
			$this->holdinglist[] = $holding;
		}
	}
}
WDGovDoc::RunIt();
