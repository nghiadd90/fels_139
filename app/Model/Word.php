<?php
class Word extends AppModel
{
    public $belongsTo = 'Category';

    public $hasMany = ['WordAnswer', 'LessonWord'];
}
