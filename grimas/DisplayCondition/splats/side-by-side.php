<?php
if ($item['statistics_note_3'] == 'HALE return'||$item['statistics_note_3'] == 'AHD HALE return'||$item['statistics_note_3'] == 'ANNEX ingest'||$item['statistics_note_3'] == 'AHD ANNEX ingest'||$item['statistics_note_3'] == 'To be WITHDRAWN'||$item['statistics_note_3'] == 'AHD To be WITHDRAWN'||$item['statistics_note_3'] == 'PHYSICAL CONDITION REVIEW For Possible Withdraw'||$item['statistics_note_3'] == '') {
	$pattern = '/(HALE return|AHD HALE return|ANNEX ingest|AHD ANNEX ingest|To be WITHDRAWN|AHDTo be WITHDRAWN)|(^)/';
	$replace = 'Place on Reveiw Cart';
	$style = 'style="background-color: #ffffff;"';
	
}

if ($item['statistics_note_3'] == 'PHYSICAL CONDITION REVIEW For Possible Withdraw') {
	$pattern = '/(PHYSICAL CONDITION REVIEW For Possible Withdraw)/';
	$replace = 'WITHDRAW';
	$style = 'style="background-color: #cd5555;"';

  if ($item['description']  !== ''||$item['copy_id'] >= '1') {
    $pattern = '/(PHYSICAL CONDITION REVIEW For Possible Withdraw)/';
    $replace = 'Multiple Copy/Volume Withdraw Shelf';
    $style = 'style="background-color: #ffd800;"';
  }
  $holding = new Holding();
  $holding->loadFromAlma($item['mms_id'],$item['holding_id']);
  $subfields = $holding->getSubfieldValues("852","x");
  $subfieldt = $holding->getSubfieldValues("852","t");
  $subfield6 = $holding->getFields("866");
  $subfield7 = $holding->getFields("867");
  $subfield8 = $holding->getFields("868");
  $subfieldx = implode(" ",$subfields);
  $poss = strpos($subfieldx,'s');
  $posa = strpos($subfieldx,'a');
  $posp = strpos($subfieldx,'p');
  if ($poss !== false||$posa !== false||$posp !== false) {
    $pattern = '/(PHYSICAL CONDITION REVIEW For Possible Withdraw)/';
    $replace = 'Multiple Copy/Volume Withdraw Shelf';
    $style = 'style="background-color: #ffd800;"';
  }
  if (!empty($subfieldt)) {
    $pattern = '/(PHYSICAL CONDITION REVIEW For Possible Withdraw)/';
    $replace = 'Multiple Copy/Volume Withdraw Shelf';
    $style = 'style="background-color: #ffd800;"';
  }
    
    if (!empty($subfield6)) {
    $pattern = '/(PHYSICAL CONDITION REVIEW For Possible Withdraw)/';
    $replace = 'Multiple Copy/Volume Withdraw Shelf';
    $style = 'style="background-color: #ffd800;"';
  }
  
    if (!empty($subfield7)) {
    $pattern = '/(PHYSICAL CONDITION REVIEW For Possible Withdraw)/';
    $replace = 'Multiple Copy/Volume Withdraw Shelf';
    $style = 'style="background-color: #ffd800;"';
  }
    
    if (!empty($subfield8)) {
    $pattern = '/(PHYSICAL CONDITION REVIEW For Possible Withdraw)/';
    $replace = 'Multiple Copy/Volume Withdraw Shelf';
    $style = 'style="background-color: #ffd800;"';
  }
  //The following will only work with php8 or higher
  /*$holding = new Holding();
  $holding->loadFromAlma($item['mms_id'],$item['holding_id']);
  $subfields = $holding->getSubfieldValues("852","x");
  $subfieldx = implode(" ",$subfields);
  if (str_contains($subfieldx,'ser')||str_contains($subfieldx,'per')||str_contains($subfieldx,'anal')) {
	$pattern = '/(PHYSICAL CONDITION REVIEW For Possible Withdraw)/';
	$replace = 'Multiple Copy/Volume Withdraw Shelf';
  $style = 'style="background-color: #ffd800;"';
  }*/
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