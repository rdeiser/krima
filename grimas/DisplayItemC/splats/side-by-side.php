<?php if ($item['statistics_note_3']=='To be WITHDRAWN') {
			$style = 'style="background-color: #cd5555;"';
}
	else if ($item['statistics_note_3']=='ANNEX ingest') {
			$style = 'style="background-color: #6495ed;"';
	}
	else if ($item['statistics_note_3']=='HALE return') {
			$style = 'style="background-color: #9f79ee;"';
	}
					?>
		<!--<h1 class="page-header text-center"><?=$e($title)?></h1>-->
        <div class="row">
          <div class="col">
            <div class="card" <?=$style?>>
              <div class="card-header">
                <h2 class="card-title"><?=
				$item['statistics_note_3']='0';
				if isset($e($item['statistics_note_3'])){
					echo $e($item['statistics_note_3']);
				}
				else if !empty($e($item['statistics_note_3'])){
					print_r("Send to Problem Shelf <br>");
				}?></h2>
              </div>
              <div class="card-body">
<?= $t('rightBody', array('item' => $item)) ?>
              </div>
            </div>
          </div>
        </div>
<?= $t('messages') ?>
