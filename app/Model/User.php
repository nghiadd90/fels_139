<?php
class User extends AppModel
{
    public $hasMany = ['Activity', 'Lesson'];

    public $hasAndBelongstoMany = [
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
}
