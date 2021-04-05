<?php
/**
*Title: serverAuthentication.php
*Description: This script is used connect Woocoomerce REST API.
*@author Joao Fagner, Sergio Gomes, Daniel Souza <daniel.souza@diletec.com.br>
*Version: 2.0.0
*WC REST API: v1 e v2
*WC Version:	2.6.x or later
*WP Version: 4.8 or later
*Requirements: http://woothemes.github.io/woocommerce-rest-api-docs/
*/

/*Faz bloqueio de execução, se um insert demorar ele não permite o cadastro duplicado de dados*/

require_once('look/trateIntegracao.class.php');
require __DIR__ . '/config/autoloader.php';
//require __DIR__ . '/vendor/autoload.php';
require_once('cURLRequest.php');

use Automattic\WooCommerce\Client;

/**
 * Define Server URL API Path to Pebbian Server
 * This URL need to be provided by the Pebbian ERP manager
*/
error_reporting(E_ALL);
ini_set('display_errors', 1);


/**Link para o webservice do cliente e seus dados de conexão*/
define('PEBBIAN_SERVER_PATH', 'https://pebbianservice.teknisa.com/index.php/');
define('NRORG', '1');
define('USER', 'teknisa_homolog');
define('CONN', 'teknisa');
define('HOST', '192.1');
define('PORT', '1521');
define('DBNAME', 'x875854e');
define('SERVICE', 'true');
define('ISENCRYPTED', 'false');
define('USEVPD', 'false');
define('VPDPASSWORD', '');
define('VPDWITHWALLET', 'false');
define('RETORNO_EMAIL1', '');
define('RETORNO_EMAIL2', '');
define('NRSEQWEBSERVICE', '0001');
define('CDFILIAL', '9998');
//Set the default API keys provided by the Pebbian ERP manager
$urlKey = array(
	'NRORG'           => NRORG,
	'USER'	          => USER,
	'CONN'	          => CONN,
	'HOST'            => HOST,
	'PORT'		  	  => PORT,
	'DBNAME'          => DBNAME,
	'SERVICE'		  => SERVICE,
	'ISENCRYPTED'	  => ISENCRYPTED,
	'USEVPD'		  => USEVPD,
	'VPDPASSWORD'	  => VPDPASSWORD,
	'VPDWITHWALLET'	  => VPDWITHWALLET,
	'RETORNO_EMAIL1'  => RETORNO_EMAIL1,
	'RETORNO_EMAIL2'  => RETORNO_EMAIL2,
	'NRSEQWEBSERVICE' => NRSEQWEBSERVICE
);

//Request the URL API from Pebbian Server
$request = new cURLRequest(PEBBIAN_SERVER_PATH);

//Connect from URL using the API key parameters
$configFilter =  array(
	'NRORG'           => NRORG,
	'USER'	          => USER,
	'CONN'	          => CONN,
	'HOST'            => HOST,
	'PORT'		      => PORT,
	'DBNAME'          => DBNAME,
	'SERVICE'		  => SERVICE,
	'ISENCRYPTED'	  => ISENCRYPTED,
	'USEVPD'		  => USEVPD,
	'VPDPASSWORD'	  => VPDPASSWORD,
	'VPDWITHWALLET'	  => VPDWITHWALLET,
	'RETORNO_EMAIL1'  => RETORNO_EMAIL1,
	'RETORNO_EMAIL2'  => RETORNO_EMAIL2,
	'NRSEQWEBSERVICE' => NRSEQWEBSERVICE
);
//Request the info from "PebbianService/config" Route
$configResponse = $request->request( "PebbianService/config", array(
		    "requestType" => "Row",
		    "row"=> $configFilter
		 ));

//Decodes a JSON string
$config = json_decode($configResponse);


$woocommerce = new Client(
	'http://192.168.12/clienteName',
	'ck_01dc5f0dffc830bb871d9dd67eb4d38c63ea3a36',
	'cs_d0f112ab2590b2dcde478fffff3274faec5caeb0',
    [
        'wp_api' => true,
        'version' => 'wc/v2',
        'verify_ssl' => false,
    ]
);


$trateIntegracao = new trateIntegracao;


