<?php
App::uses('AppHelper', 'View/Helper');

class CheckRelationshipHelper extends AppHelper
{
    public $helpers = ['Html', 'Form'];

    public function checkRelationship($following, $follower_id)
    {
        $listFollowers = $following['Follower'];
        foreach ($listFollowers as $key => $follwer) {
            if ($follwer['id'] == $follower_id) {

                return $this->Html->link(__('UnFollow'), [
                    'controller' => 'users',
                    'action' => 'unfollow',
                    $following['User']['id'], 
                ], 
                [
                    'class' => 'btn btn-primary'
                ]);
            }
        }

        return $this->Html->link(__('Follow'), [
            'controller' => 'users',
            'action' => 'follow',
            $following['User']['id']
        ],
        [
            'class' => 'btn btn-primary'
        ]);
    }

    public function checkActivities($following, $follower_id)
    {
        $listFollowers = $following['Follower'];
        if ($following['User']['id'] == $follower_id) {

            return true;
        } else {
            foreach ($listFollowers as $key => $follower) {
                if ($follower['id'] == $follower_id) {

                    return true;
                }
            }

            return false;
        }
    }
}