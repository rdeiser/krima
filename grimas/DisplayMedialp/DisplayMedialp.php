<?php

require_once("../grima-lib.php");

class DisplayMedialp extends GrimaTask {

	function do_task() {
		{$item = new Item();
		$item->loadFromAlmaBarcode($this['unboxed_barcode']);
		$item->addInventoryDate(date("Y-m-d"));
		//ADD to Right body splat
		/*if ($item['in_temp_location'] = 'true') {
			$item['in_temp_location'] = 'false';
		}*/
		$item->updateAlma();
		}
		
{
		$this->item = new Item();
		$this->item->loadFromAlmaBarcode($this['unboxed_barcode']);
		$this->splatVars['item'] = $this->item;
}
}
}

DisplayMedialp::RunIt();
