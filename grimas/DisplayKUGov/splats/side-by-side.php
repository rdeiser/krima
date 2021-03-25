<?php 
if ($item['statistics_note_3'] == 'KU FDLP REQUEST') {
	$pattern = '/(KU FDLP REQUEST)/';
	$replace = 'Send to KU';
}

if ($item['library_code'] == 'WITHDRAW') {
	$pattern = '//';
	$replace = 'GOV WITHDRAW';
	$style = 'style="background-color: #cd5555;"';
}else if ($item['library_code'] !== 'WITHDRAW') {
	$pattern = '/[A-z]/';
	$replace = 'Send to Problem Shelf';
}/*else if ($item['statistics_note_3'] !== 'KU FDLP REQUEST') {
	$pattern = '/(ANNEX ingest)|(HALE return)|(To be WITHDRAWN)|(AHD ANNEX ingest)|(AHD HALE return)|(AHD To be WITHDRAWN)|(GOV UNBOXING review)|(PHYSICAL CONDITION REVIEW)|(Needs pam binder)/';
	$replace = 'Send to Problem Shelf';
}*/

	else if ($item['statistics_note_3']=='KU FDLP REQUEST') {
			$style = 'style="background-color: #ab82ff;"';
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
