<?php
($item['process_type']=='null');
if (!empty($item['process_type'])) {
		$style = 'type= "text/css;"';
}
	else if ($item['process_type']) {
		$style = 'style="background-color:red;"';
}
?>
              <table class="table">
                <tr><th class="flip"><span>Title:</span><span>Título:</span></th><td><?=$e($item['title'])?></td></tr>
				<tr><th class="flip"><span>Call Number:</span><span>Número de clasificación:</span></th><td><?=$e($item['call_number'])?></td></tr>
				<tr><th class="flip"><span>Description:</span><span>Descripción:</span></th><td><?=$e($item['description'])?></td></tr>
				<tr><th class="flip"><span>Barcode:</span><span>códigos de barras:</span></th><td><?=$e($item['barcode'])?></td></tr>
				<tr><th class="flip"><span>Location:</span><span>Ubicación:</span></th><td><?=$e($item['location'])?></td></tr>
				<tr <?=$style?>><th class="flip"><span>Process Type:</span><span>Tipo de Proceso:</span></th><td><?=$e($item['process_type'])?></td></tr>
				<tr><th class="flip"><span>Fulfillment Note:</span><span>Nota de cumplimiento:</span></th><td><?=$e($item['fulfillment_note'])?></td></tr>
				<tr><th class="flip"><span>Inventory Date:</span><span>Fecha de inventario:</span></th><td><?=$e($item['inventory_date'])?></td></tr>
				<tr><th>Inventory Number:</th><td><?=$e($item['inventory_number'])?></td></tr>
				<tr><th>Internal Note 3:</th><td><?=$e($item['internal_note_3'])?></td></tr>
				<tr><th>Statistics Note 3:</th><td class="statnote"><?=$e($item['statistics_note_3'])?>
				</td></tr>
              </table>
			  <!--<input class="btn btn-primary btn-sm active" onclick="history.go(-1);" autofocus="autofocus" type="submit" value="Back"/>-->
			  <form method="post" action="../UnboxingWorkflowC/UnboxingWorkflowC.php">
				<div class="col">
				<div class="card">
				<div class="card-body">
				<div class="form-row col-12 pb-4">
					<label class="col-3 form-check-label" for="barcode">Barcode:</label>
					<input class="col-9 form-control znew" type="text" name="unboxed_barcode" id="barcode" size="20" autofocus="autofocus" placeholder="SCAN NEXT BARCODE"/>
				</div>
				<input class="btn btn-primary btn-sm active" type="submit" value="Submit">
				</div>
				</div>
				</div>
              </form>