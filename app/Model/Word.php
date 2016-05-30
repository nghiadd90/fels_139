<?php
class Word extends AppModel
{
    public $belongsTo = 'Category';

    public $hasMany = ['WordAnswer', 'LessonWord'];

    public $validate = [
        'content' => [
            'rule' => 'notEmpty',
            'message' => 'This field could not be blank'
        ]
    ];

    public function isCorrect($word_id, $word_answer_id)
    {
        return $this->WordAnswer->find('count', [
            'conditions' => [
                'WordAnswer.correct' => 1,
                'WordAnswer.word_id' => $word_id,
                'WordAnswer.id' => $word_answer_id
            ]
        ]);
    }
}
