<?php

require_once("../grima-lib.php");

class BatchItem extends GrimaTask {
	public $holdinglist = array();

	function do_task() {
		$this->holdings = preg_split('/\r\n|\r|\n/',$this['holding_id']);

		foreach ($this->holdings as $holdingid) {
			$holding = new Holding();
			$this['mms_id'] = Holding::getMmsFromHoldingID($holdingid);
			if ($this['mms_id']) {
				$holding->loadFromAlma($this['mms_id'],$holdingid);

				$item = new Item();
				$item['fulfillment_note'] = $this['fulnote'];
				$item['item_policy'] = 'book/ser';
				$item['pieces'] = '1';
				$item['inventory_date'] = date("Y-m-d");
				$item['receiving_operator'] = 'Grima';
				$item['statistics_note_1'] = 'FIRE 2018 OZONE';
				$item['statistics_note_3'] = $this['whichnote'];
				$item->addToAlmaHolding($this['mms_id'],$holdingid);
			}
				$this->addMessage('success',"Successfully added an Item Record to {$holdingid} with item PID: {$item['item_pid']}");
			} else {
				$this->addMessage('error',"Holding Record Suppressed or no longer active in Alma {$holdingid}");
			}
			//$this->holdinglist[] = $holding;
		}
	}
}
BatchItem::RunIt();
