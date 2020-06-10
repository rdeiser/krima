<?php

require_once("../grima-lib.php");

class DeleteTreePO extends GrimaTask {

	function do_task() {
		$bib = new Bib();
		$bib->loadFromAlma($this['mms_id']);
		$bib->getHoldings();
		$holding = $bib->holdings[0];
		$holding = new Holding();
		//$withdrawn_phrase = "withdrawn" . date("m-Y")
		$holding->appendField("852","8","","");
		$holding->updateAlma();
		/*$holding->getItemList();
		if (count($holding->itemList->items) > 1) {
			addMessage('warn', "More than one item on holding {$holding['holding_id']}");
			//continue;
		}
		$item = $holding->itemList->items[0];
		$item['statistics_note_1'] = 'WITHDRAWN';
		$item->updateAlma();
		
		$bib->deleteTreeFromAlma();
		$this->addMessage('success',
			"deleted bib {$this['mms_id']} and all inventory with Statistics Note 1 = {$item['statistics_note_1']}");*/
	}
}

DeleteTreePO::RunIt();
