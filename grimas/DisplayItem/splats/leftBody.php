              <form method="post" action="DisplayItem.php">
			  <input type="hidden" name="next_barcode" value="<?=$e($item['barcode'])?>">
				<div class="form-row col-12 pb-4">
					<label class="col-3 form-check-label" for="next_barcode">Barcode:</label>
					<input class="col-9 form-control znew" type="text" name="barcode" id="barcode" size="20" placeholder="SCAN NEXT BARCODE"/>
				</div>
				<input type="hidden" name="adding" value="true"> <!-- override button -->
				<input class="btn btn-primary btn-sm active" type="submit" value="Submit">
              </form>
