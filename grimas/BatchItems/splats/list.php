<ul>
<h1 class='card-title'>Holding #<?=$e($holding['holding_id'])?>
      <a class='d-print-none viewlink' href="../PrintHolding/PrintHolding.php?holding_id=<?=$e($holding['holding_id'])?>">(view)</a>
    </h1>
    <?php foreach ($holdinglist as $holding): ?>
    <li>Holding #<?=$e($holding['holding_id'])?>
	(<a href="../PrintHolding/PrintHolding.php?holding_id=<?=$e($holding['holding_id'])?>">Print Record</a>)
</li>
    <?php endforeach ?>
