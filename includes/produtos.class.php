<?php

class produtos{

	function cadProd(){
		//Consume os Produtos
	}

	function consProduct($uriPro){
		//Inicia o cURL
		$ch = curl_init();
		//Url dos produtos da Base
        curl_setopt($ch, CURLOPT_URL, "http://sergiogomes.zeedhi.com/workfolder/pedidos/pedidos/backend/public/index.php/PebbianService/buscarProduto?requestType=Row&row[NRORG]=1077&row[USER]=USR_ORG_1077&row[CONN]=testesaas&row[HOST]=192.168.122.5&row[PORT]=1521&row[DBNAME]=pdborcl&row[RETORNO_EMAIL1]=daniel.souza@diletec.com.br&row[RETORNO_EMAIL1]=sergio.gomes@teknisa.com&row[NRSEQWEBSERVICE]=0001&row[CDPRECOBASE]=01&row[CDPRODUTO]=ALL");
       //Recebe o retorno
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //Execulta a requizição
        $output = curl_exec($ch);
        //Decodifica a resposta OBS precisa ser true para funcionar o array abaixo
        $produto = json_decode($output, true);

		$iddddd = $_SESSION['IDERPCLI'];


        foreach ($produto as $key) {
        	foreach ($key as $item) {
        		foreach ($item as $variable) {
        			$variable["CDPRODUTO"];
        			$variable['NMPRODUTO'];
        			$variable['NMPRODUTO'];
        			$variable['SGUNIDADE'];
        			$variable['VRITEPREBASE'];
        			$variable['DSDESCRICAO'];
        			$i = $variable['FOTO'];
        			foreach ($i as $key) {
        				$key['0'];
        			}
        		}
        	}
        }

        //Fecha a resposta
        curl_close($ch);


	}

}