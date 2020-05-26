<?php

require_once("../grima-lib.php");

class ASDecisions extends GrimaTask {
	public $barcodelist = array();

	function do_task() {
		$this->barcodes = preg_split('/\r\n|\r|\n/',$this['barcodes']);

		foreach ($this->barcodes as $barcode) {
			$item = new Item();
			$item->loadFromAlmaBarcode($barcode);
			if (isset($item['statistics_note_2'])) {
			} else {
				$item['statistics_note_2'] = 'FIRE 2018 OZONE';
			}/*elseif ($item['statistics_note_2'] != '') {}
			if (empty($item['statistics_note_3'])) {
				$item['statistics_note_3'] = $this['whichnote'];
			} elseif ($item['statistics_note_3'] != '') {}*/
			$item->updateAlma();
			$this->addMessage('success',"Successfully updated Item Recored for:{$item['barcode']}");
		}
	}
}
ASDecisions::RunIt();