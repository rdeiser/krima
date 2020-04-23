<?php
require_once("../grima-lib.php");

class BatchItems extends GrimaTask {
	public $holdinglist = array();
	
	function do_task() {
		$this->bibs = preg_split('/\r\n|\r|\n/',$this['mms']);

		foreach ($this->bibs as $mmsid) {
			$bib = new Bib();
			$bib->loadFromAlma($mmsid);
			$this->biblist[] = $bib;
		}

		$this->biblist[0]->getHoldings();
		$mfhd = $this->biblist[0]->holdings[0];

		foreach (this->biblist as $k => $bib) {
			if ($k > 0) {
				$ret = $newItem->addToAlmaHolding($this->item['mms_id'],$this->item['holding_id']);
			$this->item = new Item();
			$this->item->xml = $ret;
			}
		}
		$mfhd->updateAlma();

		$this->splatVars['width'] = 12;
		$this->splatVars['biblist'] = $this->biblist;
		$this->splatVars['body'] = array( 'list', 'messages' );

	}
}
BatchItems::RunIt();
