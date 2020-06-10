<?php

require_once("../grima-lib.php");

class DeleteTree extends GrimaTask {

	function do_task() {
		$bib = new Bib();
		$bib->loadFromAlma($this['mms_id']);
		$bib->getHoldings();
		$holding = $bib->holdings[0];
		$holding->getItemList();
		if (count($holding->itemList->items) > 1) {
			addMessage('warn', "More than one item on holding {$holding['holding_id']}");
			//continue;
		} else {
		if ($item['statistics_note_3'] == 'To be WITHDRAWN') {
			if ($item['statistics_note_1'] == '') {
				$item['statistics_note_1'] = 'WITHDRAWN';
				$item->updateAlma();
			} else {}
		}
		
		$holding->deleteTreeFromAlma();
		$this->addMessage('success',
			"deleted bib {$this['mms_id']} and all inventory with Statistics Note 1 = {$item['statistics_note_1']}");
	}
}
}

DeleteTree::RunIt();
