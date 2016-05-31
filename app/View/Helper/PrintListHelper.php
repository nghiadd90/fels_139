<?php
App::uses('AppHelper', 'View/Helper');
App::import('Model', 'User');
App::import('Model', 'Lesson');

class PrintListHelper extends AppHelper
{
    public $helpers = ['Html', 'Ajax', 'Form'];

    public function printModel($model, $name)
    {
        if ($name == 'User') {
            $editLink = $this->Html->link(__('Edit'), [
                'controller' => 'users',
                'action' => 'edit',
                $model['User']['id']
            ],
            [
                'class' => 'btn btn-warning'
            ]);
            
            $deleteLink = $this->Form->postLink(__('Delete'), [
                'controller' => 'users',
                'action' => 'delete',
                $model['User']['id']
            ],
            [
                'confirm' => __('Are you sure?'),
                'class' => 'btn btn-danger'
            ]);
            $viewLink = $this->Html->link($model['User']['username'], [
                'controller' => 'users', 
                'action' => 'view',
                $model['User']['id']
            ]);
            
            return $this->Html->tableCells([
                [$model['User']['id'], $viewLink, $editLink, $deleteLink]
            ]);
        } elseif ($name == 'Activity') {
            if ($model['action_type'] == 'follow' || $model['action_type'] == 'unfollow') {
                $userModel = new User();
                $target = $userModel->find('first', [
                    'conditions' => [
                        'User.id' => $model['target_id']
                    ]
                ]);

                return $model['action_type'] . ' ' . $target['User']['username'] . __(' at ') . $model['created'];
            }
            $lessonModel = new Lesson();
            $target = $lessonModel->find('first', [
                'conditions' => [
                'Lesson.id' => $model['target_id']
                ]
            ]);

            return $model['action_type'] . ' ' . $target['Lesson']['result'] . __(' words in Category ') . $target['Category']['name'] . __(' at ') . $model['created'];
        }
    }

    public function printAvatar($user)
    {
        if ($user['User']['avatar'] == null) {

            return '<img src="http:\\\placehold.it\200x200" alt="User avatar">';
        } else {
            
            return '<img src="' . $user['User']['avatar'] . '" alt="User avatar">';
        }
    }

    public function printUpdateProfile($user, $authUser)
    {
        if ($user['User']['id'] == $authUser['id']) {
            $updateProfileLink = $this->Html->link(__('Update Profile'), [
                'controller' => 'users',
                'action' => 'updateProfile',
                $user['User']['id']
            ],
            [
                'class' => 'btn btn-info'
            ]);

            return $updateProfileLink;
        }
    }
}