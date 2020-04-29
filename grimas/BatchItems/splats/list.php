<ul>
    <?php foreach ($holdinglist as $holding): ?>
    <li><h1><?=$e($holding['holding_id'])?></h1>
	(<a href="../PrintHolding/PrintHolding.php?holding_id=<?=$e($holding['holding_id'])?>">(view)</a>)
</li>
    <?php endforeach ?>
</ul>
<ul>
<?php foreach ($holdinglist->items as $item): ?>
<?=$e($item['item_pid'])?>
<?=$e($item['barcode'])?>
</ul>
<?php endforeach ?>