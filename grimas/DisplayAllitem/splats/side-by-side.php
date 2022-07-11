		<!--<h1 class="page-header text-center"><?=$e($title)?></h1>-->
        <div class="row">
          <div class="col">
            <div class="card" <?=$style?>>
              <div class="card-header">
                <h2 class="card-title"><?=$e($item['location'])?></h2>
              </div>
              <div class="card-body">
<?= $t('rightBody', array('item' => $item)) ?>
              </div>
            </div>
          </div>
        </div>
<?= $t('messages') ?>
