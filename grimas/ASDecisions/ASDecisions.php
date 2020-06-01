<?php

require_once("../grima-lib.php");

class ASDecisions extends GrimaTask {
	public $barcodelist = array();

	function do_task() {
		$set = new Set();
		$set->createSet($this['setName']);

		$this->barcodes = preg_split('/\r\n|\r|\n/',$this['barcodes']);

		foreach ($this->barcodes as $barcode) {
			$set->postSetManageMembers();
			$item = new Item();
			$item->loadFromAlmaBarcode($barcode);
			if ($item['statistics_note_2'] == '') {
				$item['statistics_note_2'] = 'FIRE 2018 OZONE';
			} else {}/*elseif ($item['statistics_note_2'] != '') {}*/
			if ($item['statistics_note_3'] == '') {
				$item['statistics_note_3'] = $this['whichnote'];
			} else {}
			$item->updateAlma();
			//$set = new Set();
			//$set->postSetMangeMembers;
			$this->addMessage('success',"Successfully updated Item Recored for:{$item['barcode']}");
		}
	}
}
ASDecisions::RunIt();