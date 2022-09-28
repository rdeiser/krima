<?php
require_once("../grima-lib.php");
class DisplayCondition extends GrimaTask {
	function do_task() {
		$item = new Item();
		$item->loadFromAlmaBarcode($this['unboxed_barcode']);
		/**$item->addInventoryDate(date("Y-m-d"));
		if ($item['statistics_note_3'] == 'PHYSICAL CONDITION REVIEW For Possible Withdraw') {
			$item['statistics_note_1'] == 'WITHDRAWN';
			if ($item['library'] !== 'WITHDRAW') {
				if($item['location_code'] == 'cmc') {
					$item['library_code'] = 'WITHDRAW';
					$item['location_code'] = 'wdcmc';
				}
				if($item['location_code'] == 'juv') {
					$item['library_code'] = 'WITHDRAW';
					$item['location_code'] = 'wdjuv';
				}
				if($item['location_code'] == 'main') {
					$item['library_code'] = 'WITHDRAW';
					$item['location_code'] = 'wdmain';
				}
				if($item['location_code'] == 'over') {
					$item['library_code'] = 'WITHDRAW';
					$item['location_code'] = 'wdover';
				}
				if($item['location_code'] == 'overplus') {
					$item['library_code'] = 'WITHDRAW';
					$item['location_code'] = 'wdoverplus';
				}
				if($item['location_code'] == 'ref') {
					$item['library_code'] = 'WITHDRAW';
					$item['location_code'] = 'wdref';
				}
			}
		}			
		$item->updateAlma();
{
		$this->item = new Item();
		$this->item->loadFromAlmaBarcode($this['unboxed_barcode']);
		$this->splatVars['item'] = $this->item;
}*/ /**else {
	$this->addMessage('error',"Place book on No Barcode Shelf {$this['unboxed_barcode']}");
}**/
}
}
DisplayCondition::RunIt();