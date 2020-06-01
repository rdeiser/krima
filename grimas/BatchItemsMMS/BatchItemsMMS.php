<?php

require_once("../grima-lib.php");

class BatchItemsMMS extends GrimaTask {
	public $biblist = array();

	function do_task() {
		$this->bibs = preg_split('/\r\n|\r|\n/',$this['mms']);

		foreach ($this->bibs as $mmsid) {
			$bib = new Bib();
			$bib->loadFromAlma($mmsid);
			$bib->getHoldings();
			$holding = new Holding();
			$holding['library_code'] = 'WITHDRAW';
			if ($holding['location_code'] = 'main') {
				$holding['location_code'] = 'wdmain';
			} else {}
			if ($holding['location_code'] = 'over') {
				$holding['location_code'] = 'wdover';
			} else {}
			if ($holding['location_code'] = 'cmc') {
				$holding['location_code'] = 'wdcmc';
			} else {}
			if ($holding['location_code'] = 'juv') {
				$holding['location_code'] = 'wdjuv';
			} else {}
			if ($holding['location_code'] = 'overplus') {
				$holding['location_code'] = 'wdoverplus';
			} else {}
			if ($holding['location_code'] = 'ref') {
				$holding['location_code'] = 'wdref';
			} else {}
			$holding->updateAlma();
		}
			
			$this->biblist[] = $bib;
}
}
//}
BatchItemsMMS::RunIt();
