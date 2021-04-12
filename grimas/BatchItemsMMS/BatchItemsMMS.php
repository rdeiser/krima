<?php

require_once("../grima-lib.php");

class BatchItemsMMS extends GrimaTask {
	public $biblist = array();

	function do_task() {
		if (empty($this['mms'])) {
			$holding = new Holding();
			$holding->loadFromAlma($this['holding_id'],$this['holding_id']);
			
				if ($this['whichnote'] == ''){
					$item = new Item();
					$item['barcode'] = $this['barcode'];
					$item['item_policy'] = 'book/ser';
					$item['pieces'] = '1';
					$item['inventory_date'] = date("Y-m-d");
					$item['receiving_operator'] = 'Grima';
					$item['statistics_note_1'] = 'WITHDRAWN';
					$item['statistics_note_2'] = 'FIRE 2018 OZONE';
				} else {
				$item->addToAlmaHolding($this['holding_id'],$this['holding_id']);
				$item = new Item();
				$item['barcode'] = $this['barcode'];
				$item['item_policy'] = 'book/ser';
				$item['pieces'] = '1';
				$item['inventory_date'] = date("Y-m-d");
				$item['receiving_operator'] = 'Grima';
				$item['statistics_note_2'] = 'FIRE 2018 OZONE';
				$item['statistics_note_3'] = $this['whichnote'];
				$item->addToAlmaHolding($this['holding_id'],$this['holding_id']);
				
				$this->item = new Item();
				$this->item->loadFromAlmaX($item['item_pid']);
				if ($this['whichnote'] == 'AHD To be WITHDRAWN'){
					if ($this->item['location_code'] == 'main') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmain';
					} 
					if ($this->item['location_code'] == 'over') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdover';
					} 
					if ($this->item['location_code'] == 'cmc') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdcmc';
					} 
					if ($this->item['location_code'] == 'juv') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdjuv';
					} 
					if ($this->item['location_code'] == 'overplus') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdoverplus';
					} 
					if ($this->item['location_code'] == 'ref') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdref';
					}
					if ($this->item['location_code'] == 'annex') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmain';
					}
					if ($this->item['location_code'] == 'musart') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmusart';
					}
					if ($this->item['location_code'] == 'musartover') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmusartov';
					}
					if ($this->item['location_code'] == 'musscore') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmusscore';
					}
					if ($this->item['location_code'] == 'musartref') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmusartre';
					}
					if ($this->item['location_code'] == 'muscd') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmuscd';
					}
					if ($this->item['location_code'] == 'muscdover') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmuscdove';
					}
					if ($this->item['location_code'] == 'mediacoll') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmediacol';
					}
					if ($this->item['location_code'] == 'medialp') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmedialp';
					}
					if ($this->item['location_code'] == 'mediaover') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmediaove';
					}
					$this->item->updateAlma();
				}
				}
				if ($this['whichnote'] == 'To be WITHDRAWN'){
					if ($this->item['location_code'] == 'annex') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmain';
					} 
					if ($this->item['location_code'] == 'main') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmain';
					} 
					if ($this->item['location_code'] == 'over') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdover';
					} 
					if ($this->item['location_code'] == 'cmc') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdcmc';
					} 
					if ($this->item['location_code'] == 'juv') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdjuv';
					} 
					if ($this->item['location_code'] == 'overplus') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdoverplus';
					} 
					if ($this->item['location_code'] == 'ref') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdref';
					}
					if ($this->item['location_code'] == 'annex') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmain';
					}
					if ($this->item['location_code'] == 'musart') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmusart';
					}
					if ($this->item['location_code'] == 'musartover') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmusartov';
					}
					if ($this->item['location_code'] == 'musscore') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmusscore';
					}
					if ($this->item['location_code'] == 'musartref') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmusartre';
					}
					if ($this->item['location_code'] == 'muscd') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmuscd';
					}
					if ($this->item['location_code'] == 'muscdover') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmuscdove';
					}
					if ($this->item['location_code'] == 'mediacoll') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmediacol';
					}
					if ($this->item['location_code'] == 'medialp') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmedialp';
					}
					if ($this->item['location_code'] == 'mediaover') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmediaove';
					}
					$this->item->updateAlma();
				}
				if ($this['whichnote'] == 'PHYSICAL CONDITION REVIEW For Possible Withdraw'){
					if ($this->item['location_code'] == 'main') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmain';
					} 
					if ($this->item['location_code'] == 'over') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdover';
					} 
					if ($this->item['location_code'] == 'cmc') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdcmc';
					} 
					if ($this->item['location_code'] == 'juv') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdjuv';
					} 
					if ($this->item['location_code'] == 'overplus') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdoverplus';
					} 
					if ($this->item['location_code'] == 'ref') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdref';
					}
					if ($this->item['location_code'] == 'annex') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmain';
					}
					if ($this->item['location_code'] == 'musart') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmusart';
					}
					if ($this->item['location_code'] == 'musartover') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmusartov';
					}
					if ($this->item['location_code'] == 'musscore') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmusscore';
					}
					if ($this->item['location_code'] == 'musartref') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmusartre';
					}
					if ($this->item['location_code'] == 'muscd') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmuscd';
					}
					if ($this->item['location_code'] == 'muscdover') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmuscdove';
					}
					if ($this->item['location_code'] == 'mediacoll') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmediacol';
					}
					if ($this->item['location_code'] == 'medialp') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmedialp';
					}
					if ($this->item['location_code'] == 'mediaover') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmediaove';
					}
					$this->item->updateAlma();
				}
				if ($this['whichnote'] == 'GOV UNBOXING review'){
					if($this->item['location_code'] == 'main') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdgov';
					}
					if($this->item['location_code'] == 'wdmain') {
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

				$item = new Item();
				$item['barcode'] = $this['barcode'];
				$item['item_policy'] = 'book/ser';
				$item['pieces'] = '1';
				$item['inventory_date'] = date("Y-m-d");
				$item['receiving_operator'] = 'Grima';
				$item['statistics_note_2'] = 'FIRE 2018 OZONE';
				$item['statistics_note_3'] = $this['whichnote'];
				$item->addToAlmaHolding($this['mms'],$this['holding_id']);
				
				$this->item = new Item();
				$this->item->loadFromAlmaX($item['item_pid']);
				if ($this['whichnote'] == 'AHD To be WITHDRAWN'){
					if ($this->item['location_code'] == 'main') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmain';
					} 
					if ($this->item['location_code'] == 'over') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdover';
					} 
					if ($this->item['location_code'] == 'cmc') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdcmc';
					} 
					if ($this->item['location_code'] == 'juv') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdjuv';
					} 
					if ($this->item['location_code'] == 'overplus') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdoverplus';
					} 
					if ($this->item['location_code'] == 'ref') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdref';
					}
					if ($this->item['location_code'] == 'annex') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmain';
					}
					if ($this->item['location_code'] == 'musart') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmusart';
					}
					if ($this->item['location_code'] == 'musartover') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmusartov';
					}
					if ($this->item['location_code'] == 'musscore') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmusscore';
					}
					if ($this->item['location_code'] == 'musartref') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmusartre';
					}
					if ($this->item['location_code'] == 'muscd') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmuscd';
					}
					if ($this->item['location_code'] == 'muscdover') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmuscdove';
					}
					if ($this->item['location_code'] == 'mediacoll') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmediacol';
					}
					if ($this->item['location_code'] == 'medialp') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmedialp';
					}
					if ($this->item['location_code'] == 'mediaover') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmediaove';
					}
					$this->item->updateAlma();
				}
				if ($this['whichnote'] == 'To be WITHDRAWN'){
					if ($this->item['location_code'] == 'annex') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmain';
					} 
					if ($this->item['location_code'] == 'main') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmain';
					} 
					if ($this->item['location_code'] == 'over') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdover';
					} 
					if ($this->item['location_code'] == 'cmc') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdcmc';
					} 
					if ($this->item['location_code'] == 'juv') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdjuv';
					} 
					if ($this->item['location_code'] == 'overplus') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdoverplus';
					} 
					if ($this->item['location_code'] == 'ref') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdref';
					}
					if ($this->item['location_code'] == 'annex') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmain';
					}
					if ($this->item['location_code'] == 'musart') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmusart';
					}
					if ($this->item['location_code'] == 'musartover') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmusartov';
					}
					if ($this->item['location_code'] == 'musscore') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmusscore';
					}
					if ($this->item['location_code'] == 'musartref') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmusartre';
					}
					if ($this->item['location_code'] == 'muscd') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmuscd';
					}
					if ($this->item['location_code'] == 'muscdover') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmuscdove';
					}
					if ($this->item['location_code'] == 'mediacoll') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmediacol';
					}
					if ($this->item['location_code'] == 'medialp') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmedialp';
					}
					if ($this->item['location_code'] == 'mediaover') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmediaove';
					}
					$this->item->updateAlma();
				}
				if ($this['whichnote'] == 'PHYSICAL CONDITION REVIEW For Possible Withdraw'){
					if ($this->item['location_code'] == 'main') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmain';
					} 
					if ($this->item['location_code'] == 'over') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdover';
					} 
					if ($this->item['location_code'] == 'cmc') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdcmc';
					} 
					if ($this->item['location_code'] == 'juv') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdjuv';
					} 
					if ($this->item['location_code'] == 'overplus') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdoverplus';
					} 
					if ($this->item['location_code'] == 'ref') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdref';
					}
					if ($this->item['location_code'] == 'annex') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmain';
					}
					if ($this->item['location_code'] == 'musart') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmusart';
					}
					if ($this->item['location_code'] == 'musartover') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmusartov';
					}
					if ($this->item['location_code'] == 'musscore') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmusscore';
					}
					if ($this->item['location_code'] == 'musartref') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmusartre';
					}
					if ($this->item['location_code'] == 'muscd') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmuscd';
					}
					if ($this->item['location_code'] == 'muscdover') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmuscdove';
					}
					if ($this->item['location_code'] == 'mediacoll') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmediacol';
					}
					if ($this->item['location_code'] == 'medialp') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmedialp';
					}
					if ($this->item['location_code'] == 'mediaover') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdmediaove';
					}
					$this->item->updateAlma();
				}
				if ($this['whichnote'] == 'GOV UNBOXING review'){
					if($this->item['location_code'] == 'main') {
						$this->item['library_code'] = 'WITHDRAW';
						$this->item['location_code'] = 'wdgov';
					}
					if($this->item['location_code'] == 'wdmain') {
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

		}

			$this->addMessage('success',"Successfully added an Item Record to {$this['holding_id']} with Barcode: {$this->item['barcode']}");
				/*function print_success() {
    do_redirect('../WithdrawLibrary/WithdrawLibrary.php?holding_id=' . $this['holding_id']);
}*/
			/* else {
				$this->addMessage('error',"Holding Record Suppressed or no longer active in Alma {$holdingid}");
			}*/
		}

	}

BatchItemsMMS::RunIt();