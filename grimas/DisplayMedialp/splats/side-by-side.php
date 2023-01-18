<?php 
if ($item['statistics_note_3'] == 'HALE return') {
	$pattern = '/(HALE return)/';
	$replace = 'HALE return';
	$style = 'style="background-color: #ab82ff;"';
	$text = '';
} 

if ($item['statistics_note_3'] !== 'HALE return') {
	$pattern = '/(^)/';
	$replace = 'Send to Problem Review Shelf';
	$style = 'style="background-color: #cd5555;"';
	$text = '';
}
if ($item['location'] !== "medialp") {
	if ($item['statistics_note_3'] == 'HALE return') {
		$pattern = '/(HALE return)/';
		$replace = 'Send to Problem Shelf';
		$style = 'style="background-color: #cd5555;"';
	} else if ($item['statistics_note_3'] == 'AHD HALE return') {
		$pattern = '/(AHD HALE return)/';
		$replace = 'Send to Problem Shelf';
		$style = 'style="background-color: #cd5555;"';
	}
}

	$holding = new Holding();
	$holding->loadFromAlma($item['mms_id'],$item['holding_id']);
	if ($holding['suppress_from_publishing'] == 'true'){
		if ($item['statistics_note_3']== 'AHD HALE return') {
			$pattern = '/(AHD HALE return)/';
			$replace = 'Send to Problem Shelf';
			$style = 'style="background-color: #cd5555;"';
			}else if ($item['statistics_note_3']== 'HALE return') {
				$pattern = '/(HALE return)/';
				$replace = 'Send to Problem Shelf';
				$style = 'style="background-color: #cd5555;"';
				}
	}else {
		$bib = new bib();
		$bib->loadFromAlma($item['mms_id']);
		if ($bib['suppress_from_publishing'] == 'true'){
			if ($item['statistics_note_3']== 'AHD HALE return') {
				$pattern = '/(AHD HALE return)/';
				$replace = 'Send to Problem Shelf';
				$style = 'style="background-color: #cd5555;"';
				} else if ($item['statistics_note_3']== 'HALE return') {
					$pattern = '/(HALE return)/';
					$replace = 'Send to Problem Shelf';
					$style = 'style="background-color: #cd5555;"';
				}
		}
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
