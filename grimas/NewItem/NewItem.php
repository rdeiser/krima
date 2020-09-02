<?php

require_once("../grima-lib.php");

class NewItem extends GrimaTask {
	public $holdinglist = array();

	function do_task() {
		$this->holdings = preg_split('/\r\n|\r|\n/',$this['holding_id']);

		foreach ($this->holdings as $holdingid) {
			$holding = new Holding();
			$this['mms_id'] = Holding::getMmsFromHoldingID($holdingid);
			if ($this['mms_id']) {
				$holding->loadFromAlma($this['mms_id'],$holdingid);
				if ($this['statnote3'] == 'AHD To be WITHDRAWN'){
					if ($holding['location_code'] == 'main') {
						$holding['library_code'] = 'WITHDRAW';
						$holding['location_code'] = 'wdmain';
					} 
					if ($holding['location_code'] == 'over') {
						$holding['library_code'] = 'WITHDRAW';
						$holding['location_code'] = 'wdover';
					} 
					if ($holding['location_code'] == 'cmc') {
						$holding['library_code'] = 'WITHDRAW';
						$holding['location_code'] = 'wdcmc';
					} 
					if ($holding['location_code'] == 'juv') {
						$holding['library_code'] = 'WITHDRAW';
						$holding['location_code'] = 'wdjuv';
					} 
					if ($holding['location_code'] == 'overplus') {
						$holding['library_code'] = 'WITHDRAW';
						$holding['location_code'] = 'wdoverplus';
					} 
					if ($holding['location_code'] == 'ref') {
						$holding['library_code'] = 'WITHDRAW';
						$holding['location_code'] = 'wdref';
					}
					$holding->updateAlma();
				}
				if ($this['statnote3'] == 'To be WITHDRAWN'){
					if ($holding['location_code'] == 'main') {
						$holding['library_code'] = 'WITHDRAW';
						$holding['location_code'] = 'wdmain';
					} 
					if ($holding['location_code'] == 'over') {
						$holding['library_code'] = 'WITHDRAW';
						$holding['location_code'] = 'wdover';
					} 
					if ($holding['location_code'] == 'cmc') {
						$holding['library_code'] = 'WITHDRAW';
						$holding['location_code'] = 'wdcmc';
					} 
					if ($holding['location_code'] == 'juv') {
						$holding['library_code'] = 'WITHDRAW';
						$holding['location_code'] = 'wdjuv';
					} 
					if ($holding['location_code'] == 'overplus') {
						$holding['library_code'] = 'WITHDRAW';
						$holding['location_code'] = 'wdoverplus';
					} 
					if ($holding['location_code'] == 'ref') {
						$holding['library_code'] = 'WITHDRAW';
						$holding['location_code'] = 'wdref';
					}
					$holding->updateAlma();
				}
				if ($this['statnote3'] == 'PHYSICAL CONDITION REVIEW For Possible Withdraw'){
					if ($holding['location_code'] == 'main') {
						$holding['library_code'] = 'WITHDRAW';
						$holding['location_code'] = 'wdmain';
					} 
					if ($holding['location_code'] == 'over') {
						$holding['library_code'] = 'WITHDRAW';
						$holding['location_code'] = 'wdover';
					} 
					if ($holding['location_code'] == 'cmc') {
						$holding['library_code'] = 'WITHDRAW';
						$holding['location_code'] = 'wdcmc';
					} 
					if ($holding['location_code'] == 'juv') {
						$holding['library_code'] = 'WITHDRAW';
						$holding['location_code'] = 'wdjuv';
					} 
					if ($holding['location_code'] == 'overplus') {
						$holding['library_code'] = 'WITHDRAW';
						$holding['location_code'] = 'wdoverplus';
					} 
					if ($holding['location_code'] == 'ref') {
						$holding['library_code'] = 'WITHDRAW';
						$holding['location_code'] = 'wdref';
					}
					$holding->updateAlma();
				}
				if(empty($this['barcode'])) {
					$item = new Itemnbc();
					if (empty($this['copyid'])) {
						$item['copy_id'] = '0';
					} else {
						$item['copy_id'] = $this['copyid'];
					}
					$item['item_policy'] = $this['itempolicy'];
					if (empty($this['pieces'])) {
						$item['pieces'] = '1';
					} else {
						$item['pieces'] = $this['pieces'];
					}
					$item['inventory_date'] = date("Y-m-d");
					$item['receiving_operator'] = 'Grima';
					$item['public_note'] = $this ['pubnote'];
					$item['fulfillment_note'] = $this['fulnote'];
					$item['statistics_note_1'] = $this['statnote1'];
					$item['statistics_note_2'] = $this['statnote2'];
					$item['statistics_note_3'] = $this['statnote3'];
					$item->addToAlmaHolding($this['mms_id'],$holdingid);
					
					$this->addMessage('success',"Successfully added an Item Record to {$holdingid} with PID: {$item['item_pid']}");
				} else {
					$item = new Item();
					if (empty($this['copyid'])) {
						$item['copy_id'] = '0';
					} else {
						$item['copy_id'] = $this['copyid'];
					}
					$item['item_policy'] = $this['itempolicy'];
					if (empty($this['pieces'])) {
						$item['pieces'] = '1';
					} else {
						$item['pieces'] = $this['pieces'];
					}
					$item['inventory_date'] = date("Y-m-d");
					$item['receiving_operator'] = 'Grima';
					$item['public_note'] = $this ['pubnote'];
					$item['fulfillment_note'] = $this['fulnote'];
					$item['statistics_note_1'] = $this['statnote1'];
					$item['statistics_note_2'] = $this['statnote2'];
					$item['statistics_note_3'] = $this['statnote3'];
					$item['barcode'] = $this['barcode'];
					$item->addToAlmaHolding($this['mms_id'],$holdingid);
					$this->addMessage('success',"Successfully added an Item Record to {$holdingid} with Barcode: {$item['barcode']}");
				}
			} else {
				$this->addMessage('error',"Holding Record Suppressed or no longer active in Alma {$holdingid}");
			}
		}
	}
}

NewItem::RunIt();
