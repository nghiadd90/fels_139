<?php
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

class User extends AppModel
{
    public $findMethods = ['learned' => true];

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

    public function totalLearnedWords()
    {
        return sizeof($this->learnedWordList());
    }

    /**
     * generate list of words that learned by current user
     * @param  integer $category_id
     * @return array              (key is word id, value is word content)
     */
    public function learnedWordList($category_id = null)
    {
        $categoryModel = ClassRegistry::init('Category');
        $user = $this->getCurrentUser();
        $user_id = $user['id'];
        $this->recursive = -1;
        $options = [
            'joins' => [
                [
                    'table' => 'lessons',
                    'alias' => 'l',
                    'type' => 'inner',
                    'conditions' => ['User.id = l.user_id']
                ],
                [
                    'table' => 'lesson_words',
                    'alias' => 'lw',
                    'type' => 'inner',
                    'conditions' => ['l.id = lw.lesson_id']
                ],
                [
                    'table' => 'words',
                    'alias' => 'w',
                    'type' => 'inner',
                    'conditions' => ['lw.word_id = w.id']
                ],
                [
                    'table' => 'word_answers',
                    'alias' => 'wa',
                    'type' => 'inner',
                    'conditions' => ['lw.word_answer_id = wa.id']
                ]
            ],
            'conditions' => [
                'User.id' => $user_id,
                'wa.correct' => 1
            ],
            'fields' => ['w.id', 'w.content']
        ];

        if (isset($category_id) && $categoryModel->exists($category_id)) {
            $options['conditions']['l.category_id'] = $category_id;
        }

        $results = $this->find('all', $options);

        $learnedWordList = [];
        foreach ($results as $result) {
            $learnedWordList[$result['w']['id']] = $result['w']['content'];
        }

        return $learnedWordList;
    }

    /**
     * generate list of words that not learned by current user
     * @param  integer $category_id
     * @return array              (key is word id, value is word content)
     */
    public function notLearnedWordList($category_id = null)
    {
        $categoryModel = ClassRegistry::init('Category');
        $wordModel = ClassRegistry::init('Word');

        $options = [
            'fields' => [
                'Word.id',
                'Word.content'
            ],
            'recursive' => -1
        ];

        if (isset($category_id) && $categoryModel->exists($category_id)) {
            $learnedWordList = $this->learnedWordList($category_id);
            $options['conditions'] = [
                'Word.category_id' => $category_id
            ];
        }

        $wordLists = $wordModel->find('all', $options);

        $notLearnedWordList = [];
        foreach ($wordLists as $wordList) {
            $notLearnedWordList[$wordList['Word']['id']] = $wordList['Word']['content'];
        }

        //filter list of unlearned words
        foreach ($learnedWordList as $key => $value) {
            if (array_key_exists($key, $notLearnedWordList)) {
                unset($notLearnedWordList[$key]);
            }
        }

        return $notLearnedWordList;
    }

    /**
     * list of 20 words will be shown for lesson
     * @param  integer $category_id
     * @return array  (each element comprise of data about word and answer for this word)
     */
    public function wordsForLesson($category_id = null)
    {
        ClassRegistry::init([
            [
                'class' => 'Word',
                'alias' => 'Word'
            ],
            [
                'class' => 'WordAnswer',
                'alias' => 'WordAnswer'
            ],
            [
                'class' => 'Category',
                'alias' => 'Category'
            ]
        ]);
        $model = ClassRegistry::getInstance();

        if (!$model->getObject('Category')->exists($category_id)) {
            throw new NotFoundException(__('Invalid category'));
        }

        $count = 0;
        $notLearnedWordList = $this->notLearnedWordList($category_id);
        $wordsForLesson = [];

        foreach ($notLearnedWordList as $key => $value) {
            if ($count >= 2) {
                unset($notLearnedWordList[$key]);
                continue;
            }

            $wordsForLesson[$count] = [
                'Word' => [
                    'id' => $key,
                    'content' => $value
                ],
                'wa' => $model->getObject('WordAnswer')->find('all', [
                    'conditions' => [
                        'WordAnswer.word_id' => $key
                    ],
                    'recursive' => -1,
                    'fields' => [
                        'WordAnswer.id',
                        'WordAnswer.content',
                        'WordAnswer.correct'
                    ]
                ])
            ];

            $count++;
        }

        return $wordsForLesson;
    }

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
