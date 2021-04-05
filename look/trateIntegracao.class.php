<?php
/*
** @author Name Daniel Souza <daniel.souza@diletec.com.br>
*/
class trateIntegracao{

	//Função de menssagem de erros por e-mail
	function intErros($empresa, $assunto, $men){
		email($empresa, 'Erros', $men);
		exit();
	}

	//Bloqueia o uso de mais de uma execução
	function look($name){
		$lookPass 	= time();
		$nameArk = $name.'.txt';
		//verifica se o arquivo existe, se existe ele verifica se tem mais de X tempo
		if(file_exists($nameArk)){
			$handle		= fopen($nameArk, "r"); //Abre para leitura.
			$leitura = fgets($handle);
			fclose($handle);
			/**O Arquivo foi criado agora, siga */
			if($leitura == $lookPass){
			/**O arquivo tem mais de 320s? se sim exclui o arquivo e volta ao inicio da função*/
			}elseif($leitura+320 <= $lookPass){
				try {
					unlink($nameArk);
					sleep(10);
				} catch (Exception $e) {
					echo $e->getMessage();
				}
			/**Se uma execução está em seu tempo normal, só não deixar uma nova. */
			}else{
				echo 'Uma execução já esta em andamento.';
				exit();
			}
		/**Se o arquivo não existe crie, atualiza a função e segue*/
		}else{
			$handle	= fopen($nameArk, "w"); //Abre para escrita.
			fwrite($handle, $lookPass); //– escreve em um arquivo.
			fclose($handle); //Fecha o arquivo.
			sleep(10);
		}

	}

	//Desbloqueia o sistema para a próxima execução
	function unlook($name){
		$nameArk = $name.'.txt';
		unlink($nameArk);
	}

	//Envia o email com o processo da integração
	function email($empresa, $assunto, $mensagem){
		/*** INÍCIO - DADOS A SEREM ALTERADOS DE ACORDO COM SUAS CONFIGURAÇÕES DE E-MAIL ***/
		$enviaFormularioParaNome = 'Admin';
		$enviaFormularioParaEmail = '';

		$caixaPostalServidorNome = 'Integração | '.$empresa;
		$caixaPostalServidorEmail = '';
		$caixaPostalServidorSenha = '';

		/*** FIM - DADOS A SEREM ALTERADOS DE ACORDO COM SUAS CONFIGURAÇÕES DE E-MAIL ***/

		/* abaixo as veriaveis principais, que devem conter em seu formulario*/

		$remetenteNome  = 'Sistema de Integração';
		$remetenteEmail = 'contato@clorofitum.com.br';

		$mensagemConcatenada = 'Email gerado pela integração'.'<br/>';
		$mensagemConcatenada .= '-------------------------------<br/><br/>';
		$mensagemConcatenada .= 'Nome: '.$remetenteNome.'<br/>';
		$mensagemConcatenada .= 'E-mail: '.$remetenteEmail.'<br/>';
		$mensagemConcatenada .= 'Assunto: '.$assunto.'<br/>';
		$mensagemConcatenada .= '-------------------------------<br/><br/>';
		$mensagemConcatenada .= 'Mensagem: "'.$mensagem.'"<br/>';
		$mensagemConcatenada .= '-------------------------------<br/><br/>';
		$mensagemConcatenada .= 'Obs: Se o sistema apresentar erros, favor procurar por Daniel Souza.';


		/*********************************** A PARTIR DAQUI NAO ALTERAR ************************************/

		require_once('mail/PHPMailerAutoload.php');

		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPAuth  = false;
		$mail->Charset   = 'utf8_decode()';
		$mail->Host  = '';
		$mail->Port  = '';
		$mail->Username  = $caixaPostalServidorEmail;
		$mail->Password  = $caixaPostalServidorSenha;
		$mail->From  = $caixaPostalServidorEmail;
		$mail->FromName  = utf8_decode($caixaPostalServidorNome);
		$mail->IsHTML(true);
		$mail->Subject  = utf8_decode($assunto);
		$mail->Body  = utf8_decode($mensagemConcatenada);


		$mail->AddAddress($enviaFormularioParaEmail,utf8_decode($enviaFormularioParaNome));

		if(!$mail->Send()){
			$mensagemRetorno = 'Erro ao enviar formulário: '. print($mail->ErrorInfo);
			$ch = curl_init();
			$ini = "enviarFormulario=ok&remetenteNome=".$remetenteNome."&remetenteEmail=".$remetenteEmail."&assunto=".$assunto."&mensagem=".$mensagem;
			//Url dos produtos da Base
			$url = "";
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, 1);                //0 = get 1 = post
			curl_setopt($ch, CURLOPT_POSTFIELDS, $ini);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //Transferencia de dados
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,3); //Tempo para se conectar
			curl_setopt($ch, CURLOPT_TIMEOUT, 86400); //Tempo maxímo para obter o retorno
			$response = curl_exec($ch); //execulta
		}else{
			$mensagemRetorno = 'Formulário enviado com sucesso!';
		}
		//fim dos e-mails
	}



}





