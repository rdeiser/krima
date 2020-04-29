<ul>
    <?php foreach ($holdinglist->items as $item): ?>
    <li><?=$e($item['barcode'])?>
	(<a href="../PrintHolding/PrintHolding.php?holding_id=<?= $holding['holding_id']?>">view record</a>)
</li>
    <?php endforeach ?>
	</ul>