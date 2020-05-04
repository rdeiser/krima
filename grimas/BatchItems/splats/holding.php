<div class='card mt-2 bib'>
  <div class='card-header'>
  <?php foreach($holdinglist as $holding): ?>
    <h1 class='card-title'>Holding #<?=$e ($holding['holding_id'])?>Number of added Item Records:<?=$e($item['item_id'])?>
      <a class='d-print-none viewlink' href="../PrintHolding/PrintHolding.php?holding_id=<?=$e($holding['holding_id'])?>">(view)</a>
    </h1>
  </div>
<?php endforeach?>