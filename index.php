<?php

	header('Content-type: text/html; charset=UTF-8');

	/*
	CÓDIGO  NOME
	1       Dólar (venda)
	10813   Dólar (compra)
	21619   Euro (venda)
	21620   Euro (compra)
	21621   Iene (venda)
	21622   Iene (compra)
	21623   Libra esterlina (venda)
	21624   Libra esterlina (compra)
	21625   Franco Suíço (venda)
	21626   Franco Suíço (compra)
	21627   Coroa Dinamarquesa (venda)
	21628   Coroa Dinamarquesa (compra)
	21629   Coroa Norueguesa (venda)
	21630   Coroa Norueguesa (compra)
	21631   Coroa Sueca (venda)
	21632   Coroa Sueca (compra)
	21633   Dólar Australiano (venda)
	21634   Dólar Australiano (compra)
	21635   Dólar Canadense (venda)
	21636   Dólar Canadense (compra)
	*/

	$quotation = getLastCurrency('21619');
	
	if (!$quotation->error)
	{

		$currName = $quotation->NOME;
		$currValue = $quotation->VALOR;
		$quotDate = $quotation->DATA->DIA . '/' . $quotation->DATA->MES . '/' . $quotation->DATA->ANO;

		echo "$currName
		<hr />
		Valor unitário: R$ $currValue <br /> 
		Dia da Cotação: $quotDate ";

	} else {

		echo $CotacaoMoedaWS->error;

	}


	function getLastCurrency($currency)
	{

		$function = "getUltimoValorXML";
		ini_set("soap.wsdl_cache_enabled", "0");

		$WsSOAP = new SoapClient("https://www3.bcb.gov.br/sgspub/JSP/sgsgeral/FachadaWSSGS.wsdl");

		try {
			
			$result = $WsSOAP -> $function($currency); 
			 
			if (isset($result)) { 

				$data = simplexml_load_string($result)->SERIE;
			
			} else {
			
				$data = (object) array('error' => 'Falha ao abrir XML do BCB.');
			}

		} catch (Exception $Exception) {
			
			$data = (object) array('error' => 'ERRO AO REALIZAR A CAPTURA DE DADOS DO WEBSERVICE: ' . $Exception -> getMessage());

		}

		return $data;

	}

?>