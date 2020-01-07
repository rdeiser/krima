              <form method="post" action="NextItem.php">
			  <input type="hidden" name="unboxed_barcode" value="<?=$e(item['unboxed_barcode'])?>">
				<div class="form-row col-12 pb-4">
					<label class="col-3 form-check-label" for="unboxed_barcode">Barcode:</label>
					<input class="col-9 form-control znew" type="text" name="barcode" id="barcode" size="20" placeholder="SCAN NEW BARCODE"/>
				</div>
				<input class="btn btn-primary btn-sm active" type="submit" value="Submit">
              </form>
