<?php
/**
*@author Daniel Souza <daniel.souza@diletec.com.br>
*/
require_once('cURLRequest.php');
require_once('serverAuthentication.php');
use Automattic\WooCommerce\Client;
require_once('conexao.php');
$trateIntegracao->look('clientes');

##
## Inicio dos clientes
##


//Inicia o cURL
$ch = curl_init();
//Url dos usuarios/clientes da Base
curl_setopt($ch, CURLOPT_URL, "http://pedidoservice.cliente.com:65015/consumirCliente?requestType=Row&row[NRORG]=1&row[USER]=&row[CONN]=&row[HOST]=192.168&row[PORT]=1521&row[DBNAME]=5h1ftyh15y&row[SERVICE]=true&row[ISENCRYPTED]=false&row[USEVPD]=false&row[VPDPASSWORD]=&row[VPDWITHWALLET]=false&row[RETORNO_EMAIL1]=&row[RETORNO_EMAIL1]=&row[NRSEQWEBSERVICE]=0001&row[CDCLIENTE]=ALL");
//Recebe o retorno
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//Execulta a requizição
$output = curl_exec($ch);
//Decodifica a resposta OBS precisa ser true para funcionar o array abaixo
$cli = json_decode($output, true);
//var_dump($cli);
if($cli == NULL){
	echo 'Todos os clientes já forão cadastrados.';
	//$trateIntegracao->email('Integração', 'Clientes', 'Todos os clietes já estão cadastrados!');
}else{
	$fimTime = time()+300;//A hora que é para parar.
	foreach ($cli as $key) {
		foreach ($key as $item) {
			foreach ($item as $variable) {

				/**Evitar duplicidade de dados, se mudar o tempo, mude no look */
				if($fimTime < time()){ //Se chegar a 5 minutos de execução ele para.
					echo 'Limite de '. 300/60 .' minutos atingido.';
					$trateIntegracao->unlook('clientes');
					exit();
				}

				$ID = $variable['CDCLIENTE'];
				// echo $NOME = $variable['NMFANTCLIE'].' ';
				$EMAIL = $variable['DSEMAILCLIE'];
				/**Conferir se o cliente existe ou não */
				$conferir = mysqli_query($connDb,"SELECT * FROM `wp_brasilg_users` WHERE `user_email`='$EMAIL'");
				// var_dump($connDb);
				$cont = mysqli_num_rows($conferir);
				/**Não existe, cadastra e manda a resposta com o ID no e-commerce para o ERP */
				if($cont==0){
				    $dataCadC = [
					    'email' => $variable['DSEMAILCLIE'],
					    'first_name' => $variable['NMFANTCLIE'],
					    'username' => $variable['DSEMAILCLIE'],
					    'password' => 'teknisa'
					];
					//var_dump($dataCadC);
					$clienteWoocommerce = $woocommerce->post('customers', $dataCadC);
					//var_dump($clienteWoocommerce);

					$serverDePara = array(
							'NRORG'           => NRORG,
							'USER'	          => USER,
							'CONN'	          => CONN,
							'HOST'            => HOST,
							'PORT'		      => PORT,
							'DBNAME'          => DBNAME,
							'NRSEQWEBSERVICE' => NRSEQWEBSERVICE
						);
						$pC = array(
						   'CDWEBEXTERNO' 		=> $clienteWoocommerce['id'],
						   'CDCLIENTE'    		=> $ID,
						   'NRORG'        		=> NRORG,
						   'NRSEQWEBSERVICE'	=> NRSEQWEBSERVICE
						);

						$paraC = array(
							$serverDePara,
							$pC
						);
						/**Envia para o sergio*/
						//  $deParaResponseC = $request->request("PebbianService/registraClienteExterno", array(
						//     "requestType" => "DataSet",
						//     "dataset"     => $paraC
						// ));

						// Resposta do sergio.

						// var_dump($deParaResponseC);

						/*$trateIntegracao->email('Integração', 'Clientes', $deParaResponseC);*/

				}else{ /**A pessoa está usando e-mail de outro usuário */
					$dadosCCL = mysqli_fetch_object($conferir);
					$IDD = $dadosCCL->ID;

					echo $rr = 'O cliente <strong>'.$variable['NMFANTCLIE'].'</strong> está tentando se cadastrar usando o e-mail <strong>'. $EMAIL. '</strong>, porem o mesmo ja esta sendo usando por <strong>'. $dadosCCL2->meta_value.'</strong></br><hr>';
					//$trateIntegracao->email('Integração', 'Clientes', $rr);
				}
			}
		}
	}
}
curl_close($ch);
##
## Fim dos clientes
##

//echo 'Vamos deletar';
$trateIntegracao->unlook('clientes');