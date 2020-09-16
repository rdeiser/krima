<?php
if ($item['additional_info'] =="Item's destination is: Hale Library. Request/Process Type: Transit for reshelving. Requester: . Requester ID: . Place in Queue: 1") {
	$pattern = "/^(Item's destination is: Hale Library. Request\/Process Type: Transit for reshelving. Requester: . Requester ID: . Place in Queue: 1)/";
	$replace = 'Hale Library';
}
//if (isset($item['additional_info'])) {
if ($item['additional_info'] =="Item's destination is: Reshelve to main. Request/Process Type: . /Requester: . Requester ID: . Place in Queue: 0") {
	$pattern = "/^(Item's destination is: Reshelve to main. Request\/Process Type: . Requester: . Requester ID: . Place in Queue: 0)/";
	$replace = 'Hale Library';
}
if ($item['additional_info'] =="Item's destination is: Reshelve to sortmain. Request/Process Type: . Requester: . Requester ID: . Place in Queue: 0") {
	$pattern = "/^(Item's destination is: Reshelve to sortmain. Request\/Process Type: . Requester: . Requester ID: . Place in Queue: 0)/";
	$replace = 'Hale Library--sortmain';
}
/*if ($item['additional_info'] =="Item's destination is: On Hold Shelf. Request/Process Type: Patron physical item request. Requester: Deiser II, Raymond. Requester ID: rdeiser. Place in Queue: 1") {*/
if (isset($item['additional_info'])) {
	$pattern = "/Item's destination is: On Hold Shelf./i";
	$replace = 'Hold Shelf';
}
/*if ($item['additional_info'] =="Item's destination is: Manage Locally (Quarantine). Request/Process Type: Quarantine. Requester: . Requester ID: . Place in Queue: 1") {
	$pattern = "/^(Item's destination is: Manage Locally \(Quarantine\). Request\/Process Type: Quarantine. Requester: . Requester ID: . Place in Queue: 1)/";
	$replace = '72hr Quarantine';
}*/
if (isset($item['additional_info'])) {
	$pattern = "/^(Item's destination is: Manage Locally \(Quarantine\). Request\/Process Type: Quarantine. Requester: . Requester ID: . Place in Queue: 1)/";
	$replace = '72hr Quarantine';
}
if ($item['process_type'] =="WORK_ORDER_DEPARTMENT") {
	$pattern = "/^WORK_ORDER_DEPARTMENT/";
	$replace = '72hr Quarantine';
}
?>
              <table class="table">
                <tr><th>Title:</th><td><?=$e($item['title'])?></td></tr>
				<tr><th>Call Number:</th><td><?=$e($item['call_number'])?></td></tr>
				<tr><th>Description:</th><td><?=$e($item['description'])?></td></tr>
				<tr><th>Barcode:<!--Código de procedencia:--></th><td><?=$e($item['barcode'])?></td></tr>
				<!--<tr><th>Location:Lugar:</th><td><?=$e($item['location'])?></td></tr>-->
				<tr <?//=$style?>><th>Process Type:</th><td><?= preg_replace($pattern, $replace, $item['process_type'])?></td></tr>
				<tr <?//=$style2?>><th>Fulfillment Note:<!--Nota de servicios al usuario:--></th><td><?=$e($item['fulfillment_note'])?></td></tr>
				<tr><th>Requested:</th><td><?=$e($item['requested'])?></td></tr>
				<tr><th>Inventory Date:</th><td><?=$e($item['inventory_date'])?></td></tr>
				<tr><th>Additional Info:</th><td><?=$e($item['additional_info'])?></td></tr>
				<tr><th>Destination:</th><td><?= preg_replace($pattern, $replace, $item['additional_info'])?></td></tr>
				<tr><th>Stat Note 3:</th><td class="statnote"><?=$e ($item['statistics_note_3'])?>
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
						<!--<option value="ARCH">Paul Weigel Library of Architecture, Planning, Design</option>-->
						<option value="ARCH" <?php echo (isset($_POST['library']) && $_POST['library'] === 'ARCH') ? 'selected' : ''; ?>>Paul Weigel Library of Architecture, Planning, Design</option>
						<!--<option value="MATHPHYS">Math/Physics Library</option>-->
						<option value="MATHPHYS" <?php echo (isset($_POST['library']) && $_POST['library'] === 'MATHPHYS') ? 'selected' : ''; ?>>Math/Physics Library</option>
					</select>
					<label>Place on Hold Shelf</label>
					<select name="hold" id="hold" style="width: 402px;" box-sizing: border-box>
						<option value="false">No</option>
						<!--<option value="true">Yes</option>-->
						<option value="true" <?php echo (isset($_POST['hold']) && $_POST['hold'] === 'true') ? 'selected' : ''; ?>>Yes</option>
					</select>
					<label>Done</label>
					<select name="done" id="done" style="width: 402px;" box-sizing: border-box>
						<option value="false">No</option>
						<!--<option value="true">Yes</option>-->
						<option value="true" <?php echo (isset($_POST['done']) && $_POST['done'] === 'true') ? 'selected' : ''; ?>>Yes</option>
					</select>
					<label>Place in 72hr Quarantine</label>
					<select name="order" id="order" style="width: 402px;" box-sizing: border-box>
						<option value="false">No</option>
						<!--<option value="true">Yes</option>-->
						<option value="true" <?php echo (isset($_POST['order']) && $_POST['order'] === 'true') ? 'selected' : ''; ?>>Yes</option>
					</select>
					<label class="col-3 form-check-label" for="barcode">Barcode:</label>
					<input class="col-9 form-control znew" type="text" name="barcode" id="barcode" size="20" autofocus="autofocus" placeholder="SCAN NEXT BARCODE"/>
				</div>
				<input class="btn btn-primary btn-sm active" type="submit" value="Submit">
				</div>
				</div>
				</div>
              </form>