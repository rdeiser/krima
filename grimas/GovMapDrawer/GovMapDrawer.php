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
				if ($holding['call_number'] === ' Drawer 211 ') {
					$holding['call_number'] == 'Drawer 371';
					$holding->updateAlma();
				}
				if ($holding['call_number'] == ' Drawer 212 ') {
					$holding['call_number'] == 'Drawer 372';
					$holding->updateAlma();
				}
				if ($holding['call_number'] == ' Drawer 213 ') {
					$holding['call_number'] == 'Drawer 373';
					$holding->updateAlma();
				}
				if ($holding['call_number'] == ' Drawer 214 ') {
					$holding['call_number'] == 'Drawer 374';
					$holding->updateAlma();
				}
				if ($holding['call_number'] == ' Drawer 218 ') {
					$holding['call_number'] == 'Drawer 375';
					$holding->updateAlma();
				}
				if ($holding['call_number'] == ' Drawer 219 ') {
					$holding['call_number'] == 'Drawer 376';
					$holding->updateAlma();
				}
				if ($holding['call_number'] == ' Drawer 220 ') {
					$holding['call_number'] == 'Drawer 377';
					$holding->updateAlma();
				}
				if ($holding['call_number'] == ' Drawer 221 ') {
					$holding['call_number'] == 'Drawer 378';
					$holding->updateAlma();
				}
				if ($holding['call_number'] == ' Drawer 222 ') {
					$holding['call_number'] == 'Drawer 379';
					$holding->updateAlma();
				}
				if ($holding['call_number'] == ' Drawer 223 ') {
					$holding['call_number'] == 'Drawer 380';
					$holding->updateAlma();
				}
				if ($holding['call_number'] == ' Drawer 224 ') {
					$holding['call_number'] == 'Drawer 381';
					$holding->updateAlma();
				}
				if ($holding['call_number'] == ' Drawer 225 ') {
					$holding['call_number'] == 'Drawer 382';
					$holding->updateAlma();
				}
				if ($holding['call_number'] == ' Drawer 226 ') {
					$holding['call_number'] == 'Drawer 383';
					$holding->updateAlma();
				}
				if ($holding['call_number'] == ' Drawer 227 ') {
					$holding['call_number'] == 'Drawer 384';
					$holding->updateAlma();
				}
				if ($holding['call_number'] == ' Drawer 228 ') {
					$holding['call_number'] == 'Drawer 385';
					$holding->updateAlma();
				}
				if ($holding['call_number'] == ' Drawer 229 ') {
					$holding['call_number'] == 'Drawer 386';
					$holding->updateAlma();
				}
				if ($holding['call_number'] == ' Drawer 230 ') {
					$holding['call_number'] == 'Drawer 387';
					$holding->updateAlma();
				}
				if ($holding['call_number'] == ' Drawer 231 ') {
					$holding['call_number'] == 'Drawer 388';
					$holding->updateAlma();
				}
				if ($holding['call_number'] == ' Drawer 232 ') {
					$holding['call_number'] == 'Drawer 389';
					$holding->updateAlma();
				}
				if ($holding['call_number'] == ' Drawer 233 ') {
					$holding['call_number'] == 'Drawer 390';
					$holding->updateAlma();
				}
				if ($holding['call_number'] == ' Drawer 234 ') {
					$holding['call_number'] == 'Drawer 391';
					$holding->updateAlma();
				}
				if ($holding['call_number'] == ' Drawer 235 ') {
					$holding['call_number'] == 'Drawer 392';
					$holding->updateAlma();
				}
				if ($holding['call_number'] == ' Drawer 236 ') {
					$holding['call_number'] == 'Drawer 393';
					$holding->updateAlma();
				}
				if ($holding['call_number'] == ' Drawer 237 ') {
					$holding['call_number'] == 'Drawer 394';
					$holding->updateAlma();
				}
				if ($holding['call_number'] == ' Drawer 238 ') {
					$holding['call_number'] == 'Drawer 395';
					$holding->updateAlma();
				}
				if ($holding['call_number'] == ' Drawer B-44 ') {
					$holding['call_number'] == 'Drawer 399';
					$holding->updateAlma();
				}
				if ($holding['call_number'] == ' Drawer B-45 ') {
					$holding['call_number'] == 'Drawer 400';
					$holding->updateAlma();
				}
				if ($holding['call_number'] == ' Drawer B-46 ') {
					$holding['call_number'] == 'Drawer 401';
					$holding->updateAlma();
				}
				if ($holding['call_number'] == ' Drawer B-220 ') {
					$holding['call_number'] == 'Drawer 402';
					$holding->updateAlma();
				}
				if ($holding['call_number'] == ' Drawer 71 ') {
					$holding['call_number'] == 'Drawer 403';
					$holding->updateAlma();
				}
				if ($holding['call_number'] == ' Drawer B-50 ') {
					$holding['call_number'] == 'Drawer 404';
					$holding->updateAlma();
				}
				if ($holding['call_number'] == ' Drawer B-51 ') {
					$holding['call_number'] == 'Drawer 405';
					$holding->updateAlma();
				}
				if ($holding['call_number'] == ' Drawer B-52 ') {
					$holding['call_number'] == 'Drawer 406';
					$holding->updateAlma();
				}
				if ($holding['call_number'] == ' Drawer B-53 ') {
					$holding['call_number'] == 'Drawer 407';
					$holding->updateAlma();
				}
				if ($holding['call_number'] == ' Drawer B-54 ') {
					$holding['call_number'] == 'Drawer 408';
					$holding->updateAlma();
				}
				if ($holding['call_number'] == ' Drawer B-55 ') {
					$holding['call_number'] == 'Drawer 409';
					$holding->updateAlma();
				}
				if ($holding['call_number'] == ' Drawer B-56 ') {
					$holding['call_number'] == 'Drawer 410';
					$holding->updateAlma();
				}
				if ($holding['call_number'] == ' Drawer B-57 ') {
					$holding['call_number'] == 'Drawer 411';
					$holding->updateAlma();
				}
				if ($holding['call_number'] == ' Drawer B-58 ') {
					$holding['call_number'] == 'Drawer 412';
					$holding->updateAlma();
				}
				if ($holding['call_number'] == ' Drawer B-59 ') {
					$holding['call_number'] == 'Drawer 413';
					$holding->updateAlma();
				}
				if ($holding['call_number'] == ' Drawer B-223 ') {
					$holding['call_number'] == 'Drawer 414';
					$holding->updateAlma();
				}
				if ($holding['call_number'] == ' Drawer B-236 ') {
					$holding['call_number'] == 'Drawer 415';
					$holding->updateAlma();
				}
				if ($holding['call_number'] == ' Drawer 1 ') {
					$holding['call_number'] == 'Drawer 416';
					$holding->updateAlma();
				}
				if ($holding['call_number'] == ' Drawer 287 ') {
					$holding['call_number'] == 'Drawer 417';
					$holding->updateAlma();
				}
				if ($holding['location_code'] = 'govoffmap') {
					$holding['location_code'] = 'govmap';
					$holding->updateAlma();
				}
				//$holding->setMapCallNumber($this['whichnote'],$this['olddrawer'],$this['newdrawer'],'8');
				//$holding->updateAlma();
				$this->addMessage('success',"Successfully updated map drawer number for {$holdingid} with {$holding['call_number']}");
				} else {
				$this->addMessage('error',"Did not update map drawer number for {$holdingid}");
				continue;
				}
		}
	}
}

GovMapDrawer::RunIt();
