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
				//$holding->loadFromAlma($this['mms_id'],$holdingid);
				$holding->loadFromAlmaX($holdingid);
				$xpath = new DomXpath ($this->xml);
				$field852 = $xpath->query("//record/datafield[@tag='852']")->item(0);
				$subfieldCs = $xpath->query("subfield[@code='c']",$field852);
				$subfieldHs = $xpath->query("subfield[@code='h']",$field852);
				if ($subfieldC->nodeValue = $this['whichnote'] && $subfieldHs->nodeValue = $this['olddrawer']) {
					$subfieldHs->parentNode->removeChild($subfieldHs);
					$holding->appendInnerXML($field852,"<subfield code=\"h\">$this['newdrawer']</subfield>");
				}
				$this->addMessage('success',"Successfully updated map drawer number for {$holdingid}");
			} else {
				$this->addMessage('error',"Did not update map drawer number for {$holdingid}");
				continue;
			}
		}
	}
}
GovMapDrawer::RunIt();
