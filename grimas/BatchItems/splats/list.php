<ul>
<?php foreach($holdinglist as $holding): ?>
<li><?= $holding->get_title_proper() ?>
 (<a href="../Hierarchy/Hierarchy.php?mms_id=<?= $holding['mms_id']?>">hierarchy</a>)
 (<a href="../PrintBib/PrintBib.php?mms_id=<?= $holding['mms_id']?>">view record</a>)
</li>
<?php endforeach ?>
</ul>

<ul>
    <?php foreach ($holdinglist as $holding): ?>
    <li><?=$e($holding['holding_id'])?>
	(<a href="../PrintHolding/PrintHolding.php?holding_id=<?=$e($holding['holding_id'])?>">Print Record</a>)
</li>
    <?php endforeach ?>
</ul>
<ul>
<?php foreach ($holdinglist->items as $item): ?>
<?=$e($item['item_pid'])?>
<?=$e($item['barcode'])?>
<?php endforeach ?>
</ul>