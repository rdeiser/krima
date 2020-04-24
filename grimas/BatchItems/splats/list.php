<ul>
<?php foreach($holdinglist as $holding): ?>
<li><?= $holding->get_title_proper() ?>
 <?$holding['mms_id']?>
 <?$holding['holding_id']?>
</li>
<?php endforeach ?>
</ul>
