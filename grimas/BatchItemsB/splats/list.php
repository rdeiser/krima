<div class='card mt-2 bib'>
  <div class='card-header'>
  <?php foreach($biblist as $bib): ?>
    <h1 class='card-title'>Number of Modified Holdings<?=$e($holding['holding_id'])?>
      <a class='d-print-none viewlink' href="../PrintHolding/PrintHolding.php?holding_id=<?=$e($holding['holding_id'])?>">(view)</a>
    </h1>
  </div>
<?php endforeach?>