<?php

require_once("../grima-lib.php");

class WithdrawLibrary extends GrimaTask {
	public $holdinglist = array();

	function do_task() {
		$this->holdings = preg_split('/\r\n|\r|\n/',$this['holding_id']);

		foreach ($this->holdings as $holdingid) {
			$holding = new Holding();
			$this['mms_id'] = Holding::getMmsFromHoldingID($holdingid);
			if ($this['mms_id']) {
				$holding->loadFromAlma($this['mms_id'],$holdingid);
				$holding = new Holding();
				if ($holding['location_code'] == 'main') {
				$holding['library_code'] = 'WITHDRAW';
				$holding['location_code'] = 'wdmain';
			} else {}
			if ($holding['location_code'] == 'over') {
				$holding['library_code'] = 'WITHDRAW';
				$holding['location_code'] = 'wdover';
			} else {}
			if ($holding['location_code'] == 'cmc') {
				$holding['library_code'] = 'WITHDRAW';
				$holding['location_code'] = 'wdcmc';
			} else {}
			if ($holding['location_code'] == 'juv') {
				$holding['library_code'] = 'WITHDRAW';
				$holding['location_code'] = 'wdjuv';
			} else {}
			if ($holding['location_code'] == 'overplus') {
				$holding['library_code'] = 'WITHDRAW';
				$holding['location_code'] = 'wdoverplus';
			} else {}
			if ($holding['location_code'] == 'ref') {
				$holding['library_code'] = 'WITHDRAW';
				$holding['location_code'] = 'wdref';
			} else {}
			$holding->updateAlma();
				
	}
}
}
}
WithdrawLibrary::RunIt();
