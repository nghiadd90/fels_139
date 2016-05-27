<div class="users col-md-8 col-md-offset-2">
{$this->Form->create('User', [
    'class' => 'form',
    'controller' => 'users',
    'action' => 'edit'
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
    </fieldset>
{$this->Form->end([
    'class' => 'btn btn-primary',
    'label' => __('Update')
])}
</div>