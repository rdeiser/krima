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
				$holding->setMapCallNumber($this['whichnote'],'  Drawer B-46  ','Drawer 401','8');
				$holding->updateAlma();
				$this->addMessage('success',"Successfully updated map drawer number for {$holdingid} with {$holding['call_number']}");
				/*if ($holding['call_number'] == ' Drawer 236') {
					$holding->setMapCallNumber($this['whichnote'],' Drawer 236 ','Drawer 393','8');
				
				$holding->setMapCallNumber($this['whichnote'],$this['olddrawer'],$this['newdrawer'],'8');
					$holding->updateAlma();
					$this->addMessage('success',"Successfully updated map drawer number for {$holdingid} with {$holding['call_number']}");
				} elseif ($holding['call_number'] == ' Drawer 237') {
					$holding->setMapCallNumber($this['whichnote'],' Drawer 237 ','Drawer 394','8');
					$holding->updateAlma();
					$this->addMessage('success',"Successfully updated map drawer number for {$holdingid} with {$holding['call_number']}");
				} elseif ($holding['call_number'] == ' Drawer 238') {
					$holding->setMapCallNumber($this['whichnote'],' Drawer 238 ','Drawer 395','8');
					$holding->updateAlma();
					$this->addMessage('success',"Successfully updated map drawer number for {$holdingid} with {$holding['call_number']}");
				} elseif ($holding['call_number'] == ' Drawer B-46') {
					$holding->setMapCallNumber($this['whichnote'],'  Drawer B-46  ','Drawer 401','8');
					$holding->updateAlma();
					$this->addMessage('success',"Successfully updated map drawer number for {$holdingid} with {$holding['call_number']}");
				} elseif ($holding['call_number'] == 'Drawer B-220') {
					$holding->setMapCallNumber($this['whichnote'],'Drawer B-220','Drawer 402','8');
					$holding->updateAlma();
					$this->addMessage('success',"Successfully updated map drawer number for {$holdingid} with {$holding['call_number']}");
				} elseif ($holding['call_number'] == ' Drawer 71') {
					$holding->setMapCallNumber($this['whichnote'],' Drawer 71 ','Drawer 403','8');
					$holding->updateAlma();
					$this->addMessage('success',"Successfully updated map drawer number for {$holdingid} with {$holding['call_number']}");
				} elseif ($holding['call_number'] == 'Drawer B-50') {
					$holding->setMapCallNumber($this['whichnote'],'Drawer B-50','Drawer 404','8');
					$holding->updateAlma();
					$this->addMessage('success',"Successfully updated map drawer number for {$holdingid} with {$holding['call_number']}");
				} elseif ($holding['call_number'] == 'Drawer B-52') {
					$holding->setMapCallNumber($this['whichnote'],'Drawer B-52','Drawer 406','8');
					$holding->updateAlma();
					$this->addMessage('success',"Successfully updated map drawer number for {$holdingid} with {$holding['call_number']}");
				} elseif ($holding['call_number'] == 'Drawer B-53') {
					$holding->setMapCallNumber($this['whichnote'],'Drawer B-53','Drawer 407','8');
					$holding->updateAlma();
					$this->addMessage('success',"Successfully updated map drawer number for {$holdingid} with {$holding['call_number']}");
				} elseif ($holding['call_number'] == 'Drawer B-54') {
					$holding->setMapCallNumber($this['whichnote'],'Drawer B-54','Drawer 408','8');
					$holding->updateAlma();
					$this->addMessage('success',"Successfully updated map drawer number for {$holdingid} with {$holding['call_number']}");
				} elseif ($holding['call_number'] == 'Drawer B-56') {
					$holding->setMapCallNumber($this['whichnote'],'Drawer B-56','Drawer 410','8');
					$holding->updateAlma();
					$this->addMessage('success',"Successfully updated map drawer number for {$holdingid} with {$holding['call_number']}");
				} elseif ($holding['call_number'] == 'Drawer B-223') {
					$holding->setMapCallNumber($this['whichnote'],'Drawer B-223','Drawer 414','8');
					$holding->updateAlma();
					$this->addMessage('success',"Successfully updated map drawer number for {$holdingid} with {$holding['call_number']}");
				} elseif ($holding['call_number'] == 'Drawer B-236') {
					$holding->setMapCallNumber($this['whichnote'],'Drawer B-236','Drawer 415','8');
					$holding->updateAlma();
					$this->addMessage('success',"Successfully updated map drawer number for {$holdingid} with {$holding['call_number']}");
				} elseif ($holding['call_number'] == 'Drawer 1') {
					$holding->setMapCallNumber($this['whichnote'],'Drawer 1 ','Drawer 416','8');
					$holding->updateAlma();
					$this->addMessage('success',"Successfully updated map drawer number for {$holdingid} with {$holding['call_number']}");
				} elseif ($holding['call_number'] == ' Drawer 287') {
					$holding->setMapCallNumber($this['whichnote'],' Drawer 287 ','Drawer 417','8');
					$holding->updateAlma();
					$this->addMessage('success',"Successfully updated map drawer number for {$holdingid} with {$holding['call_number']}");
				*/} else {
					$this->addMessage('error',"Did not update map drawer number for {$holdingid}--{$holding['call_number']}");
					continue;
					}
			}
			}
		}
	}

GovMapDrawer::RunIt();
