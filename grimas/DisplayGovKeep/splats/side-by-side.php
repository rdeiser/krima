<?php 
if ($item['statistics_note_3'] == 'HALE return') {
	if($item['location_code'] == 'gov'||'govcen'||'govelect'||'govmap'||'govmfile'||'govmic'||'govover'||'govref'||'govmindex'||'govoffmap'||'govposter') {
		$pattern = '/(HALE return)/';
		$replace = $item['location'];
	} else {
		$pattern = '/(ANNEX ingest)|(HALE return)|(To be WITHDRAWN)|(AHD ANNEX ingest)|(AHD HALE return)|(AHD To be WITHDRAWN)|(GOV UNBOXING review)|(PHYSICAL CONDITION REVIEW)|(Needs pam binder)/';
		$replace = 'Send to Problem Shelf';
	}
}
if ($item['statistics_note_3'] == '') {
	$pattern = '/^/';
	$replace = 'Send to Problem Shelf';
}

	else if ($item['statistics_note_3']=='HALE return') {
			$style = 'style="background-color: #ab82ff;"';
			$text = '';
	}
	else if ($item['statistics_note_3']=='') {
			$style = 'style=";"';
			$text = 'Send to Problem Shelf';
	}
	
	$holding = new Holding();
	$holding->loadFromAlma($item['mms_id'],$item['holding_id']);
	if ($holding['suppress_from_publishing'] == 'true'){
		if ($item['statistics_note_3']== 'AHD HALE return') {
			$pattern = '/(AHD HALE return)/';
			$replace = 'Send to Problem Shelf';
			$style = 'style=";"';
			}else if ($item['statistics_note_3']== 'HALE return') {
				$pattern = '/(HALE return)/';
				$replace = 'Send to Problem Shelf';
				$style = 'style=";"';
				}
	}else {
		$bib = new bib();
		$bib->loadFromAlma($item['mms_id']);
		if ($bib['suppress_from_publishing'] == 'true'){
			if ($item['statistics_note_3']== 'AHD HALE return') {
				$pattern = '/(AHD HALE return)/';
				$replace = 'Send to Problem Shelf';
				$style = 'style=";"';
				} else if ($item['statistics_note_3']== 'HALE return') {
					$pattern = '/(HALE return)/';
					$replace = 'Send to Problem Shelf';
					$style = 'style=";"';
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
