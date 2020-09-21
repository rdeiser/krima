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
					
					$this->item = new Item();
					$this->item->loadFromAlmaX($item['item_pid']);
					if ($this['statnote3'] == 'AHD To be WITHDRAWN'){
					if ($item['location_code'] == 'main') {
						$item['library_code'] = 'WITHDRAW';
						$item['location_code'] = 'wdmain';
					} 
					if ($item['location_code'] == 'over') {
						$item['library_code'] = 'WITHDRAW';
						$item['location_code'] = 'wdover';
					} 
					if ($item['location_code'] == 'cmc') {
						$item['library_code'] = 'WITHDRAW';
						$item['location_code'] = 'wdcmc';
					} 
					if ($item['location_code'] == 'juv') {
						$item['library_code'] = 'WITHDRAW';
						$item['location_code'] = 'wdjuv';
					} 
					if ($item['location_code'] == 'overplus') {
						$item['library_code'] = 'WITHDRAW';
						$item['location_code'] = 'wdoverplus';
					} 
					if ($item['location_code'] == 'ref') {
						$item['library_code'] = 'WITHDRAW';
						$item['location_code'] = 'wdref';
					}
					$this->item->updateAlma();
				}
				if ($this['statnote3'] == 'To be WITHDRAWN'){
					if ($item['location_code'] == 'annex') {
						$item['library_code'] = 'WITHDRAW';
						$item['location_code'] = 'wdmain';
					} 
					if ($item['location_code'] == 'main') {
						$item['library_code'] = 'WITHDRAW';
						$item['location_code'] = 'wdmain';
					} 
					if ($item['location_code'] == 'over') {
						$item['library_code'] = 'WITHDRAW';
						$item['location_code'] = 'wdover';
					} 
					if ($item['location_code'] == 'cmc') {
						$item['library_code'] = 'WITHDRAW';
						$item['location_code'] = 'wdcmc';
					} 
					if ($item['location_code'] == 'juv') {
						$item['library_code'] = 'WITHDRAW';
						$item['location_code'] = 'wdjuv';
					} 
					if ($item['location_code'] == 'overplus') {
						$item['library_code'] = 'WITHDRAW';
						$item['location_code'] = 'wdoverplus';
					} 
					if ($item['location_code'] == 'ref') {
						$item['library_code'] = 'WITHDRAW';
						$item['location_code'] = 'wdref';
					}
					$this->item->updateAlma();
				}
				if ($this['statnote3'] == 'PHYSICAL CONDITION REVIEW For Possible Withdraw'){
					if ($item['location_code'] == 'main') {
						$item['library_code'] = 'WITHDRAW';
						$item['location_code'] = 'wdmain';
					} 
					if ($item['location_code'] == 'over') {
						$item['library_code'] = 'WITHDRAW';
						$item['location_code'] = 'wdover';
					} 
					if ($item['location_code'] == 'cmc') {
						$item['library_code'] = 'WITHDRAW';
						$item['location_code'] = 'wdcmc';
					} 
					if ($item['location_code'] == 'juv') {
						$item['library_code'] = 'WITHDRAW';
						$item['location_code'] = 'wdjuv';
					} 
					if ($item['location_code'] == 'overplus') {
						$item['library_code'] = 'WITHDRAW';
						$item['location_code'] = 'wdoverplus';
					} 
					if ($item['location_code'] == 'ref') {
						$item['library_code'] = 'WITHDRAW';
						$item['location_code'] = 'wdref';
					}
					$this->item->updateAlma();
				}
				if ($this['statnote3'] == 'Gov unboxing review'){
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
				}
					$this->addMessage('success',"Successfully added an Item Record to {$holdingid} with Barcode: {$item['barcode']}");
				}
			} else {
				$this->addMessage('error',"Holding Record Suppressed or no longer active in Alma {$holdingid}");
			}
		}
	}
}

NewItem::RunIt();
