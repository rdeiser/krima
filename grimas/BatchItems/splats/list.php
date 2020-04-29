<ul>
    <?php foreach ($holdinglist as $holding): ?>
    <li><?=$e($holding['holding_id'])?>
	(<a href="../PrintHolding/PrintHolding.php?holding_id=<?= $holding['holding_id']?>">view record</a>)
</li>
    <?php endforeach ?>
</ul>
<ul>
<?php foreach ($holdinglist->items as $item): ?>
<?=$e($item['item_pid'])?>
<?=$e($item['barcode'])?>
</ul>
<?php endforeach ?>