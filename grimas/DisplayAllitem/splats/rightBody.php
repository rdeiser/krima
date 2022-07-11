<?php
if (preg_match("/^([2-9]|[1-9][0-9]|[1-9][0-9][0-9])$/", $item['copy_id'])) {
	$style3 = 'style="opacity:1;"';
} else {
	$style3 = 'style="opacity:0;"';
}
if ($item['description']=='') {
	$style4 = 'style="opacity:0;"';
	$pattern2 = '//';
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
				<tr><th>Barcode:</th><td><?=$e($item['barcode'])?></td></tr>
				<tr><th>Inventory Date:</th><td><?=$e($item['inventory_date'])?></td></tr>
				<tr><th>Item Policy:</th><td><?=$e($item['item_policy'])?></td></tr>
				<tr><th>Process Type:</th><td><?=$e($item['process_type'])?></td></tr>
				<tr><th>Fulfillment Note:</th><td><?=$e($item['fulfillment_note'])?></td></tr>
				<tr><th>Public Note:</th><td><?=$e($item['public_note'])?></td></tr>
				<tr><th>Internal Note 1:</th><td><?=$e($item['internal_note_1'])?></td></tr>
				<tr><th>Internal Note 2:</th><td><?=$e($item['internal_note_2'])?></td></tr>
				<tr><th>Statistics Note 1:</th><td><?=$e($item['statistics_note_1'])?></td></tr>
				<tr><th>Statistics Note 2:</th><td><?=$e($item['statistics_note_2'])?></td></tr>
				<tr><th>Statistics Note 3:</th><td><?=$e($item['statistics_note_3'])?></td></tr>
				<tr><th>Location:</th><td><?=$e($item['location'])?></td></tr>
				<tr><th></th><td></td></tr>
              </table>
			  <!--<input class="btn btn-primary btn-sm active" onclick="history.go(-1);" autofocus="autofocus" type="submit" value="Back"/>-->
			  <!--The following combines the two grimas ontop of each other-->
			  <form method="post" action="../DisplayAllitem/DisplayAllitem.php">
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