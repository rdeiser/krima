<?php

require_once("../grima-lib.php");

class DeleteItem extends GrimaTask {

	function do_task() {
		$item = new Item();
		$item->loadFromAlmaBCorX($this['item']);
		$item['statistics_note_1'] = 'WITHDRAWN';
		unset($item['statistics_note_3']);
		$item->updateAlma();
		/*if ($item['statistics_note_3'] == 'To be WITHDRAWN') {
			if ($item['statistics_note_1'] == '') {
				$item['statistics_note_1'] = 'WITHDRAWN';
				$item->updateAlma();
			}
		}*/
		if ($item['statistics_note_1'] = 'WITHDRAWN' && $item['statistics_note_3'] = '') {
			$item->deleteFromAlma();
			$this->addMessage('success',"Deleted item {$this['item']} with Statistics Note 1 of {$item['statistics_note_1']} and Statistics Note 3 of {$item['statistics_note_3']}");
			} else {
				$this->addMessage('error',"Item Record for {$item['barcode']} has Statistics Note 1 of {$item['statistics_note_1']} and Statistics Note 3 of {$item['statistics_note_3']}");
		}
	}
}

DeleteItem::RunIt();
