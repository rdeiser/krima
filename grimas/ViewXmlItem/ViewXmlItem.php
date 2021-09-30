<?php

require_once("../grima-lib.php");

class ViewXmlItem extends GrimaTask {

	function do_task() {
		$this->item = new Item();
		$itemid = $this->item->getHoldingIDFromCallnumber($this['callnumber']);
		$this->item->loadFromAlmaX($itemid);
	}

	function print_success() {
		XMLtoWeb($this->item->xml);
	}

}

ViewXmlItem::RunIt();
