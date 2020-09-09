<?php
require_once("../grima-lib.php");

class ScanInReturn extends GrimaTask {

	function do_task() {
		$item = new Item();
		$item->loadFromAlmaBarcode($this['barcode']);

		$this->item = new Item();
		$this->item->loadFromAlmaX($item['item_pid']);
		$this->item->fulfillmentscan($item['mms_id'],$item['holding_id'],$item['item_pid'],$op = 'scan',$library = $this['library'],$circ_desk = 'DEFAULT_CIRC_DESK');
		/*if $this['hold'] == 'true' {
			$this->item->fulfillmentscan($item['mms_id'],$item['holding_id'],$item['item_pid'],$op = 'scan',$library = $this['library'],$place_on_hold_shelf = $this['hold'],$circ_desk = 'DEFAULT_CIRC_DESK');
		} elseif {
			$this->item->fulfillmentscan($item['mms_id'],$item['holding_id'],$item['item_pid'],$op = 'scan',$library = $this['library'],$circ_desk = 'DEFAULT_CIRC_DESK');
		}*/
		$this->splatVars['item'] = $this->item;

		//$this->addMessage('success',"Successfully Scanned In: {$item['barcode']} Additional Information: {$this->item['additional_info']}");
	}


}

ScanInReturn::RunIt();
