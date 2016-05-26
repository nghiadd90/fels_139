<?php
App::uses('AppHelper', 'View/Helper');

class PrintListHelper extends AppHelper
{
    public $helpers = ['Html', 'Ajax', 'Form'];

    public function printModel($model)
    {

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
    }
}