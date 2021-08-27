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
				if ($holding['call_number'] = ' Drawer 211 ') {
					$holding['call_number'] = 'Drawer 371';
				}
				if ($holding['location_code'] = 'govoffmap') {
					$holding['location_code'] = 'govmap');
				}
					
				//$holding->setMapCallNumber($this['whichnote'],$this['olddrawer'],$this['newdrawer'],'8');
				$holding->updateAlma();
				$this->addMessage('success',"Successfully updated map drawer number for {$holdingid} with {$holding['call_number']}");
				} else {
				$this->addMessage('error',"Did not update map drawer number for {$holdingid}");
				continue;
				}
		}
	}
}

GovMapDrawer::RunIt();
