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
			$item['item_policy'] = 'book/ser'
			if($item['location_code'] == 'govcen') {
				$item['location_code'] = 'gov';
			}
			if($item['location_code'] == 'govelect') {
				$item['location_code'] = 'gov';
			}
			if($item['location_code'] == 'govover') {
				$item['location_code'] = 'gov';
			}
			if($item['location_code'] == 'govref') {
				$item['location_code'] = 'gov';
			}
			if($item['location_code'] == 'govposter') {
				$item['location_code'] = 'gov';
			}
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
