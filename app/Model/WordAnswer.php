<?php
class WordAnswer extends AppModel
{
    public $belongsTo = 'Word';

    public $hasMany = 'LessonWord';

    public $validate = [
        'content' => [
            'notempty' => [
                'rule' => 'notEmpty',
                'message' => 'This field could not be blank'
            ]
        ]
    ];
}
