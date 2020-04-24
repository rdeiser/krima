<?php

require_once("../grima-lib.php");

class BatchItems extends GrimaTask {
	public $biblist = array();
	
	function do_task() {
		$this->bibs = preg_split('/\r\n|\r|\n/',$this['mms']);

		# BIBS
		foreach ($this->bibs as $mmsid) {
			$bib = new Bib();
			$bib->loadFromAlma($mmsid);
			$this->biblist[] = $bib;
		}

		## HOLDING
		$this->biblist[0]->getHoldings();
		$mfhd = $this->biblist[0]->holdings[0];

		foreach ($this->biblist as $k => $bib) {
			if ($holding['library_code']=='MAIN') {
				function postItem($mms_id,$holding_id,$item{
					$ret = $this->post('/almaws/v1/bibs/{mms_id}/holdings/{holding_id}/items',
			array('mms_id' => $mms_id, 'holding_id' => $holding_id),
			array(),
			$item
			);
		$this->checkForErrorMessage($ret);
		return $ret;
	
			else if ($holding['library_code']==''){
			}
			}
		}
		$this->splatVars['width'] = 12;
		$this->splatVars['biblist'] = $this->biblist;
		$this->splatVars['body'] = array( 'list', 'messages' );


	}
}
BatchItems::RunIt();
