<?php
class Activity extends AppModel
{
    public $belongsTo = 'User';

    public function saveActivity($target_id, $user_id, $action)
    {
        $activityData = [
            'target_id' => $target_id,
            'user_id' => $user_id,
            'action_type' => $action
        ];

        return $this->save($activityData);
    }
}
