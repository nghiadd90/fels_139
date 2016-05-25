<?php
class LessonWord extends AppModel
{
    public $belongsTo = ['Lesson', 'Word', 'WordAnswer'];
}
