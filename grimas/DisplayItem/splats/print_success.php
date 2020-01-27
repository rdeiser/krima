<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <head>
<?=$t('head')?>
<meta name="google" content="notranslate">
  </head>
  <body>
      <div class="container task-<?=$e($basename)?>">
        <div class="container mt-4 position-relative">
          <div class="position-absolute mx-auto help-button">
            <a class="btn btn-info" href="<?=$e($basename)?>.md" target="_blank">?</a>
          </div>
        </div>
        <!-- success -->
<?= $t('success') ?>
      </div>
  </body>
</html>
