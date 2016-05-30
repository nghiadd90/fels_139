<?php
class Category extends AppModel
{
    public $hasMany = ['Lesson', 'Word'];

    public $validate = [
        'name' => [
            'rule' => 'notEmpty',
            'message' => 'This field is required'
        ]
    ];

    /**
     * count total words in category
     * @return array (key is category id, value is total words in that category)
     */
    public function totalWordsInCategory()
    {
        $this->recursive = -1;
        $results = $this->find('list', ['fields' => 'Category.id']);
        $totalWordsInCategory = [];
        foreach ($results as $result) {
            $totalWordsInCategory[$result] = $this->Word->find('count', [
                'conditions' => [
                    'Word.category_id' => $result
                ]
            ]);
        }

        return $totalWordsInCategory;
    }

    /**
     * total words that current user learned in category
     * @return array (key is category id, value is total learned word by current user in that category)
     */
    public function totalLearnedWordsInCategory()
    {
        $user = $this->getCurrentUser();
        $user_id = $user['id'];
        $this->recursive = -1;
        $options = [
            'joins' => [
                [
                    'table' => 'lessons',
                    'alias' => 'l',
                    'type' => 'left',
                    'conditions' => ['Category.id = l.category_id']
                ],
                [
                    'table' => 'lesson_words',
                    'alias' => 'lw',
                    'type' => 'left',
                    'conditions' => ['l.id = lw.lesson_id']
                ],
                [
                    'table' => 'words',
                    'alias' => 'w',
                    'type' => 'left',
                    'conditions' => ['lw.word_id = w.id']
                ],
                [
                    'table' => 'word_answers',
                    'alias' => 'wa',
                    'type' => 'left',
                    'conditions' => ['lw.word_answer_id = wa.id']
                ]
            ],
            'conditions' => [
                'l.user_id' => $user_id,
                'wa.correct' => 1
            ],
            'group' => 'Category.id',
            'fields' => [
                "COUNT('w.id') as total_learned_words",
                'Category.id'
            ]
        ];

        $results = $this->find('all', $options);
        $learnedWordsInCategory = [];
        foreach ($results as $result) {
            $learnedWordsInCategory[$result['Category']['id']] = $result[0]['total_learned_words'];
        }

        // set $data for categories do not have any words that learned by current user
        $categories = $this->find('list', [
            'fields' => 'Category.id'
        ]);

        foreach ($categories as $category) {
            if (!isset($learnedWordsInCategory[$category])) {
                $learnedWordsInCategory[$category] = 0;
            }
        }

        return $learnedWordsInCategory;
    }
}
