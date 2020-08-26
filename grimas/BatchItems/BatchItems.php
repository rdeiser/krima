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
				if ($this['whichnote'] == 'AHD To be WITHDRAWN'){
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
				if ($this['whichnote'] == 'To be WITHDRAWN'){
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
				if ($this['whichnote'] == 'PHYSICAL CONDITION REVIEW For Possible Withdraw'){
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

				$item = new Itemnbc();
				//$item['fulfillment_note'] = $this['fulnote'];
				$item['item_policy'] = 'book/ser';
				$item['pieces'] = '1';
				$item['inventory_date'] = '1976-01-01';
				$item['receiving_operator'] = 'Grima';
				$item['statistics_note_2'] = 'FIRE 2018 OZONE';
				$item['statistics_note_3'] = $this['whichnote'];
				$item->addToAlmaHolding($this['mms_id'],$holdingid);
				
				$item = new Item();
				$item->loadFromAlmaBCorX($item['item_pid');
				
				//$this->addMessage('success',"Successfully added an Item Record to {$holdingid} with item PID: {$item['item_pid']}");
				$this->addMessage('success',"Successfully added an Item Record to {$holdingid} with Barcode: {$item['barcode']}");
				/*function print_success() {
    do_redirect('../WithdrawLibrary/WithdrawLibrary.php?holding_id=' . $this['holding_id']);
}*/
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
