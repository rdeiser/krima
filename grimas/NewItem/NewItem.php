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
					
					$this->item = new Item();
					$this->item->loadFromAlmaX($item['item_pid']);
					if ($this['statnote3'] == 'AHD To be WITHDRAWN'){
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
				if ($this['statnote3'] == 'To be WITHDRAWN'){
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
				if ($this['statnote3'] == 'PHYSICAL CONDITION REVIEW For Possible Withdraw'){
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
				if ($this['statnote3'] == 'Gov unboxing review'){
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
					
					$this->addMessage('success',"Successfully added an Item Record to {$holdingid} with PID: {$this->item['barcode']}");
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
				if ($this['statnote3'] == 'To be WITHDRAWN'){
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
				if ($this['statnote3'] == 'PHYSICAL CONDITION REVIEW For Possible Withdraw'){
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
				if ($this['statnote3'] == 'Gov unboxing review'){
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
					$this->addMessage('success',"Successfully added an Item Record to {$holdingid} with Barcode: {$this->item['barcode']}");
				}
			} else {
				$this->addMessage('error',"Holding Record Suppressed or no longer active in Alma {$holdingid}");
			}
		}
	}
}

NewItem::RunIt();
