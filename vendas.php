<?php
/*
##Desenvolvedor: Daniel Souza
##Fone: 31 9 9332 - 0829
##Site:www.diletec.com.br
##Precisando de ajuda? entre em contato.
*/
require_once('cURLRequest.php');
require_once('serverAuthentication.php');
require_once('conexao.php');
$trateIntegracao->look('vendas');
/*
Se não esta enviando, pode ser o status do pedido. Use a linha 22 (vardump) para verificar o status.
*/

##
## Inicio das vendas
##
/**Vendano e-coomerce */
$confVend = $woocommerce->get('orders');
//var_dump($confVend);
foreach ($confVend as $key) {
	//Envia e atualiza o status de processing para on-hold (Aguardando).
	if($key["status"] == 'processing' OR $key["status"] == 'pending'){
		$d = $key['date_created'];
		$d1 = explode('-', $d);
		$d3 = explode('T', $d1[2]);
		$dateVenda = $d3[0].'/'.$d1[1].'/'.$d1[0];

		$key['id'];
		$key['billing']; //Array de dados do cliente comprador
		$key['shipping']; //Array de dados do cliente comprador para entrega
		$key['payment_method']; // Method de pagamento
		$key['line_items']; // Lista dos itens
		//var_dump($key);	
		//var_dump($key['line_items']);
		//echo '<br/>'.count($key['line_items']);
		foreach ($key['line_items'] as $value) {
			//echo count($value['id']).'<br/>';
			$V[] = array(
		    	//$key['line_items']
		    	"CDITPEDEXTERNO" => strval($value["product_id"]),//"9010100100",
		        "CDPRODEXTERNO" => strval($value["product_id"]),//"9010100100",
		        "NMPRODUTO" => $value["name"],//"ACELGA",
		        "DSPRODUTO" => $value["name"],//"ACELGA",
		        "VRPREUNITPED" => $value["price"],//"1",
		        "QTITEMPED" => "1.",
		        "DSITEMPED" => "sef", //descrição
		        "DTENTITPED" => "" //data de entrega
	    	);
		}
		//var_dump($V);

		$server = array(
			'NRORG'           => NRORG,
			'USER'	          => USER,
			'CONN'	          => CONN,
			'HOST'            => HOST,
			'PORT'			  => PORT,
			'DBNAME'          => DBNAME,
			'RETORNO_EMAIL1'  => RETORNO_EMAIL1,
			'RETORNO_EMAIL2'  => RETORNO_EMAIL2,
			'NRSEQWEBSERVICE' => NRSEQWEBSERVICE
		);
		$pedido = array(
	        'PEDEXTERNO'      => $key['id'],
	        'VRDESCONTO'      => $key["discount_total"],
	        'CDMODPGTO'       => '00004',//$key['payment_method'],
	        'CDVENDEDOR'      => '0001',
	        'VRFRETE' 		  => $key["shipping_tax"],//$orderData->VRENCARGOPED,
	        'DTENTPED' 		  => $dateVenda,//null,
	        "ITENS" 		  => $V,
	        'CDCLIEEXTERNO'   => $key["customer_id"],//'J07851254000162',//$key["customer_id"],//$orderData->CDCLIEEXTERNO,
	        'CDCLIENTE'       => $key["customer_id"],//'J07851254000162',//$key["customer_id"],//$orderData->CDCLIEEXTERNO,
			'PRECOSITE' 	  => 'N',
	        'IDTPIJURCLIE'    => 'F',
	        'NRINSJURCLIE'    => 'cpf/cnpj',
	        'NMRAZSOCCLIE'    => 'nome',
	        'NMFANTCLIE'      => 'nome',
	        'NMPAIS'          => $key['shipping']["country"],
	        'NMESTADO'        => $key['shipping']["state"],
	        'NMMUNICIPIO'     => $key['shipping']["city"],
	        'DSENDECLIE'      => $key['shipping']["address_1"],
	        'DSCOMPENDCLI'    => 'complemento',
	        'NRCEPCLIE'       => $key['shipping']["postcode"],
	        'DSEMAILCLIE'     => $key['billing']["email"],
	        'NRTELECLIE'      => $key['billing']["phone"],
	        'DSPTOREFECLI'    => 'referencia',			        
	        //'DTENTPED'	      =>	$key["date_completed"],
	        'DSPEDVEN'        => 'Falar com ',
	        'Cliente'         => $key['billing']['first_name'],

	        'NRORG'           => NRORG,
	        'CDFILIAL' 		  => CDFILIAL,
	        //'CDMODPGTO' => '00001',
	        'CDOPERADOR' 	  =>'000000107712',
	        'CDPRECOBASE'     => '01',
	        'IDTIPOOPERWEB'   => 'S',
	        'CDTIPOOPERWEB'   => '01',
	        //'CDVENDEDOR' => '9999',
	        'NRSEQWEBSERVICE' => NRSEQWEBSERVICE
		);

		$ordersDePara = array(
			$server,
			$pedido,        
	    );

		//Fim da venda array
		//$ordersDePara = json_encode($ordersDePara);
		//echo '<pre>';
		//var_dump($ordersDePara);
		//echo '</pre>';

		//Enviar para o Sergio ERP Pebbian
		$deParaResponse = $request->request("PebbianService/registraPedido", array(
		    "requestType" => "DataSet",
		    "dataset"     => $ordersDePara
		));
		$atuProd = [
		    'status' => 'on-hold'
		];
		$idPro = $key['id'];
		$woocommerce->put('orders/'.$idPro, $atuProd);
		// var_dump($deParaResponse);
		//$trateIntegracao->email('Integração Amaral - Clorofitum', 'Vendas', $deParaResponse);
	}//Só vai enviar se o status for processing
}
##
## Fim das vendas
##
$trateIntegracao->unlook('vendas');