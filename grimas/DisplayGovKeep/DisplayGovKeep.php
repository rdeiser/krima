<?php

require_once("../grima-lib.php");

class DisplayGovKeep extends GrimaTask {

	function do_task() {
		$item = new Item();
		$item->loadFromAlmaBarcode($this['unboxed_barcode']);
		$item->addInventoryDate(date("Y-m-d"));
		if ($item['location_code'] == 'govcen'||'govelect'||'govover'||'govref'||'govposter') {
			$item['location_code'] = 'gov';
			$item['item_policy'] = 'book/ser';
			$item->updateAlma();
		}
		if ($item['item_policy'] !== 'book/ser') {
			if ($item['statistics_note_3'] == 'HALE return') {
				if($item['location_code'] == 'govcen'||'govelect'||'govover'||'govref'||'govposter') {
					$holding = new Holding ();
					$holding->getItemList();
					if (count($holding->itemList->items) = 1 {
						$holding->loadFromAlma($item['mms_id'],$item['holding_id']);
						$holding['location_code'] = 'gov';
						$holding->updateAlma();
					}
				}
			}
		} else {
			$item = new Item();
			$item->loadFromAlmaBarcode($this['unboxed_barcode']);
			if ($item['location_code'] == 'govcen'||'govelect'||'govover'||'govref'||'govposter') {
				$item['location_code'] = 'gov';
				$item->updateAlma();
			}
		}
		
		$this->item = new Item();
		$this->item->loadFromAlmaBarcode($this['unboxed_barcode']);
		$this->splatVars['item'] = $this->item;
	}
}


DisplayGovKeep::RunIt();
