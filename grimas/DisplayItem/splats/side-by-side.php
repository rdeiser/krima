<?php if ($item['statistics_note_3']=='To be WITHDRAWN') {
			$style = 'style="background-color: #cd5555;"';
			$text = '';
}
	else if ($item['statistics_note_3']=='ANNEX ingest') {
			$style = 'style="background-color: #6495ed;"';
			$text = '';
	}
	else if ($item['statistics_note_3']=='HALE return') {
			$style = 'style="background-color: #ab82ff;"';
			$text = '';
	}
	else if ($item['statistics_note_3']=='') {
			$text = 'Send to Problem Shelf';
	}
					?>
		<!--<h1 class="page-header text-center"><?=$e($title)?></h1>-->
        <div class="row">
          <div class="col">
            <div class="card" <?=$style?>>
              <div class="card-header">
                <h2 class="card-title"><?=$e($item['statistics_note_3'])?><?=$text?></h2>
              </div>
              <div class="card-body">
<?= $t('rightBody', array('item' => $item)) ?>
              </div>
            </div>
          </div>
        </div>
<?= $t('messages') ?>
