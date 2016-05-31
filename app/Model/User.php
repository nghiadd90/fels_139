<?php
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

class User extends AppModel
{
    public $hasMany = ['Activity', 'Lesson'];

    public $hasAndBelongsToMany = [
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
                'rule' => 'notEmpty',
                'message' => 'Password confirm required'
            ],
            'match' => [
                'rule' => 'checkPasswordConfirm',
                'message' => 'Password and Password Confirm not match'
            ]
        ],
        'email' => [
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
        ],
        'avatar_image' => [
            'rule_image' => [
                'rule' => ['extension', ['jpg', 'png', 'jepg']],
                'message' => 'This file is not image'
            ]
        ]
    ];

    public function checkPasswordConfirm($data)
    {
        if ($this->data['User']['password'] != $this->data['User']['passwd_confirm']) {
            return false;
        }
        
        return true;
    }

    public function beforeSave($options = [])
    {
        if (isset($this->data['User']['password'])) {
            $passwordHasher = new BlowfishPasswordHasher();
            $this->data['User']['password'] = $passwordHasher->hash($this->data['User']['password']);
        }
        if (isset($this->data['User']['passwd_confirm'])) {
            unset($this->data['User']['passwd_confirm']);
        }
        if (isset($this->data['User']['avatar_image'])) {
            $fileUploaded = $this->data['User']['avatar_image']['name'];
            $extension = pathinfo($fileUploaded, PATHINFO_EXTENSION);
            $filename = 'img'. DS . 'avatar' . DS . $this->data['User']['id'] . DS . $this->data['User']['id'] . '.' . $extension;
            if ($extension != '') {
                $uploadFolder = 'img'. DS . 'avatar' . DS . $this->data['User']['id'];
                $folder = new Folder($uploadFolder);
                if (is_null($folder->path)) {
                    $folder->create($uploadFolder, 0777);
                } else {
                    $folder->delete();
                    $folder->create($uploadFolder, 0777);
                }
                move_uploaded_file($this->data['User']['avatar_image']['tmp_name'], $filename);
                $this->data['User']['avatar'] = DS . APP_DIR . DS . WEBROOT_DIR . DS . $filename;
            }
        }

        return true;
    }
}
