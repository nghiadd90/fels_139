<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController 
{
    public $components = ['Paginator'];

    public $helpers = ['Paginator', 'PrintList'];

    public $paginate = [
        'limit' => 4,
        'order' => [
            'User.name' => 'asc'
        ]
    ];
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->fields = [
            'username' => 'username', 
            'password' => 'password'
        ];
    }

    public function login()
    {
        if ($this->Auth->user('id') != null) {

            return $this->redirect('/');
        }

        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $this->Session->setFlash(__('You have just login'));

                return $this->redirect('/');
            }
            $this->Session->setFlash(__('Invalid user login infomation, pls try again'));
        }
    }

    public function logout()
    {
        $this->Session->setFlash(__('You have just logout'));

        return $this->redirect($this->Auth->logout());
    }

    public function register()
    {
        if ($this->Auth->user('id') != null) {

            return $this->redirect('/');
        }

        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('You register successed!'));

                return $this->redirect('/');
            }
            $this->Session->setFlash(__('There something wrong pls try register again'));
        }
    }

    public function index()
    {
        $this->User->recursive = 0;
        $this->Paginator->settings = $this->paginate;
        $data = $this->Paginator->paginate('User');
        $this->set('data', $data);
    }

    public function delete($id = null)
    {
        $this->request->onlyAllow('post', 'delete');
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('User does not exist!'));            
        }
        if ($this->User->delete()) {
            $this->Session->setFlash(__('User has been deteled'));

            return $this->redirect('/users/index');
        }
        $this->Session->setFlash(__('There something wrong, User can not delete'));

        return $this->redirect('/users/index');
    }

    public function edit($id = null)
    {
        if (!$id) {
            throw new NotFoundException(__('Invalid url'));
        }
        $user = $this->User->findById($id);
        if (!$user) {
            throw new NotFoundException(__('User not exist'));
        }
        if ($this->request->is('post', 'put')) {
            $this->User->id = $id;
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('User has been saved'));
                
                return $this->redirect('/users/index');
            }
            $this->Session->setFlash(__('Can not update user info'));
        }
        if (!$this->request->data) {
            $this->request->data = $user;
        }
    }
}
