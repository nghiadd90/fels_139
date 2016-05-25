<?php
class WordAnswer extends AppModel
{
    public $belongsTo = 'Word';

    public $hasMany = 'LessonWord';
}
