<!--Following php color codes the Process type if it is populated-->
<?php/*
function process_type() {
if ($item['process_type']=='') {
		$style = 'style=";"';
}
	else if ($item['process_type']) {
		$style = 'style="background-color:#cd3700;"';
}
}
Following php color codes the Fulfillment Note if it matches one of the patterns
function fulfillment_note() {
if ($item['fulfillment_note']=='') {
		$style = 'style=";"';
}
	else if ($item['fulfillment_note']=='send*') {
		$style = 'style="background-color:#cd3700;"';
}
	else if ($item['fulfillment_note']=='withdraw*') {
		$style = 'style="background-color:#cd3700;"';
}
	else if ($item['fulfillment_note']=='voyager*') {
		$style = 'style="background-color:#cd3700;"';
}
	else if ($item['fulfillment_note']=='transfer*') {
		$style = 'style="background-color:#cd3700;"';
}
	else if ($item['fulfillment_note']=='return*') {
		$style = 'style="background-color:#cd3700;"';
}
	else if ($item['fulfillment_note']=='please*') {
		$style = 'style="background-color:#cd3700;"';
}
	else if ($item['fulfillment_note']=='lost*') {
		$style = 'style="background-color:#cd3700;"';
}
	else if ($item['fulfillment_note']=='give*') {
		$style = 'style="background-color:#cd3700;"';
}
	else if ($item['fulfillment_note']=='ILL*') {
		$style = 'style="background-color:#cd3700;"';
}
	else if ($item['fulfillment_note']=='binding*') {
		$style = 'style="background-color:#cd3700;"';
}
	else if ($item['fulfillment_note']=='route*') {
		$style = 'style="background-color:#cd3700;"';
}
	else if ($item['fulfillment_note']=='*send*') {
		$style = 'style="background-color:#cd3700;"';
}
	else if ($item['fulfillment_note']=='*withdraw*') {
		$style = 'style="background-color:#cd3700;"';
}
	else if ($item['fulfillment_note']=='*voyager*') {
		$style = 'style="background-color:#cd3700;"';
}
	else if ($item['fulfillment_note']=='*transfer*') {
		$style = 'style="background-color:#cd3700;"';
}
	else if ($item['fulfillment_note']=='*return*') {
		$style = 'style="background-color:#cd3700;"';
}
	else if ($item['fulfillment_note']=='*please*') {
		$style = 'style="background-color:#cd3700;"';
}
	else if ($item['fulfillment_note']=='*lost*') {
		$style = 'style="background-color:#cd3700;"';
}
	else if ($item['fulfillment_note']=='*give*') {
		$style = 'style="background-color:#cd3700;"';
}
	else if ($item['fulfillment_note']=='*ILL*') {
		$style = 'style="background-color:#cd3700;"';
}
	else if ($item['fulfillment_note']=='*binding*') {
		$style = 'style="background-color:#cd3700;"';
}
	else if ($item['fulfillment_note']=='*route*') {
		$style = 'style="background-color:#cd3700;"';
}
}
*/?>
              <table class="table">
                <tr><th class="flip"><span>Title:</span><span>Título:</span></th><td><?=$e($item['title'])?></td></tr>
				<tr><th class="flip"><span>Call Number:</span><span>Número de clasificación:</span></th><td><?=$e($item['call_number'])?></td></tr>
				<tr><th class="flip"><span>Description:</span><span>Descripción:</span></th><td><?=$e($item['description'])?></td></tr>
				<tr><th class="flip"><span>Barcode:</span><span>Códigos de procedencia:</span></th><td><?=$e($item['barcode'])?></td></tr>
				<tr><th class="flip"><span>Location:</span><span>Ubicación:</span></th><td><?=$e($item['location'])?></td></tr>
				<tr <?=$style?>><th class="flip"><span>Process Type:</span><span>Tipo de Proceso:</span></th><td><?=$e($item['process_type'])?></td></tr>
				<tr <?=$style?>><th class="flip"><span>Fulfillment Note:</span><span>Nota de servicios al usuario:</span></th><td><?=$e($item['fulfillment_note'])?></td></tr>
				<tr><th class="flip"><span>Inventory Date:</span><span>Fecha de inventario:</span></th><td><?=$e($item['inventory_date'])?></td></tr>
				<tr><th>Inventory Number:</th><td><?=$e($item['inventory_number'])?></td></tr>
				<tr><th>Internal Note 3:</th><td><?=$e($item['internal_note_3'])?></td></tr>
				<tr><th>Destination:</th><!--<th>Statistics Note 3:</th>--><td class="statnote"><?=$e($item['statistics_note_3'])?>
				</td></tr>
				<tr><th></th><td></dt></tr>
              </table>
			  <!--<input class="btn btn-primary btn-sm active" onclick="history.go(-1);" autofocus="autofocus" type="submit" value="Back"/>-->
			  <!--The following combines the two grimas ontop of each other-->
			  <!--<form method="post" action="../UnboxingWorkflowB/UnboxingWorkflowB.php">-->
			  <form method="post" action="/DisplayItemB/DisplayItemB.php">
				<div class="col">
				<div class="card" style="width: 500px;left: 225px;">
				<div class="card-body" style="width: 500px">
				<div class="form-row col-12 pb-4">
					<label class="col-3 form-check-label" for="barcode">Barcode:</label>
					<input class="col-9 form-control znew" type="text" name="unboxed_barcode" id="barcode" size="20" autofocus="autofocus" placeholder="SCAN NEXT BARCODE/Escanear los siguientes códigos fuente"/>
				</div>
				<input class="btn btn-primary btn-sm active" type="submit" value="Submit">
				</div>
				</div>
				</div>
              </form>