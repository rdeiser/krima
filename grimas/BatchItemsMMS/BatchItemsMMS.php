<?php

require_once("../grima-lib.php");

class BatchItemsMMS extends GrimaTask {
	public $biblist = array();

	function do_task() {
		$this->bibs = preg_split('/\r\n|\r|\n/',$this['mms']);

		foreach ($this->bibs as $mmsid) {
			$holding = new Holding();
			$holding->loadFromAlma($mmsid,$this['holding_id']);
			if ($holding['location_code'] = 'main') {
				$holding['library_code'] = 'WITHDRAW';
				$holding['location_code'] = 'wdmain';
			} 
			if ($holding['location_code'] = 'over') {
				$holding['library_code'] = 'WITHDRAW';
				$holding['location_code'] = 'wdover';
			} 
			if ($holding['location_code'] = 'cmc') {
				$holding['library_code'] = 'WITHDRAW';
				$holding['location_code'] = 'wdcmc';
			} 
			if ($holding['location_code'] = 'juv') {
				$holding['library_code'] = 'WITHDRAW';
				$holding['location_code'] = 'wdjuv';
			} 
			if ($holding['location_code'] = 'overplus') {
				$holding['library_code'] = 'WITHDRAW';
				$holding['location_code'] = 'wdoverplus';
			} 
			if ($holding['location_code'] = 'ref') {
				$holding['library_code'] = 'WITHDRAW';
				$holding['location_code'] = 'wdref';
			} */
			$holding->updateAlma();
		}
}
}
//}
BatchItemsMMS::RunIt();
