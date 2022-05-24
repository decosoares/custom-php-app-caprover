<?php

class TipoParcelasController extends AppController
{
	public function index($id = null){
		set_time_limit(60);
		$this->layout='ajax';
		//$this->autoRender = false;

		$url = Configure::read('HTTP_API_BASE').'/tipo_parcela/';
		if(!empty($id)){
			$url = Configure::read('HTTP_API_BASE').'/tipo_parcela/'.$id;
		}
		$HttpSocket = new HttpSocket();
		$result = $HttpSocket->get($url,$_GET);


		echo $result->body;
		exit();
	}
}
