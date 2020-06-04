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
			//$set = new Set();
			//$this['setName'] = Set::postSetManageMembers($setid);
			/*if ($this['setName']) {
				$set->loadFromAlma($set['set_id']);
				$postSetManageMembers($set['set_id'],$barcode);
				$set->addToAlmaSet();
				//$set->addToAlmaSet($set['set_id'],$barcode);
				continue;
			} else {}*/
				
			//$set->postSetManageMembers($set['set_id'], $barcode);
			
			$item = new Item();
			$item->loadFromAlmaBarcode($barcode);
			if ($this->danger = true) {
				$this->addMessage('danger',"Alma did not find {$item['barcode']}");
				continue;
			} else {
			
			if ($item['statistics_note_2'] == '') {
				$item['statistics_note_2'] = 'FIRE 2018 OZONE';
			} else {}/*elseif ($item['statistics_note_2'] != '') {}*/
			if ($item['statistics_note_3'] == '') {
				$item['statistics_note_3'] = $this['whichnote'];
			} else {}
			$item->updateAlma();
			$this->addMessage('success',"Successfully updated Item Recored for:{$item['barcode']}");
			//$this->addMessage('success',"Successfully updated Item Recored for:{$item['barcode']} and set#{$set['set_id']}");
			}
		}
	}
}
ASDecisions::RunIt();