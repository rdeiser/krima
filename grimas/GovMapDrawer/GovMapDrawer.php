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
					if ($holding->HoldingsListEntry['call_number'] = '103') {
						$holding->setCallNumber('Drawer 345','','8');
						$holding->updateAlma();
					}
					if ($holding->HoldingsListEntry['call_number'] == 'Drawer 104') {
						$holding->setCallNumber('Drawer 346','','8');
						$holding->updateAlma();
					}
					if ($holding->HoldingsListEntry['call_number'] == 'Drawer 105') {
						$holding->setCallNumber('Drawer 347','','8');
						$holding->updateAlma();
					}
				}
				$this->addMessage('success',"Successfully updated map drawer number for {$holdingid}");
			} else {
				$this->addMessage('error',"Did not update map drawer number for {$holdingid}");
				continue;
			}
		}
	}
}
GovMapDrawer::RunIt();
