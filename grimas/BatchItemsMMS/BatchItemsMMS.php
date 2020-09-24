<?php

require_once("../grima-lib.php");

class BatchItemsMMS extends GrimaTask {
	public $biblist = array();

	function do_task() {
		$this->bibs = preg_split('/\r\n|\r|\n/',$this['mms']);

		foreach ($this->bibs as $mmsid) {
			$holding = new Holding();
			$holding->loadFromAlma($mmsid,$this['holding_id']);
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
				}
				$holding->updateAlma();

			$item = new Itemnbc();
				//$item['fulfillment_note'] = $this['fulnote'];
				$item['item_policy'] = 'book/ser';
				$item['pieces'] = '1';
				$item['inventory_date'] = '1976-01-01';
				$item['receiving_operator'] = 'Grima';
				$item['statistics_note_2'] = 'FIRE 2018 OZONE';
				$item['statistics_note_3'] = $this['whichnote'];
				$item->addToAlmaHolding($mmsid,$this['holding_id']);
				
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