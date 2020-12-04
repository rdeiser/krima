<?php
if ($item['statistics_note_3'] == 'SPEC return') {
	$pattern = '/(SPEC return)/';
	$replace = 'SPEC return';
}
if ($item['statistics_note_3'] == 'SPEC CONDITION') {
	$pattern = '/(SPEC CONDITION)/';
	$replace = 'SPEC CONDITION';
}
if ($item['statistics_note_3'] == 'HALE return') {
	$pattern = '/(HALE return)/';
	$replace = 'HALE return';
} 
if ($item['statistics_note_3'] == 'ANNEX ingest') {
	$pattern = '/(ANNEX ingest)/';
	$replace = 'ANNEX ingest';
}
if ($item['statistics_note_3'] == 'To be WITHDRAWN') {
	$pattern = '/(To be WITHDRAWN)/';
	$replace = 'To be WITHDRAWN';
}
if ($item['statistics_note_3'] == 'AHD HALE return') {
	$pattern = '/(AHD HALE return)/';
	$replace = 'HALE return';
} 
if ($item['statistics_note_3'] == 'AHD ANNEX ingest') {
	$pattern = '/(AHD ANNEX ingest)/';
	$replace = 'ANNEX ingest';
}
if ($item['statistics_note_3'] == 'AHD To be WITHDRAWN') {
	$pattern = '/(AHD To be WITHDRAWN)/';
	$replace = 'To be WITHDRAWN';
}
if ($item['statistics_note_3'] == 'PHYSICAL CONDITION REVIEW For Possible Withdraw') {
	$pattern = '/(PHYSICAL CONDITION REVIEW For Possible Withdraw)/';
	$replace = 'Send to Condition Review Shelf';
}
if ($item['statistics_note_3'] == '') {
	$pattern = '//';
	$replace = 'Send to Problem Shelf';
}

/*if ($item['location'] == 'juv') {
	if ($item['statistics_note_3'] == 'HALE return') {
		$pattern = '/(HALE return)/';
		$replace = 'Send to Problem Shelf';
		}
	}
if ($item['location'] == 'cmc') {
	if ($item['statistics_note_3'] == 'HALE return') {
		$pattern = '/(HALE return)/';
		$replace = 'Send to Problem Shelf';
		}
	}
if ($item['location_code'] == 'main') {
	if ($item['statistics_note_3'] == 'HALE return') {
		$pattern = '/(HALE return)/';
		$replace = 'Send to Problem Shelf';
		}
	}
if ($item['location'] == 'over') {
	if ($item['statistics_note_3'] == 'HALE return') {
		$pattern = '/(HALE return)/';
		$replace = 'Send to Problem Shelf';
		}
	}
if ($item['location'] == 'overplus') {
	if ($item['statistics_note_3'] == 'HALE return') {
		$pattern = '/(HALE return)/';
		$replace = 'Send to Problem Shelf';
		}
	}
if ($item['location'] == 'dowref') {
	if ($item['statistics_note_3'] == 'HALE return') {
		$pattern = '/(HALE return)/';
		$replace = 'Send to Problem Shelf';
		}
	}
if ($item['location'] == 'ref') {
	if ($item['statistics_note_3'] == 'HALE return') {
		$pattern = '/(HALE return)/';
		$replace = 'Send to Problem Shelf';
		}
	}
if ($item['location'] == 'juv') {
	if ($item['statistics_note_3'] == 'AHD HALE return') {
		$pattern = '/(AHD HALE return)/';
		$replace = 'Send to Problem Shelf';
		}
	}
if ($item['location'] == 'cmc') {
	if ($item['statistics_note_3'] == 'AHD HALE return') {
		$pattern = '/(AHD HALE return)/';
		$replace = 'Send to Problem Shelf';
		}
	}
if ($item['location'] == 'main') {
	if ($item['statistics_note_3'] == 'AHD HALE return') {
		$pattern = '/(AHD HALE return)/';
		$replace = 'Send to Problem Shelf';
		}
	}
if ($item['location'] == 'over') {
	if ($item['statistics_note_3'] == 'AHD HALE return') {
		$pattern = '/(AHD HALE return)/';
		$replace = 'Send to Problem Shelf';
		}
	}
if ($item['location'] == 'overplus') {
	if ($item['statistics_note_3'] == 'AHD HALE return') {
		$pattern = '/(AHD HALE return)/';
		$replace = 'Send to Problem Shelf';
		}
	}
if ($item['location'] == 'dowref') {
	if ($item['statistics_note_3'] == 'AHD HALE return') {
		$pattern = '/(AHD HALE return)/';
		$replace = 'Send to Problem Shelf';
		}
	}
if ($item['location'] == 'ref') {
	if ($item['statistics_note_3'] == 'AHD HALE return') {
		$pattern = '/(AHD HALE return)/';
		$replace = 'Send to Problem Shelf';
		}
	}*/
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
/*	else if (preg_match("/[gG]ive/", $item['fulfillment_note'])) {
		$style2 = 'style="background-color:#cd3700;"';
}*/
	else if (preg_match("/Archival box/", $item['fulfillment_note'])) {
			$style2 = 'style="#FFFF00;"';
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

$holding = new Holding();
$holding->loadFromAlma($item['mms_id'],$item['holding_id']);
if ($holding['suppress_from_publishing'] == 'true'){
	if ($item['statistics_note_3']== 'AHD HALE return') {
		$pattern = '/(AHD HALE return)/';
		$replace = 'Send to Problem Shelf';
		}else if ($item['statistics_note_3']== 'HALE return') {
			$pattern = '/(HALE return)/';
			$replace = 'Send to Problem Shelf';
		}
} else {
	$bib = new bib();
	$bib->loadFromAlma($item['mms_id']);
	if ($bib['suppress_from_publishing'] == 'true'){
		if ($item['statistics_note_3']== 'AHD HALE return') {
			$pattern = '/(AHD HALE return)/';
			$replace = 'Send to Problem Shelf';
		}else if ($item['statistics_note_3']== 'HALE return') {
			$pattern = '/(HALE return)/';
			$replace = 'Send to Problem Shelf';
		}
}
}

?>
              <table class="table">
                <tr><th class="flip"><span>Title:</span><span>Título:</span></th><td><?=$e($item['title'])?></td></tr>
				<tr><th class="flip"><span>Call Number:</span><span>Número de clasificación:</span></th><td><?=$e($item['call_number'])?></td></tr>
				<tr><th class="flip"><span>Description:</span><span>Descripción:</span></th><td><?=$e($item['description'])?></td></tr>
				<tr><th class="flip"><span>Barcode:</span><span>Código de barras:<!--Código de procedencia:--></span></th><td><?=$e($item['barcode'])?></td></tr>
				<!--<tr><th class="flip"><span>Location:</span><span>Lugar:</span></th><td><?=$e($item['location'])?></td></tr>-->
				<tr <?=$style?>><th class="flip"><span>Process Type:</span><span>Tipo de Proceso:</span></th><td><?=$e($item['process_type'])?></td></tr>
				<tr <?=$style2?>><th class="flip"><span>Fulfillment Note:</span><span>Nota de Procesamiento:<!--Nota de servicios al usuario:--></span></th><td><?=$e($item['fulfillment_note'])?></td></tr>
				<tr><th class="flip"><span>Inventory Date:</span><span>Fecha de inventario:</span></th><td><?=$e($item['inventory_date'])?></td></tr>
				<!--<tr><th>Inventory Number:</th><td><?=$e($item['inventory_number'])?></td></tr>
				<tr><th>Internal Note 3:</th><td><?=$e($item['internal_note_3'])?></td></tr>-->
				<tr><th class="flip"><span>Destination:</span><span>Destino:</span></th><td class="statnote"><?= preg_replace($pattern, $replace, $item['statistics_note_3'])?>
				</td></tr>
				<!--<tr><th>Bib Suppressed:</th><td><?=$e($bib['suppress_from_publishing'])?>
				<tr><th>Holding Suppressed:</th><td><?=$e($holding['suppress_from_publishing'])?>
				</td></tr>
				<tr><th>Holding ID:</th><td><?=$e($item['holding_id'])?>
				</td></tr>-->
				<tr><th></th><td></td></tr>
              </table>
			  <!--<input class="btn btn-primary btn-sm active" onclick="history.go(-1);" autofocus="autofocus" type="submit" value="Back"/>-->
			  <!--The following combines the two grimas ontop of each other-->
			  <form method="post" action="../SpecUnboxing/SpecUnboxing.php">
				<div class="col">
				<div class="card" style="width: 500px;left: 225px;">
				<div class="card-body" style="width: 500px">
				<div class="form-row col-12 pb-4">
					<label class="col-3 form-check-label" for="barcode">Barcode:</label>
					<input class="col-9 form-control znew" type="text" name="unboxed_barcode" id="barcode" size="20" autofocus="autofocus" placeholder="SCAN NEXT BARCODE"/>
				</div>
				<input class="btn btn-primary btn-sm active" type="submit" value="Submit">
				</div>
				</div>
				</div>
              </form>