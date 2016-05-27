<!-- File: app/View/Categories/index.tpl -->
<div class="fels-header">
    <div class="container">
        <h1>{__('Word categories')}</h1>
        <p>{__('Summary about word categories')}</p>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="fels-add-button col-sm-12">
            {$this->Html->link(
                __('Add Category'),
                [
                    'controller' => 'categories',
                    'action' => 'add'
                ],
                [
                    'class' => 'btn btn-default btn-primary'
                ]
            )}
        </div>

        <!-- index content -->
        <div class="fels-index col-sm-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>{__('Id')}</th>
                        <th>{__('Name')}</th>
                        <th>{__('Action')}</th>
                        <th>{__('Created')}</th>
                    </tr>
                    {assign var="edit_link" value="<i class='fa fa-pencil'></i>  {__('Edit')}"}
                    {assign var="delete_link" value="<i class='fa fa-trash'></i>  {__('Delete')}"}
                    {foreach $categories as $category}
                    <tr>
                        <td>{$category['Category']['id']}</td>
                        <td>{$this->Html->link($category['Category']['name'], ['action' => 'view', $category['Category']['id']])}</td>
                        <td>
                            {$this->Html->link(
                                $edit_link,
                                [
                                    'action' => 'edit',
                                    $category['Category']['id']
                                ],
                                [
                                    'class' => 'btn btn-default btn-primary',
                                    'escape' => false
                                ]
                            )}
                            {$this->Form->postLink(
                                $delete_link,
                                [
                                    'action' => 'delete',
                                    $category['Category']['id']
                                ],
                                [
                                    'confirm' => __('Are you sure?'),
                                    'class' => 'btn btn-default btn-danger',
                                    'escape' => false
                                ]
                            )}
                        </td>
                        <td>{$category['Category']['created']}</td>
                    </tr>
                    {/foreach}
                </table>
            </div><!-- end table-responsive -->
        </div><!-- end index content -->
    </div>
</div>
