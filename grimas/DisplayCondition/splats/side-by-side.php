<?php
//Multiple Copy/Volume Withdraw Shelf -- Anther cart for description and item copy number/holdings copy number and 852 $x ser;per;anal Multiple Copy/Volume Withdraw Add Stat Note 1 WITHDRAW
if ($item['statistics_note_3'] == 'HALE return'||$item['statistics_note_3'] == 'AHD HALE return'||$item['statistics_note_3'] == 'ANNEX ingest'||$item['statistics_note_3'] == 'AHD ANNEX ingest'||$item['statistics_note_3'] == 'To be WITHDRAWN'||$item['statistics_note_3'] == 'AHD To be WITHDRAWN'||$item['statistics_note_3'] == 'PHYSICAL CONDITION REVIEW For Possible Withdraw'||$item['statistics_note_3'] == '') {
	$pattern = '/(HALE return|AHD HALE return|ANNEX ingest|AHD ANNEX ingest|To be WITHDRAWN|AHDTo be WITHDRAWN)|(^)/';
	$replace = 'Place on Reveiw Cart';
	$style = 'style="background-color: #ffffff;"';
	
}

if ($item['statistics_note_3'] == 'PHYSICAL CONDITION REVIEW For Possible Withdraw') {
	$pattern = '/(PHYSICAL CONDITION REVIEW For Possible Withdraw)/';
	$replace = 'WITHDRAW';
	$style = 'style="background-color: #cd5555;"';
	
}

if ($item['description']  !== ''||$item['copy_id'] >= '1') {
  $pattern = '/(PHYSICAL CONDITION REVIEW For Possible Withdraw)/';
	$replace = 'Multiple Copy/Volume Withdraw Shel';
	$style = 'style="background-color: #cd5555;"';
}

if ($item['statistics_note_3'] == 'Condition review--REPAIR'||$item['statistics_note_3'] == 'Condition review--CRITICAL') {
	$pattern = '/(Condition review--REPAIR|Condition review--CRITICAL)/';
	$replace = 'BINDING Cart';
	$style = 'style="background-color: #38761d;"';
	$text = '';
}

?>
		<!--<h1 class="page-header text-center"><?=$e($title)?></h1>-->
        <div class="row">
          <div class="col">
            <div class="card" <?=$style?>>
              <div class="card-header">
                <h2 class="card-title"><?=preg_replace($pattern, $replace, $item['statistics_note_3'])?></h2>
              </div>
              <div class="card-body">
<?= $t('rightBody', array('item' => $item)) ?>
              </div>
            </div>
          </div>
        </div>
<?= $t('messages') ?>