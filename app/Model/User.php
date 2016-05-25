<?php
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class User extends AppModel
{
    public $hasMany = ['Activity', 'Lesson'];

    public $hasAndBelongstoMany = [
        'Follower' => [
            'className' => 'User',
            'joinTable' => 'relationships',
            'foreignKey' => 'following_id',
            'associationForeignKey' => 'follower_id'
        ],
        'Following' => [
            'className' => 'User',
            'joinTable' => 'relationships',
            'foreignKey' => 'follower_id',
            'associationForeignKey' => 'following_id'
        ]
    ];

    public $validate = [
        'username' => [
            'required' => [
                'rule' => 'notEmpty',
                'message' => 'User Name required'
            ],
            'rule_unique' => [
                'rule' => 'isUnique',
                'message' => 'This user name has been existed'
            ]
        ],
        'password' => [
            'required' => [
                'rule' => 'notEmpty',
                'message' => 'Password required'
            ]
        ],
        'passwd_confirm' => [
            'require' => [
                'rule' =>  'notEmpty',
                'message' => 'Password confirm required'
            ],
            'match' => [
                'rule' => 'checkPasswordConfirm',
                'message' => 'Password and Password Confirm not match'
            ]
        ],
        'email' =>  [
            'require' => [
                'rule' => 'notEmpty',
                'message' => 'Email is required'
            ],
            'rule_email' => [
                'rule' => 'email',
                'message' => 'Email must be correct format'
            ],
            'rule_unique' => [
                'rule' => 'isUnique',
                'message' => 'This email has been use'
            ]
        ]
    ];

    function checkPasswordConfirm($data)
    {
        if ($this->data['User']['password'] != $this->data['User']['passwd_confirm']) {
            return false;
        }
        
        return true;
    }

    public function beforeSave($options = [])
    {
        if (isset($this->data['User']['password'])) {
            $passwordHasher =  new BlowfishPasswordHasher();
            $this->data['User']['password'] = $passwordHasher->hash($this->data['User']['password']);
        }
        if (isset($this->data['User']['passwd_confirm'])) {
            unset($this->data['User']['passwd_confirm']);
        }

        return true;
    }
}
