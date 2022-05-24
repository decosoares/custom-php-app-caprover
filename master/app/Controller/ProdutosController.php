<?php

class ProdutosController extends AppController
{
	public function index($id = null){
		$this->layout='ajax';
		//$this->autoRender = false;

		$url = Configure::read('HTTP_API_BASE').'/produtos/';
		if(!empty($id)){
			$url = Configure::read('HTTP_API_BASE').'/produtos/'.$id;
		}
		$HttpSocket = new HttpSocket();
		$result = $HttpSocket->get($url,$_GET);


		echo $result->body;
		exit();
	}
}
