<html><head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>AS Decisions Populated</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="../Grima.css" integrity="sha384-eHQCFEopV+FC0FMg+lfng8NEquSqSkUw1vaCdeQQsofqpeIzS3IdSR0fAVUWX6eH">
  </head>
  <body>
    <div class="jumbotron">
      <div class="container task-ASDecisions">
        <!-- form -->
        		<div class="card">
		  <div class="card-header">
			<h2 class="card-title">AS Decisions Populated</h2>
		  </div>
		  <div class="card-body">
			<form method="post" action="../ASDecisions/ASDecisions.php" class="">
  <div class="form-group">
    <label for="whichnote">Unboxing Stat 3 Note:</label>
    <select name="whichnote" id="whichnote" class="form-control">
      <option value="ANNEX ingest">ANNEX ingest</option>
	  <option value="HALE return" <?php echo (isset($_POST['whichnote']) && $_POST['whichnote'] === 'HALE return') ? 'selected' : ''; ?>>HALE return</option>
	  <option value="To be WITHDRAWN" <?php echo (isset($_POST['whichnote']) && $_POST['whichnote'] === 'To be WITHDRAWN') ? 'selected' : ''; ?>>To be WITHDRAWN</option>
	  <option value="AHD HALE return" <?php echo (isset($_POST['whichnote']) && $_POST['whichnote'] === 'AHD HALE return') ? 'selected' : ''; ?>>AHD HALE return</option>
	  <option value="AHD ANNEX ingest" <?php echo (isset($_POST['whichnote']) && $_POST['whichnote'] === 'AHD ANNEX ingest') ? 'selected' : ''; ?>>AHD ANNEX ingest</option>
	  <option value="AHD To be WITHDRAWN" <?php echo (isset($_POST['whichnote']) && $_POST['whichnote'] === 'AHD To be WITHDRAWN') ? 'selected' : ''; ?>>AHD To be WITHDRAWN</option>
	  <option value="PHYSICAL CONDITION REVIEW For Possible Withdraw" <?php echo (isset($_POST['whichnote']) && $_POST['whichnote'] === 'PHYSICAL CONDITION REVIEW For Possible Withdraw') ? 'selected' : ''; ?>>PHYSICAL CONDITION REVIEW</option>
	  <option value="GOV UNBOXING review" <?php echo (isset($_POST['whichnote']) && $_POST['whichnote'] === 'AGOV UNBOXING review') ? 'selected' : ''; ?>>GOV UNBOXING review</option>
    <small class="invalid-feedback">Field is required
</small>
  </div>
  <div class="form-group">
    <label for="barcodes">Barcodes needing Stat Note 2 and 3 Populated</label>
    <textarea rows="5" cols="20" class="form-control" name="barcodes" id="barcodes" placeholder="Barcodes, one per line."></textarea>
    <small class="invalid-feedback">Field is required
</small>
  </div>
  <input class="btn btn-primary active" type="submit" value="Submit">
  <?php $this->addMessage('success',"Successfully updated Item Recored for: {$item['barcode']}");?>
</form>
                <div class="messages mt-3">
                </div>
          </div>
        </div>
      </div>
    </div>
  

</body></html>