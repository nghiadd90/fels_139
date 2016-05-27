<!-- File: app/View/Words/index.tpl -->
<div class="fels-header">
    <div class="container">
        <h1>{__('Word List')}</h1>
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
        </div>

        <!-- index content -->
        <div class="fels-index col-sm-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>{__('Id')}</th>
                        <th>{__('Content')}</th>
                        <th>{__('Action')}</th>
                        <th>{__('Created')}</th>
                    </tr>

                    {foreach $words as $word}
                    <tr>
                        <td>{$word['Word']['id']}</td>
                        <td>{$this->Html->link($word['Word']['content'], ['action' => 'view', $word['Word']['id']])}</td>
                        <td>
                            {$this->Html->link(
                                '<i class="fa fa-pencil"></i> Edit',
                                [
                                    'action' => 'edit',
                                    $word['Word']['id']
                                ],
                                [
                                    'class' => 'btn btn-default btn-primary',
                                    'escape' => false
                                ]
                            )}
                            {$this->Form->postLink(
                                '<i class="fa fa-trash"></i> Delete',
                                [
                                    'action' => 'delete',
                                    $word['Word']['id']
                                ],
                                [
                                    'confirm' => 'Are you sure?',
                                    'class' => 'btn btn-default btn-danger',
                                    'escape' => false
                                ]
                            )}
                        </td>
                        <td>{$word['Word']['created']}</td>
                    </tr>
                    {/foreach}
                </table>
            </div><!-- end table-responsive -->
        </div><!-- end index content -->
    </div>
</div>
