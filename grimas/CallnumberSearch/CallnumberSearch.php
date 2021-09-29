<?php

require_once("../grima-lib.php");

class CallnumberSearch extends GrimaTask {

	function do_task() {
		$this->holding = new Holding();
		$this['holding_id'] = Holding::getHoldingIDFromCallnumber($this['call_number']);
		if ($this['holding_id']) {
			echo $this['holding_id']
			/*$this->holding->loadFromAlma($this['holding_id'],$this['holding_id']);
			$this->holding->getItems();
			$this->splatVars['holding'] = $this->holding;*/
		}
	}
}

CallnumberSearch::RunIt();
