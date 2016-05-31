<div class="col-md-12" >
    <div class="panel panel-default">
        <div class="panel-heading">
            {__('Profile of ')} {$user['User']['username']}
        </div>
        <div class="panel-body">
            <p><strong>{__('User Name :')}</strong> {$user['User']['username']}</p> 
            <p><strong>{__('Email :')}</strong> {$user['User']['email']}</p>
            {if $user['User']['id'] != $authUser['id']}
                {$this->CheckRelationship->checkRelationship($user, $authUser['id'])}
            {/if}
        </div>
    </div>
</div>