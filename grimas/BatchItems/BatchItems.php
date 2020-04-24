<?php

require_once("../grima-lib.php");

class BatchItems extends GrimaTask {
	public $holdinglist = array();
	
	function do_task() {
		$this->holdings = preg_split('/\r\n|\r|\n/',$this['mms']);

		# HOLDING
		foreach ($this->holdings as $holdingid) {
			$holding = new Holding();
			$holding->loadFromAlma($this['mms_id'],$this['holding_id']);
			$this->holdinglist[] = $holding;
		}

		/*## BIBS
		$this->holdinglist[0]->getBib();
		$mmsid = $this->holdinglist[0]->bib[0];

		function do_task() {
			$this->item = new Item();
			$newItem->addToAlmaHolding($this->item['mms_id'],$this->item['holding_id']);
		}*/
		
		$this->splatVars['width'] = 12;
		$this->splatVars['holdinglist'] = $this->holdinglist;
		$this->splatVars['body'] = array( 'list', 'messages' );
	}

}

BatchItems::RunIt();
