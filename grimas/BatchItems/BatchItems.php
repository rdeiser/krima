<?php

require_once("../grima-lib.php");

class BatchItems extends GrimaTask {
	public $holdinglist = array();

	function do_task() {
		$this->holdings = preg_split('/\r\n|\r|\n/',$this['holding_id']);

		foreach ($this->holdings as $holdingid) {
			if ($this['whichnote'] == 'SpecUniv'){
				$holding = new Holding();
				$holding->loadFromAlma($holdingid,$holdingid);
				$holding->deleteSubfieldMatching("866","z","/(^Request at Special Collections$)/");
				$holding->updateAlma();

				$item = new Item();
				$item['item_policy'] = 'no loan';
				$item['pieces'] = '1';
				//$item['inventory_date'] = date("Y-m-d");
				$item['receiving_operator'] = 'Grima';
				$item['statistics_note_2'] = 'FIRE 2018 SPECIAL COLLECTIONS';
				$item->addToAlmaHolding($holdingid,$holdingid);
			
				$this->addMessage('success',"Successfully added an Item Record to {$holdingid} with item PID: {$item['item_pid']}");
			} else {
				
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
				
				$this->item = new Item();
				$this->item->loadFromAlmaX($item['item_pid']);
				if ($item['statistics_note_3'] == 'GOV UNBOXING review') {
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
				$this->addMessage('success',"Successfully added an Item Record to {$holdingid} with item PID: {$item['item_pid']}");
				
			} else {
				$this->addMessage('error',"Holding Record Suppressed or no longer active in Alma {$holdingid}");
			}
			}
			$this->holdinglist[] = $holding;
		}
		
	}
}
BatchItems::RunIt();
