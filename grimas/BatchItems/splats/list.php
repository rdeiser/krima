<ul>
    <?php foreach ($holdinglist as $holding): ?>
    <li>Holding #<?=$e($holding['holding_id'])?>
	(<a href="../PrintHolding/PrintHolding.php?holding_id=<?=$e($holding['holding_id'])?>">Print Record</a>)
</li>
    <?php endforeach ?>
	<?php foreach ($holdinglist->items as $item): ?>
<li><?=$e($item['item_pid'])?>
<?=$e($item['barcode'])?>
<?php endforeach ?></li>
</ul>
