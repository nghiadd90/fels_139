<!-- File: app/View/Categories/index.tpl -->
<div class="fels-header">
    <div class="container">
        <h1>{h($category['Category']['name'])}</h1>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="fels-add-button col-sm-12">
            {$this->Html->link(
                __('Add Word'),
                [
                    'controller' => 'words',
                    'action' => 'add'
                ],
                [
                    'class' => 'btn btn-default btn-primary'
                ]
            )}
            {$this->Html->link(
                __('Back categories'),
                [
                    'controller' => 'categories',
                    'action' => 'index'
                ],
                [
                    'class' => 'btn btn-default btn-primary pull-right'
                ]
            )}
        </div>

        <!-- index content -->
        <div class="fels-index col-sm-12">
            <h4>{__('List of words')}</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>{__('Id')}</th>
                        <th>{__('Content')}</th>
                        <th>{__('Action')}</th>
                        <th>{__('Created')}</th>
                    </tr>

                    <tr>
                        {assign var="edit_link" value="<i class='fa fa-pencil'></i>  {__('Edit')}"}
                        {assign var="delete_link" value="<i class='fa fa-trash'></i>  {__('Delete')}"}
                        <td>{$category['Category']['id']}</td>
                        <td>{$this->Html->link($category['Category']['name'], ['action' => 'view', $category['Category']['id']])}</td>
                        <td>
                            {$this->Html->link(
                                $edit_link,
                                [
                                    'controller' => 'categories',
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
                                    'controller' => 'categories',
                                    'action' => 'delete',
                                    $category['Category']['id']
                                ],
                                [
                                    'confirm' => __('Are you sure delete this category?'),
                                    'class' => 'btn btn-default btn-danger',
                                    'escape' => false
                                ]
                            )}
                        </td>
                        <td>{$category['Category']['created']}</td>
                    </tr>
                </table>
            </div><!-- end table-responsive -->
        </div><!-- end index content -->
    </div>
</div>


