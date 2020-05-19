<?php

require_once("../grima-lib.php");

class ASDecisions extends GrimaTask {
	public $holdinglist = array();

	function do_task() {
		$this->barcodes = preg_split('/\r\n|\r|\n/',$this['holding_id']);

		foreach ($this->barcodes as $barcode) {
			$item = new Item();
			$item->loadFromAlmaBarcode($barcode);
			if ($item['statistics_note_2'] == '') {
				$item['statistics_note_2'] = 'FIRE 2018 OZONE';
				continue;
			} else {}
			if ($item['statistics_note_3'] == '') {
				$item['statistics_note_3'] = $this['whichnote'];
			} else {}
			$item->updateAlma();
		}
	}
}
ASDecisions::RunIt();