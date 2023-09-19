<?php

require_once("../grima-lib.php");

class AcqWorkorder extends GrimaTask {
	public $itemlist = array();
	
	function do_task() {
		$this->holdings = preg_split('/\r\n|\r|\n/',$this['holding_id']);

		foreach ($this->holdings as $holdingid) {
			$holding = New Holding();
			$holding->loadFromAlma($holdingid,$holdingid);

			$item = new Item();
			$item['item_policy'] = 'book/ser';
			$item['pieces'] = '1';
			$item['inventory_date'] = '1976-01-01';
			$item['receiving_operator'] = 'Grima';
			$item->addToAlmaHolding($holdingid,$holdingid);

			// Scan-in will only work with a barcode
			$this->item = new Item();
			$this->item->loadFromAlmaX($item['item_pid']);
			$this->item->acqworkscan($item['mms_id'],$item['holding_id'],$item['item_pid'],$op = 'scan',$library = 'MAIN',$this['department'],$work_order_type = 'AcqWorkOrder',$this['status'],$done = 'false');

			if ($this->item['additional_info'] == "Item's destination is: Manage Locally (Acquisitions/Technical Services). Request/Process Type: Acquisition technical services. Requester: . Requester ID: . Place in Queue: 1") {
				$pattern = "/^(Item\'s destination is\: Manage Locally \(Acquisitions\/Technical Services\)\. Request\/Process Type: Acquisition technical services\. Requester: \. Requester ID: \. Place in Queue: 1)/";
				$replace = "Placed on Acquisitions Work Order";
				$scanreturn = preg_replace($pattern, $replace, $this->item['additional_info']);
			}

			// $this->addMessage('success',"{$this->item['additional_info']}, Item Record: {$this->item['barcode']}");
			$this->addMessage('success',"Item Record Created and {$scanreturn}, Item Record: {$this->item['barcode']}");

		}
	}
	/* function do_task() {
		$this->holdings = preg_split('/\r\n|\r|\n/',$this['holding_id']);
		foreach ($this->holdings as $holdingid) {
			$item = new Item();
			$item->loadFromAlmaBarcode($holdingid);
			$item->acqworkscan($item['mms_id'],$item['holding_id'],$item['item_pid'],$op = 'scan',$library = 'MAIN',$this['department'],$work_order_type = 'AcqWorkOrder',$this['status'],$done = $this['done']);

			$this->addMessage('success',"{$this->item['additional_info']}, Item Record: {$this->item['barcode']}");

		}
	} */
}

AcqWorkorder::RunIt();
