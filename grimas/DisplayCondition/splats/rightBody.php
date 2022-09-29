<?php
if ($item['statistics_note_3'] == '') {
	$pattern = '//';
	$replace = 'Send to Problem Shelf';
}

if ($item['statistics_note_3'] == 'HALE return'||$item['statistics_note_3'] == 'AHD HALE return'||$item['statistics_note_3'] == 'ANNEX ingest'||$item['statistics_note_3'] == 'AHD ANNEX ingest'||$item['statistics_note_3'] == 'To be WITHDRAWN'||$item['statistics_note_3'] == 'AHD To be WITHDRAWN'||$item['statistics_note_3'] == 'PHYSICAL CONDITION REVIEW For Possible Withdraw'||$item['statistics_note_3'] == '') {
	$pattern = '/(HALE return|AHD HALE return|ANNEX ingest|AHD ANNEX ingest|To be WITHDRAWN|AHDTo be WITHDRAWN)|(^)/';
	$replace = 'Place on Reveiw Cart';
	
}

if ($item['statistics_note_3'] == 'PHYSICAL CONDITION REVIEW For Possible Withdraw') {
	$pattern = '/(PHYSICAL CONDITION REVIEW For Possible Withdraw)/';
	$replace = 'WITHDRAW';

  if ($item['description']  !== ''||$item['copy_id'] >= '1') {
    $pattern = '/(PHYSICAL CONDITION REVIEW For Possible Withdraw)/';
    $replace = 'Multiple Copy/Volume Withdraw Shelf';
  }

  $holding = new Holding();
  $holding->loadFromAlma($item['mms_id'],$item['holding_id']);
  $subfields = $holding->getSubfieldValues("852","x");
  $subfieldx = implode(" ",$subfields);
  $poss = strpos($subfieldx,'s');
  $posa = strpos($subfieldx,'a');
  $posp = strpos($subfieldx,'p');
  if ($poss !== false||$posa !== false||$posp !== false) {
	$pattern = '/(PHYSICAL CONDITION REVIEW For Possible Withdraw)/';
	$replace = 'Multiple Copy/Volume Withdraw Shelf';
  }
}
  

if ($item['statistics_note_3'] == 'Condition review--REPAIR'||$item['statistics_note_3'] == 'Condition review--CRITICAL') {
	$pattern = '/(Condition review--REPAIR|Condition review--CRITICAL)/';
	$replace = 'BINDING Cart';
}

//Following php color codes the Process type if it is populated
if ($item['process_type']=='') {
		$style = 'style=";"';
}
	else if ($item['process_type']) {
		$style = 'style="background-color:#cd3700;"';
}
//Following php color codes the Fulfillment Note if it matches one of the patterns
if (preg_match("/[sS]end/", $item['fulfillment_note'])) {
		$style2 = 'style="background-color:#cd3700;"';
}
	else if (preg_match("/[rR]te/", $item['fulfillment_note'])) {
		$style2 = 'style="background-color:#cd3700;"';
}
	else if (preg_match("/[wW]ithdrawn/", $item['fulfillment_note'])) {
		$style2 = 'style="background-color:#cd3700;"';
}
	else if (preg_match("/[wW]ithdraw/", $item['fulfillment_note'])) {
		$style2 = 'style="background-color:#cd3700;"';
}
	else if (preg_match("/[vV]oyager/", $item['fulfillment_note'])) {
		$style2 = 'style="background-color:#cd3700;"';
}
	else if (preg_match("/[tT]transfer/", $item['fulfillment_note'])) {
		$style2 = 'style="background-color:#cd3700;"';
}
	else if (preg_match("/[rR]eturn/", $item['fulfillment_note'])) {
		$style2 = 'style="background-color:#cd3700;"';
}
	else if (preg_match("/[pP]lease/", $item['fulfillment_note'])) {
		$style2 = 'style="background-color:#cd3700;"';
}
	else if (preg_match("/[lL]ost/", $item['fulfillment_note'])) {
		$style2 = 'style="background-color:#cd3700;"';
}
	/*else if (preg_match("/^[aA]rchival [bB]ox/", $item['fulfillment_note'])) {
		$style2 = 'style=";"';
}*/
	else if (preg_match("/[gG]ive/", $item['fulfillment_note'])) {
		$style2 = 'style="background-color:#cd3700;"';
}
	else if (preg_match("/[iI]LL/", $item['fulfillment_note'])) {
		$style2 = 'style="background-color:#cd3700;"';
}
	else if (preg_match("/[iI]ll/", $item['fulfillment_note'])) {
		$style2 = 'style="background-color:#cd3700;"';
}
	else if (preg_match("/[bB]ind/", $item['fulfillment_note'])) {
		$style2 = 'style="background-color:#cd3700;"';
}
	else if (preg_match("/[bB]inding/", $item['fulfillment_note'])) {
		$style2 = 'style="background-color:#cd3700;"';
}
	else if (preg_match("/[rR]oute/", $item['fulfillment_note'])) {
		$style2 = 'style="background-color:#cd3700;"';
}
	else if (preg_match("/[dD]bm/", $item['fulfillment_note'])) {
		$style2 = 'style="background-color:#cd3700;"';
}
	else if (preg_match("/[dD]BM/", $item['fulfillment_note'])) {
		$style2 = 'style="background-color:#cd3700;"';
}
	else if ($item['fulfillment_note']=='') {
		$style2 = 'style=";"';
}
if (preg_match("/[aA]rchival [bB]ox/", $item['fulfillment_note'])) {
		$style2 = 'style=";"';
}
if (preg_match("/^([2-9]|[1-9][0-9]|[1-9][0-9][0-9])$/", $item['copy_id'])) {
	$style3 = 'style="opacity:1;"';
} else {
	$style3 = 'style="opacity:0;"';
}
if ($item['description']=='') {
	$style4 = 'style="opacity:0;"';
	$pattern2 = '/^/';
	$replace2 = '';
} else {
	$style4 = 'style="opacity:1;"';
	$pattern2 = '/^/';
	$replace2 = '&nbsp;';
}


	$pattern4 = '/(^AUDIO TAPE|^BLU\-RAY\/DVD|BLU\-RAY|^CD\-ROM|^COMPACT DISC|^COMPUTER DISK|^DVD\-ROM|^DVD|^EQUIPMENT|^LASERDISC|^MAP|^MEDIA|^MICROCARD|^MICROFICHE|^MICROFILM|^MICROPRINT|^PHONODISC|^VIDEO TAPE)/';
	$replace4 = '';
?>
              <table class="table">
                <tr><th>Title:</th><td><?=$e($item['title'])?></td></tr>
				<tr><th>Call Number:</th><td><?= preg_replace($pattern4, $replace4, $item['call_number'])?><text <?=$style4?>><?= preg_replace($pattern2, $replace2, $item['description'])?></text><text <?=$style3?>>&nbsp;c.<?=$e($item['copy_id'])?></text></td></tr>
				<!--<tr><th>Description:</th><td><?=$e($item['description'])?></td></tr>-->
				<tr><th>Barcode:</th><td><?=$e($item['barcode'])?></td></tr>
				<tr><th>Inventory Date:</th><td><?=$e($item['inventory_date'])?></td></tr>
				<tr <?=$style?>><th>Process Type:</th><td><?=$e($item['process_type'])?></td></tr>
				<tr <?=$style2?>><th>Fulfillment Note:</th><td><?=$e($item['fulfillment_note'])?></td></tr>
				<tr><th>Public Note:</th><td><?=$e($item['public_note'])?></td></tr>
				<tr><th>Internal Note 1:</th><td><?=$e($item['internal_note_1'])?></td></tr>
				<tr><th>Internal Note 2:</th><td><?=$e($item['internal_note_2'])?></td></tr>
				<tr><th>Statistics Note 1:</th><td><?=$e($item['statistics_note_1'])?></td></tr>
				<tr><th>Statistics Note 2:</th><td><?=$e($item['statistics_note_2'])?></td></tr>
				<tr><th>Statistics Note 3:</th><td><?=$e($item['statistics_note_3'])?></td></tr>
				<tr><th>Location:</th><td><?=$e($item['location'])?></td></tr>
				<tr><th>Destination:</th><td class="statnote"><?= preg_replace($pattern, $replace, $item['statistics_note_3'])?></td></tr>
				<tr><th></th><td></td></tr>
              </table>
			  <!--The following combines the two grimas ontop of each other-->
			  <form method="post" action="../DisplayCondition/DisplayCondition.php">
				<div class="col">
				<div class="card" style="width: 500px;left: 225px;">
				<div class="card-body" style="width: 500px">
				<div class="form-row col-12 pb-4">
					<label class="col-3 form-check-label" for="barcode" style="top: 10px;">Barcode:</label>
					<input class="col-9 form-control znew" type="text" name="unboxed_barcode" id="barcode" size="20" autofocus="autofocus" placeholder="SCAN NEXT BARCODE" style="top: 8px;"/>
				</div>
				<input class="btn btn-primary btn-sm active" type="submit" value="Submit">
				</div>
				</div>
				</div>
              </form>