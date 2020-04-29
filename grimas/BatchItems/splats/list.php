<ul>
    <?php foreach ($holdinglist as $holding): ?>
    <li>Holding #<?=$e($holding['holding_id'])?>
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