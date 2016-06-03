<div class="col-md-12" >
    <div class="panel panel-default">
        <div class="panel-heading">
            {__('Activities of ')} {$user['User']['username']}
        </div>
        <div class="panel-body">
            {if $this->CheckRelationship->checkActivities($user, $authUser['id'])}
                {foreach $user['Activity'] as $item}
                    <p>{$user['User']['username']} {$this->PrintList->printModel($item, 'Activity')}</p>
                {/foreach}
            {/if}
        </div>
    </div>
</div>