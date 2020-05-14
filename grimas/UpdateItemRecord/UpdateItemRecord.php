<?php

require_once("../grima-lib.php");

class UpdateItemRecord extends GrimaTask {

	function do_task() {
		$this->item = new Item();
		$this->item->loadFromAlmaX($this['item_pid']);
		$item['statistics_note_3'] = 'HALE return';
		$item->updateAlma();
	}

	function print_success() {
		XMLtoWeb($this->item->xml);
	}

}

UpdateItemRecord::RunIt();
