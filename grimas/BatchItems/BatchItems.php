<?php

require_once("../grima-lib.php");

class BatchItems extends GrimaTask {
	public $holdinglist = array();
	
	function do task() {
		$this->holding = preg_split('/\r\n|\r|\n/',$this['holding_id']);

		#pull holdings
		foreach (this->holding as $holding_id) {
			$holding = new Holding();
			$holding->loadFromAlma($holding_id);
			$this->holdinglist[] = $holding;
		}
		foreach ($itemdata_elements as $element) {
				if (isset($this[$element])) {
					$newItem[$element] = $this[$element];
				}
			}
			$ret = $newItem->addToAlmaHolding($this->item['mms_id'],$this->item['holding_id']);
			$this->item = new Item();
			$this->item->xml = $ret;
		}
BatchItems::RunIt();
