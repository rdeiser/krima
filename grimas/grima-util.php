<?php

###############################################################################
#  UTILITIES
###############################################################################

function XMLtoWeb( $DOM ) {
	header('Content-Type: text/plain');
	$DOM->preserveWhiteSpace = false;
	$DOM->formatOutput = true;
	print $DOM->saveXML();
}

function importXML( $DOM, $xmlString ) {
	$frag = $DOM->createDocumentFragment();
	$frag->appendXML($xmlString);
	return $frag;
}

function appendInnerXML( $elt, $xmlString ) {
	$DOM = $elt->ownerDocument;
	$frag = importXML( $DOM, $xmlString );
	$elt->appendChild( $frag );
}

function setInnerXML( $elt, $xmlString ) {
	while( $elt->hasChildNodes() )
		$elt->removeChild( $elt->lastChild );
	appendInnerXML( $elt, $xmlString );
}

function pauseAndAsk() {
	echo "Are you sure you want to do this?  Type 'yes' to continue: ";
	$handle = fopen ("php://stdin","r");
	$line = fgets($handle);
	if(trim($line) != 'yes'){
    	echo "ABORTING!\n";
    	exit;
	}
	fclose($handle);
	echo "\n";
	echo "Thank you, continuing...\n";
}

function do_redirect($url) {
	if(!headers_sent()) header("Location: $url");
	$url_html = htmlspecialchars($url);
echo "<!DOCTYPE html><html><head><title>Redirect</title><meta http-equiv=refresh content='1; url=$url'></head><body><a href='$url_html'>Go here: $url_html</a></body></html>\n";
	exit;
}

###############################################################################
#  INSANITY
###############################################################################

function bib_get($mms_id) {
	require_once("grima-config.php");
	$url = $hostname . '/almaws/v1/bibs/{mms_id}';
	$ch = curl_init();
	$templateParamNames = array('{mms_id}');
	$templateParamValues = array(urlencode($mms_id));
	$url = str_replace($templateParamNames, $templateParamValues, $url);
	$queryParams = '?view=full&expand=None&apikey=' . urlencode($apikey);
	curl_setopt($ch, CURLOPT_URL, $url . $queryParams);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
	$response = curl_exec($ch);
	curl_close($ch);
	return $response;
}

function mfhd_get($mms_id,$holding_id) {
	require_once("grima-config.php");
	$url = $hostname . '/almaws/v1/bibs/{mms_id}/holdings/{holding_id}';
	$ch = curl_init();
	$templateParamNames = array('{mms_id}','{holding_id}');
	$templateParamValues = array(urlencode($mms_id,$holding_id));
	$url = str_replace($templateParamNames, $templateParamValues, $url);
	$queryParams = '?view=full&expand=None&apikey=' . urlencode($apikey);
	curl_setopt($ch, CURLOPT_URL, $url . $queryParams);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
	$response = curl_exec($ch);
	curl_close($ch);
	return $response;
}
//The following scan in coding did not function properly--red 08/12/2020
/*function scan_in($mms_id,$holding_id,$item_pid) {
	//require_once("grima-config.php");
	require_once("grima-lib.php");
	//$url = 'https://api-na.hosted.exlibrisgroup.com/almaws/v1/bibs/{mms_id}/holdings/{holding_id}/items/{item_pid}';
	$url = $server . 'almaws/v1/bibs/{mms_id}/holdings/{holding_id}/items/{item_pid}';
	//$url = 'almaws/v1/bibs/{mms_id}/holdings/{holding_id}/items/{item_pid}';
	$ch = curl_init();
	$templateParamNames = array('{mms_id}','{holding_id}','{item_pid}');
	$templateParamValues = array(urlencode($mms_id),urlencode($holding_id),urlencode($item_pid));
	$url = str_replace($templateParamNames, $templateParamValues, $url);
	$queryParams ='?apikey=' . urlencode('$apikey') . '&' . urlencode('op') . '=' . urlencode('scan') . '&' . urlencode('library') . '=' . urlencode('MAIN') . '&' . urlencode('circ_desk') . '=' . urlencode('DEFAULT_CIRC_DESK')/* . '&' . urlencode('work_order_type') . '=' . urlencode('72hr') . '&' . urlencode('status') . '=' . urlencode('72hr_Quarantine') . '&' . urlencode('done') . '=' . urlencode('false') . '&' . urlencode('auto_print_slip') . '=' . urlencode('false') . '&' . urlencode('place_on_hold_shelf') . '=' . urlencode('false') . '&' . urlencode('confirm') . '=' . urlencode('false') . '&' . urlencode('register_in_house_use') . '=' . urlencode('false') . '&apikey=' . urlencode($apikey);
	curl_setopt($ch, CURLOPT_URL, $url . $queryParams);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	//curl_setopt($ch, CURLOPT_HEADER, TRUE);
	//curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization:apikey***'));
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
	$response = curl_exec($ch);
	curl_close($ch);
	return $response;

}*/

/*
function importXML($DOM, $content) {
    $DOMInnerXML = new DOMDocument();
    $DOMInnerXML->loadXML($content);
    $contentNode = $DOM->importNode($DOMInnerXML->documentElement, true);
    return $contentNode;
}

function setInnerXML($DOM, $element, $content) {
    $contentNode = importXML($DOM, $content);
    while($element->hasChildNodes()) {
        $element->removeChild($element->lastChild);
    }
    $element->appendChild($contentNode);
    return $element;
}

function appendInnerXML($DOM, $element, $content) {
    $contentNode = importXML($DOM, $content);
    $element->appendChild($contentNode);
    return $element;
}
*/

function join_paths(...$paths) {
	return preg_replace('~[/\\\\]+~', DIRECTORY_SEPARATOR, implode(DIRECTORY_SEPARATOR, $paths));
}
