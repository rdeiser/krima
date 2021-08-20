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
				if ($this['whichnote'] == 'govmap'){
					if ($holding['location_code'] == $this['whichnote']) {
						if ($holding['call_number'] = 'Drawer 166') {
							$holding->setCallNumber('Drawer 357','','8');
							$holding->updateAlma();
						}
					}
				}
				$this->addMessage('success',"Successfully added an Item Record to {$holdingid} with item PID: {$item['item_pid']}");
				//$this->addMessage('success',"Successfully added an Item Record to {$holdingid} with Barcode: {$item['barcode']}");
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
GovMapDrawer::RunIt();
