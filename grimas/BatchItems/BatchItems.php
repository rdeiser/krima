<?php

require_once("../grima-lib.php");

class BatchItems extends GrimaTask {
	public $holdinglist = array();

	function do_task() {
		$this->holdings = preg_split('/\r\n|\r|\n/',$this['holding_id']);

		foreach ($this->holdings as $holdingid) {
			$holding = new Holding();
			$this['mms_id'] = Holding::getMmsFromHoldingID($holdingid);
			if ($this['mms_id']) {
				$holding->loadFromAlma($this['mms_id'],$holdingid);
				//$item = new Item();
				//$item->($item['barcode']);
				//$item['inventory_date'] = '1976-01-01';
				//$item['statistics_note_2'] = 'FIRE 2018 OZONE';
				//$item['statistics_note_3'] = $this['whichnote'];
				$item->addToAlmaHolding($this['mms_id'],$holdingid);
				$this->addMessage('success',"Successfully added an Item Record to {$holdingid}");
			} else {
				$this->addMessage('error',"Holding Record Suppressed or no longer active in Alma {$holdingid}");
			}
			$this->holdinglist[] = $holding;
		}
		/*foreach ($this->holdinglist as $holding) {
			$count = count($holding->itemList->items, COUNT_RECURSIVE);
		}
		
		$this->addMessage('success',"Total Number of Items Added {$count}");*/
		//$this->holding->getItems();
		//$this->splatVars['holding'] = $this->holding;
		//$this->splatVars['width'] = 12;
		//$this->splatVars['holdinglist'] = $this->holdinglist;
		//$this->splatVars['body'] = array( 'holding', 'messages' );
	}
}
BatchItems::RunIt();
