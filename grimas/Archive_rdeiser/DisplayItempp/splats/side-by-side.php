<?php 
//popup alert for juv,cmc,over,overplus,dowref, and ref
//message box on the screen
if ($item['location'] == 'juv') {
	echo'<script>alert("Send to Problem Shelf")</script>';
}
if ($item['location'] == 'cmc') {
	echo'<script>alert("Send to Problem Shelf")</script>';
}
if ($item['location'] == 'over') {
	echo'<script>alert("Send to Problem Shelf")</script>';
}
if ($item['location'] == 'overplus') {
	echo'<script>alert("Send to Problem Shelf")</script>';
}
if ($item['location'] == 'dowref') {
	echo'<script>alert("Send to Problem Shelf")</script>';
}
if ($item['location'] == 'ref') {
	echo'<script>alert("Send to Problem Shelf")</script>';
}
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
if ($item['statistics_note_3'] == '') {
	$pattern = '/^/';
	$replace = 'Send to Problem Shelf';
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
	else if ($item['statistics_note_3']=='') {
			$style = 'style=";"';
			//$text = 'Send to Problem Shelf';
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
