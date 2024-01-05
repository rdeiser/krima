<div class="card">
    <div class="card-header">
        <h2 class="card-title">New Item Record Creation</h2>
    </div>
    <div class="card-body">
			<form method="post" action="../NewItem/NewItem.php" class="">
                <div class="form-group">
                    <label for="holding_id">Holdings Record Id</label>
					<input class="form-control" name="holding_id" id="holding_id" size="20" placeholder="Holding Id Number" autocomplete="off" type="input" value="" autofocus="autofocus">
                    <small class="invalid-feedback">Field is required
                        </small>
                </div>
                <div class="form-group">
                    <label for="copyid">Copy ID</label>
                    <input class="form-control" name="copyid" id="copyid" size="20" placeholder="If left blank, Copy ID will be 0" autocomplete="off" type="input" autofocus="autofocus" value="<?php echo isset($_POST['copyid']) ? $_POST['copyid'] : '' ?>">
                    <small class="invalid-feedback"></small>
                </div>
                <div class="form-group">
                    <label for="materialtype">Material type</label>
                    <select name="materialtype" id="materialtype" class="form-control">
                        <option value="BOOK">Book</option>
                        <option value="ISSUE" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'ISSUE') ? 'selected' : ''; ?>>Issue</option>
                        <option value="DVD" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'DVD') ? 'selected' : ''; ?>>DVD</option>
						<option value="CD" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'CD') ? 'selected' : ''; ?>>Compact Disc</option>
						<option value="CDROM" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'CDROM') ? 'selected' : ''; ?>>CD-ROM</option>
						<option value="DVDRM" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'DVDRM') ? 'selected' : ''; ?>>DVD-ROM</option>
						<option value="SCORE" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'SCORE') ? 'selected' : ''; ?>>Music Score</option>
						<option value="VIDEOCASSETTE" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'VIDEOCASSETTE') ? 'selected' : ''; ?>>Video cassette</option>
						<option value="AUDIOCASSETTE" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'AUDIOCASSETTE') ? 'selected' : ''; ?>>Audio cassette</option>
						<option value="MANUSCRIPT" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'MANUSCRIPT') ? 'selected' : ''; ?>>Manuscript</option>
						<option value="FILM" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'FILM') ? 'selected' : ''; ?>>Microfilm</option>
						<option value="FICHE" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'FICHE') ? 'selected' : ''; ?>>Microfiche</option>
						<option value="DISK" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'DISK') ? 'selected' : ''; ?>>Computer Disk</option>
						<option value="REALIA" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'REALIA') ? 'selected' : ''; ?>>Realia</option>
						<option value="KIT" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'KIT') ? 'selected' : ''; ?>>Kit</option>
						<option value="PICTURE" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'PICTURE') ? 'selected' : ''; ?>>Picture</option>
						<option value="MAP" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'MAP') ? 'selected' : ''; ?>>Map</option>
						<option value="LP" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'LP') ? 'selected' : ''; ?>>LP</option>
						<option value="RECORD" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'RECORD') ? 'selected' : ''; ?>>Sound Recording</option>
						<option value="LPTOP" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'LPTOP') ? 'selected' : ''; ?>>Laptop</option>
						<option value="ARTORIG" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'ARTORIG') ? 'selected' : ''; ?>>Art Original</option>
						<option value="ARTREPRO" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'ARTREPRO') ? 'selected' : ''; ?>>Art Reproduction</option>
						<option value="CHART" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'CHART') ? 'selected' : ''; ?>>Chart</option>
						<option value="FILMSTRIP" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'FILMSTRIP') ? 'selected' : ''; ?>>Filmstrip</option>
						<option value="FLASHCARD" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'FLASHCARD') ? 'selected' : ''; ?>>Flash Card</option>
						<option value="GAME" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'GAME') ? 'selected' : ''; ?>>Game</option>
						<option value="GRAPHIC" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'GRAPHIC') ? 'selected' : ''; ?>>Graphic</option>
						<option value="SLIDE" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'SLIDE') ? 'selected' : ''; ?>>Slide</option>
						<option value="TECHDRAWING" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'TECHDRAWING') ? 'selected' : ''; ?>>Technical Drawing</option>
						<option value="PHOTOGRAPH" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'PHOTOGRAPH') ? 'selected' : ''; ?>>Photograph</option>
						<option value="THESIS" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'THESIS') ? 'selected' : ''; ?>>K-State only Thesis</option>
						<option value="AUDIOBOOK" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'AUDIOBOOK') ? 'selected' : ''; ?>>Audiobook</option>
						<option value="EQUIP" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'EQUIP') ? 'selected' : ''; ?>>Equipment</option>
						<option value="MICROFORM" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'MICROFORM') ? 'selected' : ''; ?>>Microform</option>
						<option value="VRECORD" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'VRECORD') ? 'selected' : ''; ?>>Video Recording</option>
						<option value="ARTICLE" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'DVD') ? 'selected' : ''; ?>>Article</option>
						<option value="BLURAY" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'BLURAY') ? 'selected' : ''; ?>>Blu-Ray</option>
						<option value="BLURAYDVD" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'BLURAYDVD') ? 'selected' : ''; ?>>Blu-Ray And DVD</option>
						<option value="MICROCARD" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'MICROCARD') ? 'selected' : ''; ?>>Microcard</option>
						<option value="MMFILM" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'MMFILM') ? 'selected' : ''; ?>>16 mm Film</option>
						<option value="OTHERVM" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'OTHERVM') ? 'selected' : ''; ?>>Other Visual Material</option>
						<option value="PHONODISC" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'PHONODISC') ? 'selected' : ''; ?>>78 rpm discs</option>
						<option value="AUDIOVM" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'AUDIOVM') ? 'selected' : ''; ?>>Audio visual media</option>
						<option value="HATHIMATERIAL" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'HATHIMATERIAL') ? 'selected' : ''; ?>>HathiTrust Material</option>
						<option value="MUSICINSTRUMENT" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'MUSICINSTRUMENT') ? 'selected' : ''; ?>>Musical Instrument</option>
						<option value="LOCKER" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'LOCKER') ? 'selected' : ''; ?>>Locker</option>
						<option value="MICROPHONE" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'MICROPHONE') ? 'selected' : ''; ?>>Microphone</option>
						<option value="FASCICULE" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'FASCICULE') ? 'selected' : ''; ?>>Fascicule</option>
						<option value="LRDSC" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'LRDSC') ? 'selected' : ''; ?>>Laserdisc</option>      <option value="OTHER" <?php echo (isset($_POST['materialtype']) && $_POST['materialtype'] === 'OTHER') ? 'selected' : ''; ?>>Other</option>
                    </select>
                    <small class="invalid-feedback"></small>
                </div>
                <div class="form-group">
                    <label for="itempolicy">Item Policy</label>
                    <select name="itempolicy" id="itempolicy" class="form-control">
                        <option value="book/ser">book/ser</option>
						<option value="no loan" <?php echo (isset($_POST['itempolicy']) && $_POST['itempolicy'] === 'no loan') ? 'selected' : ''; ?>>no loan</option>
						<option value="score" <?php echo (isset($_POST['itempolicy']) && $_POST['itempolicy'] === 'score') ? 'selected' : ''; ?>>score</option>
						<option value="video" <?php echo (isset($_POST['itempolicy']) && $_POST['itempolicy'] === 'video') ? 'selected' : ''; ?>>video</option>
						<option value="dvd" <?php echo (isset($_POST['itempolicy']) && $_POST['itempolicy'] === 'dvd') ? 'selected' : ''; ?>>dvd</option>
						<option value="sound rec" <?php echo (isset($_POST['itempolicy']) && $_POST['itempolicy'] === 'sound rec') ? 'selected' : ''; ?>>sound rec</option>
						<option value="7 day" <?php echo (isset($_POST['itempolicy']) && $_POST['itempolicy'] === '7 day') ? 'selected' : ''; ?>>7 day</option>
						<option value="30 day" <?php echo (isset($_POST['itempolicy']) && $_POST['itempolicy'] === '30 day') ? 'selected' : ''; ?>>30 day</option>
						<option value="media" <?php echo (isset($_POST['itempolicy']) && $_POST['itempolicy'] === 'media') ? 'selected' : ''; ?>>media</option>
						<option value="res30day" <?php echo (isset($_POST['itempolicy']) && $_POST['itempolicy'] === 'res30day') ? 'selected' : ''; ?>>res30day</option>
						<option value="res4hrcl" <?php echo (isset($_POST['itempolicy']) && $_POST['itempolicy'] === 'res4hrcl') ? 'selected' : ''; ?>>res4hrcl</option>
						<option value="videobox" <?php echo (isset($_POST['itempolicy']) && $_POST['itempolicy'] === 'videobox') ? 'selected' : ''; ?>>videobox</option>
						<option value="per3" <?php echo (isset($_POST['itempolicy']) && $_POST['itempolicy'] === 'per3') ? 'selected' : ''; ?>>per3</option>
						<option value="res1day" <?php echo (isset($_POST['itempolicy']) && $_POST['itempolicy'] === 'res1day') ? 'selected' : ''; ?>>res1day</option>
						<option value="res2week" <?php echo (isset($_POST['itempolicy']) && $_POST['itempolicy'] === 'res2week') ? 'selected' : ''; ?>>res2week</option>
						<option value="res3day" <?php echo (isset($_POST['itempolicy']) && $_POST['itempolicy'] === 'res3day') ? 'selected' : ''; ?>>res3day</option>
						<option value="res7day" <?php echo (isset($_POST['itempolicy']) && $_POST['itempolicy'] === 'res7day') ? 'selected' : ''; ?>>res7day</option>
						<option value="cdrom" <?php echo (isset($_POST['itempolicy']) && $_POST['itempolicy'] === 'cdrom') ? 'selected' : ''; ?>>cdrom</option>
						<option value="accom" <?php echo (isset($_POST['itempolicy']) && $_POST['itempolicy'] === 'accom') ? 'selected' : ''; ?>>accom</option>
						<option value="per4" <?php echo (isset($_POST['itempolicy']) && $_POST['itempolicy'] === 'per4') ? 'selected' : ''; ?>>per4</option>
						<option value="per5" <?php echo (isset($_POST['itempolicy']) && $_POST['itempolicy'] === 'per5') ? 'selected' : ''; ?>>per5</option>
						<option value="res2hr" <?php echo (isset($_POST['itempolicy']) && $_POST['itempolicy'] === 'res2hr') ? 'selected' : ''; ?>>res2hr</option>
						<option value="res5hr" <?php echo (isset($_POST['itempolicy']) && $_POST['itempolicy'] === 'res5hr') ? 'selected' : ''; ?>>res5hr</option>
						<option value="res2hrcl" <?php echo (isset($_POST['itempolicy']) && $_POST['itempolicy'] === 'res2hrcl') ? 'selected' : ''; ?>>res2hrcl</option>
                    </select>
                    <small class="invalid-feedback"></small>
                </div>
                <div class="form-group">
                    <label for="pieces">Pieces</label>
                    <input class="form-control" name="pieces" id="pieces" size="20" placeholder="If left blank, Piece Count will be 1" autocomplete="off" type="input" autofocus="autofocus" value="<?php echo isset($_POST['pieces']) ? $_POST['pieces'] : '' ?>">
                    <small class="invalid-feedback"></small>
                </div>
                <div class="form-group">
                    <label for="pubnote">Public Note</label>
                    <input class="form-control" name="pubnote" id="pubnote" size="20" placeholder="" autocomplete="off" type="input" autofocus="autofocus" value="<?php echo isset($_POST['pubnote']) ? $_POST['pubnote'] : '' ?>">
                    <small class="invalid-feedback"></small>
                </div>
                <div class="form-group">
                    <label for="fulnote">Fulfillment Note</label>
                    <input class="form-control" name="fulnote" id="fulnote" size="20" placeholder="" autocomplete="off" type="input" autofocus="autofocus" value="<?php echo isset($_POST['fulnote']) ? $_POST['fulnote'] : '' ?>">
                    <small class="invalid-feedback"></small>
                </div>
                <div class="form-group">
                    <label for="statnote1">Statistics Note 1</label>
                    <select name="statnote1" id="statnote1" class="form-control">
                        <option></option>
                        <option value="MISSING 2024">MISSING 2024</option>
						<option value="MISSING 2023">MISSING 2023</option>
						<option value="MISSING 2022">MISSING 2022</option>
						<option value="MISSING 2021">MISSING 2021</option>
						<option value="MISSING Pre-2020">MISSING Pre-2020</option>
						<option value="LOST 2024">LOST 2024</option>
						<option value="LOST 2023">LOST 2023</option>
						<option value="LOST 2022">LOST 2022</option>
						<option value="WITHDRAWN">WITHDRAWN</option>
						<option value="WITHDRAWN--LOST">WITHDRAWN--LOST</option>
						<option value="WITHDRAWN--MISSING">WITHDRAWN--MISSING</option>
						<option value="To be WITHDRAWN from Annex">To be WITHDRAWN from Annex</option>
						<option value="To be WITHDRAWN">To be WITHDRAWN</option>
                    </select>
                    <small class="invalid-feedback"></small>
                </div>
                <div class="form-group">
                    <label for="statnote2">Statistics Note 2</label>
                    <select name="statnote2" id="statnote2" class="form-control">
                        <option></option>
						<option value="no loan" <?php echo (isset($_POST['statnote2']) && $_POST['statnote2'] === 'FIRE 2018 OZONE') ? 'selected' : ''; ?>>FIRE 2018 OZONE</option>
						<option value="no loan" <?php echo (isset($_POST['statnote2']) && $_POST['statnote2'] === 'FIRE 2018 OZONE GAMMA') ? 'selected' : ''; ?>>FIRE 2018 OZONE GAMMA</option>
						<option value="no loan" <?php echo (isset($_POST['statnote2']) && $_POST['statnote2'] === 'FIRE 2018 OZONE GAMMA REBIND') ? 'selected' : ''; ?>>FIRE 2018 OZONE GAMMA REBIND</option>
						<option value="no loan" <?php echo (isset($_POST['statnote2']) && $_POST['statnote2'] === 'FIRE 2018 SPECIAL COLLECTIONS') ? 'selected' : ''; ?>>FIRE 2018 SPECIAL COLLECTIONS</option>
						<option value="no loan" <?php echo (isset($_POST['statnote2']) && $_POST['statnote2'] === 'LACKS ozone') ? 'selected' : ''; ?>>LACKS ozone</option>
						<option value="no loan" <?php echo (isset($_POST['statnote2']) && $_POST['statnote2'] === 'FIRE 2018 LACKS ozone') ? 'selected' : ''; ?>>FIRE 2018 LACKS ozone</option>
                    </select>
                    <small class="invalid-feedback"></small>
                </div>
                <div class="form-group">
                    <label for="statnote3">Statistics Note 3</label>
                    <select name="statnote3" id="statnote3" class="form-control">
                        <option></option>
                        <option value="ANNEX ingest">ANNEX ingest</option>
						<option value="HALE return">HALE return</option>
						<option value="To be WITHDRAWN">To be WITHDRAWN</option>
						<option value="AHD HALE return">AHD HALE return</option>
						<option value="AHD ANNEX ingest">AHD ANNEX ingest</option>
						<option value="AHD To be WITHDRAWN">AHD To be WITHDRAWN</option>
						<option value="PHYSICAL CONDITION REVIEW For Possible Withdraw">PHYSICAL CONDITION REVIEW</option>
                    </select>
                    <small class="invalid-feedback"></small>
                </div>
                <div class="form-group">
                    <label for="barcode">Barcode</label>
                    <input class="form-control" name="barcode" id="barcode" size="20" placeholder="Scan barcode..." autocomplete="off" type="input" value="" autofocus="autofocus">
                    <small class="invalid-feedback"></small>
                </div>
                <input class="btn btn-primary active" type="submit" value="Submit">
            </form>
            <div class="messages mt-3">
                <div class="alert alert-success">Successfully added an Item Record to <?php echo isset($_POST['holding_id']) ? $_POST['holding_id'] : '' ?> with Barcode: <?php echo isset($_POST['barcode']) ? $_POST['barcode'] : '' ?></div>
            </div>
</div>