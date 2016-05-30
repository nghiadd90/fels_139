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

    public $uses = ['User', 'LessonWord', 'Word', 'Activity'];

    public $helpers = ['Paginator', 'PrintList', 'CheckRelationship'];

    public $paginate = [
        'limit' => 4,
        'order' => [
            'User.username' => 'asc'
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
                $this->Session->setFlash(__('You have just login'), 'success');

                return $this->redirect('/categories/index');
            }
            $this->Session->setFlash(__('Invalid user login infomation, pls try again'), 'error');
        }
    }

    public function logout()
    {
        $this->Session->setFlash(__('You have just logout'), 'success');

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
                $this->Session->setFlash(__('You register successed!'), 'success');

                return $this->redirect('/users/login');
            }
            $this->Session->setFlash(__('There something wrong pls try register again'), 'error');
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
            $this->Session->setFlash(__('User has been deteled'), 'success');

            return $this->redirect('/users/index');
        }
        $this->Session->setFlash(__('There something wrong, User can not delete'), 'error');

        return $this->redirect('/users/index');
    }

    public function edit($id = null)
    {
        if (!$id) {
            throw new NotFoundException(__('Invalid url'));
        }
        $user = $this->User->find('first', [ 
            'conditions' => [
                'User.id' => $id
            ]
        ]);
        if (!$user) {
            throw new NotFoundException(__('User not exist'));
        }
        if ($this->request->is('post', 'put')) {
            $this->User->id = $id;
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('User has been saved'), 'success');

                return $this->redirect('/users/index');
            }
            $this->Session->setFlash(__('Can not update user info'), 'error');
        }
        if (!$this->request->data) {
            $this->request->data = $user;
        }
    }

    public function view($id = null)
    {
        if (!$id) {
            throw new NotFoundException(__('Invalid url'));
        }
        $this->User->recursive = 2;
        $user = $this->User->find('first', [
            'conditions' => [
                'User.id' => $id,
            ]
        ]);
        $wordLearned = $this->LessonWord->find('all', [
            'conditions' => [
                'Lesson.user_id' => $id,
                'WordAnswer.correct' => 1
            ]
        ]);
        $authUser = $this->Auth->user();
        $this->Word->recursive = -1;
        $allWord = $this->Word->find('all');
        if (!$user) {
            throw new NotFoundException(__('User not exists'));
        }
        $this->set(compact('user', 'authUser', 'wordLearned', 'allWord'));
    }

    public function follow($id = null)
    {
        if (!$id) {
            throw new NotFoundException(__('Invalid Url'));
        }
        $user = $this->User->find('first', [
            'conditions' => [
                'User.id' => $id,
            ]
        ]);
        if (!$user) {
            throw new NotFoundException(__('User not exists'));
        }
        $data = [
            'Relationship' => [
                'follower_id' => $this->Auth->user('id'),
                'following_id' => $id
            ]
        ];
        if ($this->User->Follower->Relationship->save($data) && 
            $this->Activity->saveActivity($id, $this->Auth->user('id'), 'follow')) {
            $this->Session->setFlash(__('Following success'), 'success');
        } else {
            $this->Session->setFlash(__('There something wrong'), 'error');
        }

        return $this->redirect("/users/view/$id");
    }

    public function unfollow($id = null)
    {
        if (!$id) {
            throw new NotFoundException(__('Invalid Url'));
        }
        $user = $this->User->find('first', [
            'conditions' => [
                'User.id' => $id,
            ]
        ]);
        if (!$user) {
            throw new NotFoundException(__('User not exists'));
        }
        $conditions = [
            'Relationship.follower_id' => $this->Auth->user('id'),
            'Relationship.following_id' => $id
        ];
        if ($this->User->Follower->Relationship->deleteAll($conditions) && 
            $this->Activity->saveActivity($id, $this->Auth->user('id'), 'unfollow')) {
            $this->Session->setFlash(__(' Unfollowing success'), 'success');
        } else {
            $this->Session->setFlash(__('There something wrong'), 'error');
        }

        return $this->redirect("/users/view/$id");
    }

    public function updateProfile($id = null)
    {
        if (!$id) {
            throw new NotFoundException(__('Invalid url'));
        }
        $user = $this->User->find('first', [ 
            'conditions' => [
                'User.id' => $id
            ]
        ]);
        if (!$user) {
            throw new NotFoundException(__('User not exist'));
        }
        if ($this->request->is('post', 'put')) {
            $this->User->id = $id;
            $isNoFileUploaded = ($this->request->data['User']['avatar_image']['error'] 
                == UPLOAD_ERR_NO_FILE) ? true : false;
            if ($isNoFileUploaded) {
                $this->User->validator()->remove('avatar_image');
            }
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('User has been saved'), 'success');
                
                return $this->redirect("/users/updateProfile/$id");
            }
            $this->Session->setFlash(__('Can not update user info'), 'error');
        }
        if (!$this->request->data) {
            $this->request->data = $user;
        }
    }
}
