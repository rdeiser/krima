<?php

require_once("../grima-lib.php");

class GovMapDrawer extends GrimaTask {
	public $holdinglist = array();

	function do_task() {
		$this->holdings = preg_split('/\r\n|\r|\n/',$this['holding_id']);

		foreach ($this->holdings as $holdingid) {
			$holding = new Holding();
			$this['mms_id'] = $holdingid;
			if ($this['mms_id']) {
				$holding->loadFromAlma($this['mms_id'],$holdingid);
				if ($holding['call_number'] == ' Drawer 236 ') {
					$holding->setMapCallNumber($this['whichnote'],' Drawer 236 ','Drawer 393','8');
				
				//$holding->setMapCallNumber($this['whichnote'],$this['olddrawer'],$this['newdrawer'],'8');
					$holding->updateAlma();
					$this->addMessage('success',"Successfully updated map drawer number for {$holdingid} with {$holding['call_number']}");
				} else {
					$this->addMessage('error',"Did not update map drawer number for {$holdingid}--{$holding['call_number']");
					continue;
					}
				if ($holding['call_number'] == ' Drawer 237 ') {
					$holding->setMapCallNumber($this['whichnote'],' Drawer 237 ','Drawer 394','8');
				
				//$holding->setMapCallNumber($this['whichnote'],$this['olddrawer'],$this['newdrawer'],'8');
					$holding->updateAlma();
					$this->addMessage('success',"Successfully updated map drawer number for {$holdingid} with {$holding['call_number']}");
				} else {
					$this->addMessage('error',"Did not update map drawer number for {$holdingid}");
					continue;
					}
				if ($holding['call_number'] == ' Drawer 238 ') {
					$holding->setMapCallNumber($this['whichnote'],' Drawer 238 ','Drawer 395','8');
				
				//$holding->setMapCallNumber($this['whichnote'],$this['olddrawer'],$this['newdrawer'],'8');
					$holding->updateAlma();
					$this->addMessage('success',"Successfully updated map drawer number for {$holdingid} with {$holding['call_number']}");
				} else {
					$this->addMessage('error',"Did not update map drawer number for {$holdingid}--{$holding['call_number']}");
					continue;
					}
			}
			}
		}
	}

GovMapDrawer::RunIt();
