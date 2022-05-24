<?php

class ClientesController extends AppController
{
	public function index($id = null){
		set_time_limit(60);
		$this->layout='ajax';
		//$this->autoRender = false;

		$url = Configure::read('HTTP_API_BASE').'/clientes/';
		if(!empty($id)){
			$url = Configure::read('HTTP_API_BASE').'/clientes/'.$id;
		}
		$HttpSocket = new HttpSocket(array('timeout'=>240));
		$result = $HttpSocket->get($url,$_GET);


		echo $result->body;
		exit();
	}

	public function por_vendedor($vendedor_id){
		set_time_limit(60);
		$this->layout='ajax';

		$url = Configure::read('HTTP_API_BASE').'/clientes/vendedor/'.$vendedor_id;

		$HttpSocket = new HttpSocket(array('timeout'=>240));
		$result = $HttpSocket->get($url,$_GET);


		echo $result->body;
		exit();
	}
}
