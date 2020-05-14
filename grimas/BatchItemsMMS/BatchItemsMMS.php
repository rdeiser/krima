<?php

require_once("../grima-lib.php");

class BatchItemsMMS extends GrimaTask {
	public $biblist = array();

	function do_task() {
		$this->bibs = preg_split('/\r\n|\r|\n/',$this['mms']);

		foreach ($this->bibs as $mmsid) {
			$bib = new Bib();
			$bib->loadFromAlma($mmsid);
			$this->biblist[0]->getHoldings();
			$mfhd =$this->biblist[0]->holdings[0];
			
			$item = new Item();
			$item->addToAlmaHolding($mmsid,$mfhd);
		}
			
			$this->biblist[] = $bib;
}
}
//}
BatchItemsMMS::RunIt();
