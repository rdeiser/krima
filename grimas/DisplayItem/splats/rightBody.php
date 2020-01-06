              <form method="post" action="DisplayItem.php">
			  <input required="yes" type="hidden" name="next_barcode" value="<?=$e($item['barcode'])?>">
			  <div class="form-row col-12 pb-4">
					<label class="col-3 form-check-label" autofocus="autofocus" for="barcode">Barcode:</label>
					<input class="col-9 form-control znew" type="text" name="next_barcode" id="barcode" size="20" placeholder="SCAN NEXT BARCODE"/>
				  </div>
				</div>
                <input class="btn btn-primary btn-lg active" type="submit" value="Submit">
              </form>