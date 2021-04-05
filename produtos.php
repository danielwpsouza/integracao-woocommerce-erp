<?php
/**
*@author Daniel Souza <daniel.souza@diletec.com.br>
*/
set_time_limit(0);
require_once('cURLRequest.php');
require_once('serverAuthentication.php');
require_once('conexao.php');
//$trateIntegracao->look('produtos');
##
## Inicio dos produtos
##
//Inicia o cURL
$ch = curl_init();
//Url dos produtos da Base
curl_setopt($ch, CURLOPT_URL, "http://pedidoservice.dominio.com:65015/buscarProduto?requestType=Row&row[NRORG]=1&row[USER]=teknisa_homolog&row[CONN]=teknisa&row[HOST]=192.168&row[PORT]=1521&row[DBNAME]=x58aw45&row[SERVICE]=true&row[ISENCRYPTED]=false&row[USEVPD]=false&row[VPDPASSWORD]=&row[VPDWITHWALLET]=false&row[RETORNO_EMAIL1]=&row[RETORNO_EMAIL1]=&row[NRSEQWEBSERVICE]=0001&row[CDPRECOBASE]=00&row[CDPRODUTO]=ALL");
//Recebe o retorno
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//curl_setopt($ch, CURLOPT_TIMEOUT,15000); // 500 seconds
//Execulta a requizição
$output = curl_exec($ch);
//Decodifica a resposta OBS precisa ser true para funcionar o array abaixo
$produto = json_decode($output, true);
//$limited = count($produto["dataset"]["produtos"]);
echo '<pre> produtos consumidos:
//  ';
var_dump($produto);
echo '</pre>';
if($produto == NULL){
	echo 'Todos os produtos já forão cadastrados.';
	//$trateIntegracao->email('Integração ', 'Produtos', 'Todos os produtos já cadastrados.');
}else{
//count($produto). '</br>';
//exit();
$fimTime = time()+300;//A hora que é para parar.
	foreach ($produto as $key) {
		foreach ($key as $item) {
			foreach ($item as $variable) {

				if($fimTime < time()){ //Se chegar a 5 minutos de execução ele para.
					echo 'Limite de '. 300/60 .' minutos atingido.';
					$trateIntegracao->unlook('produtos');
					exit();
				}

				$nProd = $variable['NMPRODUTO'];
				$conferir = mysqli_query($connDb,"SELECT * FROM `wp_brasilg_posts` WHERE `post_title` =  '$nProd' AND `post_type` = 'product'");
				$cont = mysqli_num_rows($conferir);
				//echo '<br/>';
				//exit();
				if($cont==0){
					$i = $variable['FOTO'];
					$is = count($i);
					//exit();
					if($is > 0){
						for ($in=0; $in < $is; $in++) {

							$imag[] =
							[
								'src' => $i[$in]['DSLINKFOTO'],
								'position' => intval($in)
							];
						}

						$price = $variable['VRITEPREBASE'];
						if(!preg_match('/^[1-9][0-9]*$/',$price)){
						}else{
							$price = $variable['VRITEPREBASE'].',00';
						}
						$dataCadP = [
				    		'name' => $variable['NMPRODUTO'],
							'type' => 'simple',
							'regular_price' => $price,
							'description' => $variable['DSDESCRICAO'],
							'short_description' => $variable['DSOBSNUTR'],
							'categories' => [
						        [
						            'id' => null
						        ]
						    ],
						    'images' => $imag
						];
						//echo 'tem imagem <br/>';
						try{
							$productWoocommerce = $woocommerce->post('products', $dataCadP);
						}catch(HttpClientException $e){
							echo $e->getMenssage();
						}
						unset($imag);

						//Responde para o Sergio
						$produtosDePara = array(
							'NRORG'           => NRORG,
							'USER'	          => USER,
							'CONN'	          => CONN,
							'HOST'            => HOST,
							'PORT'		      => PORT,
							'DBNAME'          => DBNAME,
							'NRSEQWEBSERVICE' => NRSEQWEBSERVICE
						);
						$p = array(
							'CDWEBEXTERNO' 		=> $productWoocommerce['id'],
						  	'CDPRODUTO'    		=> $variable['CDPRODUTO'],
						  	'NRORG'             => NRORG,
						  	'NRSEQWEBSERVICE'	=> NRSEQWEBSERVICE
						  );

						$para = array(
							$produtosDePara,
							$p
						);

						 $deParaResponse = $request->request("PebbianService/registraCodExterno", array(
						    "requestType" => "DataSet",
						    "dataset"     => $para
						));


					}else{ //Else de Imagens
						$price = $variable['VRITEPREBASE'];
						if(!preg_match('/^[1-9][0-9]*$/',$price)){
						}else{
							$price = $variable['VRITEPREBASE'].',00';
						}
						$dataCadP = [
				    		'name' => $variable['NMPRODUTO'],
							'type' => 'simple',
							'regular_price' => $price,
							'description' => $variable['DSDESCRICAO'],
							'short_description' => $variable['DSOBSNUTR'],
							'categories' => [
						        [
						            'id' => null
						        ]
						    ]
						];

						try{
							$productWoocommerce = $woocommerce->post('products', $dataCadP);
						}catch(HttpClientException $e){
							echo $e->getMenssage();
						}


						//Responde para o Sergio
						$produtosDePara = array(
							'NRORG'           => NRORG,
							'USER'	          => USER,
							'CONN'	          => CONN,
							'HOST'            => HOST,
							'PORT'		      => PORT,
							'DBNAME'          => DBNAME,
							'NRSEQWEBSERVICE' => NRSEQWEBSERVICE
						);
						$p = array(
							'CDWEBEXTERNO' 		=> $productWoocommerce['id'],
						  	'CDPRODUTO'    		=> $variable['CDPRODUTO'],
						  	'NRORG'        		=> NRORG,
						  	'NRSEQWEBSERVICE'	=> NRSEQWEBSERVICE
						  );

						$para = array(
							$produtosDePara,
							$p
						);

						 $deParaResponse = $request->request("PebbianService/registraCodExterno", array(
						    "requestType" => "DataSet",
						    "dataset"     => $para
						));


					}//else de fotos


				}//Fim do IF de produtos que mão existe
				else{ //iniciar os que já existem.
					$app = mysqli_fetch_object($conferir);
					//echo $app->ID;
					//echo ' Else, só entra aqui se o produto existir. <br/>';
					$produtosDePara = array(
							'NRORG'           => NRORG,
							'USER'	          => USER,
							'CONN'	          => CONN,
							'HOST'            => HOST,
							'PORT'		      => PORT,
							'DBNAME'          => DBNAME,
							'NRSEQWEBSERVICE' => NRSEQWEBSERVICE
						);
						$p = array(
							'CDWEBEXTERNO' 		=> $app->ID,
						  	'CDPRODUTO'    		=> $variable['CDPRODUTO'],
						  	'NRORG'        		=> NRORG,
						  	'NRSEQWEBSERVICE'	=> NRSEQWEBSERVICE
						  );

						$para = array(
							$produtosDePara,
							$p
						);

						 $deParaResponse = $request->request("PebbianService/registraCodExterno", array(
						    "requestType" => "DataSet",
						    "dataset"     => $para
						));


				}

			}
		}
	}

}//fim do else

//Fecha a resposta
curl_close($ch);
##
## Fim dos produtos
##
//$trateIntegracao->unlook('produtos');