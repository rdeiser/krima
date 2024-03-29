<?php

require_once("../grima-lib.php");

class Boundwith extends GrimaTask {
	public $biblist = array();
	
	function do_task() {
		$this->bibs = preg_split('/\r\n|\r|\n/',$this['mms']);

		# BIBS
		foreach ($this->bibs as $mmsid) {
			$bib = new Bib();
			$bib->loadFromAlma($mmsid);
			$bib->appendfield("948"," "," ",array(
				'a' => "m:red",
				'd' => "07/2021"
				)
				);
			$bib->appendfield("948"," "," ",array(
				'z' => "send to rdamarz"
				)
				);
			$bib->updateAlma();
			$this->biblist[] = $bib;
		}

		# build array of unique titles
		$arrfor501 = array();
		foreach ($this->biblist as $k => $bib) {
			$title = $bib->get_title_proper();
			if ($k > 0) {
				$this->biblist[0]->appendField("774","1"," ",array(
					't' => $title,
					'w' => $bib['mms_id']
					)
				);
			} 
			if (!in_array($title,$arrfor501)) {
				$arrfor501[] = $title;
			}
		}

		foreach ($this->biblist as $bib) {
			$my501text = "Bound with: ";
			$skip = $bib->get_title_proper();
			foreach ($arrfor501 as $title) {
				if ($title != $skip) {
					$my501text .= $title . "; ";
				}
			}
			$my501text = preg_replace("/; $/",".",$my501text);
			$bib->appendField("501"," "," ",array('a' => $my501text));
			$bib->deleteField("501");
			$bib->updateAlma();
		}

		## HOLDING
		$this->biblist[0]->getHoldings();
		/*if (count($bib->holdings) = 0) {
			$holding = new Holding();
			$holding->appendField("014","1"," ",array('x' => 'BOUNDWITH'));
			$holding['library_code'] = 'MAIN';
			$holding['location_code'] = 'main';
			$holding->setCallNumber($callno[0],$callno[1],0);
			$holding->addToAlmaBib($bib['mms_id']);
		} else {*/
		$mfhd = $this->biblist[0]->holdings[0];
		$mfhd->appendField("014","1"," ",array('x' => 'BOUNDWITH'));
		/*foreach ($this->biblist as $k => $bib) {
			if ($k > 0) {
				$mfhd->appendField("014","1"," ",array('x' => 'BOUNDWITH'));
			}
		}*/
		$mfhd->updateAlma();
		//}

		$this->splatVars['width'] = 12;
		$this->splatVars['biblist'] = $this->biblist;
		$this->splatVars['body'] = array( 'list', 'messages' );
	}

}

Boundwith::RunIt();
