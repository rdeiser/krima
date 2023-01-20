<?php

require_once("../grima-lib.php");

class AnnexWorkorder extends GrimaTask {
	public $itemlist = array();
	
	function do_task() {
		$this->items = preg_split('/\r\n|\r|\n/',$this['barcode']);

		foreach ($this->items as $barcode) {
			$item = new Item();
			$item->loadFromAlmaBarcode($barcode);

			$this->item = new Item();
			$this->item->loadFromAlmaX($item['item_pid']);
			if ($this['order'] == 'true') {
				$this->item->fulfillmentscan($item['mms_id'],$item['holding_id'],$item['item_pid'],$op = 'scan',$library = $this['library'],$circ_desk = 'DEFAULT_CIRC_DESK',$work_order_type = 'Nichltd',$status,$done = $this['done'],$place_on_hold_shelf = 'false',$register_in_house_use = 'false');

				if ($this->item['additional_info'] == "Item's destination is: Manage Locally (Special Collections--Please email libsc@ksu.edu). Request/Process Type: Special Collections--Please email libsc@ksu.edu. Requester: . Requester ID: . Place in Queue: 1") {
					$pattern = "/^(Item\'s destination is\: Manage Locally \(Special Collections\-\-Please email libsc\@ksu\.edu\)\. Request\/Process Type\: Special Collections\-\-Please email libsc\@ksu\.edu\. Requester\: \. Requester ID\: \. Place in Queue\: 1)/";
					$replace = "Successfully added Special Collections Work Order";
					$scanreturn = preg_replace($pattern, $replace, $this->item['additional_info']);
				}

				//$this->addMessage('success',"Successfully added {$scanreturn} to Item Record: {$this->item['barcode']}");
			}
			if ($this['order'] == 'false') {
				$this->item->fulfillmentscan($item['mms_id'],$item['holding_id'],$item['item_pid'],$op = 'scan',$library = $this['library'],$circ_desk = 'DEFAULT_CIRC_DESK',$work_order_type,$status,$done = $this['done'],$place_on_hold_shelf = 'false',$register_in_house_use = 'false');

				if ($this->item['additional_info'] == "Item's destination is: Reshelve to nichltd. Request/Process Type: . Requester: . Requester ID: . Place in Queue: 0") {
					$pattern = "/^(Item\'s destination is\: Reshelve to nichltd\. Request\/Process Type: \. Requester: \. Requester ID: \. Place in Queue: 0)/";
					$replace = "Reshelve to nichltd";
					$scanreturn = preg_replace($pattern, $replace, $this->item['additional_info']);
				}
			}
			$this->addMessage('success',"{$scanreturn}, Item Record: {$this->item['barcode']}");
		}
	}
}

AnnexWorkorder::RunIt();
