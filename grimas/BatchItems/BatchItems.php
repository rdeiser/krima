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
			$this->bib->getHoldings();
			/*if ($holding['Library']=='HALE') {
				addToAlmaHolding($this->item['mms_id'],$this->item['holding_id']);
			$this->item = new Item();
			$this->item->xml;
			} else {
				GrimaTask::call('ShowItemsFromHoldingsB', array('holding_id' => $this['holding_id']));
			}*/
		}

		$this->splatVars['biblist'] = $this->biblist;
		$this->splatVars['body'] = array( 'holding', 'messages' );
	}

}
BatchItems::RunIt();
