<?php

require_once("../grima-lib.php");

class UpdateItemRecord extends GrimaTask {

	function do_task() {
		$bib = new Bib();
		$bib->loadFromAlma($this['mms']);
		$bib->getHoldings();
		$holding = $bib->holdings[0[;
		$holding->getItemList();
		$item = $holding->itemList->items[0];
		$item['statistics_note_3'] = 'HALE return';
		$item->updateAlma();
		$this->addMessage('success',"Successfully added an Item Record to {$item['item_pid']}:{$item['barcode']}");
	}

}

UpdateItemRecord::RunIt();
