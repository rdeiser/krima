<?php

require_once("../grima-lib.php");

class BatchItems extends GrimaTask {
	public $biblist = array();
	
	function do_task() {
		$this->holdings = preg_split('/\r\n|\r|\n/',$this['mms']);
		$this->holding->loadFromAlma($this['holding_id']);
		/*foreach ($this->holding->item as $item) {
			$this->item = new Item();
			$newItem->addToAlmaHolding($this->item['mms_id'],$this->item['holding_id']);
		}*/
		
		$this->splatVars['width'] = 12;
		$this->splatVars['biblist'] = $this->biblist;
		$this->splatVars['body'] = array( 'list', 'messages' );
	}

}

BatchItems::RunIt();
