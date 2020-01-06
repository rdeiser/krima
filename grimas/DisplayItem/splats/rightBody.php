              <form method="post" action="NextUnboxingWorkflow.php">
			  <input type="hidden" required="yes" autofocus="autofocus" name="unboxed_barcode" value="<?=$item->loadFromAlmaBarcode($this['unboxed_barcode'])?>">
			  <div class="form-row col-12 pb-4">
					<label class="col-3 form-check-label" for="barcode">Barcode:</label>
					<input class="col-9 form-control znew" type="text" name="barcode" id="barcode" size="20" placeholder="SCAN NEXT BARCODE"/>
				  </div>
				</div>
				<input type=hidden" name="adding" value="true">
                <input class="btn btn-primary btn-lg active" type="submit" value="Submit">
              </form>