<?= $t('side-by-side', 
		array(
			'biblist' => $biblist,
			/*'title' => 'Item Information:',*/
			/*'leftTitle' => 'Scan Next Barcode',*/
			'rightTitle' => 'Holdings Data:',
		 )
	)
?>
<ul>
<?php foreach($biblist as $bib): ?>
<li><?= $bib->get_title_proper() ?>
 (<a href="../Hierarchy/Hierarchy.php?mms_id=<?= $bib['mms_id']?>">hierarchy</a>)
 (<a href="../PrintBib/PrintBib.php?mms_id=<?= $bib['mms_id']?>">view record</a>)
</li>
<?php endforeach ?>
</ul>
