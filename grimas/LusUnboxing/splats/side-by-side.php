<?php 
if ($item['statistics_note_3'] == 'HALE return') {
	$pattern = '/(HALE return)/';
	$replace = 'HALE return';
} 
if ($item['statistics_note_3'] == 'ANNEX ingest') {
	$pattern = '/(ANNEX ingest)/';
	$replace = 'ANNEX ingest';
}
if ($item['statistics_note_3'] == 'To be WITHDRAWN') {
	$pattern = '/(To be WITHDRAWN)/';
	$replace = 'To be WITHDRAWN';
}
if ($item['statistics_note_3'] == 'PHYSICAL CONDITION REVIEW For Possible Withdraw') {
	$pattern = '/(PHYSICAL CONDITION REVIEW For Possible Withdraw)/';
	$replace = 'Send to Condition Review Shelf';
}
if ($item['statistics_note_3'] == 'AHD HALE return') {
	$pattern = '/(AHD HALE return)/';
	$replace = 'HALE return';
} 
if ($item['statistics_note_3'] == 'AHD ANNEX ingest') {
	$pattern = '/(AHD ANNEX ingest)/';
	$replace = 'ANNEX ingest';
}
if ($item['statistics_note_3'] == 'AHD To be WITHDRAWN') {
	$pattern = '/(AHD To be WITHDRAWN)/';
	$replace = 'To be WITHDRAWN';
}

if ($item['statistics_note_3']=='To be WITHDRAWN') {
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
	else if ($item['statistics_note_3']=='AHD HALE return') {
			$style = 'style="background-color: #ab82ff;"';
			$text = '';
	}
	else if ($item['statistics_note_3']=='AHD To be WITHDRAWN') {
			$style = 'style="background-color: #cd5555;"';
			$text = '';
}
	else if ($item['statistics_note_3']=='AHD ANNEX ingest') {
			$style = 'style="background-color: #6495ed;"';
			$text = '';
	}
	else if ($item['statistics_note_3']=='PHYSICAL CONDITION REVIEW For Possible Withdraw') {
			$style = 'style=";"';
			$text = '';
	}
if ($item['statistics_note_3'] == '') {
	if ($item['in_temp_location'] == 'false') {
		$pattern = '/^/';
		$replace = $item['library'];
		if ($item['library_code'] =='ANNEX') {
			$style = 'style="background-color: #6495ed;"';
		} else if ($item['library_code'] =='MAIN') {
			$style = 'style="background-color: #ab82ff;"';
		} else if ($item['library_code'] =='SALINA') {
			$style = 'style="background-color: #ab82ff;"';
		} else if ($item['library_code'] =='ARCH') {
			$style = 'style="background-color: #ab82ff;"';
		} else if ($item['library_code'] =='MATHPHYS') {
			$style = 'style="background-color: #ab82ff;"';
		}
	} else {
		$pattern = '/^/';
		$replace = $item['temp_location'];
		if ($item['temp_library'] =='ANNEX') {
			$style = 'style="background-color: #6495ed;"';
		} else if ($item['temp_library'] =='MAIN') {
			$style = 'style="background-color: #ab82ff;"';
		} else if ($item['temp_library'] =='SALINA') {
			$style = 'style="background-color: #ab82ff;"';
		} else if ($item['temp_library'] =='ARCH') {
			$style = 'style="background-color: #ab82ff;"';
		} else if ($item['temp_library'] =='MATHPHYS') {
			$style = 'style="background-color: #ab82ff;"';
		}
	}

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
