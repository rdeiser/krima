<?php

require_once("../grima-lib.php");

class GovMapDrawer extends GrimaTask {
	public $holdinglist = array();

	function do_task() {
		$this->holdings = preg_split('/\r\n|\r|\n/',$this['holding_id']);

		foreach ($this->holdings as $holdingid) {
			$holding = new Holding();
			$this['mms_id'] = $holdingid;
			if ($this['mms_id']) {
				$holding->loadFromAlma($this['mms_id'],$holdingid);
				if ($holding['location_code'] == $this['whichnote'] && $holding->HoldingsListEntry['call_number'] = 'Drawer 103'){
					$holding->setCallNumber('Drawer 345','','8');
					$holding->updateAlma();
					$this->addMessage('success',"Successfully updated map drawer number for {$holdingid} to: {$holding->HoldingsListEntry['call_number']}");
				} else {
					$this->addMessage('error',"Did not update map drawer number for {$holdingid}");
					continue;
				}
				if ($holding['location_code'] == $this['whichnote'] && $holding->HoldingsListEntry['call_number'] = 'Drawer 104'){
					$holding->setCallNumber('Drawer 346','','8');
					$holding->updateAlma();
				}
				if ($holding['location_code'] == $this['whichnote'] && $holding->HoldingsListEntry['call_number'] = 'Drawer 105'){
					$holding->setCallNumber('Drawer 347','','8');
					$holding->updateAlma();
				}
					}
				}
				//$this->addMessage('success',"Successfully updated map drawer number for {$holdingid} to: STOP");
				//$this->addMessage('success',"Successfully added an Item Record to {$holdingid} with Barcode: {$item['barcode']}");
				/*function print_success() {
    do_redirect('../WithdrawLibrary/WithdrawLibrary.php?holding_id=' . $this['holding_id']);
}*/
			}
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
GovMapDrawer::RunIt();
