<ul>
    <?php foreach ($holdinglist as $holding): ?>
    <li><?=$e($holding['holding_id'])?>
	(<a href="../PrintHolding/PrintHolding.php?holding_id=<?= $holding['holding_id']?>">view record</a>)
</li>
    <?php endforeach ?>
</ul>