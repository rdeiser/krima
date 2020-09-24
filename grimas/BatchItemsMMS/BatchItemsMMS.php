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
				
				if (empty($this['barcode'])) {
					$item = new Itemnbc();
					//$item['fulfillment_note'] = $this['fulnote'];
					$item['item_policy'] = 'book/ser';
					$item['pieces'] = '1';
					$item['inventory_date'] = '1976-01-01';
					$item['receiving_operator'] = 'Grima';
					$item['statistics_note_2'] = 'FIRE 2018 OZONE';
					$item['statistics_note_3'] = $this['whichnote'];
					$item->addToAlmaHolding($mmsid,$this['holding_id']);
					
					if ($this->item['statistics_note_3'] == 'GOV UNBOXING review') {
						if($this->item['location_code'] == 'main') {
							$this->item['library_code'] = 'WITHDRAW';
							$this->item['location_code'] = 'wdgov';
						}
						if($this->item['location_code'] == 'gov') {
							$this->item['library_code'] = 'WITHDRAW';
							$this->item['location_code'] = 'wdgov';
						}
						if($this->item['location_code'] == 'govcen') {
							$this->item['library_code'] = 'WITHDRAW';
							$this->item['location_code'] = 'wdgovcen';
						}
						if($this->item['location_code'] == 'govelect') {
							$this->item['library_code'] = 'WITHDRAW';
							$this->item['location_code'] = 'wdgovelect';
						}
						if($this->item['location_code'] == 'govmap') {
							$this->item['library_code'] = 'WITHDRAW';
							$this->item['location_code'] = 'wdgovmap';
						}
						if($this->item['location_code'] == 'govmfile') {
							$this->item['library_code'] = 'WITHDRAW';
							$this->item['location_code'] = 'wdgovmfile';
						}
						if($this->item['location_code'] == 'govmic') {
							$this->item['library_code'] = 'WITHDRAW';
							$this->item['location_code'] = 'wdgovmic';
						}
						if($this->item['location_code'] == 'govover') {
							$this->item['library_code'] = 'WITHDRAW';
							$this->item['location_code'] = 'wdgovover';
						}
						if($this->item['location_code'] == 'govref') {
							$this->item['library_code'] = 'WITHDRAW';
							$this->item['location_code'] = 'wdgovref';
						}
						if($this->item['location_code'] == 'govmindex') {
							$this->item['library_code'] = 'WITHDRAW';
							$this->item['location_code'] = 'wgovmindex';
						}
						if($this->item['location_code'] == 'govoffmap') {
							$this->item['library_code'] = 'WITHDRAW';
							$this->item['location_code'] = 'wgovoffmap';
						}
						if($this->item['location_code'] == 'govposter') {
							$this->item['library_code'] = 'WITHDRAW';
							$this->item['location_code'] = 'wgovposter';
						}
						$this->item->updateAlma();
					}
				} else {
					$this->item = new Item();
					$this->item->loadFromAlmaX($item['item_pid']);
					$this->item['barcode'] = $this['barcode'];
					if ($this->item['statistics_note_3'] == 'GOV UNBOXING review') {
						if($this->item['location_code'] == 'main') {
							$this->item['library_code'] = 'WITHDRAW';
							$this->item['location_code'] = 'wdgov';
						}
						if($this->item['location_code'] == 'gov') {
							$this->item['library_code'] = 'WITHDRAW';
							$this->item['location_code'] = 'wdgov';
						}
						if($this->item['location_code'] == 'govcen') {
							$this->item['library_code'] = 'WITHDRAW';
							$this->item['location_code'] = 'wdgovcen';
						}
						if($this->item['location_code'] == 'govelect') {
							$this->item['library_code'] = 'WITHDRAW';
							$this->item['location_code'] = 'wdgovelect';
						}
						if($this->item['location_code'] == 'govmap') {
							$this->item['library_code'] = 'WITHDRAW';
							$this->item['location_code'] = 'wdgovmap';
						}
						if($this->item['location_code'] == 'govmfile') {
							$this->item['library_code'] = 'WITHDRAW';
							$this->item['location_code'] = 'wdgovmfile';
						}
						if($this->item['location_code'] == 'govmic') {
							$this->item['library_code'] = 'WITHDRAW';
							$this->item['location_code'] = 'wdgovmic';
						}
						if($this->item['location_code'] == 'govover') {
							$this->item['library_code'] = 'WITHDRAW';
							$this->item['location_code'] = 'wdgovover';
						}
						if($this->item['location_code'] == 'govref') {
							$this->item['library_code'] = 'WITHDRAW';
							$this->item['location_code'] = 'wdgovref';
						}
						if($this->item['location_code'] == 'govmindex') {
							$this->item['library_code'] = 'WITHDRAW';
							$this->item['location_code'] = 'wgovmindex';
						}
						if($this->item['location_code'] == 'govoffmap') {
							$this->item['library_code'] = 'WITHDRAW';
							$this->item['location_code'] = 'wgovoffmap';
						}
						if($this->item['location_code'] == 'govposter') {
							$this->item['library_code'] = 'WITHDRAW';
							$this->item['location_code'] = 'wgovposter';
						}
						$this->item->updateAlma();
					}

			$this->addMessage('success',"Successfully added an Item Record to {$holding['holding_id']} with Barcode: {$this->item['barcode']}");
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