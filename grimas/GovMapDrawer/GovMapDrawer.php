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
				if ($this['whichnote'] == 'govmap' || $holding->HoldingsListEntry['call_number'] = 'Drawer 103'){
					if ($holding['location_code'] == $this['whichnote']) {
						if ($holding->HoldingsListEntry['call_number'] = 'Drawer 103') {
							$holding->setCallNumber('Drawer 345','','8');
							$holding->updateAlma();
						}
						if ($holding->HoldingsListEntry['call_number'] = 'Drawer 104') {
							$holding->setCallNumber('Drawer 346','','8');
							$holding->updateAlma();
						}
						if ($holding->HoldingsListEntry['call_number'] = 'Drawer 105') {
							$holding->setCallNumber('Drawer 347','','8');
							$holding->updateAlma();
						}
						if ($holding->HoldingsListEntry['call_number'] = 'Drawer 106') {
							$holding->setCallNumber('Drawer 348','','8');
							$holding->updateAlma();
						}
						if ($holding->HoldingsListEntry['call_number'] = 'Drawer 107') {
							$holding->setCallNumber('Drawer 349','','8');
							$holding->updateAlma();
						}
						if ($holding->HoldingsListEntry['call_number'] = 'Drawer 108') {
							$holding->setCallNumber('Drawer 350','','8');
							$holding->updateAlma();
						}
						if ($holding->HoldingsListEntry['call_number'] = 'Drawer 109') {
							$holding->setCallNumber('Drawer 351','','8');
							$holding->updateAlma();
						}
						if ($holding->HoldingsListEntry['call_number'] = 'Drawer 110') {
							$holding->setCallNumber('Drawer 352','','8');
							$holding->updateAlma();
						}
					}
				}
				$this->addMessage('success',"Successfully updated map drawer number for {$holdingid} to: STOP");
				//$this->addMessage('success',"Successfully added an Item Record to {$holdingid} with Barcode: {$item['barcode']}");
				/*function print_success() {
    do_redirect('../WithdrawLibrary/WithdrawLibrary.php?holding_id=' . $this['holding_id']);
}*/
			} else {
				$this->addMessage('error',"Did not update map drawer number for {$holdingid}");
				continue;
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
GovMapDrawer::RunIt();
