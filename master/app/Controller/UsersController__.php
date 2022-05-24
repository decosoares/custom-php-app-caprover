<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController {

	public $components = array(
		'Flash',
		'Paginator',
		'Auth' => array(
			'loginAction' => array(
				'controller' => 'users',
				'action' => 'login_admin'
			),
			'loginRedirect' => array(
				'controller' => 'users',
				'action' => 'index'
			),
			'logoutRedirect' => array(
				'controller' => 'users',
				'action' => 'login_admin'
			)
		)
	);

	public function beforeFilter(){
		parent::beforeFilter();
		$this->Security->unlockedActions = array('logar');
		$this->Auth->allow('logar');

	}

	public function login_admin(){
		$this->layout = 'login';
		if ($this->request->is('post')) {
			$this->request->data['User']['password'] = Security::hash($this->request->data['User']['password'], 'md5', true);
			$usuario = $this->User->find('first', array('conditions' => array('user' => $this->request->data['User']['user'], 'password' => $this->request->data['User']['password'])));
			if (!empty($usuario)) {
				$this->Auth->login($usuario);
				return $this->redirect($this->Auth->redirectUrl());
			}
			$this->Flash->error(__('Invalid username or password, try again'));
		}
	}

	public function logout()
	{
		return $this->redirect($this->Auth->logout());
	}

	protected function login($user,$password){
		$this->autoRender = false;
		$this->layout = 'ajax';

		$pwd = Security::hash($password , 'md5', true);

		$usuario = $this->User->find('first', array('conditions'=>array('user'=>$user,'password'=>$pwd)));

		if(!empty($usuario)){
			$data = array();
			$usuario['User']['id'] = (int) utf8_encode($usuario['User']['id']);
			$usuario['Almoxarifado']['id'] = (int) utf8_encode($usuario['Almoxarifado']['id']);
			$data['data'] = $usuario['User'];
			$data['data']['almoxarifado'] = $usuario['Almoxarifado'];
			return $data;
		}

		return false;
	}

	public function logar(){

		$this->autoRender = false;
		$this->layout = 'ajax';

		if($this->request->is('post')){
			$login = $this->request->input('json_decode', TRUE);

			$result = $this->login($login['user'],$login['password']);

			$this->RequestHandler->respondAs('json');

			if($result){
				echo json_encode($result);
			}else{
				$this->response->statusCode(400);
				$this->response->body(
					json_encode(
						array('data' => false, 'message' => 'Não foi possível fazer o login')
					)
				);
				$this->response->send();
				$this->_stop();
			}
		}



	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$dados = $this->request->data['User'];
			if($dados['password'] == $dados['confirm_password']){
				$this->request->data['User']['password'] = Security::hash($dados['password'] , 'md5', true);

				if ($this->User->save($this->request->data)) {
					$this->Flash->success(__('The user has been saved.'));
					return $this->redirect(array('action' => 'index'));
				} else {
					$this->Flash->error(__('The user could not be saved. Please, try again.'));
				}
			}else{
				$this->Flash->error(__('Senha e Confirmação não conferem.'));
			}
		}
		$almoxarifados = $this->User->Almoxarifado->find('list');
		$this->set(compact('almoxarifados'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is(array('post', 'put'))) {
			$dados = $this->request->data['User'];
			$this->request->data['User']['password'] = Security::hash($dados['password'] , 'md5', true);
			if ($this->User->save($this->request->data)) {
				$this->Flash->success(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
		$almoxarifados = $this->User->Almoxarifado->find('list');
		$this->set(compact('almoxarifados'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->User->delete($id)) {
			$this->Flash->success(__('The user has been deleted.'));
		} else {
			$this->Flash->error(__('The user could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
