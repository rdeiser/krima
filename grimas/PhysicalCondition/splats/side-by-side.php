<?php
if ($item['statistics_note_3'] == 'Condition review--CRITICAL' || $item['statistics_note_3'] == 'Condition review--REPAIR') {
	$pattern = '/(Condition review--CRITICAL)|(Condition review--REPAIR)/';
	$replace = 'REPAIR';
	$style = 'style="background-color: #ab82ff;"';
	$text = '';
}
if ($item['statistics_note_3'] == 'To be WITHDRAWN' || $item['statistics_note_3'] == 'AHD To be WITHDRAWN') {
	$pattern = '/(To be WITHDRAWN)|(AHD To be WITHDRAWN)/';
	$replace = 'To be WITHDRAWN';
	$style = 'style="background-color: #cd5555;"';
	$text = '';
}
if ($item['statistics_note_3'] == 'PHYSICAL CONDITION REVIEW For Possible Withdraw') {
	$pattern = '/(PHYSICAL CONDITION REVIEW For Possible Withdraw)/';
	$replace = 'Physical Condition Rebox';
}
if ($item['statistics_note_3'] == '' || $item['statistics_note_3'] == 'HALE return' || $item['statistics_note_3'] == 'AHD HALE return' || $item['statistics_note_3'] == 'ANNEX ingest' || $item['statistics_note_3'] == 'AHD ANNEX ingest') {
	$pattern = '/(^$)|(HALE return)|(AHD HALE return)|(ANNEX ingest)|(AHD ANNEX ingest)/';
	$replace = 'Send to Problem Shelf';
	$style = 'style=";"';
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
