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
}
