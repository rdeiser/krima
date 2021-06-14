<tr><th class="245">
<?php
	$xpath = new DomXPath($marc->xml);
	$fields = $xpath->query("//record/datafield[@tag='245']");
?>
<?php	foreach ($fields as $field): ?>
<?php		foreach ($field->childNodes as $subfield): ?>
<?php			if ($subfield->nodeName == "subfield"): ?>
    <span class='subfield value'><?=$e($subfield->nodeValue)?></span>
<?php			endif ?>
<?php		endforeach?>
    </td>
  </tr>
<?php endforeach ?>
</td></tr>
