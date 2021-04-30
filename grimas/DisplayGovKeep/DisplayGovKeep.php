<?php

require_once("../grima-lib.php");

class DisplayGovKeep extends GrimaTask {

	function do_task() {
		{$item = new Item();
		$item->loadFromAlmaBarcode($this['unboxed_barcode']);
		$item->addInventoryDate(date("Y-m-d"));
		if ($item['item_policy'] !== 'book/ser') {
			if ($item['location_code'] == 'govcen'||'govelect'||'govover'||'govref'||'govposter') {
				$item['location_code'] = 'gov';
				$item['item_policy'] = 'book/ser';
			}
		}
		$item->updateAlma();
		}
{
		$this->item = new Item();
		$this->item->loadFromAlmaBarcode($this['unboxed_barcode']);
		$this->splatVars['item'] = $this->item;
}
}
}

DisplayGovKeep::RunIt();
