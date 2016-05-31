<div class="col-md-3">
    <div class="thumbnail">
        {$this->PrintList->printAvatar($user)}
        <div class="caption">
            <h3>{$user['User']['username']}</h3>
            <p>{__('You learned ')} {count($wordLearned)}/{count($allWord)} {__(' words')}</p>
            {$this->PrintList->printUpdateProfile($user, $authUser)}
        </div>
    </div>
</div>
