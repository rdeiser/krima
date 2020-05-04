<?php

require_once("../grima-lib.php");

class BatchItems extends GrimaTask {
	public $holdinglist = array();

	function do_task() {
		$this->holdings = preg_split('/\r\n|\r|\n/',$this['holding_id']);

		foreach ($this->holdings as $holdingid) {
			$holding = new Holding();
			$this['mms_id'] = Holding::getMmsFromHoldingID($holdingid);
			$holding->loadFromAlma($this['mms_id'],$holdingid);
			$item = new Item();
			$item['barcode'] = '';
			//$item['inventory_date'] = '1976-01-01';
			$item['statistics_note_2'] = 'FIRE 2018 OZONE';
			$item['statistics_note_3'] = 'HALE return';
			$item->addToAlmaHolding($this['mms_id'],$holdingid);
			$countA = count($item['item_pid']);
			$this->holdinglist[] = $holding;
		}
		$countB = count($countA);
		$this->addMessage('success',"Number of Item Records Added {$countB}");
		//$this->holding->getItems();
		//$this->splatVars['holding'] = $this->holding;
		//$this->splatVars['width'] = 12;
		//$this->splatVars['holdinglist'] = $this->holdinglist;
		//$this->splatVars['body'] = array( 'holding', 'messages' );
	}
}
BatchItems::RunIt();
