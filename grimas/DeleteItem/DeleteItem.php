<?php

require_once("../grima-lib.php");

class DeleteItem extends GrimaTask {

	function do_task() {
		$item = new Item();
		$item->loadFromAlmaBCorX($this['item']);
		$item['statistics_note_1'] = 'WITHDRAWN';
		$item->updateAlma();
		$item->deleteFromAlma();
		$this->addMessage('success',"Deleted item {$this['item']}");
	}
}

DeleteItem::RunIt();
