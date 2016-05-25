<?php
class Lesson extends AppModel
{
    public $belongsTo = ['User', 'Category'];

    public $hasMany = 'LessonWord';
}
