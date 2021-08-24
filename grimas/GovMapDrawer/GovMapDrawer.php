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
					$xpath = new DomXpath ($this->xml);
					$callnumber = $xpath->query("//record/datafield[@tag='852']/subfield[@code='h']");
					if ($holding['location_code'] = $this['whichnote'] && $callnumber = $this['olddrawer']) {
						$holding->setCallNumber('$this['newdrawer]','','8');
						$holding->updateAlma();
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
