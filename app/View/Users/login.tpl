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
            'label' => _('User Name'),
            'class' => 'form-control',
            'placeholder' => __('Your User Name')
        ])}
        {$this->Form->input('password', [
            'label' => 'Password', 
            'class' => 'form-control',
            'placeholder' => __('Your Password')
        ])}
    </fieldset>
{$this->Form->end([
    'class' => 'btn btn-primary ',
    'label' => __('Login')
])}
</div>