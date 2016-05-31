<div class="users col-md-8 col-md-offset-2">
{$this->Form->create('User', [
    'enctype' => 'multipart/form-data',
    'class' => 'form',
    'controller' => 'users',
    'action' => 'updateProfile'
])}
    <fieldset>
        <legend>
            {__('Infomation about User')}
        </legend>
        {$this->Form->input('username', [
            'class' => 'form-control',
            'label' => __('User Name')
        ])}
        {$this->Form->input('email', [
            'type' => 'text', 
            'class' => 'form-control'
        ])}
        {$this->Form->input('id', [
            'type' => 'hidden'
        ])}
        {$this->Form->input('avatar_image', [
            'type' => 'file', 
            'class' => 'form-control'
        ])}
    </fieldset>
{$this->Form->end([
    'class' => 'btn btn-primary',
    'label' => __('Update')
])}
</div>
