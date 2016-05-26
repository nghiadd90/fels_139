<table>
    {foreach $data as $user}
        {$this->PrintList->printModel($user)}
    {/foreach}
</table>
{$this->Paginator->numbers(['User'])}