              <form method="post" action="NextUnboxingWorkflow.php">
			  <input required="no" type="hidden" name="next_barcode" value="<?=$e($item['barcode'])?>">
			  <div class="form-row col-12 pb-4">
					<label class="col-3 form-check-label" autofocus="autofocus" for="barcode">Barcode:</label>
					<input class="col-9 form-control znew" type="text" name="barcode" id="barcode" size="20" placeholder="SCAN NEXT BARCODE"/>
				  </div>
				</div>
                <input class="btn btn-primary btn-lg active" type="submit" autofocus="autofocus" value="Submit">
              </form>