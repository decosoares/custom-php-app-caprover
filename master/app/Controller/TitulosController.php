<?php

class TitulosController extends AppController
{
	public function vencidos_por_vendedor($vendedor_id = null)
	{

		set_time_limit(300);
		$this->layout = 'ajax';

		$url = Configure::read('HTTP_API_BASE') . 'titulos/vencidos/vendedor/' . $vendedor_id;

		/*
		$HttpSocket = new HttpSocket();
		$result = $HttpSocket->get($url, $_GET);

		echo $result->body;
		*/
		$dados = file_get_contents($url);
		echo $dados;
		exit();
	}

	public function por_vendedor($vendedor_id = null)
	{

		set_time_limit(480);
		$this->layout = 'ajax';

		$url = Configure::read('HTTP_API_BASE') . 'titulos/vendedor/' . $vendedor_id;

		$HttpSocket = new HttpSocket(array('timeout'=>240));
		$result = $HttpSocket->get($url, $_GET);

		echo $result->body;

		exit();
	}
}
