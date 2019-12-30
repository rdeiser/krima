<?php

require_once("../grima-lib.php");

class UnboxingWorkflow extends GrimaTask {

	function do_task() {
		$item = new Item();
		$item->loadFromAlmaBarcode($this['barcode']);
		$item['internal_note_3'] = date("m/d/Y");
		$item->updateAlma();
		$this->splatVars['item'] = $this->barcode;
}
}

UnboxingWorkflow::RunIt();
