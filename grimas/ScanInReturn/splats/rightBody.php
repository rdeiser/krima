              <table class="table">
                <tr><th>Title:</th><td><?=$e($item['title'])?></td></tr>
				<tr><th>Call Number:</th><td><?=$e($item['call_number'])?></td></tr>
				<tr><th>Description:</th><td><?=$e($item['description'])?></td></tr>
				<tr><th>Barcode:<!--Código de procedencia:--></th><td><?=$e($item['barcode'])?></td></tr>
				<!--<tr><th>Location:Lugar:</th><td><?=$e($item['location'])?></td></tr>-->
				<tr <?=$style?>><th>Process Type:</th><td><?=$e($item['process_type'])?></td></tr>
				<tr <?=$style2?>><th>Fulfillment Note:<!--Nota de servicios al usuario:--></th><td><?=$e($item['fulfillment_note'])?></td></tr>
				<tr><th>Inventory Date:</th><td><?=$e($item['inventory_date'])?></td></tr>
				<tr><th>Additional Info:</th><td><?=$e($item['additional_info'])?></td></tr>
				<tr><th>Destination:</th><td class="statnote"><?=$e ($item['statistics_note_3'])?>
				</td></tr>
				<tr><th></th><td></td></tr>
              </table>
			  <!--<input class="btn btn-primary btn-sm active" onclick="history.go(-1);" autofocus="autofocus" type="submit" value="Back"/>-->
			  <!--The following combines the two grimas ontop of each other-->
			  <form method="post" action="../ScanInReturn/ScanInReturn.php">
				<div class="col">
				<div class="card" style="width: 500px;left: 225px;">
				<div class="card-body" style="width: 500px">
				<div class="form-row col-12 pb-4">
					<label for="library">Library Circ Desk</label>
					<select name="library" id="library" style="width: 402px;" box-sizing: border-box>
						<option value="MAIN">Hale Library</option>
						<option value="ARCH">Paul Weigel Library of Architecture, Planning, Design</option>
						<option value="MATHPHYS">Math/Physics Library</option>
					</select>
					<label class="col-3 form-check-label" for="barcode">Barcode:</label>
					<input class="col-9 form-control znew" type="text" name="barcode" id="barcode" size="20" autofocus="autofocus" placeholder="SCAN NEXT BARCODE"/>
				</div>
				<input class="btn btn-primary btn-sm active" type="submit" value="Submit">
				</div>
				</div>
				</div>
              </form>