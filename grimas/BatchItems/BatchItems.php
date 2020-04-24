<?php

require_once("../grima-lib.php");

class BatchItems extends GrimaTask {
	public $biblist = array();
	
	function do_task() {
		$this->bibs = preg_split('/\r\n|\r|\n/',$this['mms']);

		# BIBS
		foreach ($this->bibs as $mmsid) {
			$bib = new Bib();
			$bib->loadFromAlma($mmsid);
			$this->biblist[] = $bib;
		}

		## HOLDING
		$this->biblist[0]->getHoldings();
		$mfhd = $this->biblist[0]->holdings[0];

		function do_task() {
			$this->item = new Item();
			$newItem->addToAlmaHolding($this->item['mms_id'],$this->item['holding_id']);
		}
	}

}

BatchItems::RunIt();
