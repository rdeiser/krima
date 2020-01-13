              <table class="table">
                <tr><th>Title:</th><td><?=$e($item['title'])?></td></tr>
				<tr><th>Call Number:</th><td><?=$e($item['call_number'])?></td></tr>
				<tr><th>Description:</th><td><?=$e($item['description'])?></td></tr>
				<tr><th>Barcode:</th><td><?=$e($item['barcode'])?></td></tr>
				<tr><th>Location:</th><td><?=$e($item['location'])?></td></tr>
				<tr><th>Process Type:</th><td><?=$e($item['process_type'])?></td></tr>
				<tr><th>Fulfillment Note</th><td><?=$e($item['fulfillment_note'])?></td></tr>
				<tr><th>Inventory Date</th><td><?=$e($item['inventory_date'])?></td></tr>
				<tr><th>Inventory Number</th><td><?=$e($item['inventory_number'])?></td></tr>
				<tr><th>Internal Note 3</th><td><?=$e($item['internal_note_3'])?></td></tr>
				<tr><th>Statistics Note 3</th><td><?=$e($item['statistics_note_3'])?>
				<?=$f=array();
				$f["$item"] = "statistics_note_3";
				$f["value"] = "ANNEX ingest";
				$f["css"]="'background-color':'#FBEC88', 'color':'green'";
				?>
				
				</td></tr>
              </table>
			  <!--<input class="btn btn-primary btn-sm active" onclick="history.go(-1);" autofocus="autofocus" type="submit" value="Back"/>-->
			  <form method="post" action="../UnboxingWorkflowB/UnboxingWorkflowB.php">
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
				<script src="DisplayItemC.js"></script>
              </form>
