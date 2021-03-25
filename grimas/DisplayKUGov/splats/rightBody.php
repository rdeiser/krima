<?php
if ($item['statistics_note_3'] == 'KU FDLP REQUEST') {
	$pattern = '/(KU FDLP REQUEST)/';
	$replace = 'Send to KU';
}

if ($item['library_code'] == 'WITHDRAW') {
	$pattern = '//';
	$replace = 'GOV WITHDRAW';
}else if ($item['library_code'] !== 'WITHDRAW') {
	$pattern = '//';
	$replace = 'Send to Problem Shelf';
}else if ($item['statistics_note_3'] !== 'KU FDLP REQUEST') {
	$pattern = '/(ANNEX ingest)|(HALE return)|(To be WITHDRAWN)|(AHD ANNEX ingest)|(AHD HALE return)|(AHD To be WITHDRAWN)|(GOV UNBOXING review)|(PHYSICAL CONDITION REVIEW)|(Needs pam binder)/';
	$replace = 'Send to Problem Shelf';
}
?>
              <table class="table">
				<tr><th class="flip"><span>Barcode:</span><span>Código de barras:<!--Código de procedencia:--></span></th><td><?=$e($item['barcode'])?></td></tr>
				<tr><th class="flip"><span>Inventory Date:</span><span>Fecha de inventario:</span></th><td><?=$e($item['inventory_date'])?></td></tr>
				<tr><th class="flip"><span>Destination:</span><span>Destino:</span></th><td class="statnote"><?= preg_replace($pattern, $replace, $item['statistics_note_3'])?>
				</td></tr>
				<tr><th></th><td></td></tr>
              </table>
			  <form method="post" action="../DisplayKUGov/DisplayKUGov.php">
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