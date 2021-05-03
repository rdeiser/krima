<?php

require_once("../grima-lib.php");

class DisplayGovKeep extends GrimaTask {

	function do_task() {
		{$item = new Item();
		$item->loadFromAlmaBarcode($this['unboxed_barcode']);
		$item->addInventoryDate(date("Y-m-d"));
		$item->updateAlma();
		}
		{if($item['location_code'] == 'govcen'||'govelect'||'govover'||'govref'||'govposter') {
			$item['library_code'] = 'MAIN';
			$item['location_code'] = 'gov';
			$item->updateAlma();
		}
		}
		{
		$this->item = new Item();
		$this->item->loadFromAlmaBarcode($this['unboxed_barcode']);
		$this->splatVars['item'] = $this->item;
		}
	}
}

DisplayGovKeep::RunIt();
