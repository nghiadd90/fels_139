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
}
