<?php
/**
 *		grima-lib.php - a library for running API calls in Alma
 *
 *		(c) 2019 Kathryn Lybarger. CC-BY-SA
 */

require_once("grima-util.php");
require_once("grima-util.php");
require_once("grima-xmlbag.php");
require_once("grima-splats.php");
require_once("grima-splats.php");

// {{{ class Grima
/** @class Grima */
class Grima {
	public $server;
	public $apikey;

// {{{ session management

	function session_init( $force = false ) {
		if( !isset($_SESSION) ) {
			$session_name = 'grima';
			$session_dir = join_paths( sys_get_temp_dir(), 'grima' );
			@mkdir($session_dir, 0777, true);
			session_save_path($session_dir);
			session_name( $session_name );
			session_set_cookie_params(365*24*60*60); # one year
			ini_set('session.gc_maxlifetime',525600*60); # of love
			if( $force || isset($_COOKIE[$session_name]) ) {
				session_start();
			}
		}
	}

	function session_save($result) {
		$this->session_init(true);
		foreach( $result as $key => $value ) {
			$_SESSION[$key] = $value;
		}
		session_write_close();
	}

	function session_destroy() {
		$this->session_init(true);
		session_start();
		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000,
				$params["path"], $params["domain"],
				$params["secure"], $params["httponly"]
			);
		}
		session_destroy();
		$_SESSION=array();
	}

// }}}

// {{{ config
	function __construct() {
		$this->get_config();
	}

	function get_config() {
		# Precedence:
		# $_REQUEST, $_SESSION, $_SERVER, $_ENV, grima-config.php

		if (isset($_REQUEST['apikey']) and isset($_REQUEST['server']) and
			($_REQUEST['apikey']) and ($_REQUEST['server'])
		) {
			$this->session_save( array(
				'apikey' => $_REQUEST['apikey'],
				'server' => $_REQUEST['server']
			) );
			$this->apikey = $_REQUEST['apikey'];
			$this->server = $_REQUEST['server'];
			return true;
		}

		$this->session_init();
		if ( isset($_SESSION) ) {
			session_write_close();
			if(
				isset($_SESSION['apikey']) and
				isset($_SESSION['server']) and
				($_SESSION['apikey']) and
				($_SESSION['server'])
			) {
				$this->apikey = $_SESSION['apikey'];
				$this->server = $_SESSION['server'];
				return true;
			}
		}

		if ( isset($_SERVER['apikey']) and isset($_SERVER['server']) and
				($_SERVER['apikey']) and ($_SERVER['server'])) {
			$this->apikey = $_SERVER['apikey'];
			$this->server = $_SERVER['server'];
			return true;
		}

		if ( isset($_ENV['apikey']) and isset($_ENV['server']) and
				($_ENV['apikey']) and ($_ENV['server'])) {
			$this->apikey = $_ENV['apikey'];
			$this->server = $_ENV['server'];
			return true;
		}

		if( file_exists("grima-config.php") ) {
			require('grima-config.php'); # this should set those
			return true;
		}

		return false;
	}

// }}}

// {{{ REST - get/post/put/delete

// {{{ get - general function for GET (retrieve) API calls
/**
 * @brief general function for GET (retrieve) API calls
 *
 * @param string $url - URL pattern string with parameters in {}
 * @param array $URLparams - URL parameters
 * @param array $QSparams - query string parameters
 * @return DomDocument of requested record
 */
	function get($url,$URLparams,$QSparams) {
		# returns a DOM document
		foreach ($URLparams as $k => $v) {
			$url = str_replace('{'.$k.'}',urlencode($v),$url);
		}
		$url = $this->server . $url . '?apikey=' . urlencode($this->apikey);
		foreach ($QSparams as $k => $v) {
			$url .= "&$k=$v";
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		$response = curl_exec($ch);
		$code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
		if (curl_errno($ch)) {
			throw new Exception("Network error: " . curl_error($ch));
		}
		curl_close($ch);
		$xml = new DOMDocument();
		try {
			if (!preg_match('/^</',$response)) {
				throw new Exception($url);
			}
			$xml->loadXML($response);
		} catch (Exception $e) {
			throw new Exception("Malformed XML from Alma: $e");
		}
		return $xml;
	}
// }}}

// {{{ post - general function for POST (create) API calls
/**
 * @brief general function for POST (create) API calls
 *
 * @param string $url - URL pattern string with parameters in {}
 * @param array $URLparams - URL parameters
 * @param array $QSparams - query string parameters
 * @param DomDocument $body - object to add to Alma
 * @return DomDocument $body - object as it now appears in Alma
 */
	function post($url,$URLparams,$QSparams,$body) {
		foreach ($URLparams as $k => $v) {
			$url = str_replace('{'.$k.'}',urlencode($v),$url);
		}
		$url = $this->server . $url . '?apikey=' . urlencode($this->apikey);
		foreach ($QSparams as $k => $v) {
			$url .= "&$k=$v";
		}

		$bodyxml = $body->saveXML();

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $bodyxml);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
		$response = curl_exec($ch);
		$code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
		if (curl_errno($ch)) {
			throw new Exception("Network error: " . curl_error($ch));
		}
		curl_close($ch);
		$xml = new DOMDocument();
		try {
			$xml->loadXML($response);
		} catch (Exception $e) {
			throw new Exception("Malformed XML from Alma: $e");
		}
		return $xml;
	}
// }}}

// {{{ postscanin - general function for POST (Scan In) API calls
/**
 * @brief general function for POST (Scan In) API calls
 *
 * @param string $url - URL pattern string with parameters in {}
 * @param array $URLparams - URL parameters
 * @param array $QSparams - query string parameters
 */
		function postscanin($url,$URLparams,$QSparams) {
		foreach ($URLparams as $k => $v) {
			$url = str_replace('{'.$k.'}',urlencode($v),$url);
		}
		$url = $this->server . $url . '?apikey=' . urlencode($this->apikey);
		foreach ($QSparams as $k => $v) {
			$url .= "&$k=$v";
		}

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
		$response = curl_exec($ch);
		$code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
		if (curl_errno($ch)) {
			throw new Exception("Network error: " . curl_error($ch));
		}
		/*curl_close($ch);
		return $response;*/
		
		curl_close($ch);
		$xml = new DOMDocument();
		try {
			$xml->loadXML($response);
		} catch (Exception $e) {
			throw new Exception("Malformed XML from Alma: $e");
		}
		return $xml;
	}
// }}}

// {{{ postjobs - general function for POST Job (create) API calls
/**
 * @brief general function for POST Job (create) API calls
 *
 * @param string $url - URL pattern string with parameters in {}
 * @param array $URLparams - URL parameters
 * @param array $QSparams - query string parameters
 * @param DomDocument $body - object to add to Alma
 * @return DomDocument $body - object as it now appears in Alma
 */
	function postjobs($url,$URLparams,$QSparams,$body) {
		foreach ($URLparams as $k => $v) {
			$url = str_replace('{'.$k.'}',urlencode($v),$url);
		}
		$url = $this->server . $url . '?apikey=' . urlencode($this->apikey);
		foreach ($QSparams as $k => $v) {
			$url .= "&$k=$v";
		}

		$bodyxml = $body->saveXML();

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_HTTPHEADER,
			array ("Accept: application/xml"));
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $bodyxml);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
		$response = curl_exec($ch);
		$code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
		if (curl_errno($ch)) {
			throw new Exception("Network error: " . curl_error($ch));
		}
		curl_close($ch);
		$xml = new DOMDocument();
		try {
			$xml->loadXML($response);
		} catch (Exception $e) {
			throw new Exception("Malformed XML from Alma: $e");
		}
		return $xml;
	}
// }}}

// {{{ put - general function for PUT (update) API calls
/**
 * @brief general function for PUT (update) API calls
 *
 * @param string $url - URL pattern string with parameters in {}
 * @param array $URLparams - URL parameters
 * @param array $QSparams - query string parameters
 * @param DomDocument $body - record to update Alma record with
 * @return DomDocument - record as it now appears in Alma
 */
	function put($url,$URLparams,$QSparams,$body) {
		foreach ($URLparams as $k => $v) {
			$url = str_replace('{'.$k.'}',urlencode($v),$url);
		}
		$url = $this->server . $url . '?apikey=' . urlencode($this->apikey);
		foreach ($QSparams as $k => $v) {
			$url .= "&$k=$v";
		}

		$bodyxml = $body->saveXML();

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $bodyxml);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
		$response = curl_exec($ch);
		$code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
		if (curl_errno($ch)) {
			throw new Exception("Network error: " . curl_error($ch));
		}
		curl_close($ch);
		$xml = new DOMDocument();
		try {
			$xml->loadXML($response);
		} catch (Exception $e) {
			throw new Exception("Malformed XML from Alma: $e");
		}
		return $xml;
	}
// }}}

// {{{ delete - general function for DELETE API calls
/**
 * @brief general function for DELETE API calls
 *
 * @param string $url - URL pattern string with parameters in {}
 * @param array $URLparams - URL parameters
 * @param array $QSparams - query string parameters
 */
	function delete($url,$URLparams,$QSparams) {
		foreach ($URLparams as $k => $v) {
			$url = str_replace('{'.$k.'}',urlencode($v),$url);
		}
		$url = $this->server . $url . '?apikey=' . urlencode($this->apikey);
		foreach ($QSparams as $k => $v) {
			$url .= "&$k=$v";
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_HTTPHEADER,
			array ("Accept: application/xml"));
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
		$response = curl_exec($ch);
		$code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
		if (curl_errno($ch)) {
			throw new Exception("Network error: " . curl_error($ch));
		}
		curl_close($ch);
		if ($code != 204) {
			$xml = new DOMDocument();
			try {
				$xml->loadXML($response);
			} catch (Exception $e) {
				throw new Exception("Malformed XML from Alma: $e");
			}
			return $xml;
		}
	}
// }}}

// {{{ post - general function for POST (create) API calls
/**
 * @brief general function for POST (create) Scan In API calls
 *
 * @param string $url - URL pattern string with parameters in {}
 * @param array $URLparams - URL parameters
 * @param array $QSparams - query string parameters
 */

	/*function postIn($url,$URLparams,$QSparams) {
		$URLparams = array('{mms_id}','{holding_id}','{item_pid}');
		$QSparams = array(urlencode($mms_id,$holding_id,$item_pid));
		}
		$url = $this->server . $url . '?apikey=' . urlencode($this->apikey);
		foreach ($QSparams as $k => $v) {
			$url .= "&$k=$v";
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
		$response = curl-exec($ch);
		$code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $bodyxml);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
		$response = curl_exec($ch);
		curl_close($ch);
	}*/
// }}}

// {{{ checkForErrorMessage - checks for errorMessage tag, throws exceptions
/**
 * @brief checks for errorMessage tag, throws exceptions
 * @param DomDocument $xml
 */
	function checkForErrorMessage($xml) {
		if ($xml instanceOf DomDocument) {
			$xpath = new DomXpath($xml);
			$xpath->registerNamespace("err","http://com/exlibris/urm/general/xmlbeans");
			$error = $xpath->query('//err:errorMessage');
			if ($error->length > 0) {
				throw new Exception("Alma says: " . $error[0]->nodeValue);
			}
		}
	}
// }}}

// }}}

//{{{Bib APIs
/**@name Bib APIs */
/**@{*/

// {{{ getBib (Retrieve Bib)
/**
 * @brief Retrieve Bib - retrieve a bib record from Alma
 *
 * Makes a call to the API:
 * [(API docs)](https://developers.exlibrisgroup.com/alma/apis/bibs#Resources)
 *
 *		GET /almaws/v1/bibs/{mms_id}
 *
 * @param string $mms_id The Bib Record ID.
 * @param string $view Optional. Default=full
 * @param string $expand Optional. Default=None
 * @return DomDocument Bib object https://developers.exlibrisgroup.com/alma/apis/xsd/rest_bib.xsd?tags=GET
 */
	function getBib($mms_id, $view = 'full', $expand = 'None') {
		$ret = $this->get('/almaws/v1/bibs/{mms_id}',
			array('mms_id' => $mms_id),
			array('view' => $view, 'expand' => $expand)
			);
		$this->checkForErrorMessage($ret);
		return $ret;
	}
// }}}

// {{{ postBib (Create Record)
/**
 * @brief Create Record - adds a new bib record to Alma
 *
 * Makes a call to the API:
 * [(API docs)](https://developers.exlibrisgroup.com/alma/apis/bibs#Resources)
 *
 *		POST /almaws/v1/bibs
 *		https://developers.exlibrisgroup.com/alma/apis/bibs#Resources
 * @param DomDocument $bib Bib object to add to Alma as new record
 * @return DomDocument Bib object as it now appears in Alma https://developers.exlibrisgroup.com/alma/apis/xsd/rest_bib.xsd?tags=GET
 */
	function postBib($bib) {
		$ret = $this->post('/almaws/v1/bibs',
			array(),
			array(),
			$bib
			);
		$this->checkForErrorMessage($ret);
		return $ret;
	}
// }}}

// {{{ putBib (Update Bib Record)
/**
 * @brief Update Bib Record - updates the copy of the bib in Alma
 *
 * Makes a call to the API:
 * [(API docs)](https://developers.exlibrisgroup.com/alma/apis/bibs#Resources)
 *
 * PUT /almaws/v1/bibs/{mms_id}
 *
 * @param string $mms_id Alma Bib record to update
 * @param DomDocument $bib Bib to replace old record
 * @return DomDocument Bib object as it now appears in Alma https://developers.exlibrisgroup.com/alma/apis/xsd/rest_bib.xsd?tags=GET
 */
	function putBib($mms_id,$bib) {
		$ret = $this->put('/almaws/v1/bibs/{mms_id}',
			array('mms_id' => $mms_id),
			array(),
			$bib
			);
		$this->checkForErrorMessage($ret);
		return $ret;
	}
// }}}

// {{{ deleteBib (Delete Bib Record)
/**
 * @brief Delete Bib Record - deletes the bib record from Alma
 *
 * Makes a call to the API:
 * [(API docs)](https://developers.exlibrisgroup.com/alma/apis/bibs#Resources)
 *
 *		DELETE /almaws/v1/bibs/{mms_id}
 *
 * @param string $mms_id MMS ID of Alma Bib record to delete
 * @param string $override Optional. Default=false
 */
	function deleteBib($mms_id,$override='false') {
		$ret = $this->delete('/almaws/v1/bibs/{mms_id}',
			array('mms_id' => $mms_id),
			array('override' => $override)
		);
		$this->checkForErrorMessage($ret);
	}
// }}}

/**@}*/
//}}}

//{{{Holdings List APIs
/**@name Holdings List APIs */
/**@{*/

// {{{ grima -> getHoldingsList (Retrieve Holdings list)
/**
 * @brief Retrieve Holdings list - download brief descriptions of holdings
 * for the bib
 *
 * Makes a call to the API:
 * [(API docs)](https://developers.exlibrisgroup.com/alma/apis/bibs#Resources)
 *
 *		GET /almaws/v1/bibs/{mms_id}/holdings
 *
 * @param string $mms_id MMS ID of Alma Bib to gather holdings from
 * @return DomDocument Holdings List object
 */
	function getHoldingsList($mms_id) {
		$ret = $this->get('/almaws/v1/bibs/{mms_id}/holdings',
			array('mms_id' => $mms_id),
			array()
			);
		$this->checkForErrorMessage($ret);
		return $ret;
	}
// }}}

/**@}*/
//}}}

//{{{Holding APIs
/**@name Holding APIs */
/**@{*/

// {{{ getHolding (Retrieve Holdings Record)
/**
 * @brief Retrieve Holdings Record - retrieve holdings record from Alma
 *
 * Makes a call to the API:
 * [(API docs)](https://developers.exlibrisgroup.com/alma/apis/bibs#Resources)
 *
 *		GET /almaws/v1/bibs/{mms_id}/holdings/{holding_id}
 *
 * @param string $mms_id MMS ID of Alma Bib
 * @param string $holding_id Holdings ID of Alma Holding
 * @return DomDocument Holding object
 */
	function getHolding($mms_id,$holding_id) {
		$ret = $this->get('/almaws/v1/bibs/{mms_id}/holdings/{holding_id}',
			array(
			'mms_id' => $mms_id,
			'holding_id' => $holding_id
			),
			array()
			);
		$this->checkForErrorMessage($ret);
		return $ret;
	}
// }}}

// {{{ grima -> postHolding (Create holding record)
/**
 * @brief Create holding record - add a new holdings record to a bib
 *
 * Makes a call to the API:
 * [(API docs)](https://developers.exlibrisgroup.com/alma/apis/bibs#Resources)
 *
 *		POST /almaws/v1/bibs/{mms_id}/holdings
 *
 * @param string $mms_id MMS ID of bib record
 * @param DomDocument $holding Holding object to add to Alma as new record
 * @return DomDocument Holding object as it now appears in Alma https://developers.exlibrisgroup.com/alma/apis/xsd/rest_bib.xsd?tags=GET
 */
	function postHolding($mms_id,$holding) {
		$ret = $this->post('/almaws/v1/bibs/{mms_id}/holdings',
			array('mms_id' => $mms_id),
			array(),
			$holding
			);
		$this->checkForErrorMessage($ret);
		return $ret;
	}
// }}}

// {{{ putHolding (Update Holdings Record)
/**
 * @brief Update Holdings Record - replace the holdings record in Alma
 *
 * Makes a call to the API:
 * [(API docs)](https://developers.exlibrisgroup.com/alma/apis/bibs#Resources)
 *
 *		PUT /almaws/v1/bibs/{mms_id}/holdings/{holding_id}
 *
 * @param string $mms_id MMS ID of Bib
 * @param string $holding_id Holding ID of holding to replace
 * @param DomDocument $holding Holding object to add to Alma as new record
 * @return DomDocument Bib object as it now appears in Alma https://developers.exlibrisgroup.com/alma/apis/xsd/rest_bib.xsd?tags=GET
 */
	function putHolding($mms_id,$holding_id,$holding) {
		$ret = $this->put('/almaws/v1/bibs/{mms_id}/holdings/{holding_id}',
			array('mms_id' => $mms_id, 'holding_id' => $holding_id),
			array(),
			$holding
			);
	}
// }}}

// {{{ grima -> deleteHolding (Delete Holdings Record)
/**
 * @brief Delete Holdings Record - delete the holdings record from Alma
 *
 * Makes a call to the API:
 * [(API docs)](https://developers.exlibrisgroup.com/alma/apis/bibs#Resources)
 *
 *		DELETE /almaws/v1/bibs/{mms_id}/holdings/{holding_id}
 *
 * @param string $mms_id MMS ID of Alma Bib record
 * @param string $holding_id Holding ID of Holding record to delete from Alma
 * @param string $override Optional. Default=false
 */
	function deleteHolding($mms_id,$holding_id,$override='false') {
		$ret = $this->delete('/almaws/v1/bibs/{mms_id}/holdings/{holding_id}',
			array(
				'mms_id' => $mms_id,
				'holding_id' => $holding_id
			),
			array('override' => $override)
		);
		$this->checkForErrorMessage($ret);
	}
// }}}

/**@}*/
//}}}

//{{{Item List APIs
/**@name Item List APIs */
/**@{*/

// {{{ getItemList (Retrieve Items list)
/**
 * @brief Retrieve Items list - retrieve the items list from a holding or bib from Alma
 *
 * Makes a call to the API:
 * [(API docs)](https://developers.exlibrisgroup.com/alma/apis/bibs#Resources)
 *
 *		GET /almaws/v1/bibs/{mms_id}/holdings/{holding_id}/items
 *
 * @param string $mms_id MMS ID of Alma bib
 * @param string $holding_id MMS ID of Alma holding
 * @param string $limit Max number of items to retrieve
 * @param string $offset Offset of the results returned
 * @return DomDocument Item List object
 */
	function getItemList($mms_id,$holding_id,$limit,$offset) {
		$ret = $this->get('/almaws/v1/bibs/{mms_id}/holdings/{holding_id}/items', array('mms_id' => $mms_id, 'holding_id' => $holding_id),
			array('limit' => $limit, 'offset' => $offset)
		);
		$this->checkForErrorMessage($ret);
		return $ret;
	}
// }}}

/**@}*/
//}}}

//{{{Item APIs
/**@name Item APIs */
/**@{*/

// {{{ getItem (Retrieve Item and print label information)
/**
 * @brief Retrieve Item and print label information
 *
 * Makes a call to the API:
 * [(API docs)](https://developers.exlibrisgroup.com/alma/apis/bibs#Resources)
 *
 *		GET /almaws/v1/bibs/{mms_id}/holdings/{holding_id}/items/{item_pid}
 *
 * @param string $mms_id MMS ID of Alma Bib
 * @param string $holding_id Holding ID of Alma Holding
 * @param string $item_pid Item ID of Alma Holding
 */
	function getItem($mms_id,$holding_id,$item_pid) {
		$ret = $this->get('/almaws/v1/bibs/{mms_id}/holdings/{holding_id}/items/{item_pid}', array(
			'mms_id' => $mms_id,
			'holding_id' => $holding_id,
			'item_pid' => $item_pid
			),
			array()
			);
		$this->checkForErrorMessage($ret);
		return $ret;
	}
// }}}

// {{{ getItemBC (Retrieve Item and print label information (by barcode))
/**
 * @brief Retrieve Item and print label information (by barcode))
 *
 * Makes a call to the API:
 * [(API docs)](https://developers.exlibrisgroup.com/alma/apis/bibs#Resources)
 *
 *		GET /almaws/v1/items?item_barcode={item_barcode}
 *
 * @param string $barcode Barcode of Alma item
 */
	function getItemBC($barcode) {
		$ret = $this->get('/almaws/v1/items',
			array(),
			array(
				'item_barcode' => $barcode,
			)
		);
		$this->checkForErrorMessage($ret);
		return $ret;
	}
// }}}

// {{{ postItem (Create Item)
/**
 * @brief Create Item - add a new item to a holding in Alma
 *
 * Makes a call to the API:
 * [(API docs)](https://developers.exlibrisgroup.com/alma/apis/bibs#Resources)
 *
 *		POST /almaws/v1/bibs/{mms_id}/holdings/{holding_id}/items
 *
 * @param string $mms_id		- MMS ID of Bib record
 * @param string $holding_id	- Holding ID of Holding record
 * @param DomDocument $item		- Item object to add to Alma as new record
 * @return DomDocument Bib object as it now appears in Alma https://developers.exlibrisgroup.com/alma/apis/xsd/rest_bib.xsd?tags=GET
 */
	function postItem($mms_id,$holding_id,$item) {
		$ret = $this->post('/almaws/v1/bibs/{mms_id}/holdings/{holding_id}/items',
			array('mms_id' => $mms_id, 'holding_id' => $holding_id),
			array(),
			$item
			);
		$this->checkForErrorMessage($ret);
		return $ret;
	}
// }}}

// {{{ postScan (Send Scan-in)
/**
 * @brief Send the Item Record for Scan-In
 *
 * Makes a call to the API:
 * [(API docs)](https://developers.exlibrisgroup.com/alma/apis/bibs#Resources)
 *
 *		POST /almaws/v1/bibs/{mms_id}/holdings/{holding_id}/items
 *
 * @param string $mms_id		- MMS ID of Bib record
 * @param string $holding_id	- Holding ID of Holding record
 * @param string $item_pid	- Item PID of Item record
 * @return DomDocument Bib object as it now appears in Alma https://developers.exlibrisgroup.com/alma/apis/xsd/rest_bib.xsd?tags=GET
 */
		function postScan($mms_id,$holding_id,$item_pid,$op,$library,$circ_desk,$work_order_type,$status,$done,$place_on_hold_shelf,$register_in_house_use) {
		$ret = $this->postscanin('/almaws/v1/bibs/{mms_id}/holdings/{holding_id}/items/{item_pid}',
			array('mms_id' => $mms_id, 'holding_id' => $holding_id, 'item_pid' => $item_pid),
			array('op' => $op, 'library' => $library, 'circ_desk' => $circ_desk, 'work_order_type' => $work_order_type, 'status' => $status, 'done' => $done, 'place_on_hold_shelf' => $place_on_hold_shelf, 'register_in_house_use' => $register_in_house_use)
			);
		$this->checkForErrorMessage($ret);
		return $ret;
	}
// }}}

// {{{ postScanacq (Send Scan-in for acquisitions workorder)
/**
 * @brief Send the Item Record for Scan-In for acquisitions workorder
 *
 * Makes a call to the API:
 * [(API docs)](https://developers.exlibrisgroup.com/alma/apis/bibs#Resources)
 *
 *		POST /almaws/v1/bibs/{mms_id}/holdings/{holding_id}/items
 *
 * @param string $mms_id		- MMS ID of Bib record
 * @param string $holding_id	- Holding ID of Holding record
 * @param string $item_pid	- Item PID of Item record
 * @return DomDocument Bib object as it now appears in Alma https://developers.exlibrisgroup.com/alma/apis/xsd/rest_bib.xsd?tags=GET
 */
function postScanacq($mms_id,$holding_id,$item_pid,$op,$library,$department,$work_order_type,$status,$done) {
	$ret = $this->postscanin('/almaws/v1/bibs/{mms_id}/holdings/{holding_id}/items/{item_pid}',
		array('mms_id' => $mms_id, 'holding_id' => $holding_id, 'item_pid' => $item_pid),
		array('op' => $op, 'library' => $library, 'department' => $department, 'work_order_type' => $work_order_type, 'status' => $status, 'done' => $done)
		);
	$this->checkForErrorMessage($ret);
	return $ret;
}
// }}}


// {{{ putItem (Update Item information)
/**
 * @brief Update Item information - replace item record in Alma
 *
 * Makes a call to the API:
 * [(API docs)](https://developers.exlibrisgroup.com/alma/apis/bibs#Resources)
 *
 *		PUT /almaws/v1/bibs/{mms_id}/holdings/{holding_id}/items/{item_pid}
 *
 * @param string $mms_id MMS ID of Bib record
 * @param string $holding_id Holding ID of Holding record
 * @param string $item_pid Item ID of Item record
 * @param string generate_description = true
 * @param DomDocument $item Item object to update record with in Alma
 * @return DomDocument Bib object as it now appears in Alma https://developers.exlibrisgroup.com/alma/apis/xsd/rest_bib.xsd?tags=GET
 */
	function putItem($mms_id,$holding_id,$item_pid,$item,$generate_description='true') {
		$ret = $this->put('/almaws/v1/bibs/{mms_id}/holdings/{holding_id}/items/{item_pid}',
			array('mms_id' => $mms_id, 'holding_id' => $holding_id, 'item_pid' => $item_pid),
			array('generate_description' => $generate_description),
			$item
			);
		return $ret;
	}
// }}}

// {{{ deleteItem (Withdraw Item)
/**
 * @brief Withdraw Item - delete an item record from Alma
 *
 * Makes a call to the API:
 * [(API docs)](https://developers.exlibrisgroup.com/alma/apis/bibs#Resources)
 *
 *		DELETE /almaws/v1/bibs/{mms_id}/holdings/{holding_id}/items/{item_pid}
 *
 * @param string $mms_id MMS ID of Bib record
 * @param string $holding_id Holding ID of holding record
 * @param string $item_pid Item ID of item record
 * @param string $override Override warnings? (false, true)
 * @param string $holdings How to handle holdings with inventory? (retain, delete or suppress)
*/
	function deleteItem($mms_id,$holding_id,$item_pid,$override = "false",
		$holdings = "retain") {
		$ret = $this->delete('/almaws/v1/bibs/{mms_id}/holdings/{holding_id}/items/{item_pid}', array(
				'mms_id' => $mms_id,
				'holding_id' => $holding_id,
				'item_pid' => $item_pid
			), array(
				'override' => $override,
				'holdings' => $holdings
			)
		);
		$this->checkForErrorMessage($ret);
	}
// }}}

/**@}*/
//}}}

//{{{Electronic APIs
/**@name Electronic APIs */
/**@{*/

// {{{ getElectronicPortfolio (Retrieve Portfolio)
/**
 * @brief Retrieve Portfolio - retrieve a portfolio record from Alma
 *
 * Makes a call to the API:
 * [(API docs)](https://developers.exlibrisgroup.com/alma/apis/electronic#Resources)
 *
 *		GET /almaws/v1/electronic/e-collections/{collection_id}/e-services/{service_id}/portfolios/{portfolio_id}
 *
 * @param string $collection_id ID of collection
 * @param string $service_id ID of service
 * @param string $portfolio_id ID of portfolio
 * @return DomDocument Electronic Portfolio object
*/
	function getElectronicPortfolio($collection_id,$service_id,$portfolio_id) {
		$ret = $this->get('/almaws/v1/electronic/e-collections/{collection_id}/e-services/{service_id}/portfolios/{portfolio_id}',
			array('collection_id' => $collection_id, 'service_id' => $service_id, 'portfolio_id' => $portfolio_id),
			array()
		);
		$this->checkForErrorMessage($ret);
		return $ret;
	}
// }}}

// {{{ getElectronicPortfolioFromBib (Retrieve Portfolio)
/**
 * @brief Retrieve Portfolio - retrieve a portfolio record from Alma
 *
 * Makes a call to the API:
 * [(API docs)](https://developers.exlibrisgroup.com/alma/apis/bibs/#Catalog)
 *
 *      GET /almaws/v1/bibs/{mms_id}/portfolios/{portfolio_id}
 *
 * @param string $mms_id ID of bib record
 * @param string $portfolio_id ID of portfolio
 * @return DomDocument Electronic Portfolio object
*/
	function getElectronicPortfolioFromBib($mms_id, $portfolio_id) {
		$ret = $this->get('/almaws/v1/bibs/{mms_id}/portfolios/{portfolio_id}',
			array('mms_id' => $mms_id, 'portfolio_id' => $portfolio_id),
			array()
		);
		$this->checkForErrorMessage($ret);
		return $ret;
	}
// }}}

// {{{ postElectronicPortfolio (Create Electronic Portfolio) #XXX
/**
 * @brief Create Electronic Portfolio - add a new portfolio to Alma
 *
 * Makes a call to the API:
 * [(API docs)](https://developers.exlibrisgroup.com/alma/apis/electronic#Resources)
 *
 *		POST /almaws/v1/electronic/e-collections/{collection_id}/e-services/{service_id}/portfolios/
 *
 * @param string $collection_id ID of collection
 * @param string $service_id ID of service
 * @param string $portfolio A portfolio object to add to Alma
 * @return DomDocument Electronic Portfolio object as it appears in Alma
*/
	function postElectronicPortfolio($collection_id,$service_id,$portfolio) {
		$ret = $this->post('/almaws/v1/electronic/e-collections/{collection_id}/e-services/{service_id}/portfolios',
			array('collection_id' => $collection_id, 'service_id' => $service_id),
			array(),
			$portfolio
			);
		$this->checkForErrorMessage($ret);
		return $ret;
	}
// }}}

// {{{ postElectronicPortfolioOnBib (Create Electronic Portfolio on Bib)
/**
 * @brief Create Electronic Portfolio - add a new portfolio to Alma Bib
 *
 * Makes a call to the API:
 * [(API docs)](https://developers.exlibrisgroup.com/alma/apis/bibs#Resources)
 *
 *		POST /almaws/v1/bibs/{mms_id}/portfolios/
 *
 * @param string $portfolio_id ID of portfolio
 * @return DomDocument Electronic Portfolio object as it appears in Alma
*/
	function postElectronicPortfolioOnBib($mms_id,$portfolio) {
		$ret = $this->post('/almaws/v1/bibs/{mms_id}/portfolios/',
			array('mms_id' => $mms_id),
			array(),
			$portfolio
			);
		$this->checkForErrorMessage($ret);
		return $ret;
	}
// }}}

// {{{ putElectronicPortfolioOnBib (Update Portfolio for a Bib)
/**
 * @brief Update Electronic Portfolio - update portfolio in Alma
 *
 * Makes a call to the API:
 * [(API docs)](https://developers.exlibrisgroup.com/alma/apis/bibs#Resources)
 *
 *		PUT /almaws/v1/bibs/{mms_id}/portfolios/{portfolio_id}	 
 *
 * @param string $mms_id ID of bibliographic record
 * @param string $portfolio_id ID of portfolio
 * @return DomDocument Electronic Portfolio object as it appears in Alma
*/
	function putElectronicPortfolioOnBib($mms_id,$portfolio_id,$portfolio) {
		$ret = $this->put('/almaws/v1/bibs/{mms_id}/portfolios/{portfolio_id}',
			array('mms_id' => $mms_id, 'portfolio_id' => $portfolio_id),
			array(),
			$portfolio
			);
		$this->checkForErrorMessage($ret);
		return $ret;
	}
// }}}

// {{{ deleteElectronicPortfolio (Delete Electronic Portfolio)
/**
 * @brief Delete Electronic Portfolio - delete portfolio from Alma
 *
* Makes a call to the API:
 * [(API docs)](https://developers.exlibrisgroup.com/alma/apis/electronic#Resources)
 *
 *		DELETE /almaws/v1/electronic/e-collections/{collection_id}/e-services/{service_id}/portfolios/{portfolio_id}
 *
 * @param string $collection_id ID of collection
 * @param string $service_id ID of service
 * @param string $portfolio_id ID of portfolio
 */
	function deleteElectronicPortfolio($collection_id,$service_id,$portfolio_id) {
		$ret = $this->delete('/almaws/v1/electronic/e-collections/{collection_id}/e-services/{service_id}/portfolios/{portfolio_id}',
		array('collection_id' => $collection_id, 'service_id' => $service_id, 'portfolio_id' => $portfolio_id),
		array()
		);
		$this->checkForErrorMessage($ret);
	}
// }}}

// {{{ getElectronicPortfoliosForService (Retrieve Portfolios)
/**
 * @brief Retrieve Portfolios - retrieve a list of portfolios from Alma
 *
 * Makes a call to the API:
 * [(API docs)](https://developers.exlibrisgroup.com/alma/apis/electronic#Resources)
 *
 *		GET /almaws/v1/electronic/e-collections/{collection_id}/e-services/{service_id}/portfolios
 *
 * @param string $collection_id ID of collection
 * @param string $service_id ID of service
 * @param string $limit Max number of portfolios to retrieve
 * @param string $offset Offset of the results
 * @return DomDocument Retrieve Portfolios object
*/
	function getElectronicPortfoliosForService($collection_id, $service_id, $limit, $offset) {
		$ret = $this->get('/almaws/v1/electronic/e-collections/{collection_id}/e-services/{service_id}/portfolios',
			array('collection_id' => $collection_id, 'service_id' => $service_id),
			array('limit' => $limit, $offset = $offset)
		);
		$this->checkForErrorMessage($ret);
		return $ret;
	}
// }}}

// {{{ grima -> getElectronicPortfoliosForBib (Retrieve Portfolios)
/**
 * @brief Retrieve Portfolios list (Bib) - retrieve a list of portfolios from Alma
 *
 * Makes a call to the API:
 * [(API docs)](https://developers.exlibrisgroup.com/alma/apis/electronic#Resources)
 *
 *		GET /almaws/v1/bibs/{mms_id}/portfolios
 *
 * @param string $mms_id ID of bib
 * @param string $limit Max number of portfolios to retrieve
 * @param string $offset Offset of the results
 * @return DomDocument Portfolios List object
*/
	function getElectronicPortfoliosForBib($mms_id, $limit, $offset) {
		$ret = $this->get('/almaws/v1/bibs/{mms_id}/portfolios',
			array('mms_id' => $mms_id),
			array('limit' => $limit, $offset = $offset)
		);
		$this->checkForErrorMessage($ret);
		return $ret;
	}
// }}}

// {{{ getElectronicCollection (Retrieve Electronic Collection)
/**
 * @brief Retrieve Electronic Collection - retrieve a collection record from Alma
 *
 * Makes a call to the API:
 * [(API docs)](https://developers.exlibrisgroup.com/alma/apis/electronic#Resources)
 *
 *		GET /almaws/v1/electronic/e-collections/{collection_id}
 *
 * @param string $collection_id ID of collection
 * @return DomDocument Electronic Collection object
*/
	function getElectronicCollection($collection_id) {
		$ret = $this->get('/almaws/v1/electronic/e-collections/{collection_id}',
			array('collection_id' => $collection_id),
			array()
		);
		$this->checkForErrorMessage($ret);
		return $ret;
	}
// }}}

// {{{ getElectronicServices (Retrieve Electronic Services)
/**
 * @brief Retrieve Electronic Services - retrieve a list of services from
 * a collection in Alma
 *
 * Makes a call to the API:
 * [(API docs)](https://developers.exlibrisgroup.com/alma/apis/electronic#Resources)
 *
 *		GET /almaws/v1/electronic/e-collections/{collection_id}/e-services
 *
 * @param string $collection_id ID of collection
 * @return DomDocument Services object
*/
	function getElectronicServices($collection_id) {
		$ret = $this->get('/almaws/v1/electronic/e-collections/{collection_id}/e-services',
			array('collection_id' => $collection_id),
			array()
		);
		$this->checkForErrorMessage($ret);
		return $ret;
	}
// }}}

/**@}*/
//}}}

//{{{Library APIs
/**@name Library APIs */
/**@{*/

// {{{ getLibrary (Retrieve a Library)
/**
 * @brief Retrieve a Library - retrieve a Library from Alma
 *
 * Makes a call to the API:
 * [(API docs)](https://developers.exlibrisgroup.com/alma/apis/conf#Resources)
 *
 *		GET /almaws/v1/conf/libraries/{libraryCode}
 *
 * @param string $libraryCode ID of the library to retrieve
 * @return DomDocument Library object
*/
	function getLibrary($libraryCode) {
		$ret = $this->get('/almaws/v1/conf/libraries/{libraryCode}',
			array('libraryCode' => $libraryCode),
			array()
		);
		$this->checkForErrorMessage($ret);
		return $ret;
	}
// }}}

/**@}*/
//}}}

//{{{Location APIs
/**@name Location APIs */
/**@{*/

// {{{ getLocation (Retrieve Location)
/**
 * @brief Retrieve Location - retrieve a Library Location from Alma
 *
 * Makes a call to the API:
 * [(API docs)](https://developers.exlibrisgroup.com/alma/apis/conf#Resources)
 *
 *		GET /almaws/v1/conf/libraries/{libraryCode}/locations/{locationCode}
 *
 * @param string $libraryCode ID of the library to retrieve
 * @return DomDocument Library object
*/
	function getLocation($libraryCode,$locationCode) {
		$ret = $this->get('/almaws/v1/conf/libraries/{libraryCode}/locations/{locationCode}',
			array(
				'libraryCode' => $libraryCode,
				'locationCode' => $locationCode,
			),
			array()
		);
		$this->checkForErrorMessage($ret);
		return $ret;
	}
// }}}

/**@}*/
//}}}

//{{{Job APIs
/**@name Job APIs */
/**@{*/

// {{{ Job -> postJob (Run a Job)
/**
 * @brief Run an Alma Job on an Alma Set
 *
 * Makes a call to the API:
 * [(API docs)](https://developers.exlibrisgroup.com/alma/apis/conf#Resources)
 *
 *		POST /almaws/v1/conf/jobs{job_id}
 *
 * @param string $job_id ID
 * @return Job submission details
*/
/**PRODUCTION**/
/*	function postJob($job_id,$op) {
		$body = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?' .'>
<job link="string">
	<creator></creator>
	<next_run>2024-05-30T09:30:10Z</next_run>
		<parameters>
			<parameter>
				<name>task_189_droolesFileKey</name>
				<value>591 Spec/Annexltd</value>
			</parameter>
			<parameter>
				<name>set_id</name>
				<value>17242302810002401</value>
			</parameter>
			<parameter>
				<name>job_name</name>
				<value>591 Spec/LTD - via API - DO NOT DELETE***GRIMA SCHEDULED JOB***591 annexltd note</value>
			</parameter>
		</parameters>
</job>';

		$bodyxml = new DomDocument();
		$bodyxml->loadXML($body);
		
		$ret = $this->postjobs('/almaws/v1/conf/jobs/{job_id}', array('job_id' => $job_id), array('op' => $op),$bodyxml);
		$this->checkForErrorMessage($ret);
		return $ret;

	}*/

/**SANDBOX**/
	function postJob($job_id,$op) {
		$body = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?' .'>
<job link="string">
	<creator></creator>
	<next_run>2024-05-30T09:30:10Z</next_run>
		<parameters>
			<parameter>
				<name>task_189_droolesFileKey</name>
				<value>Spec/LTD</value>
			</parameter>
			<parameter>
				<name>set_id</name>
				<value>16588548290002401</value>
			</parameter>
			<parameter>
				<name>job_name</name>
				<value>591 Special/LTD - via API - DO NOT DELETE***GRIMA SCHEDULED JOB***591 annexltd note</value>
			</parameter>
		</parameters>
</job>';

		$bodyxml = new DomDocument();
		$bodyxml->loadXML($body);
		
		$ret = $this->postjobs('/almaws/v1/conf/jobs/{job_id}', array('job_id' => $job_id), array('op' => $op),$bodyxml);
		$this->checkForErrorMessage($ret);
		return $ret;

	}

// }}}

/**@}*/
//}}}

//{{{Set APIs
/**@name Set APIs */
/**@{*/

// {{{ Set -> getSet (Retrieve a Set)
/**
 * @brief Retrieve a Set - retrieve a Set from Alma
 *
 * Makes a call to the API:
 * [(API docs)](https://developers.exlibrisgroup.com/alma/apis/conf#Resources)
 *
 *		GET /almaws/v1/conf/sets/{set_id}
 *
 * @param string $set_id ID of the set to retrieve
 * @return DomDocument Set object
*/
	function getSet($set_id) {
		$ret = $this->get('/almaws/v1/conf/sets/{set_id}',
			array('set_id' => $set_id),
			array()
		);
		$this->checkForErrorMessage($ret);
		return $ret;
	}
// }}}

// postSetMembers
// POST /almaws/v1/conf/sets/{set_id}
/*	function postSetManageMembers($set_id,$id_type,$op){
		$ret=$this->post('/almaws/v1/conf/sets/{set_id}',
			array('set_id'=>$set_id),
			array('id_type'=>$id_type, 'op'=>$op)
		);
		$this_>checkForErrorMessage($ret);
		return $ret;
	}*/
	function postSetManageMembers($set_id, $barcode) {
		$body = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?' .'>

<set>
  <id>' . $set_id .'>/id>
  <op>add_members</op>
  <number_of_members>1</number_of_members>
<members total_record_count="1">
  <member>
    <id>' . $barcode .'</id>
  </member>
</members>
</set>';
		$bodyxml = new DomDocument();
		$bodyxml->loadXML($body);
		
		$ret = $this->post('/almaws/v1/conf/sets', array(), array('set_id' => $set_id, 'barcode' => $barcode),$bodyxml);
		
		$this->checkForErrorMessage($ret);
		return $ret;
	}
	/*function postSetManageMembers($set_id,$id_type,$op) {
		$body = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?' . '>
<set>
  <set_id>' . $set_id . '</set_id>
  <id_type>BARCODE</id_type>
  <ob>add_members</ob>
</set>';
		$bodyxml = new DomDocument();
		$bodyxml->loadXML($body);
		
		$ret = $this->post('/almaws/v1/conf/sets', array(), array('set_id' => $set_id, 'id_type' => $id_type, 'op' => $op),$bodyxml);
		
		$this->checkForErrorMessage($ret);
		return $ret;
	}*/

// {{{ Set -> createSetFromImport (Create a Set)
/**
 * @brief Create a Set from an import job
 *
 * Makes a call to the API:
 * [(API docs)](https://developers.exlibrisgroup.com/alma/apis/conf#Resources)
 *
 *		POST /almaws/v1/conf/sets
 *
 * @param string $job_instance_id ID of the import job
 * @param string $population ...
 * @return DomDocument Set object
*/

	function createSetFromImport($job_instance_id, $population) {
		# create blank set

		$body = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?' . '>
<set>
  <name>Grima set from ' . $job_instance_id . '</name>
  <description>members of ' . $job_instance_id . '</description>
  <type desc="Itemized">ITEMIZED</type>
  <content desc="All Titles">BIB_MMS</content>
  <private desc="No">false</private>
</set>';

/*
  Content:
    BIB_MMS -- all titles
    ITEM
    PORTFOLIO
    IEPA
    FILE
    AUTHORITY_MMS
    IEP
    IEE
    IED
    IEC
*/

/*
  Population:
*/

		$bodyxml = new DomDocument();
		$bodyxml->loadXML($body);

		$ret = $this->post('/almaws/v1/conf/sets', array(), array('job_instance_id' => $job_instance_id, 'population' => $population),$bodyxml);
		$this->checkForErrorMessage($ret);
		return $ret;

	}

	function createSet($name) {
		# create blank set

		$body = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?' . '>
<set>
  <name>' . $name . '</name>
  <description>Barcodes that were used to add Statnote2/3</description>
  <type desc="Itemized">ITEMIZED</type>
  <content desc="Physical items">ITEM</content>
  <private desc="No">false</private>
</set>';

/*
  Content:
    BIB_MMS -- all titles
    ITEM
    PORTFOLIO
    IEPA
    FILE
    AUTHORITY_MMS
    IEP
    IEE
    IED
    IEC
*/

/*
  Population:
*/

		$bodyxml = new DomDocument();
		$bodyxml->loadXML($body);

		$ret = $this->post('/almaws/v1/conf/sets', array(), array('name' => $name),$bodyxml);
		$this->checkForErrorMessage($ret);
		return $ret;

	}

// }}}

// {{{ grima -> deleteSet (Delete a Set)
/**
 * @brief Delete a Set - delete a set (not its items) from Alma
 *
 * Makes a call to the API:
 * [(API docs)](https://developers.exlibrisgroup.com/alma/apis/conf#Resources)
 *
 *		DELETE /almaws/v1/conf/sets/{set_id}
 *
 * @param string $set_id Set ID
*/
	function deleteSet($set_id) {
		$ret = $this->delete('/almaws/v1/conf/sets/{set_id}',
			array(
				'set_id' => $set_id,
			),
			array()
		);
		$this->checkForErrorMessage($ret);
	}
// }}}

// {{{ grima -> getSetMembers (Does it work????)
/**
 * @brief get the members of a set, IF IT WORKS?!?!
 *
 * Makes a call to the API:
 * [(API docs)](https://developers.exlibrisgroup.com/alma/apis/conf#Resources)
 *
 *		GET /almaws/v1/conf/sets/{set_id}/members
 *
 * @param string $set_id Set ID
 * @param number $limit How many to return at most (default 10)
 * @param number $offset Where to start from, for continuation (default 0, the beginning)
*/
	function getSetMembers($set_id,$limit = 10,$offset = 0) {
		$ret = $this->get('/almaws/v1/conf/sets/{set_id}/members',
			array('set_id' => $set_id),
			array('limit' => $limit, 'offset' => $offset)
		);
		$this->checkForErrorMessage($ret);
		return $ret;
	}
// }}}

/**@}*/
//}}}

//{{{Analytics APIs
/**@name Analytics APIs */
/**@{*/

	# XXX check if blank filter is ok
	function getAnalytics($path,$filter,$limit=25,$token=null) {
		return $this->get('/almaws/v1/analytics/reports',
			array(),
			array('path' => urlencode($path), 'filter' => urlencode($filter),
				'limit' => $limit, 'token' => $token)
		);
	}

/**@}*/
//}}}

}

$grima = new Grima();

// }}}

// {{{ class GrimaTask
/** @class GrimaTask
 ** @brief The base class for most "grimas"
 */
abstract class GrimaTask implements ArrayAccess {

	public $error = false;
	public $args = array();
	public $el_override = array();

	public $auto_args = array();

	public $messages = array();

	function offsetExists($offset) {
		return isset($this->args[$offset]);
	}

	function offsetGet($offset) {
		return $this->args[$offset];		
	}
	
	function offsetSet($offset,$value) {
		$this->args[$offset] = $value;
	}

	function offsetUnset($offset) {
		unset($this->args[$offset]);
	}

	function __construct() {
		$webroot = __DIR__;
		$base = get_class($this); //basename($_SERVER['PHP_SELF'],'.php');
		if (file_exists(join_paths($webroot,$base,"$base.xml")) and (!isset($this->formxml))) {
			$this->formxml = file_get_contents(join_paths($webroot,$base,"$base.xml"));
		}
		if (isset($this->formxml)) {
			$this->form = new GrimaForm();
			$this->form->fromXML($this->formxml);
		}
	}

	function setup_splat() {
		$webroot = __DIR__;
		$basename = get_class($this); //basename($_SERVER['PHP_SELF'],'.php');

		$this->splat = new zemowsplat\Splat();

		$this->splat->addBases(array(
			"$webroot/$basename/splats",	// per-task overrides
			"$webroot/splats",				// default
		));

		$this->splatVars = array(
			'title'				=> $this->form->title,
			'basename'			=> $basename,
			'webroot'			=> $webroot,
			'local_stylesheets' => array('Grima.css'),
			'form'				=> &$this->form,
			'messages'			=> &$this->messages,
			'width'				=> 9,
		);
		if (isset($this['redirect_url'])) {
			$this->splatVars['redirect_url'] = $this['redirect_url'];
		}
	}

	function print_form() {
		$this->form->loadValues($this);
		$this->splat->splat('print_form', $this->splatVars );
	}

	function print_success() {
		$this->form->loadPersistentValues($this);
		$this->splat->splat('print_success', $this->splatVars );
	}

	function print_failure() {
		$this->form->loadValues($this);
		$this->splat->splat('print_failure', $this->splatVars );
	}

	function check_login() {
		global $grima;
		if (isset($grima->apikey) and isset($grima->server) and
			($grima->apikey) and ($grima->server)) {
			return true;
		} else {
			do_redirect('../Login/Login.php?redirect_url=' . urlencode($_SERVER['PHP_SELF']));
			exit;
			return false;
		}
	}

	public function addMessage($type,$message) {
		$this->messages[] = new GrimaTaskMessage($type,$message);
	}

	public function run() {
		$this->check_login(); # if not logged in, print login form
		$this->error = false;
		$this->get_input();
		$this->setup_splat(); # should happen after form xml read in get_input
		if ($this->check_input()) {
			try {
				$this->do_task();
			} catch (Exception $e) {
				$this->addMessage('error',$e->getMessage());
				$this->error = true;
			}
		} else {
			$this->print_form();
			exit;
		}
		if ($this->error) {
			$this->print_failure();
		} else {
			$this->print_success();
		}
	}

	public static function RunIt() {
		$task = new static();
		$task->run();
	}

	function get_input() {
		if (isset($this->form)) {
			if (php_sapi_name() == "cli") { # command line
				/*
				if ($options = getopt(implode(array_keys($param)))) {
					foreach ($param as $k => $v) {
						$this->args[$v] = $options[$k[0]];
					}
					if (!$this->check_input()) {
						$this->usage(); exit;
					}
				} else {
					$this->usage(); exit;
				}
				*/
			} else { # web
				foreach ($this->form->fields as $field) {
					if (isset($_REQUEST[$field->name])) {
						$this[$field->name] = $_REQUEST[$field->name];
						/* sanitize */
					}
				}
			}

		} else {
			$this->get_input_param($this->auto_args);
		}
	}

	function check_input() {
		if (isset($this->form)) {
			$input_good = true;
			foreach ($this->form->fields as $field) {
				if ($field->required) {
					if (!isset($this[$field->name]) or
							!($this[$field->name])) {
						$field->error_condition = "error";
						$field->error_message = "Field is required\n";
						$input_good = false;
					}
				}
			}
			return $input_good;
		} else {

			foreach ($this->auto_args as $k => $v) {
				if (preg_match('/[^:]:$/',$k)) {
					if (!isset($this->args[$v]) or !($this->args[$v])) {
						return false;
					}
				}
			}
			return true;
		}
	}

	function get_input_param($param) {
		if (php_sapi_name() == "cli") { # command line
			if ($options = getopt(implode(array_keys($param)))) {
				foreach ($param as $k => $v) {
					$this->args[$v] = $options[$k[0]];
				}
				if (!$this->check_input()) {
					$this->usage(); exit;
				}
			} else {
				$this->usage(); exit;
			}
		} else { # web
			foreach ($param as $k => $v) {
				if (isset($_REQUEST[$v])) {
					$this->args[$v] = $_REQUEST[$v];
				}
			}
			if (!$this->check_input()) {
				$this->print_form(); exit;
			}
		}
	}

	abstract function do_task();

	function usage() { # XXX rewrite for grima form
		global $argv;
		print "Usage: php ${argv[0]} ";
		foreach ($this->auto_args as $k => $v) {
			if (preg_match('/^(.):$/',$k,$m)) {
				print "-${m[1]} <$v> ";
			} else {
				if (preg_match('/^(.)::$/',$k,$m)) {
					print "[ -${m[1]} <$v> ] ";
				} else {
					if (preg_match('/^.$/',$k)) {
						print "[ -$k ] ";
					}
				}
			}
		}
		print "\n";
		exit;
	}

	public static function call($grimaname,$args = array()) {
		$url = rtrim("../$grimaname/$grimaname.php?" . http_build_query($args),"?");
		do_redirect($url);
	}

}

// }}}

// {{{ class GrimaTaskMessage
/** @class GrimaTaskMessage
 ** @brief A thin wrapper around a message and urgency level
 */
class GrimaTaskMessage {
	public $type;
		/* bootstrap type: debug, info, success, warning, error */
	public $message;

	function __construct($type,$message) {
		$this->type = $type;
		$this->message = $message;
	}
}

// }}}

//{{{ class GrimaForm
/** @class GrimaForm
 ** @brief A holder for the user inputs to a grima, base on the XML file
 */
class GrimaForm {
	public $fields = array();
	public $title;
	protected $action;

// {{{ loadValues
/**
 * @brief load values into the form
 *
 * @param Object $obj array-accessible
 */
	function loadValues($obj) {
		foreach ($this->fields as $field) {
			if (isset($obj[$field->name])) {
				$field->value = $obj[$field->name];
			}
		}
	}
// }}}

// {{{ loadPersistentValues
/**
 * @brief load persistent values into the form
 *
 * @param Object $obj array-accessible
 */
	function loadPersistentValues($obj) {
		foreach ($this->fields as $field) {
			if (($field->persistent) and isset($obj[$field->name])) {
				$field->value = $obj[$field->name];
			}
		}
	}
// }}}



// {{{ fromXML
/**
 * @brief interpret XML to determine form fields and behavior
 * @param string $xml XML document
 */
	function fromXML($xml) {
		$doc = new DomDocument();
		$doc->loadXML($xml);
		$xpath = new DomXpath($doc);
		$this->title = $xpath->query('//Title')[0]->nodeValue;
		$this->action = basename($_SERVER['PHP_SELF']); # allow set?

		$nodes = $xpath->query('//Field');
		foreach ($nodes as $node) {
			$this->fields[$node->getAttribute('name')] = new GrimaFormField($node);
		}
	}
// }}}

}

// }}}

//{{{ class GrimaFormField

/** @class GrimaFormField
 ** @brief Wrapper for each field in a form, keeping track of its properties
 */
class GrimaFormField {

	public $value;

	public $name;
	public $label;
	public $placeholder;
	public $required;
	public $persistent;
	public $visible;
	public $rows;
	public $legend;
	public $id;
	protected $autocomplete;
	protected $highlight;
	public $error_condition = ""; /* can be warning or error */
	public $error_message = "";

// {{{ booly - is it true or false
/**
 * return boolean meaning of common terms ("true","on","1","yes")
 *
 * @param string $str term to interpret
 * @param $default if it is not found
 * @return boolean true or false
 */
	function booly($str, $default = 'undefined') {
		switch(strtolower($str)) {
			case 'true':
			case 't':
			case 'on':
			case 'yes':
			case '1':
				return true;
			case 'false':
			case 'f':
			case 'off':
			case 'no':
			case '0':
				return false;
			default:
				return $default;
		}
	}
// }}}

// {{{ __construct
/**
 * @brief create a new GrimaFormField
 *
 * @param DomNode $field with attributes for all properties
 */
	function __construct($field) {
		$this->name = $field->getAttribute('name');
		$this->label = $field->getAttribute('label');
		$this->placeholder = $field->getAttribute('placeholder');
		$this->rows = $field->getAttribute('rows');
		$this->legend = $field->getAttribute('legend');
		$this->id = $field->getAttribute('id');
		$this->type = $field->getAttribute('type');
		if (!$this->type) {
			$this->type = 'input';
		}
		$this->required = $this->booly($field->getAttribute('required'),true);
		$this->persistent = $this->booly($field->getAttribute('persistent'),false);
		$this->autocomplete = $this->booly($field->getAttribute('autocomplete'),false);
		$this->visible = $this->booly($field->getAttribute('visible'),true);
		$this->options = array();
		foreach ($field->getElementsByTagName("option") as $option) {
			$this->options[] = $option->ownerDocument->saveXML( $option );
		}
	}
// }}}

}

// }}}

//{{{ class AlmaObject
/** @class AlmaObject
 ** @brief Base class for objects returned from alma APIs (mostly just array access)
 */
class AlmaObject implements ArrayAccess {
	public $el_access = array();
	public $xml;
	public $templateDir = __DIR__ . "/templates";

// {{{ __construct
/**
 * @brief create new blank Alma Object
 */
	function __construct() {
		$this->xml = new DomDocument();
		$blankRecord = get_class($this);
		$this->xml->loadXML(file_get_contents("{$this->templateDir}/{$blankRecord}.xml"));
	}
// }}}

	function offsetExists($offset) {
		if (isset($this->el_override)) {
			return array_key_exists($offset, $this->el_override);
		}
		return array_key_exists($offset, $this->el_access);
	}

	function offsetGet($offset) {
		if ((isset($this->el_override)) and
				(isset($this->el_override[$offset]))) {
			return $this->el_override[$offset];
		}
		$xpath = new DomXpath($this->xml);
		$node = $xpath->query($this->el_address[$offset]);
		if (count($node) >= 1) {
			return $node[0]->nodeValue;
		}
		return null;
	}

	function offsetSet($offset, $value) {
		$xpath = new DomXpath($this->xml);
		$node = $xpath->query($this->el_address[$offset]);
		$node[0]->nodeValue = $value;

	}

	function offsetUnset($offset) {
		$xpath = new DomXpath($this->xml);
		$node = $xpath->query($this->el_address[$offset]);
		$node[0]->nodeValue = null;
	}

}

// }}}

// {{{ class AlmaObjectWithMARC
/** @class AlmaObjectWithMARC
 ** @brief Methods for fields and subfields in Alma's MARCXML
*/
class AlmaObjectWithMARC extends AlmaObject {

// {{{ AlmaObjectWithMARC -> appendField
/**
 * @brief add a field to the MARC record
 *
 * @param string $tag a three character MARC tag
 * @param Int $ind1 one digit, first indicator
 * @param Int $ind2 second digit, second indicator
 * @param Array $subfields each entry of the form $code => $value
 */
	function appendField($tag,$ind1,$ind2,$subfields) {
		$frag = "<datafield ind1=\"$ind1\" ind2=\"$ind2\" tag=\"$tag\">";
		foreach ($subfields as $k => $v) {
			$frag .= "<subfield code=\"$k\">$v</subfield>";
		}
		$frag .= "</datafield>";
		$xpath = new DomXpath($this->xml);
		$record = $xpath->query("//record");
		appendInnerXML($record[0],$frag);
	}
// }}}

// {{{ AlmaObjectWithMARC -> appendControlfield
/**
 * @brief add a control (001,004,008 etc.) field to the MARC record
 *
 * @param string $tag a three character MARC tag
 */
	function appendControlfield($tag) {
		$frag = "<controlfield tag=\"$tag\">";
		$frag .= "</controlfield>";
		$xpath = new DomXpath($this->xml);
		$record = $xpath->query("//record");
		appendInnerXML($record[0],$frag);
	}
// }}}

// {{{ AlmaObjectWithMARC -> setHldr
/**
 * @brief modifies Holdings Marc Leader 05,06,17,18
 *
 * @param Array $chr5,$chr6,$chr17,$chr18
 */
	function setHldr($chr5,$chr6,$chr17,$chr18) {
		$xpath = new DomXpath($this->xml);
		$chrs = $xpath->query("//record/leader");
		foreach ($chrs as $chr) {
		$replace1=substr_replace($chr->nodeValue,$chr5,5,1);
		$replace2=substr_replace($replace1,$chr6,6,1);
		$replace3=substr_replace($replace2,$chr17,17,1);
		$replace4=substr_replace($replace3,$chr18,18,1);
		$chr->nodeValue = $replace4;
		}
	}
// }}}

// {{{ AlmaObjectWithMARC -> setH008
/**
 * @brief modifies Holdings Marc 008 06,12,16,17-19,20,21,22-24,25
 *
 * @param Array $chr6,$chr12,$chr16,$chr17,$chr20,$chr21,$chr22,$chr25
 */
	function setH008($chr6,$chr12,$chr16,$chr17,$chr20,$chr21,$chr22,$chr25) {
		$xpath = new DomXpath($this->xml);
		$chrs = $xpath->query("//record/controlfield[@tag='008']");
		foreach ($chrs as $chr) {
		$replace1=substr_replace($chr->nodeValue,$chr6,6,1);
		$replace2=substr_replace($replace1,$chr12,12,1);
		$replace3=substr_replace($replace2,$chr16,16,1);
		$replace4=substr_replace($replace3,$chr17,17,3);
		$replace5=substr_replace($replace4,$chr20,20,1);
		$replace6=substr_replace($replace5,$chr21,21,1);
		$replace7=substr_replace($replace6,$chr22,22,3);
		$replace8=substr_replace($replace7,$chr25,25,1);
		$chr->nodeValue = $replace8;
		}
	}
// }}}

// {{{ AlmaObjectWithMARC -> setHldr5
/**
 * @brief modifies Holdings Marc Leader 05 - Record status
 *
 * @param Array $chr 
 */
	function setHldr5($chr) {
		$xpath = new DomXpath($this->xml);
		$chr5s = $xpath->query("//record/leader");
		foreach ($chr5s as $chr5) {
			$replace = substr_replace($chr5->nodeValue,$chr,5,1);
			$add = $this->xml->createElement("leader");
			$add->appendChild($this->xml->createTextNode($replace));
			$chr5s[0]->appendchild($add);
		}
		
	}
// }}}

// {{{ AlmaObjectWithMARC -> setHldr6
/**
 * @brief modifies Holdings Marc Leader 06 - Type of record
 *
 * @param Array $chr 
 */
	function setHldr6($chr) {
		$xpath = new DomXpath($this->xml);
		$chr6s = $xpath->query("//record/leader");
		foreach ($chr6s as $chr6) {
			$replace = substr_replace($chr6->nodeValue,$chr,6,1);
			$add = $this->xml->createElement("leader");
			$add->appendChild($this->xml->createTextNode($replace));
			$chr6s[0]->appendchild($add);
		}
		
	}
// }}}

// {{{ AlmaObjectWithMARC -> setHldr17
/**
 * @brief modifies Holdings Marc Leader 17 - Encoding level
 *
 * @param Array $chr 
 */
	function setHldr17($chr) {
		$xpath = new DomXpath($this->xml);
		$chr17s = $xpath->query("//record/leader");
		foreach ($chr17s as $chr17) {
			$replace = substr_replace($chr17->nodeValue,$chr,17,1);
			$add = $this->xml->createElement("leader");
			$add->appendChild($this->xml->createTextNode($replace));
			$chr17s[0]->appendchild($add);
		}
		
	}
// }}}

// {{{ AlmaObjectWithMARC -> setHldr18
/**
 * @brief modifies Holdings Marc Leader 18 - Type of record
 *
 * @param Array $chr 
 */
	function setHldr18($chr) {
		$xpath = new DomXpath($this->xml);
		$chr18s = $xpath->query("//record/leader");
		foreach ($chr18s as $chr18) {
			$replace = substr_replace($chr18->nodeValue,$chr,18,1);
			$add = $this->xml->createElement("leader");
			$add->appendChild($this->xml->createTextNode($replace));
			$chr18s[0]->appendchild($add);
		}
		
	}
// }}}

// {{{ AlmaObjectWithMARC -> set008p6
/**
 * @brief modifies Holdings Marc 008 06 - Receipt or acquisition status
 *
 * @param Array $chr 
 */
	function set008p6($chr) {
		$xpath = new DomXpath($this->xml);
		$chr6s = $xpath->query("//record/controlfield[@tag='008']");
		foreach ($chr6s as $chr6) {
			$replace = substr_replace($chr6->nodeValue,$chr,6,1);
			$add = $this->xml->createElement("controlfield");
			$add->setAttribute("tag","008");
			$add->appendChild($this->xml->createTextNode($replace));
			$chr6s[0]->appendchild($add);
		}
		
	}
// }}}

// {{{ AlmaObjectWithMARC -> set008p7
/**
 * @brief modifies Holdings Marc 008 07 - Method of acquisition
 *
 * @param Array $chr 
 */
	function set008p7($chr) {
		$xpath = new DomXpath($this->xml);
		$chr7s = $xpath->query("//record/controlfield[@tag='008']");
		foreach ($chr7s as $chr7) {
			$replace = substr_replace($chr12->nodeValue,$chr,7,1);
			$add = $this->xml->createElement("controlfield");
			$add->setAttribute("tag","008");
			$add->appendChild($this->xml->createTextNode($replace));
			$chr7s[0]->appendchild($add);
		}
		
	}
// }}}

// {{{ AlmaObjectWithMARC -> set008p12
/**
 * @brief modifies Holdings Marc 008 12 - General retention policy
 *
 * @param Array $chr 
 */
	function set008p12($chr) {
		$xpath = new DomXpath($this->xml);
		$chr12s = $xpath->query("//record/controlfield[@tag='008']");
		foreach ($chr12s as $chr12) {
			$replace = substr_replace($chr12->nodeValue,$chr,12,1);
			$add = $this->xml->createElement("controlfield");
			$add->setAttribute("tag","008");
			$add->appendChild($this->xml->createTextNode($replace));
			$chr12s[0]->appendchild($add);
		}
		
	}
// }}}

// {{{ AlmaObjectWithMARC -> set008p16
/**
 * @brief modifies Holdings Marc 008 16 - Completeness
 *
 * @param Array $chr 
 */
	function set008p16($chr) {
		$xpath = new DomXpath($this->xml);
		$chr16s = $xpath->query("//record/controlfield[@tag='008']");
		foreach ($chr16s as $chr16) {
			$replace = substr_replace($chr16->nodeValue,$chr,16,1);
			$add = $this->xml->createElement("controlfield");
			$add->setAttribute("tag","008");
			$add->appendChild($this->xml->createTextNode($replace));
			$chr16s[0]->appendchild($add);
		}
		
	}
// }}}

// {{{ AlmaObjectWithMARC -> set008p17
/**
 * @brief modifies Holdings Marc 008 17-19 - Number of coppies report
 *
 * @param Array $chr 
 */
	function set008p17($chr) {
		$xpath = new DomXpath($this->xml);
		$chr17s = $xpath->query("//record/controlfield[@tag='008']");
		foreach ($chr17s as $chr17) {
			$replace = substr_replace($chr17->nodeValue,$chr,17,3);
			$add = $this->xml->createElement("controlfield");
			$add->setAttribute("tag","008");
			$add->appendChild($this->xml->createTextNode($replace));
			$chr17s[0]->appendchild($add);
		}
		
	}
// }}}

// {{{ AlmaObjectWithMARC -> set008p20
/**
 * @brief modifies Holdings Marc 008 20 - Lending policy
 *
 * @param Array $chr 
 */
	function set008p20($chr) {
		$xpath = new DomXpath($this->xml);
		$chr20s = $xpath->query("//record/controlfield[@tag='008']");
		foreach ($chr20s as $chr20) {
			$replace = substr_replace($chr20->nodeValue,$chr,20,1);
			$add = $this->xml->createElement("controlfield");
			$add->setAttribute("tag","008");
			$add->appendChild($this->xml->createTextNode($replace));
			$chr20s[0]->appendchild($add);
		}
		
	}
// }}}

// {{{ AlmaObjectWithMARC -> set008p21
/**
 * @brief modifies Holdings Marc 008 21 - Reproduction policy
 *
 * @param Array $chr 
 */
	function set008p21($chr) {
		$xpath = new DomXpath($this->xml);
		$chr21s = $xpath->query("//record/controlfield[@tag='008']");
		foreach ($chr21s as $chr21) {
			$replace = substr_replace($chr21->nodeValue,$chr,21,1);
			$add = $this->xml->createElement("controlfield");
			$add->setAttribute("tag","008");
			$add->appendChild($this->xml->createTextNode($replace));
			$chr21s[0]->appendchild($add);
		}
		
	}
// }}}

// {{{ AlmaObjectWithMARC -> set008p22
/**
 * @brief modifies Holdings Marc 008 22-24 - Language
 *
 * @param Array $chr 
 */
	function set008p22($chr) {
		$xpath = new DomXpath($this->xml);
		$chr22s = $xpath->query("//record/controlfield[@tag='008']");
		foreach ($chr22s as $chr22) {
			$replace = substr_replace($chr22->nodeValue,$chr,21,3);
			$add = $this->xml->createElement("controlfield");
			$add->setAttribute("tag","008");
			$add->appendChild($this->xml->createTextNode($replace));
			$chr22s[0]->appendchild($add);
		}
		
	}
// }}}

// {{{ AlmaObjectWithMARC -> set008p25
/**
 * @brief modifies Holdings Marc 008 25 - Separate or composite copy report
 *
 * @param Array $chr 
 */
	function set008p25($chr) {
		$xpath = new DomXpath($this->xml);
		$chr25s = $xpath->query("//record/controlfield[@tag='008']");
		foreach ($chr25s as $chr25) {
			$replace = substr_replace($chr25->nodeValue,$chr,21,1);
			$add = $this->xml->createElement("controlfield");
			$add->setAttribute("tag","008");
			$add->appendChild($this->xml->createTextNode($replace));
			$chr25s[0]->appendchild($add);
		}
		
	}
// }}}

// {{{ AlmaObjectWithMARC -> setFieldindicators
/**
 * @brief modifies the first and second indicators of a marc field
 *
 * @param string $tag a three character MARC tag
 * @param Int $ind1 one digit, first indicator
 * @param Int $ind2 second digit, second indicator
 */
	function setFieldindicators($tag,$ind1,$ind2) {
		$xpath = new DomXpath($this->xml);
		$xpath->query("//record/datafield[starts-with(@tag,'$tag')]")->item(0)->setAttribute("ind1",$ind1);
		$xpath->query("//record/datafield[starts-with(@tag,'$tag')]")->item(0)->setAttribute("ind2",$ind2);
	}
// }}}

// {{{ AlmaObjectWithMARC -> getFields # XXX IN PROGRESS
/**
 * @brief get fields for the given MARC tag
 *
 * @param String $tag field
 * @return Array of MARC fields -> object?
 */
	function getFields($tag) {
		$xpath = new DomXpath($this->xml);
		$tag = preg_replace('/X*$/','',$tag);
		$tag = preg_replace('/\.*$/','',$tag);
		$fields = $xpath->query("//record/datafield[starts-with(@tag,'$tag')]");
		$fieldarr = array();
		foreach ($fields as $field) {
			$subfieldarr = array();
			foreach ($field->childNodes as $child) {
				$subfieldarr[] = array(
					$child->attributes[0]->value,
					$child->nodeValue
				);
			}
			$fieldarr[] = $subfieldarr;
		}
		return $fieldarr;
	}
// }}}

// {{{ AlmaObjectWithMARC -> getSubfieldValues
/**
 * @brief get subfield value
 *
 * @param String $tag field
 * @param String $code subfield
 * @return Array array containing all values of subfield
 */
	function getSubfieldValues($tag,$code) {
		$xpath = new DomXpath($this->xml);
		$subfields = $xpath->query("//record/datafield[@tag='$tag']/subfield[@code='$code']");
		$arr = array();
		foreach ($subfields as $subfield) {
			$arr[] = $subfield->nodeValue;
		}
		return $arr;
	}
// }}}

// {{{ AlmaObjectBarcode -> deleteBarcode
/**
 * @brief delete barcode from item record
 *
 * @param 
 */
 
	function deleteBarcode($barcode) {
		$xpath = new DomXpath($this->xml);
		$barcodex = $xpath->query("//item_data[@barcode='$barcode']");//"//item_data/barcode"
		foreach( $barcodex as $barcode) {
			$barcode->parentNode->removeChild($barcode);
		}
	}

// }}}
// {{{ AlmaObjectWithMARC -> deleteField
/**
 * @brief delete all $tag fields from the MARC record
 *
 * @param string $tag a three character MARC tag
 */
	function deleteField($tag) {
		$xpath = new DomXpath($this->xml);
		$fields = $xpath->query("//record/datafield[@tag='$tag']");
		foreach( $fields as $field ) {
			$field->parentNode->removeChild( $field );
		}
	}
// }}}

// {{{ AlmaObjectWithMARC -> deleteControlField
/**
 * @brief delete all $tag fields from the MARC record
 *
 * @param string $tag a three character MARC tag
 */
	function deleteControlField($tag) {
		$xpath = new DomXpath($this->xml);
		$fields = $xpath->query("//record/controlfield[@tag='$tag']");
		foreach( $fields as $field ) {
			$field->parentNode->removeChild( $field );
		}
	}
// }}}

// {{{ AlmaObjectWithMARC -> deleteSubfieldMatching
/**
 * @brief delete subfields matching a regex
 *
 * @param Array $subfields each entry of the form $code => $value
 */
	function deleteSubfieldMatching($tag,$code,$regex) {
		$xpath = new DomXPath($this->xml);
		$subfs = $xpath->query("//datafield[@tag='$tag']/subfield[@code='$code']");
		foreach ($subfs as $subf) {
			if (preg_match($regex,$subf->nodeValue)) {
				$subf->parentNode->removeChild($subf);
			}
		}
	}
// }}}

// {{{ AlmaObjectWithMARC -> replaceOrAddSubfield
/**
 * @brief replace or add subfield value in marc
 *
 * @param string $tag a three character MARC tag
 * @param string $code a one letter subfield code
 * @param string $value what to set the value to
 */
	function replaceOrAddSubfield($tag,$code,$value) {
		# very shady but sometimes needed
		$xpath = new DomXpath($this->xml);
		$fields = $xpath->query("//record/datafield[@tag='$tag']");
		if (sizeof($fields) == 0) {
			$this->appendField($tag,' ',' ',array($code => $value));
		} else {
			$done = false;
			foreach	 ($fields[0]->childNodes as $subfield) {
				if($subfield->nodeType !== 1) {
					continue;
				}
				if ($subfield->getAttribute("code") == $code) {
					$subfield->nodeValue = $value;
					$done = true;
					break;
				}
			}
			if (!$done) {
				$subfield = $this->xml->createElement("subfield");
				$subfield->setAttribute("code",$code);
				$subfield->appendChild($this->xml->createTextNode($value));
				$fields[0]->appendChild($subfield);
			}
		}
	}
// }}}

}
// }}}

// {{{ class MARCField -- # XXX in progress
/** @class MARCField
 ** @brief MARC fields for use in bibs and holdings
 */

class MARCField {
	public $tag;
	public $subfields = array();
}

class MARCSubfield {
	public $code;
	public $value;
}

// }}}

// {{{ class bib
/** @class bib
 ** @brief bib records returned from alma
 */
class Bib extends AlmaObjectWithMARC {
	public $holdingsList; # HoldingsList object
	public $holdings = array();

	public $portfolioList = array(); # just an array for now

	/* public $networknums = array(); */

	protected $el_address = array(
		'mms_id' => '//mms_id',
		'leader' => '//leader',
		'record_format' => '//record_format',
		'title' => '//title',
		'author' => '//author',
		'place_of_publication' => '//place_of_publication',
		'publisher_const' => '//publisher_const',
		'publisher' => '//publisher_const',
		'suppress_from_publishing' => '//suppress_from_publishing'
	);

	function offsetGet($offset) {
		if ($offset == 'Type') {
			$leader = $this['leader'];
			return $leader[6];
		}
		if ($offset == 'BLvl') {
			$leader = $this['leader'];
			return $leader[7];
		}
		if ($offset == 'ELvl') {
			$leader = $this['leader'];
			return $leader[17];
		}
		if ($offset == 'Desc') {
			$leader = $this['leader'];
			return $leader[18];
		}
		return parent::offsetGet($offset);
	}

	# override because these go multiple places
	function offsetSet($offset,$value) {
		parent::offsetSet($offset,$value);
		if ($offset == 'author') {
			$this->replaceOrAddSubfield('100','a',$value);
		}
		if ($offset == 'title') {
			$this->replaceOrAddSubfield('245','a',$value);
		}
		if (($offset == 'publisher_const') or ($offset == 'publisher')) {
			$this->replaceOrAddSubfield('264','b',$value);
		}
		if ($offset == 'place_of_publication') {
			$this->replaceOrAddSubfield('264','a',$value);
		}
	}
	

// {{{ Bib -> loadFromAlma (get) - gets Bib from Alma
/**
 * @brief populates the bib with a record from Alma
 *
 * @param string $mms_id MMS ID of record to load from Alma
 */
	function loadFromAlma($mms_id) {
		global $grima;
		$this->xml = $grima->getBib($mms_id);
	}
// }}}

// {{{ Bib -> addToAlma (post) - adds the Bib to Alma
/**
 * @brief adds record as a new record to Alma, updates Bib with
 * current Alma version
 */
	function addToAlma() {
		global $grima;
		$this->xml = $grima->postBib($this->xml);
	}
// }}}

// {{{ Bib -> updateAlma (put) - replaces the Bib in Alma
/**
 * @brief replaces the Bib in Alma
 */
	function updateAlma() {
		global $grima;
		$this->xml = $grima->putBib($this['mms_id'],$this->xml);
	}
// }}}

// {{{ Bib -> deleteFromAlma (delete) - deletes the Bib from Alma
/**
 * @brief deletes the Bib from Alma
 */
	function deleteFromAlma() {
		global $grima;
		$grima->deleteBib($this['mms_id']);
	}
// }}}

// {{{ Bib -> deleteTreeFromAlma (delete) - deletes Bib and inventory from Alma
/**
 * @brief deletes the Bib and its inventory #XXX
 */
	function deleteTreeFromAlma() {
		global $grima;
		$this->getHoldings();
		foreach ($this->holdings as $holding) {
			$holding->deleteTreeFromAlma(); #XXX
		}
		$this->deleteAllPortfolios($this['mms_id']); #XXX
		$grima->deleteBib($this['mms_id']);
	}
// }}}

// {{{ Bib -> hasInventory - does the bib have holdings or portfolios in Alma?
/**
 * @brief populate holdings property with Holdings items
 */
	function hasInventory() {
		$this->getHoldingsList();
		if (count($this->holdingsList->entries) > 0) {
			return true;
		}
		$this->getPortfolioList();
		if (count($this->portfolioList) > 0) {
			print_r($this->portfolioList);
			return true;
		} else {
			return false;
		}
	}
// }}}

// {{{ Bib -> linkedToCZ - is the bib linked to community zone?
/**
 * @brief is the bib linked to the community zone?
 */
	function linkedToCZ() {
		$xpath = new DomXPath($this->xml);
		$nodes = $xpath->query("//linked_record_id[@type='CZ']");
		return (count($nodes) > 0);
	}
// }}}

// {{{ Bib -> unlinkFromCZ - does this work
/**
 * @brief does this work
 * @XXX: Not supported for CZ
 */
	function unlinkFromCZ() {
		$xpath = new DomXPath($this->xml);
		$nodes = $xpath->query("//linked_record_id[@type='CZ']");
		foreach ($nodes as $node) {
			$node->parentNode->removeChild($node);
		}
		$this->updateAlma();
	}
// }}}

// {{{ Bib -> getHoldings - get holdings objects
/**
 * @brief populate holdings property with Holdings items
 */
	function getHoldings() {
		$this->getHoldingsList();
		foreach ($this->holdingsList->entries as $entry) {
			$holding = new Holding();
			$holding->loadFromAlma($this['mms_id'],$entry['holding_id']);
			$holding['mms_id'] = $this['mms_id'];
			$this->holdings[] = $holding;
		}
	}
// }}}

// {{{ Bib -> deleteAllPortfolios - delete all portfolios from the bib
/**
 * @brief delete all portfolios from the bib
 */
	function deleteAllPortfolios() {
		global $grima;
		while ($this->getPortfolioList()) {
			foreach($this->portfolioList as $portfolio) {
				$portfolio->deleteFromAlma();
			}
			$this->portfolioList = array();
			sleep(2);
		}
	}
// }}}

// {{{ Bib -> getHoldingsList
/**
 * @brief populate holdingsList property with info from Alma
 */
	function getHoldingsList() {
		$this->holdingsList = new HoldingsList($this['mms_id']);
	}
// }}}

// {{{ Bib -> getPortfolioList
/**
 * @brief populate portfolioList property with info from Alma
 */
	function getPortfolioList() { # maybe rename
		global $grima;
		$limit = 10; $offset = 0; # where to allow passing
		$ret = $grima->getElectronicPortfoliosForBib($this['mms_id'],$limit,$offset);
		$xpath = new DOMXpath($ret);
		$ports = $xpath->query('//portfolio');
		foreach ($ports as $portnode) {
			$newport = new ElectronicPortfolio();
			$newport->loadFromPortfolioListNode($portnode);
			$this->portfolioList[] = $newport;
		}
		return count($ports);
	}
// }}}

/*
	function recycle() { # XXX
		global $grima;
		$recycle_bin = new Set();
		$recycle_bin->loadFromAlma("9543638640002636");
		$recycle_bin->addMember($this['mms_id']);
		# add to recycle bin
	}
*/

// {{{ Bib -> get_title_proper
/** @brief a tidy title proper
 @return string 245$a with ISBD punctuation removed
 */
	function get_title_proper() {
		$xpath = new DomXpath($this->xml);
		$title = $xpath->query("//record/datafield[@tag='245']/subfield[@code='a']");
		return preg_replace("/[ \/=:,;\.]*$/","",$title[0]->nodeValue);
	}
// }}}

// {{{ Bib -> get_title_n
/** @brief title's $n
 @return string 245$n with ISBD punctuation removed
 */
	function get_title_n() {
		$xpath = new DomXpath($this->xml);
		$title = $xpath->query("//record/datafield[@tag='245']/subfield[@code='n']");
		return preg_replace("/[ \/=:,;\.]*$/","",$title[0]->nodeValue);
	}
// }}}

// {{{ Bib -> get_title_p
/** @brief title's $p
 @return string 245$p with ISBD punctuation removed
 */
	function get_title_p() {
		$xpath = new DomXpath($this->xml);
		$title = $xpath->query("//record/datafield[@tag='245']/subfield[@code='p']");
		return preg_replace("/[ \/=:,;\.]*$/","",$title[0]->nodeValue);
	}
// }}}

// {{{ Bib -> get_title
/** @brief title display for music cds
 @return string 245$p with ISBD punctuation removed, no $c?
 */
	function get_title() {
		$xpath = new DomXpath($this->xml);
		$fields = $xpath->query("//record/datafield[@tag='245']");
		//return ($fields[0]->nodeValue);
		$space = preg_replace("/(\[sound recording\])\W|(\[sound recording\])|\/[A-Za-z0-9].+$/","",$fields[0]->nodeValue);
		$space2 = preg_replace("/\./"," ",$space);
		$space3 = preg_replace("/\,/",", ",$space2);
		$space4 = preg_replace("/(\,  )/",", ",$space3);
		$space5 = preg_replace("/(\=)/"," = ",$space4);
		$space6 = preg_replace("/( \= )/"," = ",$space5);
		return preg_replace("/\:/"," : ",$space6);
		//return preg_replace("/\.|\:/"," ",$space);
		//return preg_replace("/[ \/=:,;\.]*$/","",$fields[0]->nodeValue);
		/*foreach ($fields as $field) {
			foreach ($field->childNodes as $subfield) {
				if ($subfield->nodeName == "subfield") {
					$ret = array($subfield[0]->nodeValue);
				}
			}
			return $ret;
		}*/
	}
	
// }}}

	/*
	function get_networkNumbers() {
		$xpath = new DomXpath($this->xml);
		$netNums = $xpath->query("//bib/network_numbers/network_number");
		$ret = array();
		for ($j=0;$j<$netNums->length;$j++) {
			$ret[] = $netNums[$j]->nodeValue;
		}
		return $ret;
	}
	*/

// {{{ Bib -> getLCCallNumber #XXX
/**
 * @brief get LC call number, giving pref to 090 and later fields
 *
 * @return Array(class,item) for two parts of call number
 */
	function getLCCallNumber() {
		$xpath = new DomXPath($this->xml);
		$calls = array();
		foreach (array('050','090') as $tag) {
			foreach ($xpath->query("//datafield[@tag='$tag']") as $call) {
				$calls[] = $call;
			}
		}
		$ret = array();

		foreach ($calls as $node) {
			$classs = $xpath->query("subfield[@code='a']",$node);
			$items = $xpath->query("subfield[@code='b']",$node);
			if ((count($classs) > 0) and (count($items) > 0)) {
				$ret = array($classs[0]->nodeValue,$items[0]->nodeValue);
			}
		}
		return $ret;
	}
// }}}

}

// }}}

// {{{ class HoldingsList
/** class HoldingsList */
class HoldingsList extends AlmaObject {
	public $el_address = array(
		'mms_id' => '//mms_id',
		'title' => '//title',
		'author' => '//author',
	);
	public $xml;
	#public $holdings = array(); # should this go in BIB?
	public $entries = array(); # array of HoldingsListEntry

	function __construct($mms_id = null) {
		if (!is_null($mms_id)) {
			$this->loadFromAlma($mms_id);
		}
	}

	function loadFromAlma($mms_id) {
		global $grima;
		$this->xml = $grima->getHoldingsList($mms_id);
		$xpath = new DomXpath($this->xml);
		$hs = $xpath->query('//holding');
		$this->entries = array(); # clear
		#$this->holdings = array(); # clear
		foreach ($hs as $h) {
			#$this->holdings[] = new HoldingsListEntry($h,$mms_id);
			$this->entries[] = new HoldingsListEntry($h,$mms_id);
		}
	}
}

// }}}

// {{{ class HoldingsListEntry
/** class HoldingsListEntry */
class HoldingsListEntry extends AlmaObject {
	protected $el_address = array(
		'holding_id' => '//holding_id',
		'leader' => '//leader',
		'008' => '//holding/008',
		'call_number' => '//holding/call_number',
		'library_code' => '//holding/library',
		'library' => '//holding/library/@desc',
		'location_code' => '//holding/location',
		'location' => '//holding/location/@desc'
	);
	public $xml;

	function __construct($node,$mms_id) {
		$this->xml = new DomDocument();
		$this->xml->appendChild($this->xml->importNode($node,true));
		$this->el_override['mms_id'] = $mms_id;
	}

	function getItemList($limit = -1) {
		global $grima;
		$this->getMmsIfNeeded();
		$this->itemList = new ItemList($this['mms_id'], $this['holding_id'], $limit);
	}
}

// }}}

// {{{ class ItemList
/** class ItemList */
class ItemList extends AlmaObject {
	public $items = array();	#maybe ok as is

	function __construct($mms_id,$holding_id,$limit =-1) {

		global $grima;
		$curr_offset = 0;
		$req_limit = ($limit == -1)?100:$limit;

		do {
			if ($curr_offset > 0) {
				if (($curr_offset+1)*100 > $limit) {
					$req_limit = $limit - $curr_offset*100;
				} else {
					$req_limit = 100;
				}
		 	}
			$xml = $grima->getItemList($mms_id,$holding_id,$req_limit,$curr_offset*100);
			$xpath = new DomXpath($xml);
			$is = $xpath->query('//item');
			foreach ($is as $i) {
				$new_item = new Item();
				$new_item->loadFromItemListNode($i);
				$this->items[] = $new_item;
			}
			$xpath = new DomXPath($xml);
			if (!$curr_offset) {
				$length = $xpath->query('//items/@total_record_count')[0]->nodeValue;
				if ($limit == -1) { $limit = $length; }
			}
			$curr_offset++;

		} while (($curr_offset*100 < $length) and ($curr_offset*100 < $limit));

	}

}

// }}}

// {{{ class Holding
/** class Holding */
class Holding extends AlmaObjectWithMARC {
	public $itemList; # object
	public $items = array();
	public $xml;

	function offsetSet($offset,$value) {
		if ($offset == "mms_id") {
			$this->el_override['mms_id'] = $value;
		} else {
			parent::offsetSet($offset,$value);
		}
	}

	function offsetGet($offset) { #XXX TEST
		if ($offset == "library") {
			$lib = new Library();
			$lib->loadFromAlma($this['library_code']);
			return $lib['name'];
		}
		if ($offset == "location") {
			$loc = new Location();
			$loc->loadFromAlma($this['library_code'],$this['location_code']);
			return $loc['name'];
		}
		if ($offset == "call_number") {
			$Hs = $this->getSubfieldValues("852","h");
			$Is = $this->getSubfieldValues("852","i");
			$acc = "";
			foreach ($Hs as $h) {
				$acc .= "$h ";
			}
			foreach ($Is as $i) {
				$acc .= "$i ";
			}
			return rtrim($acc);
		}
		return parent::offsetGet($offset);
	}

// {{{ $el_address
	public $el_address = array(
		'holding_id' => '//holding_id',
		'copy_id' => '//copy_id',
		'008' => "/holding/record/controlfield[@tag='008']",
		'inst_code' => "/holding/record/datafield[@tag='852']/subfield[@code='a']",
		'library_code' => "/holding/record/datafield[@tag='852']/subfield[@code='b']",
		'location_code' => "/holding/record/datafield[@tag='852']/subfield[@code='c']",
		'call_number' => "/holding/record/datafield[@tag='852']/subfield[@code='h']",
		'suppress_from_publishing' => '//holding/suppress_from_publishing',
	);
// }}}

// {{{ loadFromAlma (get) - populates record from Alma
/**
 * @brief populates the record from Alma
 *
 * @param $mms_id MMS ID of bib record
 * @param $holding_id Holding ID of holding
*/
	function loadFromAlma($mms_id,$holding_id) {
		global $grima;
		$this->xml = $grima->getHolding($mms_id,$holding_id);
		$this['mms_id'] = $mms_id;
	}
// }}}

//{{{ getHoldingIDFromMms (get) - gets the Holding ID for a MMS
/**
 * @brief populates the Holding ID
  *
*/
	public static function getHoldingIDFromMms($mms_id) {
		global $grima;

		$report = new AnalyticsReport();
		$report->path = "/shared/Kansas State University/Reports/In progress - Raymond/GRIMA/MMSToHolding";
		$report->filter = '
<sawx:expr xsi:type="sawx:comparison" op="equal" xmlns:saw="com.siebel.analytics.web/report/v1.1" 
xmlns:sawx="com.siebel.analytics.web/expression/v1.1" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
xmlns:xsd="http://www.w3.org/2001/XMLSchema">
  <sawx:expr xsi:type="sawx:sqlExpression">"Bibliographic Details"."MMS Id"</sawx:expr><sawx:expr xsi:type="xsd:string">{mms_id}</sawx:expr></sawx:expr>';
	
		$report->runReport(array('mms_id' => $mms_id), 1);
		if (count($report->rows) == 1) {
			return $report->rows[0][1];
		} else {
			return null;
		}
	}


// {{{ getHoldingIDIfNeeded (get) - populates Holding if needed
/**
 * @brief populates the Holding ID if not already known
 *
*/
	function getHoldingIfNeeded() {
		global $grima;

		if (!isset($this['holding_id']) or (!$this['holding_id'])) {
			$this['holding_id'] = Bib::getHoldingIDFromMms($this['mms_id']);
		}
	}
// }}}


// {{{ getMmsFromHoldingID (get) - gets the MMS for a holding ID
/**
 * @brief populates the MMS ID 
 *
*/
	public static function getMmsFromHoldingID($holding_id) {
		global $grima;

		$report = new AnalyticsReport();
		$report->path = "/shared/Kansas State University/Reports/In progress - Raymond/GRIMA/HoldingToMMS";
		$report->filter = '
<sawx:expr xsi:type="sawx:comparison" op="equal" xmlns:saw="com.siebel.analytics.web/report/v1.1" 
xmlns:sawx="com.siebel.analytics.web/expression/v1.1" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
xmlns:xsd="http://www.w3.org/2001/XMLSchema">
  <sawx:expr xsi:type="sawx:sqlExpression">"Holding Details"."Holding Id"</sawx:expr><sawx:expr xsi:type="xsd:string">{holding_id}</sawx:expr>
</sawx:expr>';
	
		$report->runReport(array('holding_id' => $holding_id), 1);
		if (count($report->rows) == 1) {
			return $report->rows[0][1];
		} else {
			return null;
		}
	}
// }}}

// {{{ getHoldingIDFromCallnumber (get) - gets the Holding ID from a callnumber search
/**
 * @brief populates the Holding ID 
 *
*/
	public static function getHoldingIDFromCallnumber($callnumber) {
		global $grima;

		$report = new AnalyticsReport();
		$report->path = "/shared/Kansas State University/Reports/In progress - Raymond/GRIMA/GRIMA_CALLNUMBER_SEARCH";
		$report->filter = '<sawx:expr xsi:type="sawx:list" op="beginsWith" xmlns:saw="com.siebel.analytics.web/report/v1.1"  xmlns:sawx="com.siebel.analytics.web/expression/v1.1" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"  xmlns:xsd="http://www.w3.org/2001/XMLSchema"><sawx:expr xsi:type="sawx:sqlExpression">"Holding Details"."Permanent Call Number"</sawx:expr><sawx:expr xsi:type="xsd:string">{callnumber}</sawx:expr></sawx:expr>';
	
		$report->runReport(array('callnumber' => $callnumber), 1);
		if (count($report->rows) == 1) {
			return $report->rows[0][1];
		} else {
			return null;
		}
	}
// }}}

// {{{ getMmsIfNeeded (get) - populates MMS if needed
/**
 * @brief populates the MMS ID if not already known
 *
*/
	function getMmsIfNeeded() {
		global $grima;

		if (!isset($this['mms_id']) or (!$this['mms_id'])) {
			$this['mms_id'] = Holding::getMmsFromHoldingID($this['holding_id']);
		}
	}
// }}}

// {{{ loadFromAlmaX (get) - populates record from Alma using holding_id
/**
 * @brief populates the record from Alma - only requires holding_id
 *
 * @param $holding_id Holding ID of holding
*/
	function loadFromAlmaX($holding_id) {
		global $grima;

		//$mms_id = Holding::getMmsFromHoldingID($holding_id);
		$this->xml = $grima->getHolding($holding_id,$holding_id);
		$this['mms_id'] = $mms_id;
	}
// }}}

// {{{ Holding -> addToAlmaBib (post) - adds new holding record to specified bib
/**
 * @brief adds a new holding record to the specified bib
 *
 * @param string $mms_id bib record to add the holdings record
 */
	function addToAlmaBib($mms_id) {
		global $grima;
		$this->xml = $grima->postHolding($mms_id,$this->xml);
		$this['mms_id'] = $mms_id;
	}
// }}}

// {{{ updateAlma (put) - update record in Alma
/**
 * @brief update holding record in Alma
 */
	function updateAlma() {
		global $grima;
		$grima->putHolding($this['mms_id'],$this['holding_id'],$this->xml);
	}
// }}}

// {{{ deleteFromAlma (delete) - delete record in Alma
/**
 * @brief delete the holding record from Alma
 */
	function deleteFromAlma() {
		global $grima;
		$grima->deleteHolding($this['mms_id'],$this['holding_id']);
	}
// }}}

/*
	function appendField($tag,$ind1,$ind2,$subfields) {
		$frag = "<datafield ind1=\"$ind1\" ind2=\"$ind2\" tag=\"$tag\">";
		foreach ($subfields as $k => $v) {
			$frag .= "<subfield code=\"$k\">$v</subfield>";
		}
		$frag .= "</datafield>";
		$xpath = new DomXpath($this->xml);
		$record = $xpath->query("//record");
		appendInnerXML($record[0],$frag);
	}
*/

	# call number object?

	function setCallNumber($h,$i,$ind1) {
		$xpath = new DomXpath($this->xml);
		$xpath->query("//record/datafield[@tag='852']")->item(0)->setAttribute("ind1",$ind1);

		$field852 = $xpath->query("//record/datafield[@tag='852']")->item(0);
		$subfieldHs = $xpath->query("subfield[@code='h']",$field852);
		foreach ($subfieldHs as $subfieldH) {
			$subfieldH->parentNode->removeChild($subfieldH);
		}
		$subfieldIs = $xpath->query("subfield[@code='i']",$field852);
		foreach ($subfieldIs as $subfieldI) {
			$subfieldI->parentNode->removeChild($subfieldI);
		}

		appendInnerXML($field852,"<subfield code=\"h\">$h</subfield>");
		if ($i) {
			appendInnerXML($field852,"<subfield code=\"i\">$i</subfield>");
		}
	}
	
	function setMapCallNumber($c,$ho,$hn,$ind1) {
		$xpath = new DomXpath($this->xml);
		$xpath->query("//record/datafield[@tag='852']")->item(0)->setAttribute("ind1",$ind1);
		//$xpath->query("//record/datafield[@tag='852']")->item(0)->setAttribute("ind2",$ind2);

		$field852 = $xpath->query("//record/datafield[@tag='852']")->item(0);
		$subfieldCs = $xpath->query("subfield[@code='c']",$field852);
		foreach ($subfieldCs as $subfieldC) {
			if ($c = 'govoffmap') {
				$subfieldC->nodeValue = 'govmap';
				continue;
			}
			if ($c = 'govmap') {
				continue;
			}
		if ($subfieldC->nodeValue != 'govmap' || $subfieldC->nodeValue != 'govoffmap') {
			break;
		}
		}
		$subfieldHs = $xpath->query("subfield[@code='h']",$field852);
		foreach ($subfieldHs as $subfieldH) {
			if ($subfieldH->nodeValue != $ho) {
				break;
			} else {
				//$subfieldH->parentNode->removeChild($subfieldH);
				$subfieldH->nodeValue = $hn;
			}
			//appendInnerXML($field852,"<subfield code=\"h\">$hn</subfield>");
		}
	}

// {{{ moveToBib - moves a holding from one bib to another
/**
 * @brief moves the holding from one bib to another -- only for empty holdings!
 */
	function moveToBib($mms_id) {
		$this->deleteFromAlma();
		$this->addToAlmaBib($mms_id);
	}
// }}}

// {{{ Holding -> getItems - get items objects
/**
 * @brief populate items property with Items objects ## XXX TEST
 */
	function getItems() {
		$this->getItemList();
		$this->items =& $this->itemList->items;
	}
// }}}

// {{{ getItemList - populates itemList property from Alma
/**
 * @brief populates itemList property from Alma
 */
	function getItemList() {
		global $grima;
		$this->getMmsIfNeeded();
		$this->itemList = new ItemList($this['mms_id'],$this['holding_id']);
	}
// }}}

// {{{ Holding -> deleteTreeFromAlma - delete the holding and all items
/**
 * @brief delete the holding and all of its items
 */
	function deleteTreeFromAlma() {
		global $grima;
		$this->getItemList();
		foreach ($this->itemList->items as $item) {
			$item->deleteFromAlma("true");
		}
		$this->deleteFromAlma();
	}
// }}}

// {{{ Holding -> deleteSubfieldMatching # XXX TEST. UM. MARC INTERFACE? OMG
/**
 * @brief delete subfields matching a regex
 *
 * @param string $tag a three character MARC tag
 * @param Int $ind1 one digit, first indicator
 * @param Int $ind2 second digit, second indicator
 * @param Array $subfields each entry of the form $code => $value
 */
/*
	function deleteSubfieldMatching($tag,$code,$regex) {
		$xpath = new DomXPath($this->xml);
		$subfs = $xpath->query("datafield[@tag='$tag']/subfield[@code='$code']");
		foreach ($subfs as $subf) {
			print "HERE";
			if (preg_match($regex,$subf->nodeValue)) {
				$subf->parentNode->removeChild($subf);
			}
		}
	}
*/
// }}}

}

// }}}
// {{{ class Itemnbc -- red 07/2020 current  does not add <barcode></barcode> to the payload
/** class Itemnbc */
class Itemnbc extends AlmaObject {

	public $el_address = array(
		'item_pid' => '//pid',
		'creation_date' => '//creation_date',
		'modification_date' => '//modification_date',
		'base_status' => '//base_status',
		'physical_material_type_code' => '//physical_material_type',
		'physical_material_type' => '//physical_material_type/@desc',
		'location' => '//location/@desc',
		'location_code' => '//location',
		'library' => '//library/@desc',
		'library_code' => '//library',
		'policy' => '//policy',
		'inventory_number' => '//inventory_number',
		'inventory_date_new_value' => '//inventory_date_new_value',
		'inventory_date' => '//inventory_date',
		'item_policy' => '//policy',
		'provenance' => '//provenance',
		'po_line' => '//po_line',
		'is_magnetic' => '//is_magnetic',
		'arrival_date' => '//arrival_date',
		'year_of_issue' => '//year_of_issue',
		'enumeration_a' => '//enumeration_a',
		'enumeration_b' => '//enumeration_b',
		'enumeration_c' => '//enumeration_c',
		'enumeration_d' => '//enumeration_d',
		'enumeration_e' => '//enumeration_e',
		'enumeration_f' => '//enumeration_f',
		'enumeration_g' => '//enumeration_g',
		'enumeration_h' => '//enumeration_h',
		'chronology_i' => '//chronology_i',
		'chronology_j' => '//chronology_j',
		'chronology_k' => '//chronology_k',
		'chronology_l' => '//chronology_l',
		'chronology_m' => '//chronology_m',
		'description' => '//description',
		'alternative_call_number' => '//alternative_call_number',
		'alternative_call_number_type' => '//alternative_call_number_type',
		'storage_location_id' => '//storage_location_id',
		'receiving_operator' => '//receiving_operator',
		'process_type' => '//process_type',
		'in_temp_location' => '//in_temp_location',
 		'mms_id' => '//mms_id',
		'holding_id' => '//holding_id',
		'title' => '//title',
		'call_number' => '//call_number',
		'pages' => '//pages',
		'pieces' => '//pieces',
		'public_note' => '//public_note',
		'fulfillment_note' => '//fulfillment_note',
		'internal_note_1' => '//internal_note_1',
		'internal_note_2' => '//internal_note_2',
		'internal_note_3' => '//internal_note_3',
		'statistics_note_1' => '//statistics_note_1',
		'statistics_note_2' => '//statistics_note_2',
		'statistics_note_3' => '//statistics_note_3',
		'requested' => '//requested',
		'physical_condition' => '//physical_condition',
		'temp_library' => '//temp_library',
		'temp_location' => '//temp_location',
		'copy_id' => '//copy_id',
	);

// {{{ loadFromAlma (get)
/**
 * @brief populates item record from Alma
 *
 * @param string $mms_id MMS ID of bib record
 * @param string $holding_id Holding ID of holding record
 * @param string $item_pid Item ID of item record
 */
	function loadFromAlma($mms_id,$holding_id,$item_pid) {
		global $grima;
		$this->xml = $grima->getItem($mms_id,$holding_id,$item_pid);
	}
// }}}

// {{{ loadFromAlmaX (get)
/**
 * @brief populates item record from Alma, only needs item_pid
 * @param string $item_pid item ID of record to load from Alma
 */
	function loadFromAlmaX($item_pid) {
		global $grima;
		$this->xml = $grima->getItem('X','X',$item_pid);
	}
// }}}

// {{{ loadFromAlmaBarcode (get)
/**
 * @brief populates item record from Alma, using barcode
 * @param string $barcode barcode of record to load from Alma
 */
	function loadFromAlmaBarcode($barcode) {
		global $grima;
		$this->xml = $grima->getItemBC($barcode);
	}
// }}}

// {{{ loadFromAlmaBCorX (get)
/**
 * @brief populates item record from Alma using either identifier
 *
 * @param string $id identifer of record to load from Alma (can be barcode
 * or item ID)
 */
	function loadFromAlmaBCorX($id) {
		global $grima;
		if (preg_match("/^23.*/",$id)) { # item_pid
			# probably should know about suffix too
			$this->loadFromAlmaX($id);
		} else {
			$this->loadFromAlmaBarcode($id);
		}
	}
// }}}

// {{{ loadFromItemListNode
/**
 * @brief populate item record from the information in an ItemList node
 *
 * @param DomNode $node node from an ItemList
 */
	function loadFromItemListNode($node) {
		$this->xml = new DomDocument();
		$this->xml->appendChild($this->xml->importNode($node,true));
	}
// }}}

// {{{ Item -> addToAlmaHolding (post)
/**
 * @brief add new item record to holding in Alma
 * @param string $mms_id MMS ID of bib record
 * @param string $holding_id Holding ID of holding record to add item to
 * @return DomDocument item object as it now appears in Alma
 */
	function addToAlmaHolding($mms_id,$holding_id) {
		global $grima;
		$this->mms_id = $mms_id;
		$this->holding_id = $holding_id;
		$this->xml = $grima->postItem($mms_id,$holding_id,$this->xml);
		return $this->xml;
	}
// }}}

	/*function scanin($mms_id,$holding_id,$item_pid) {
		global $grima;
		$this->mms_id = $mms_id;
		$this->holding_id = $holding_id;
		$this->item_id = $item_id;
		$grima->postinscan($mms_id,$holding_id,$item_pid);
	}*/

// {{{ Item -> addToAlmaHoldingNBC (post)--red 07/2020 DO NOT USE uneditable item record
/**
 * @brief add new item record to holding in Alma without barcode data
 * @param string $mms_id MMS ID of bib record
 * @param string $holding_id Holding ID of holding record to add item to
 * @return DomDocument item object as it now appears in Alma
 */
 	function addToAlmaHoldingNBC($mms_id, $holding_id) {
		global $grima;
		$body = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?' . '>
<item>
  <holding_data>
    <holding_id> ' . $holding_id . '</holding_id>
	<copy_id>0</copy_id>
	<in_temp_location>false</in_temp_location>
	<temp_library></temp_library>
    <temp_location></temp_location>
    <temp_call_number_type></temp_call_number_type>
    <temp_call_number></temp_call_number>
    <temp_policy></temp_policy>
    <due_back_date></due_back_date>
  </holding_data>
  <item_data>
    <physical_material_type desc="Book">BOOK</physical_material_type>
    <policy>book/ser</policy>
    <provenance></provenance>
    <po_line></po_line>
    <is_magnetic>false</is_magnetic>
    <arrival_date></arrival_date>
    <expected_arrival_date></expected_arrival_date>
    <year_of_issue></year_of_issue>
    <enumeration_a></enumeration_a>
    <enumeration_b></enumeration_b>
    <enumeration_c></enumeration_c>
    <enumeration_d></enumeration_d>
    <enumeration_e></enumeration_e>
    <enumeration_f></enumeration_f>
    <enumeration_g></enumeration_g>
    <enumeration_h></enumeration_h>
    <chronology_i></chronology_i>
    <chronology_j></chronology_j>
    <chronology_k></chronology_k>
    <chronology_l></chronology_l>
    <chronology_m></chronology_m>
    <description></description>
    <replacement_cost></replacement_cost>
    <receiving_operator>GRIMA</receiving_operator>
    <inventory_number></inventory_number>
    <inventory_date>2020-07-01</inventory_date>
    <inventory_price></inventory_price>
    <receive_number></receive_number>
    <weeding_number></weeding_number>
    <weeding_date></weeding_date>
    <alternative_call_number></alternative_call_number>
    <alternative_call_number_type></alternative_call_number_type>
    <alt_number_source></alt_number_source>
    <storage_location_id></storage_location_id>
    <pages></pages>
    <pieces>1</pieces>
    <public_note></public_note>
    <fulfillment_note></fulfillment_note>
    <internal_note_1></internal_note_1>
    <internal_note_2></internal_note_2>
    <internal_note_3></internal_note_3>
    <statistics_note_1></statistics_note_1>
    <statistics_note_2></statistics_note_2>
    <statistics_note_3></statistics_note_3>
    <physical_condition></physical_condition>
  </item_data>
</item>';
		
		$bodyxml = new DomDocument();
		$bodyxml->loadXML($body);
		$bodyxml = $grima->postItem($mms_id,$holding_id,$bodyxml);
		return $bodyxml;

		/*$ret = $this->post('/almaws/v1/bibs/{mms_id}/holdings/{holding_id}/items', array('mms_id' => $mms_id, 'holding_id' => $holding_id), $bodyxml);
		$this->checkForErrorMessage($ret);
		return $ret;*/

	}
	/*function addToAlmaHoldingNBC($mms_id,$holding_id) {
		global $grima;
		$this->mms_id = $mms_id;
		$this->holding_id = $holding_id;
		/*function removeBarcode() {
			$xpath = new DomXpath($this->xml);
			$xpath->query("//item_data/barcode");
			$xpath->removeNode = currNode.removeChild(currNode.childNodes[2]);
		}*/
		/*function removeBarcode() {
			$xpath = new DomXpath($this->xml);
			$xpath->query("//item_data/barcode");
			$xpath->parentNode->removeChild(barcode);
			/*foreach ($barcode as $barcode) {
				$barcode->parentNode->removeChild($barcode);
			}
			$xpath->setInnerXML( $elt, $xmlString );
			//appendInnerXML($elt, $xmlString );
		}
		$this->xml = $grima->postItemNBC($mms_id,$holding_id,$this->xml);
		return $this->xml;
	}
	
	function removeBarcode($barcode) {
		$xpath = new DomXpath($this->xml);
		$xpath->query("//item_data/barcode");
		$xpath->removeNode = currNode.removeChild(currNode.childNodes[2]);
		//$xpath->removeChild("//item_data/barcode")
		//$itemdatas = $xpath->query("//item_data");
		//$barcodes = $xpath->query("//item_data/barcode");
		//foreach ($itemdatas as $itemdata) {
		//	$itemdata->parentNode->removeChild($barcodes);
		//}
		//appendInnerXML($itemdatas);
		
		$this->xml = $grima->postItemNBC($mms_id,$holding_id,$this->xml);
		return $this->xml;
	}*/
		
// }}}

// {{{ updateAlma (put)
/**
 * @brief replace item record in Alma
 * @return DomDocument item object as it now appears in Alma
 */
	function updateAlma() {
		global $grima;
		return $grima->putItem(
			$this['mms_id'],
			$this['holding_id'],
			$this['item_pid'],
			$this->xml
		);
	}
// }}}

// {{{ updateAlma (put)
/**
 * @brief add an item record to an Alma Set
 * @return DomDocument item object as it now appears in Alma
 */

// {{{ addToAlmaSet (put)
/**
 * @brief add an item record to an Alma Set
 * @return DomDocument item object as it now appears in Alma
 */
	function addToAlmaSet($set_id,$barcode) {
		global $grima;
		$this->set_id = $set_id;
		$this->barcode = $barcode;
		$this->xml = $grima->postSetManageMembers($mms_id,$barcode,$this->xml);
		return $this->xml;
	}
	/*function updateAlma() {
		global $grima;
		return $grima->putSet(
			$this['set_id'],
			$this['barcode'],
			$this->xml
		);
	}*/
// }}}

// {{{ Item -> deleteFromAlma (delete)
/**
 * @brief delete record from Alma
 *
 * @param string $override should the item be deleted even if warnings exist? (default false)
 * @param string $holdings method for handling holdings record left with no items (retain, delete, suppress)
 */
	function deleteFromAlma($override = "false", $holdings = "retain") {
		global $grima;
		$grima->deleteItem($this['mms_id'],$this['holding_id'],$this['item_pid'],$override,$holdings);
	}
// }}}

}

// {{{ class Item
/** class Item */
class Item extends AlmaObject {

	public $el_address = array(
		'item_pid' => '//pid',
		'barcode' => '//barcode',
		'creation_date' => '//creation_date',
		'modification_date' => '//modification_date',
		'base_status' => '//base_status',
		'physical_material_type_code' => '//physical_material_type',
		'physical_material_type' => '//physical_material_type/@desc',
		'location' => '//location/@desc',
		'location_code' => '//location',
		'library' => '//library/@desc',
		'library_code' => '//library',
		'policy' => '//policy',
		'inventory_number' => '//inventory_number',
		'inventory_date_new_value' => '//inventory_date_new_value',
		'inventory_date' => '//inventory_date',
		'item_policy' => '//policy',
		'provenance' => '//provenance',
		'po_line' => '//po_line',
		'is_magnetic' => '//is_magnetic',
		'arrival_date' => '//arrival_date',
		'year_of_issue' => '//year_of_issue',
		'enumeration_a' => '//enumeration_a',
		'enumeration_b' => '//enumeration_b',
		'enumeration_c' => '//enumeration_c',
		'enumeration_d' => '//enumeration_d',
		'enumeration_e' => '//enumeration_e',
		'enumeration_f' => '//enumeration_f',
		'enumeration_g' => '//enumeration_g',
		'enumeration_h' => '//enumeration_h',
		'chronology_i' => '//chronology_i',
		'chronology_j' => '//chronology_j',
		'chronology_k' => '//chronology_k',
		'chronology_l' => '//chronology_l',
		'chronology_m' => '//chronology_m',
		'description' => '//description',
		'alternative_call_number' => '//alternative_call_number',
		'alternative_call_number_type' => '//alternative_call_number_type',
		'storage_location_id' => '//storage_location_id',
		'receiving_operator' => '//receiving_operator',
		'process_type' => '//process_type/@desc',
		'in_temp_location' => '//in_temp_location',
 		'mms_id' => '//mms_id',
		'holding_id' => '//holding_id',
		'title' => '//title',
		'call_number' => '//call_number',
		'pages' => '//pages',
		'pieces' => '//pieces',
		'public_note' => '//public_note',
		'fulfillment_note' => '//fulfillment_note',
		'internal_note_1' => '//internal_note_1',
		'internal_note_2' => '//internal_note_2',
		'internal_note_3' => '//internal_note_3',
		'statistics_note_1' => '//statistics_note_1',
		'statistics_note_2' => '//statistics_note_2',
		'statistics_note_3' => '//statistics_note_3',
		'requested' => '//requested',
		'physical_condition' => '//physical_condition',
		'temp_library' => '//temp_library',
		'temp_location' => '//temp_location',
		'temp_call_number_type' => '//temp_call_number_type',
		'temp_call_number' => '//temp_call_number',
		'temp_policy' => '//temp_policy',
		'due_back_date' => '//due_back_date',
		'alt_number_source' => '//alt_number_source',
		'copy_id' => '//copy_id',
		'additional_info' => '//additional_info',
	);

// {{{ getPIDFromBarcode (get) - gets the Holding ID from a barcode
/**
 * @brief populates the Holding ID
 *
*/
	public static function getHoldingIDFromBarcode($barcode) {
		global $grima;

		$report = new AnalyticsReport();
		$report->path = "/shared/Kansas State University/Reports/In progress - Raymond/GRIMA/BarcodeToHolding";
		$report->filter = '
<sawx:expr xsi:type="sawx:comparison" op="equal" xmlns:saw="com.siebel.analytics.web/report/v1.1" 
xmlns:sawx="com.siebel.analytics.web/expression/v1.1" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
xmlns:xsd="http://www.w3.org/2001/XMLSchema">
  <sawx:expr xsi:type="sawx:sqlExpression">"Physical Item Details"."Barcode"</sawx:expr><sawx:expr xsi:type="xsd:string">{barcode}</sawx:expr>
</sawx:expr>';
	
		$report->runReport(array('barcode' => $barcode), 1);
		if (count($report->rows) == 1) {
			return $report->rows[0][1];
		} else {
			return null;
		}
	}
// }}}

// {{{ getPIDFromBarcode (get) - gets the Item_PID from a barcode
/**
 * @brief populates the Item PID
 *
*/
	public static function getPIDFromBarcode($barcode) {
		global $grima;

		$report = new AnalyticsReport();
		$report->path = "/shared/Kansas State University/Reports/In progress - Raymond/GRIMA/BarcodeToPID";
		$report->filter = '
<sawx:expr xsi:type="sawx:comparison" op="equal" xmlns:saw="com.siebel.analytics.web/report/v1.1" 
xmlns:sawx="com.siebel.analytics.web/expression/v1.1" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
xmlns:xsd="http://www.w3.org/2001/XMLSchema">
  <sawx:expr xsi:type="sawx:sqlExpression">"Physical Item Details"."Barcode"</sawx:expr><sawx:expr xsi:type="xsd:string">{barcode}</sawx:expr>
</sawx:expr>';
	
		$report->runReport(array('barcode' => $barcode), 1);
		if (count($report->rows) == 1) {
			return $report->rows[0][1];
		} else {
			return null;
		}
	}
// }}}

// {{{ getPIDFromBarcode (get) - gets the Item_PID from a barcode
/**
 * @brief populates the Item PID
 *
*/
	public static function getMMSFromBarcode($barcode) {
		global $grima;

		$report = new AnalyticsReport();
		$report->path = "/shared/Kansas State University/Reports/In progress - Raymond/GRIMA/BarcodeToMMS";
		$report->filter = '
<sawx:expr xsi:type="sawx:comparison" op="equal" xmlns:saw="com.siebel.analytics.web/report/v1.1" 
xmlns:sawx="com.siebel.analytics.web/expression/v1.1" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
xmlns:xsd="http://www.w3.org/2001/XMLSchema">
  <sawx:expr xsi:type="sawx:sqlExpression">"Physical Item Details"."Barcode"</sawx:expr><sawx:expr xsi:type="xsd:string">{barcode}</sawx:expr>
</sawx:expr>';
	
		$report->runReport(array('barcode' => $barcode), 1);
		if (count($report->rows) == 1) {
			return $report->rows[0][1];
		} else {
			return null;
		}
	}
// }}}

// {{{ loadFromAlma (get)
/**
 * @brief populates item record from Alma
 *
 * @param string $mms_id MMS ID of bib record
 * @param string $holding_id Holding ID of holding record
 * @param string $item_pid Item ID of item record
 */
	function loadFromAlma($mms_id,$holding_id,$item_pid) {
		global $grima;
		$this->xml = $grima->getItem($mms_id,$holding_id,$item_pid);
	}
// }}}

// {{{ loadFromAlmaX (get)
/**
 * @brief populates item record from Alma, only needs item_pid
 * @param string $item_pid item ID of record to load from Alma
 */
	function loadFromAlmaX($item_pid) {
		global $grima;
		$this->xml = $grima->getItem('X','X',$item_pid);
	}
// }}}

// {{{ loadFromAlmaBarcode (get)
/**
 * @brief populates item record from Alma, using barcode
 * @param string $barcode barcode of record to load from Alma
 */
	function loadFromAlmaBarcode($barcode) {
		global $grima;
		$this->xml = $grima->getItemBC($barcode);
	}
// }}}

// {{{ loadFromAlmaBCorX (get)
/**
 * @brief populates item record from Alma using either identifier
 *
 * @param string $id identifer of record to load from Alma (can be barcode
 * or item ID)
 */
	function loadFromAlmaBCorX($id) {
		global $grima;
		if (preg_match("/^23.*/",$id)) { # item_pid
			# probably should know about suffix too
			$this->loadFromAlmaX($id);
		} else {
			$this->loadFromAlmaBarcode($id);
		}
	}
// }}}

// {{{ loadFromItemListNode
/**
 * @brief populate item record from the information in an ItemList node
 *
 * @param DomNode $node node from an ItemList
 */
	function loadFromItemListNode($node) {
		$this->xml = new DomDocument();
		$this->xml->appendChild($this->xml->importNode($node,true));
	}
// }}}

// {{{Item -> addInventoryDate--red 07/2020
/**
 * @brief addes Inventory date to the Item record xml
 * @param Inventory Date
 */
	function addInventoryDate($date) {
		$xpath = new DomXpath($this->xml);
		$idates = $xpath->query("//item_data");
	
		foreach ($idates as $idate){
			$idate = $this->xml->createElement("inventory_date");
			$idate->appendChild($this->xml->createTextNode($date));
			$idates[0]->appendChild($idate);
		}
	}
	
	/*function InternalNote1() {
		$xpath = new DomXpath($this->xml);
		$notes = $xpath->query("//item_data/internal_note_1");
		
		foreach ($notes as $note){
			if (isset(nodeValue)){
				$note->substr_replace(nodeValue,'Gov unboxing review--',21);
			}
			$notes[0]->appendchild($note);
		}*/
// }}}

// {{{Item -> changeItemLibrary($library_code, $library)--red 07/2020
/**
 * @brie changes the Physical Item's location from the Item Record
 * @parm library and library code
 */
	/*function changeItemLibrary($library_code, $library) {
		$xpath = new DomXpath ($this-xml);
		$ilibraries = $xpath->query("//item_data/library[@desc='$library']");
		
		foreach ($ilibraries as $ilibrary) {
			$ilibrary->appendField($library_code, $library);
			$ilibraries[0]->appendChild($ilibrary);
		}
	}*/
// }}}

// {{{Item -> changeItemLocation($location_code, $location)--red 07/2020
/**
 * @brie changes the Physical Item's location from the Item Record
 * @parm location and location code
 */
	/*function changeItemLocation($location_code, $location) {
		$xpath = new DomXpath ($this-xml);
		$ilocations = $xpath->query("//item_data/location[@desc='$location']");
		
		foreach ($ilocations as $ilocation) {
			$ilocation->appendField($location_code, $location);
			$ilocations[0]->appendChild($ilocation);
		}
	}*/
// }}}

// {{{ Item -> addToAlmaHolding (post)
/**
 * @brief add new item record to holding in Alma
 * @param string $mms_id MMS ID of bib record
 * @param string $holding_id Holding ID of holding record to add item to
 * @return DomDocument item object as it now appears in Alma
 */
	function addToAlmaHolding($mms_id,$holding_id) {
		global $grima;
		$this->mms_id = $mms_id;
		$this->holding_id = $holding_id;
		$this->xml = $grima->postItem($mms_id,$holding_id,$this->xml);
		return $this->xml;
	}
// }}}

// {{{ Item -> fulfillmentscan (postScan)
/**
 * @brief Scan an Item into Fulfillment Scan In Alma
 * @param string $mms_id MMS ID of bib record
 * @param string $holding_id Holding ID of holding record
 * @param string $item_pid Item PID of item record
 * @return Curl Response
 */
	function fulfillmentscan($mms_id,$holding_id,$item_pid,$op,$library,$circ_desk,$work_order_type,$status,$done,$place_on_hold_shelf,$register_in_house_use) {
		global $grima;
		$this->mms_id = $mms_id;
		$this->holding_id = $holding_id;
		$this->item_pid = $item_pid;
		$this->op = $op;
		$this->library = $library;
		$this->circ_desk = $circ_desk;
		$this->work_order_type = $work_order_type;
		$this->status = $status;
		$this->done = $done;
		$this->place_on_hold_shelf = $place_on_hold_shelf;
		$this->register_in_house_use = $register_in_house_use;
		$this->xml = $grima->postScan($mms_id,$holding_id,$item_pid,$op,$library,$circ_desk,$work_order_type,$status,$done,$place_on_hold_shelf,$register_in_house_use);
		return $this->xml;
	}

// }}}

// {{{ Item -> acqworkscan (postScan)
/**
 * @brief Scan an Item into Fulfillment Scan In Alma
 * @param string $mms_id MMS ID of bib record
 * @param string $holding_id Holding ID of holding record
 * @param string $item_pid Item PID of item record
 * @return Curl Response
 */
function acqworkscan($mms_id,$holding_id,$item_pid,$op,$library,$department,$work_order_type,$status,$done) {
	global $grima;
	$this->mms_id = $mms_id;
	$this->holding_id = $holding_id;
	$this->item_pid = $item_pid;
	$this->op = $op;
	$this->library = $library;
	$this->department = $department;
	$this->work_order_type = $work_order_type;
	$this->status = $status;
	$this->done = $done;
	$this->xml = $grima->postScanacq($mms_id,$holding_id,$item_pid,$op,$library,$department,$work_order_type,$status,$done);
	return $this->xml;
}

// }}}

// {{{ Item -> addToAlmaHoldingNBC (post)--red 07/2020 DO NOT USE uneditable item record
/**
 * @brief add new item record to holding in Alma without barcode data
 * @param string $mms_id MMS ID of bib record
 * @param string $holding_id Holding ID of holding record to add item to
 * @return DomDocument item object as it now appears in Alma
 */
 	/*function addToAlmaHoldingNBC($mms_id, $holding_id) {
		global $grima;
		$body = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?' . '>
<item>
  <holding_data>
    <holding_id> ' . $holding_id . '</holding_id>
	<copy_id>0</copy_id>
	<in_temp_location>false</in_temp_location>
	<temp_library></temp_library>
    <temp_location></temp_location>
    <temp_call_number_type></temp_call_number_type>
    <temp_call_number></temp_call_number>
    <temp_policy></temp_policy>
    <due_back_date></due_back_date>
  </holding_data>
  <item_data>
    <physical_material_type desc="Book">BOOK</physical_material_type>
    <policy>book/ser</policy>
    <provenance></provenance>
    <po_line></po_line>
    <is_magnetic>false</is_magnetic>
    <arrival_date></arrival_date>
    <expected_arrival_date></expected_arrival_date>
    <year_of_issue></year_of_issue>
    <enumeration_a></enumeration_a>
    <enumeration_b></enumeration_b>
    <enumeration_c></enumeration_c>
    <enumeration_d></enumeration_d>
    <enumeration_e></enumeration_e>
    <enumeration_f></enumeration_f>
    <enumeration_g></enumeration_g>
    <enumeration_h></enumeration_h>
    <chronology_i></chronology_i>
    <chronology_j></chronology_j>
    <chronology_k></chronology_k>
    <chronology_l></chronology_l>
    <chronology_m></chronology_m>
    <description></description>
    <replacement_cost></replacement_cost>
    <receiving_operator>GRIMA</receiving_operator>
    <inventory_number></inventory_number>
    <inventory_date>2020-07-01</inventory_date>
    <inventory_price></inventory_price>
    <receive_number></receive_number>
    <weeding_number></weeding_number>
    <weeding_date></weeding_date>
    <alternative_call_number></alternative_call_number>
    <alternative_call_number_type></alternative_call_number_type>
    <alt_number_source></alt_number_source>
    <storage_location_id></storage_location_id>
    <pages></pages>
    <pieces>1</pieces>
    <public_note></public_note>
    <fulfillment_note></fulfillment_note>
    <internal_note_1></internal_note_1>
    <internal_note_2></internal_note_2>
    <internal_note_3></internal_note_3>
    <statistics_note_1></statistics_note_1>
    <statistics_note_2></statistics_note_2>
    <statistics_note_3></statistics_note_3>
    <physical_condition></physical_condition>
  </item_data>
</item>';
		
		$bodyxml = new DomDocument();
		$bodyxml->loadXML($body);
		$bodyxml = $grima->postItem($mms_id,$holding_id,$bodyxml);
		return $bodyxml;

		/*$ret = $this->post('/almaws/v1/bibs/{mms_id}/holdings/{holding_id}/items', array('mms_id' => $mms_id, 'holding_id' => $holding_id), $bodyxml);
		$this->checkForErrorMessage($ret);
		return $ret;

	}*/
	/*function addToAlmaHoldingNBC($mms_id,$holding_id) {
		global $grima;
		$this->mms_id = $mms_id;
		$this->holding_id = $holding_id;
		/*function removeBarcode() {
			$xpath = new DomXpath($this->xml);
			$xpath->query("//item_data/barcode");
			$xpath->removeNode = currNode.removeChild(currNode.childNodes[2]);
		}*/
		/*function removeBarcode() {
			$xpath = new DomXpath($this->xml);
			$xpath->query("//item_data/barcode");
			$xpath->parentNode->removeChild(barcode);
			/*foreach ($barcode as $barcode) {
				$barcode->parentNode->removeChild($barcode);
			}
			$xpath->setInnerXML( $elt, $xmlString );
			//appendInnerXML($elt, $xmlString );
		}
		$this->xml = $grima->postItemNBC($mms_id,$holding_id,$this->xml);
		return $this->xml;
	}
	
	function removeBarcode($barcode) {
		$xpath = new DomXpath($this->xml);
		$xpath->query("//item_data/barcode");
		$xpath->removeNode = currNode.removeChild(currNode.childNodes[2]);
		//$xpath->removeChild("//item_data/barcode")
		//$itemdatas = $xpath->query("//item_data");
		//$barcodes = $xpath->query("//item_data/barcode");
		//foreach ($itemdatas as $itemdata) {
		//	$itemdata->parentNode->removeChild($barcodes);
		//}
		//appendInnerXML($itemdatas);
		
		$this->xml = $grima->postItemNBC($mms_id,$holding_id,$this->xml);
		return $this->xml;
	}*/
		
// }}}

// {{{ updateAlma (put)
/**
 * @brief replace item record in Alma
 * @return DomDocument item object as it now appears in Alma
 */
	function updateAlma() {
		global $grima;
		return $grima->putItem(
			$this['mms_id'],
			$this['holding_id'],
			$this['item_pid'],
			$this->xml
		);
	}
//updateAlma (put) set
	function addToAlmaSet($set_id,$barcode) {
		global $grima;
		$this->set_id = $set_id;
		$this->barcode = $barcode;
		$this->xml = $grima->postSetManageMembers($mms_id,$barcode,$this->xml);
		return $this->xml;
	}
	/*function updateAlma() {
		global $grima;
		return $grima->putSet(
			$this['set_id'],
			$this['barcode'],
			$this->xml
		);
	}*/
// }}}

// {{{ Item -> deleteFromAlma (delete)
/**
 * @brief delete record from Alma
 *
 * @param string $override should the item be deleted even if warnings exist? (default false)
 * @param string $holdings method for handling holdings record left with no items (retain, delete, suppress)
 */
	function deleteFromAlma($override = "false", $holdings = "retain") {
		global $grima;
		$grima->deleteItem($this['mms_id'],$this['holding_id'],$this['item_pid'],$override,$holdings);
	}
// }}}

}

// }}}

// {{{ class AddtionalInfo
/** class AdditionalInfo */

class AdditionalInfo extends AlmaObject {
	public $items = array();
	public $xml;
}
// }}}

// {{{ class ElectronicCollection
/** class ElectronicCollection */
class ElectronicCollection extends AlmaObject {

	public $xml;
	public $services = array();


// {{{ ElectronicCollection -> el_address
	public $el_address = array(
		'collection_id' => '//id',
		'id' => '//id',
	);
// }}}

// {{{ ElectronicCollection -> loadFromAlma (get)
/**
 * @brief load record from Alma
 *
 */
	function loadFromAlma($collection_id) {
		global $grima;
		$this->xml = $grima->getElectronicCollection($collection_id);
		#$this['collection_id'] = $collection_id;
	}
// }}}

// {{{ ElectronicCollection ->
/**
 * @brief load record from Alma
 *
 */
	function getServices() {
		global $grima;
		$ret = $grima->getElectronicServices($this['collection_id']);
		$xpath = new DomXpath($ret);
		$eservices = $xpath->query('//electronic_services/electronic_service');
		foreach ($eservices as $service) {
			$service_id = $service->firstChild->nodeValue; # XXX really?
			$ser = new ElectronicService();
			$ser->loadFromServiceListNode($service);
			$this->services[] = $ser;
		}
	}
// }}}

}

// }}}

// {{{ class ElectronicService
/** class ElectronicService */
class ElectronicService extends AlmaObject {
	public $number_of_portfolios;

	public $portfolios = array();

	public $el_address = array(
		'id' => '//id',
		'service_id' => '//id',
	);

	public $el_override = array();

	function __construct() {
		# load from template
	}

	function offsetSet($offset,$value) {
		if ($offset == "collection_id") {
			$this->el_override['collection_id'] = $value;
		} else {
			parent::offsetSet($offset,$value);
		}
	}

// {{{ ElectronicService -> loadFromAlma (get)
/**
 * @brief load record from Alma
 *
 */
	function loadFromAlma($collection_id,$service_id) {
		global $grima;
		$this->xml = $grima->getElectronicService($collection_id,$service_id);
		$this['collection_id'] = $collection_id;
	}
// }}}

// {{{ ElectronicService -> loadFromServiceListNode
/**
 * @brief populate item record from the information in an ServiceList node
 *
 * @param DomNode $node node from an ItemList
 */
	function loadFromServiceListNode($node) {
		$this->xml = new DomDocument();
		$this->xml->appendChild($this->xml->importNode($node,true));
		$xpath = new DomXPath($this->xml);
		$service_link = $xpath->query('//electronic_service')->item(0)->attributes['link']->nodeValue;
		preg_match('!/e-collections/(.*)/e-services/!',$service_link,$m);
		$this['collection_id'] = $m[1];
	}

	function retrieveAllPortfolios() {
		$curr_offset = 0;
		do {
			$retrieved = $this->getPortfolios(100, $curr_offset);
			$curr_offset += 100;
		} while ($retrieved == 100);
	}

// {{{ ElectronicService -> getPortfolios
/**
 * @brief get list of portfolios from Alma
 *
 * @param Int $limit max to download (default 10, max 100)
 * @param Int $offset starting point in list for download
 * @return Int number of portfolios retrieved
 */
	/* mark full or brief? */
	#function retrievePortfolios($limit = 10, $offset = 0) { # RENAME
	function getPortfolios($limit = 10, $offset = 0) {
		global $grima;
		$ret = $grima->getElectronicPortfoliosForService($this['collection_id'],$this['service_id'],$limit,$offset);
		$xpath = new DOMXpath($ret);
		$ports = $xpath->query('//portfolio');
		foreach ($ports as $portnode) {
			$newport = new ElectronicPortfolio();
			$newport->loadFromPortfolioListNode($portnode);
			$this->portfolios[] = $newport;
		}
		return count($ports);
	}

// }}}

// {{{ ElectronicService -> deleteAllPortfolios - delete all portfolios from the bib
/**
 * @brief delete all portfolios from the service
 *
 * @param string $bib_treat - for bibs with no inventory, "retain" or "delete"
 */
	function deleteAllPortfolios($bib_treat) {
		global $grima;
		while ($this->getPortfolios(100,0)) {
			foreach($this->portfolios as $portfolio) {
				$portfolio->deleteFromAlma($bib_treat);
			}
			$this->portfolios = array();
			sleep(2);
		}
	}
// }}}

/*
	function deleteAllPortfolios() { #XXX
		global $grima;
		# get portfolio list? or just ten at a time?
		$this->retrievePortfolios();
		while (sizeof($this->portfolios) > 0) {
			foreach ($this->portfolios as $portfolio) {
			print $portfolio['mms_id']->nodeValue; exit;
				#$portfolio->delete();
			}
		}
	}
*/

}

//}}}
/**@}*/
//}}}

//{{{ class ElectronicPortfolio
/** class ElectronicPortfolio */

class ElectronicPortfolio extends AlmaObject {
	public $xml;

// {{{ ElectronicPortfolio -> el_address
	public $el_address = array(
		'portfolio_id' => '//portfolio/id',
		'is_local' => '//is_local',
		'is_standalone' => '//is_standalone',
		'mms_id' => '//mms_id',
		'title' => '//title',
		'service' => '//service',
		'url' => '//url',
		'static_url' => '//static_url',
		'availability' => '//availability',
		'collection_id' => '//electronic_collection/id',
		'service_id' => '//electronic_collection/service',
		'material_type' => '//material_type',
		'url_type' => '//url_type',
		'public_note' => '//public_note'
	);
// }}}

// {{{ ElectronicPortfolio -> addToAlmaService
/**
 * @brief populate item record from the information in an PortfolioList node
 * @XXX: Insufficient permission
 *
 * @param DomNode $node node from a PortfolioList
 */
	function addToAlmaService($collection_id,$service_id) {
		global $grima;
		$ret = $grima->postElectronicPortfolio($collection_id, $service_id, $this->xml);
		return $ret;
	}
// }}}

// {{{ ElectronicPortfolio -> addToAlmaBib
/**
 * @brief add portfolio to Bib in Alma
 * @XXX: Insufficient permission
 *
 * @param Int $mms_id - id of bib to add portfolio to
 * @return DomDocument portfolio as it now appears in Alma
 */
	function addToAlmaBib($mms_id) {
		global $grima;
		$ret = $grima->postElectronicPortfolioOnBib($mms_id, $this->xml);
		return $ret;
	}
// }}}

// {{{ ElectronicPortfolio -> loadFromAlma
/**
 * @brief populate portfolio with info from Alma
 *
 * @param Int $portfolo_id - id of portfolio to pull from Alma
 */
	function loadFromAlma($portfolio_id) {
		global $grima;
		$this->xml = $grima->getElectronicPortfolio('X','X',$portfolio_id);
	}

	function loadFromAlmaX($portfolio_id) {
		global $grima;
		$this->xml = $grima->getElectronicPortfolio('X','X',$portfolio_id);
	}
// }}}

// {{{ ElectronicPortfolio -> loadFromPortfolioListNode
/**
 * @brief populate item record from the information in an PortfolioList node
 *
 * @param DomNode $node node from a PortfolioList
 */
	function loadFromPortfolioListNode($node) {
		$this->xml = new DomDocument();
		$this->xml->appendChild($this->xml->importNode($node,true));
	}
// }}}

// {{{ ElectronicPortfolio -> updateAlma 
/**
 * @brief replaces the Portfolio in Alma
 */
	function updateAlma() {
		global $grima;
		$this->xml = $grima->putElectronicPortfolioOnBib($this['mms_id'],$this['portfolio_id'],$this->xml);
	}
// }}}

// {{{ ElectronicPortfolio -> deleteFromAlma
/**
 * @param string bib_treat - for bibs with no inventory "retain" or "delete"
 *
 * @brief delete portfolio from Alma
 */
	function deleteFromAlma($bib_treat = "retain") {	# accept a variable?
		global $grima;
		$mms_id = $this['mms_id'];
		$grima->deleteElectronicPortfolio('X','X',
			$this['portfolio_id']);
		if ($bib_treat == "delete") {
			$bib = new Bib();
			$bib->loadFromAlma($mms_id);
			sleep(2);
			if (! $bib->hasInventory()) {
				if ($bib->linkedToCZ()) {
					print "LINKED TO CZ";
					$bib->unlinkFromCZ();
					exit;
				} else {
					$bib->deleteFromAlma();
				}
			}
		}
	}
// }}}

}

// }}}

// {{{ class Job
/** class Job IN PROGRESS */
class Job extends AlmaObject {
	public $xml;
	public $job_id = array();


// {{{ Job -> el_address
	public $el_address = array(
		'job_id' => '//job/id',
		'op' => '//job/op',
		'additional_info' => '//job/additional_info',
		);
// }}}

// {{{ Job -> runAlmaJob
/**
* @brief Run an Alma Job on a defined Alma Set
*/
	function runAlmaJob($job_id,$op) {
		global $grima;
		$this->job_id = $job_id;
		$this->op = $op;
		$this->xml = $grima->postJob($job_id,$op);
		return $this->xml;
	}

// }}}
}
// }}}

// }}}

// {{{ class Set
/** class Set IN PROGRESS */
class Set extends AlmaObject {
	public $xml;
	public $members = array();

	/*
	public $id;
	public $type; # itemized or logical
	public $name;
	public $private;
	public $active;
	public $size; # number of members
	*/

// {{{ Set -> el_address
	public $el_address = array(
		'set_id' => '//set/id',
		'id' => '//set/id',
	);
// }}}

	function createFromImport($job_id,$population) {
		global $grima;
		$this->xml = $grima->createSetFromImport($job_id,$population);
	}

	function createSet($name){
		global $grima;
		$this->xml = $grima->createSet($name);
	}

	/*function getSetIDifNeeded(){
		global $grima;

		if (!isset($this['setName'])
		or (!$this['setName'])) {
			$this['setName'] = Set::postSetManageMembers($this['set_id']);
		}
	}*/

// {{{ Set -> loadFromAlma
/**
 * @brief populate set with info from Alma
 *
 * @param Int $set_id - id of set to pull from Alma
 */
	function loadFromAlma($set_id) {
		global $grima;
		$this->xml = $grima->getSet($set_id);
	}
// }}}

	function getMembers($limit = -1) { # put in $members
		# limit -1 means all
		global $grima;
		if ($limit == -1) { # get them all
			$xml = $grima->getSetMembers($this['set_id'],0);
			$xpath = new DomXpath($xml);
			$this->size = $xpath->query("//members")->item(0)->getAttribute("total_record_count");
			$limit = $this->size;
		}

		for ($j = 0; $j < ceil($limit/100); $j++) { # how many queries
			$xml = $grima->getSetMembers($this['id'],100,$j*100);
			$xpath = new DomXpath($xml);
			foreach ($xpath->query("//member") as $member) {
				$this->members[] = new SetMember(
					$member->childNodes[0]->nodeValue,
					$member->childNodes[1]->nodeValue
				);
			}
		}
	}

// {{{ Set -> deleteFromAlma (delete)
/**
 * @brief delete set from Alma
 *
 */
	function deleteFromAlma() {
		global $grima;
		$grima->deleteSet($this['set_id']);
	}
// }}}

	function addMember($mms_id) {
		global $grima;
	}

	function deleteAllMembers() {
		global $grima;
	}

}

// }}}

// {{{ class SetMember
/** class SetMember */
class SetMember {
	public $id;
	public $description;

	function __construct($id,$description) {
		$this->id = $id;
		$this->description = $description;
	}
}

// }}}

// {{{ class Library
/** class Library */
class Library extends AlmaObject {
	public $el_address = array(
		'code' => '//code',
		'path' => '//path',
		'name' => '//name',
		'resource_sharing' => '//resource_sharing',
	);

// {{{ Library -> loadFromAlma
/**
 * @brief populate library with info from Alma
 *
 * @param String $code - code of library to pull from Alma
 */
	function loadFromAlma($code) {
		global $grima;
		$this->xml = $grima->getLibrary($code);
	}
// }}}

}

// }}}

// {{{ class Location
/** class Location */
class Location extends AlmaObject {
	public $el_address = array(
		'code' => '//code',
		'name' => '//name',
	);

// {{{ Location -> loadFromAlma
/**
 * @brief populate location with info from Alma
 *
 * @param String $code - code of location to pull from Alma
 */
	function loadFromAlma($libraryCode,$locationCode) {
		global $grima;
		$this->xml = $grima->getLocation($libraryCode, $locationCode);
	}
// }}}

}

// }}}

// {{{ class AnalyticsReport
/** class AnalyticsReport */
class AnalyticsReport extends AlmaObject {

public $path;
public $filter;
public $reportXml;
public $rows = array();

// {{{ AnalyticsReport -> runReport
/**
 * @brief pull Analytics report from Alma
 *
 * @param String $code - code of location to pull from Alma
 */
	function runReport($filter_params=array(), $limit = -1, $token = "") {
		global $grima;
		if (isset($this->filter)) {
			$passfilter = $this->filter;
			foreach ($filter_params as $k => $v) {
				$passfilter = str_replace('{'.$k.'}',urlencode($v),$passfilter);
			}
		} else {
			$passfilter = null;
		}
 
		if ($limit == -1) { $limit = 1000; } # no limit
		if ($limit < 25) { $limit = 25; } # must be in chunks of 25
		$this->reportXml = $grima->getAnalytics($this->path, $passfilter, $limit, $token);

		$xpath = new DomXpath($this->reportXml);
		$xpath->registerNamespace("x", "urn:schemas-microsoft-com:xml-analysis:rowset");

		$rows = $xpath->query('//x:Row');
		foreach ($rows as $row) {
			$newrow = array();
			$cols = $xpath->query("./*[contains(name(),'Column')]", $row);
			foreach ($cols as $col) {
				$newrow[] = $col->nodeValue;
			}
			$this->rows[] = $newrow;
		}

	}

// }}}


}

// }}}

// {{{ class GrimaDB

// {{{ shared
function tableExists($pdo, $table) {
	$table_esc = "\"" . preg_replace( "/\"/", "\"\"", $table ) . "\"";
	try {
		$result = $pdo->query("SELECT 1 FROM $table_esc LIMIT 1");
	} catch (Exception $e) {
		// We got an exception == table not found
		return FALSE;
	}
	// Result is either boolean FALSE (no table found) or PDOStatement Object (table found)
	return $result !== FALSE;
}

// }}}

// {{{ class GrimaDB
/** @class GrimaDB
 *	@brief Shared access to the database for GrimaUser and GrimaInstitution
 *
 */
class GrimaDB implements ArrayAccess, IteratorAggregate {
	static function init() {
		try {
			$db = self::getDb();
			if (!tableExists($db,"institutions")) {
				$db->exec("CREATE TABLE institutions ( institution VARCHAR(100) PRIMARY KEY, apikey VARCHAR(100), server VARCHAR(100) )");
			}
			if (!tableExists($db,"users")) {
				$db->exec("CREATE TABLE users ( institution VARCHAR(100), username VARCHAR(100), password VARCHAR(255), isAdmin BOOLEAN )");
			}
			return true;
		} catch(Exception $x) {
			# create the database
			return false;
		}
	}
	static function isEmpty() {
		self::init();
		$db = self::getDb();
		$result = $db->query( 'SELECT COUNT(*) as c FROM institutions' );
		foreach( $result as $row ) {
			if ($row['c']>0) return false;
		}
		return true;
	}

	protected static function getDb() {
		if (!self::$db) {
			$db_url = getenv('DATABASE_URL');
			if (!$db_url) $db_url = "sqlite:" . join_paths( sys_get_temp_dir(), "krima/grima.sql");
			self::$db = new PDO($db_url);
		}
		return self::$db;
	}
	protected function getPasswordAlgorithm() {
		return defined("PASSWORD_ARGON2I") ? constant("PASSWORD_ARGON2I") : PASSWORD_DEFAULT;
	}

	private static $db = FALSE;
	private $info;		// array

	function offsetExists($offset) {
		return isset($this->info[$offset]);
	}

	function offsetGet($offset) {
		return isset($this->info[$offset]) ? $this->info[$offset] : '';
	}

	function offsetSet($offset,$value) {
		$this->info[$offset] = $value;
	}

	function offsetUnset($offset) {
		unset($this->info[$offset]);
	}

	function getIterator() {
		return new ArrayIterator($this->info);
	}

}

// }}}

// {{{ class GrimaInstitution
/** @class GrimaInstitution
 ** @brief Interface to the GrimaDB database to retrieve API keys
 **/
class GrimaInstitution extends GrimaDB {
	public function addToDB() {
		$db = $this->getDb();
		$query = $db->prepare( 'INSERT INTO institutions(institution,apikey,server) VALUES (:institution,:apikey,:server)' );
		if (!$query) {
			$errorCode = $db->errorCode();
			$errorInfo = $db->errorInfo();
			throw new Exception(
				"Could not even prepare to insert into institution database: [$errorCode] {$errorInfo[0]} {$errorInfo[2]}"
			);
		}
		$success = $query->execute( array(
			'institution' => $this['institution'],
			'apikey' => $this['apikey'],
			'server' => $this['server'],
		) );
		if (!$success) {
			$errorCode = $query->errorCode();
			$errorInfo = $query->errorInfo();
			throw new Exception(
				"Could not insert into user database: [$errorCode] {$errorInfo[0]} {$errorInfo[2]}"
			);
		}
	}
}

// }}}

// {{{ class GrimaUser
/** @class GrimaUser
 ** @brief Interface to the GrimaDB database to check password and get institution's apikey
 **/
class GrimaUser extends GrimaDB {
	public static function FromArray( $data ) {
		$user = new GrimaUser();
		foreach ( $data as $key => $val ) {
			$user[$key] = $val;
		}
		return $user;
	}

	public static function LookupUser($username, $institution = '', $password = FALSE) {
		$db = self::getDb();
		$query = $db->prepare(
			'SELECT * ' .
			'FROM institutions NATURAL JOIN users '.
			'WHERE institution=:institution '.
			'AND username=:username'
		);
		$success = $query->execute( array(
			'institution' => $institution,
			'username' => $username,
		) );
		if ($success) {
			$row = $query->fetch(PDO::FETCH_ASSOC);
			if ($row===false) return false;
			$user = GrimaUser::FromArray( $row );
			if ( ($password !== FALSE) && ($user['password']!='') ) {
				if ( !password_verify( $password, $user['password'] ) ) return false;
				if ( password_needs_rehash( $user['password'], $user->getPasswordAlgorithm() ) ) {
					$user['password'] = $password;
					$user->updateDB();
				}
			}
			unset( $user['password'] );
			return $user;
		} else {
			$errorCode = $query->errorCode();
			$errorInfo = $query->errorInfo();
			throw new Exception(
				"Could not select from user database: [$errorCode] {$errorInfo[0]} {$errorInfo[2]}"
			);
		}
	}

	public static function RenameUser( $username, $institution, $newusername ) {
		$db = self::getDb();
		$query = $db->prepare(
			'UPDATE users ' .
			'SET username=:newusername ' .
			'WHERE institution=:institution '.
			'AND username=:username'
		);
		$success = $query->execute( array(
			'institution'	=> $institution,
			'username'		=> $username,
			'newusername'	=> $newusername,
		) );
		if ($success) {
			return true;
		} else {
			$errorCode = $query->errorCode();
			$errorInfo = $query->errorInfo();
			throw new Exception(
				"Could not update user database: [$errorCode] {$errorInfo[0]} {$errorInfo[2]}"
			);
		}
	}

	public static function ResetPassword( $username, $institution, $password ) {
		$db = self::getDb();
		$query = $db->prepare(
			'UPDATE users ' .
			'SET password=:password ' .
			'WHERE institution=:institution '.
			'AND username=:username'
		);
		$passwordHash = password_hash( $password, self::getPasswordAlgorithm() );
		$success = $query->execute( array(
			'institution'	=> $institution,
			'username'		=> $username,
			'password'		=> $passwordHash,
		) );
		if ($success) {
			return true;
		} else {
			$errorCode = $query->errorCode();
			$errorInfo = $query->errorInfo();
			throw new Exception(
				"Could not update user database: [$errorCode] {$errorInfo[0]} {$errorInfo[2]}"
			);
		}
	}

	public static function GetCurrentUser() {
		global $grima;
		$grima->session_init();
		session_write_close();
		if (!isset($_SESSION)) return false;
		return GrimaUser::FromArray( $_SESSION );
	}

	public static function SetCurrentUser( $username, $password, $institution = '' ) {
		global $grima;
		$user = GrimaUser::LookupUser( $username, $institution, $password );
		if ( $user !== false ) {
			if (isset($_SESSION)) {
				session_write_close();
				session_start();
			}
			$grima->session_save($user);
		} else {
			return false;
		}
	}

	function addToDB() {
		$db = $this->getDb();
		$query = $db->prepare( 'INSERT INTO users( username, password, institution, isAdmin ) VALUES (:username, :password, :institution, :isAdmin)' );
		if (!$query) {
			$errorCode = $db->errorCode();
			$errorInfo = $db->errorInfo();
			throw new Exception(
				"Could not even prepare to insert into user database: [$errorCode] {$errorInfo[0]} {$errorInfo[2]}"
			);
		}
		$success = $query->execute( array(
			'username' => $this['username'],
			'password' => password_hash( $this['password'], $this->getPasswordAlgorithm() ),
			'institution' => $this['institution'],
			'isAdmin' => $this['isAdmin'],
		) );
		if (!$success) {
			$errorCode = $query->errorCode();
			$errorInfo = $query->errorInfo();
			throw new Exception(
				"Could not insert into user database: [$errorCode] {$errorInfo[0]} {$errorInfo[2]}"
			);
		}
	}

	function updateDB() {
		$db = $this->getDb();
		$query = $db->prepare( 'UPDATE users SET isAdmin=:isAdmin, password=:password WHERE username=:username AND institution=:institution' );
		if (!$query) {
			$errorCode = $db->errorCode();
			$errorInfo = $db->errorInfo();
			throw new Exception(
				"Could not even prepare to update user database: [$errorCode] {$errorInfo[0]} {$errorInfo[2]}"
			);
		}
		$success = $query->execute( array(
			'username'	=> $this['username'],
			'password'	=> password_hash( $this['password'], $this->getPasswordAlgorithm() ),
			'institution' => $this['institution'],
			'isAdmin'	=> $this['isAdmin'],
		) );
		if (!$success) {
			$errorCode = $query->errorCode();
			$errorInfo = $query->errorInfo();
			throw new Exception(
				"Could not update user database: [$errorCode] {$errorInfo[0]} {$errorInfo[2]}"
			);
		}
	}

	function deleteFromDB() {
		$db = $this->getDb();
		$query = $db->prepare( 'DELETE FROM users WHERE username=:username AND institution=:institution' );
		if (!$query) {
			$errorCode = $db->errorCode();
			$errorInfo = $db->errorInfo();
			throw new Exception(
				"Could not even prepare to delete from user database: [$errorCode] {$errorInfo[0]} {$errorInfo[2]}"
			);
		}
		$success = $query->execute( array(
			'username' => $this['username'],
			'institution' => $this['institution'],
		) );
		if (!$success) {
			$errorCode = $query->errorCode();
			$errorInfo = $query->errorInfo();
			throw new Exception(
				"Could not delete from user database: [$errorCode] {$errorInfo[0]} {$errorInfo[2]}"
			);
		}
	}
}

// }}}

// }}}

/* vim: set foldmethod=marker noexpandtab shiftwidth=4 tabstop=4: */
