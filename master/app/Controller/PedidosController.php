<?php

class PedidosController extends AppController
{
	public function beforeFilter(){
		parent::beforeFilter();
		$this->Security->unlockedActions = array('enviar');

	}

	public function enviar()
	{
		$this->layout='ajax';

		$url = Configure::read('HTTP_API_BASE').'/pedidos/enviar/';

		$HttpSocket = new HttpSocket(array('timeout'=>240));
		$dadosJSON = file_get_contents('php://input');
		$result = $HttpSocket->post($url,$dadosJSON);


		echo $result->body;
		exit();
	}

	public function por_vendedor($vendedor_id)
	{
		$this->layout='ajax';

		$url = Configure::read('HTTP_API_BASE').'/pedidos/vendedor/'.$vendedor_id;

		$HttpSocket = new HttpSocket(array('timeout'=>240));
		$result = $HttpSocket->get($url,$_GET);


		echo $result->body;
		exit();
	}
}
