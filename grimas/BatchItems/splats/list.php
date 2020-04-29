<ul>
    <?php foreach ($holdinglist as $holding): ?>
    <li><?=$e($holding['holding_id'])?>
	(<a class='d-print-none viewlink' href="../PrintHolding/PrintHolding.php?holding_id=<?=$e($holding['holding_id'])?>">(view)</a>)
</li>
    <?php endforeach ?>
</ul>
<ul>
<?php foreach ($holdinglist->items as $item): ?>
<?=$e($item['item_pid'])?>
<?=$e($item['barcode'])?>
</ul>
<?php endforeach ?>