<div class="container">
    <table class="table">
        {$this->Html->tableHeaders(['ID', 'User Name', 'Edit Link', 'Delete Link'])}
        {foreach $data as $user}
            {$this->PrintList->printModel($user)}
        {/foreach}
    </table>
    <nav>
        <ul class="pagination">
            {$this->Paginator->numbers([
                'model' => 'User',
                'tag' => 'li',
                'separator' => '',
                'class' => 'item',
                'currentClass' => 'active',
                'currentTag' => 'a',
                'modulus' => 1,
                'ellipsis' => '...',
                'first' => __('First page'),
                'last' => 'Last page'
            ])}
        </ul>
    </nav>
</div>