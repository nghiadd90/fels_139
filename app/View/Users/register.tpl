<div class="users col-md-8 col-md-offset-2">
{$this->Session->flash('auth')}
{$this->Form->create('User', [
    'class' => 'form'
])}
    <fieldset>
        <legend>
            {__('Please enter your username and password')}
        </legend>
        {$this->Form->input('username', [
            'class' => 'form-control',
            'label' => __('User Name')
        ])}
        {$this->Form->input('password', [
            'class' => 'form-control',
            'label' => __('Password'),
            'type' => 'password'
        ])}
        {$this->Form->input('passwd_confirm', [
            'class' => 'form-control',
            'label' => __('Password Confirm'),
            'type' => 'password'
        ])}
        {$this->Form->input('email', [
            'type' => 'text', 
            'class' => 'form-control'
        ])}
        {$this->Form->input('role', [
            'options' => [
                'admin' => 'Admin', 
                'user' => 'User'
            ],
            'class' => 'form-control'
        ])}
    </fieldset>
{$this->Form->end([
    'class' => 'btn btn-primary',
    'label' => __('Register')
])}
</div>