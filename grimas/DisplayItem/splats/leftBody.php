              <form method="post" action="UnboxingWorfklow.php">
			  <input type="hidden" name="unboxed_barcode" value="<?=$e(item['unboxed_barcode'])?>">
              </form>
			  <div class="form-row col-12 pb-4">
					<label class="col-3 form-check-label" for="unboxed_barcode">Barcode:</label>
					<input class="col-9 form-control znew" type="text" name="unboxed_barcode" id="barcode" size="20" placeholder="SCAN NEW BARCODE"/>
				  </div>
