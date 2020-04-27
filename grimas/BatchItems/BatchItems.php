<?php

require_once("../grima-lib.php");

class BatchItems extends GrimaTask {
	public $holdinglist = array();
	
	function do_task() {
		$this->holding = preg_split('/\r\n|\r|\n/',$this['mfhd']);

		foreach ($this->holding as $holdingid) {
			$this->holding = new Holding();
			$this['mms_id']=Holding::getMmsFromHoldingID($this['holding_id']);
			if ($this['mms_id']){
				$this->holding->loadFromAlma(this['mms_id'],$this['holding_id']);
				$this->holding->getItems();
			$this->splatVars['holding']=$this->holding;
			}else{
				$this->splatVars['message']=$this->message;
			}
	}
}
}
BatchItems::RunIt();
