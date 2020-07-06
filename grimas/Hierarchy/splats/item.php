<div class='card ml-4 item'>
  <div class='card-header'>
    <h3 class='card-title'>Item #<?=$e($item['item_pid'])?>
      <!--<a class='d-print-none viewlink' href="../PrintItem/PrintItem.php?item_pid=<?=$e($item['item_pid'])?>">(view)</a>-->
    </h3>
  </div>
  <div class='card-body'>
    <dl class="row">
      <dt class="col-md-2 text-right barcode">Barcode:</dt>
      <dd class="col-md-10 barcode"><?=$e($item['barcode'])?>
      <dt class="col-md-2 text-right description">Description:</dt>
      <dd class="col-md-10 description"><?=$e($item['description'])?>
	  <dt class="col-md-2 text-right" style="white-space: nowrap">Inventory Date:</dt>
      <dd class="col-md-10" style="padding-left: 50px;"><?=$e($item['inventory_date'])?>
	  <dt class="col-md-2 text-right" style="white-space: nowrap">Statistics note 3:</dt>
      <dd class="col-md-10" style="padding-left: 50px;"><?=$e($item['statistics_note_3'])?>
    </dl>
  </div>
</div>
           
