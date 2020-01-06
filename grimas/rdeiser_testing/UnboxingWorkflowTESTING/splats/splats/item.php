<?= $t('body', array('item' => $item)) ?>
<div class='card mt-2 bib'>
  <div class='card-header'>
    <h1 class='card-title'>Barcode #<?=$e($item['barcode'])?>
    </h1>
  </div>
  <div class='card-body'>
	<div class="table">
      <tr><th>Title:</th><td><?=$e($item['title'])?></td></tr>
        <tr><th>Call Number:</th><td><?=$e($item['call_number'])?></td></tr>
        <tr><th>Description:</th><td><?=$e($item['description'])?></td></tr>
        <tr><th>Barcode:</th><td><?=$e($item['barcode'])?></td></tr>
        <tr><th>Location:</th><td><?=$e($item['location'])?></td></tr>
        <tr><th>Process Type:</th><td><?=$e($item['process_type'])?></td></tr>
        <tr><th>Fulfillment Note</th><td><?=$e($item['fulfillment_note'])?></td></tr>
        <tr><th>Statistics Note 3</th><td><?=$e($item['statistics_note_3'])?></td></tr>
      </table>