<?php

require_once("../grima-lib.php");

class ASDecisions extends GrimaTask {
	public $barcodelist = array();

	function do_task() {
		//$set = new Set();
		//$set->createSet($this['setName']);
		//$set->postSetManageMembers($set['set_id']);

		$this->barcodes = preg_split('/\r\n|\r|\n/',$this['barcodes']);

		foreach ($this->barcodes as $barcode) {

			$item = new Item();
			//$item->loadFromAlmaBarcode($barcode);
			$item->loadFromAlmaBCorX($barcode);
			$item['statistics_note_3'] = $this['whichnote'];
			if ($item['internal_note_1'] == 'Gov unboxing review') {
				unset($item['internal_note_1']);
			}
			
			$item->updateAlma();
			$this->addMessage('success',"Successfully updated Item Recored for: {$item['barcode']}");
			//$this->addMessage('success',"Successfully updated Item Recored for:{$item['barcode']} and set#{$set['set_id']}");
		}
	}
}
ASDecisions::RunIt();