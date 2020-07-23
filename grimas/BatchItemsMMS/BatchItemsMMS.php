<?php

require_once("../grima-lib.php");

class BatchItemsMMS extends GrimaTask {
	public $biblist = array();

	function do_task() {
		$this->bibs = preg_split('/\r\n|\r|\n/',$this['mms']);

		foreach ($this->bibs as $mmsid) {
			$holding = new Holding();
			$holding->loadFromAlma($mmsid,$this['holding_id']);

			$item = new Itemnbc();
				//$item['fulfillment_note'] = $this['fulnote'];
				$item['item_policy'] = 'book/ser';
				$item['pieces'] = '1';
				$item['inventory_date'] = '1976-01-01';
				$item['receiving_operator'] = 'Grima';
				$item['statistics_note_2'] = 'FIRE 2018 OZONE';
				$item['statistics_note_3'] = $this['whichnote'];
				$item->addToAlmaHolding($mmsid,$this['holding_id']);

			$this->addMessage('success',"Successfully added an Item Record to {$holding['holding_id']} with Barcode: {$item['item_pid']}");
				/*function print_success() {
    do_redirect('../WithdrawLibrary/WithdrawLibrary.php?holding_id=' . $this['holding_id']);
}*/
			}/* else {
				$this->addMessage('error',"Holding Record Suppressed or no longer active in Alma {$holdingid}");
			}*/
			$this->holdinglist[] = $holding;
		}

	}

BatchItemsMMS::RunIt();