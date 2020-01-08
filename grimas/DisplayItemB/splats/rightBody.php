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
				<tr><th>Statistics Note 3</th><td><?=$e($item['statistics_note_3'])?></td></tr>
              </table>
			  <input class="btn btn-primary btn-sm active" onclick="history.go(-1);" autofocus="autofocus" type="submit" value="Back"/>
