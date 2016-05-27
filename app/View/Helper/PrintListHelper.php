<?php
App::uses('AppHelper', 'View/Helper');

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
            ]);
            
            $deleteLink = $this->Form->postLink(__('Delete'), [
                'controller' => 'users',
                'action' => 'delete',
                $model['User']['id']
            ],
            [
                'confirm' => __('Are you sure?')
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

            return $model['action_type'] . __(' at ') . $model['created'];
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
}