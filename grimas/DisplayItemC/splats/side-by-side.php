<?php if ($item['statistics_note_3']=='To be WITHDRAWN');
			$style = 'style="background-color: #cd5555;"';
	/*else if ($item['statistics_note_3']=='ANNEX ingest');
			$style = 'style="background-color: #6495ed;"';
	else if ($item['statistics_note_3']=='HALE return');
			$style = 'style="background-color: #4f2684;"';*/
					?>
		<h1 class="page-header text-center"><?=$e($title)?></h1>
        <div class="row">
          <div class="col">
            <div class="card" <?=$style?>>
              <div class="card-header">
                <h2 class="card-title"><?=$e($rightTitle)?></h2>
              </div>
              <div class="card-body">
<?= $t('rightBody', array('item' => $item)) ?>
              </div>
            </div>
          </div>
        </div>
<?= $t('messages') ?>
