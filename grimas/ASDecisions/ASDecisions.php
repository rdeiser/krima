<?php

require_once("../grima-lib.php");

class ASDecisions extends GrimaTask {
	public $barcodelist = array();

	function do_task() {
		$this->barcodes = preg_split('/\r\n|\r|\n/',$this['barcodes']);

		foreach ($this->barcodes as $barcode) {
			$item = new Item();
			$item->loadFromAlmaBarcode($barcode);
			if (empty($item['statistics_note_2']) and empty($item['statistics_note_3'])) {
				$item['statistics_note_2'] = 'FIRE 2018 OZONE';
				$item['statistics_note_3'] = $this['whichnote'];
			} elseif ($item['statistics_note_2'] != '' and empty($item['statistics_note_3'])) {
				$item['statistics_note_3'] = $this['whichnote'];
			} elseif (empty($item['statistics_note_2']) and $item['statistics_note_3'] != '') {
				$item['statistics_note_2'] = 'FIRE 2018 OZONE';
			}
			$item->updateAlma();
		}
	}
}
ASDecisions::RunIt();