<?php
/*
##Desenvolvedor: Daniel Souza
##Fone: 31 9 9332 - 0829
##Site:www.diletec.com.br
##Precisando de ajuda pode me procurar.
*/
require_once('cURLRequest.php');
require_once('serverAuthentication.php');
use Automattic\WooCommerce\Client;
require_once('conexao.php');


##
## Inicio atualização das vendas
##
//Inicia o cURL
// $ch = curl_init();
// curl_setopt($ch, CURLOPT_URL, "http://sergiogomes.zeedhi.com/workfolder/pedidos/pedidos/backend/public/index.php/PebbianService/conferirVendas?requestType=Row&row[NRORG]=1077&&row[USER]=USR_ORG_1077&row[CONN]=testesaas&row[HOST]=192.168&row[PORT]=1521&row[DBNAME]=pdbol&row[RETORNO_EMAIL1]=&row[RETORNO_EMAIL1]=&row[NRSEQWEBSERVICE]=0001&row[CDCLIENTE]=ALL");
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// $output = curl_exec($ch);
// $cli = json_decode($output, true);
// $confVend = $woocommerce->get('orders');

// foreach ($cli as $key) {
// 	foreach ($key as $item) {
// 		foreach ($item as $variable) {
// 			$variable['id'];

// 			foreach ($confVend as $keyVend) {
// 				//Atualiza o status de concluid ou cancelado no ERP.
// 				if($keyVend["status"] == 'completed' OR $keyVend["status"] == 'cancelled'
// 				AND $keyVend["id"] == $variable['id']){
// 					//Envia a atualização para o ERP

// 				}

// 			}
// 		}
// 	}
// }
##
## Fim atualização das vendas
##