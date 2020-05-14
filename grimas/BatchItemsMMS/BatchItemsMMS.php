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
			$item = new Item();
			$item->postItem($mmsid,$this['holding_id']);
		}
			
			$this->biblist[] = $bib;
}
}
//}
BatchItemsMMS::RunIt();
