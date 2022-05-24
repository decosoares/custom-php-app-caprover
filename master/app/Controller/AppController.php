<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');
App::uses('HttpSocket', 'Network/Http');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		https://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public $components = array('RequestHandler','Flash','Security');
	private $tokens = array(
		1 => 'dd1bda84f6a6e4fc950422d1ddb14464',
		3 => 'cf281ab117b71cd640cbbf8137ce9c07',
		7 => 'b4ada357dc39278b40d335dfb2240bbf',
		13 => 'c9904b33fecb2af332f0fbc268ad427d',
		44 => '3bfd65344a41fe052ac37c38436a09be',
		49 => '3979594edebbf9d8b2473f97c44d334f'
	);

    public function beforeFilter()
    {
		header ('Content-type: application/json; charset=UTF-8');
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Headers: *");
		//$this->RequestHandler->setContent('json');
		//$this->RequestHandler->respondAs('json');

		//verify if the request has a valid token
		if($this->params->url != 'api/v1/users/logar'){
			if($this->params->controller != 'users'){
				$header = getallheaders(); //get the request header
				if(empty($header['Authorization'])){
					$message = 'Sem autorização para acessar essa api.';
					echo json_encode(array('message'=>$message));
					exit;
				}

				$token = explode(' ',$header['Authorization']);
				$validToken = $this->tokenValidate($token[1]);

				//check token
				if(!$validToken){
					$message = 'O acesso somente é permitido com um token válido.';
					echo json_encode(array('message'=>$message));
					exit;
				}
			}
		}
	}

	//find the token in database
	// public function tokenValidate($token){
	// 	$this->loadModel('User');

	// 	$user = $this->User->findByToken($token);

	// 	if(!empty($user)){
	// 		return true;
	// 	}

	// 	return false;
	// }

	public function tokenValidate($token){
		if(array_search($token,$this->tokens))
			return true;

		return false;
	}
}
