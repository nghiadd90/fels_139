<!-- File: app/View/Words/index.tpl -->
<div class="fels-header">
    <div class="container">
        <h1>{h($word['Word']['content'])}</h1>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="fels-add-button col-sm-12">
            {$this->Html->link(
                __('Edit Word'),
                [
                    'controller' => 'words',
                    'action' => 'edit',
                    $word['Word']['id']
                ],
                [
                    'class' => 'btn btn-default btn-primary'
                ]
            )}
            {$this->Html->link(
                __('Back words list'),
                [
                    'controller' => 'words',
                    'action' => 'index'
                ],
                [
                    'class' => 'btn btn-default btn-primary pull-right'
                ]
            )}
        </div>

        <!-- index content -->
        <div class="fels-index col-sm-12">
            <h4>{__('Words answer')}</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>{__('Id')}</th>
                        <th>{__('Content')}</th>
                        <th>{__('Correct')}</th>
                        <th>{__('Created')}</th>
                    </tr>
                    {foreach $word['WordAnswer'] as $wordAnswer}
                    <tr>
                        <td>{$wordAnswer['id']}</td>
                        <td>{$wordAnswer['content']}</td>
                        <td>{($wordAnswer['correct'] == 1) ? __('Correct') : __('Incorrect')}
                        </td>
                        <td>{$wordAnswer['created']}</td>
                    </tr>
                    {/foreach}
                </table>
            </div><!-- end table-responsive -->
        </div><!-- end index content -->
    </div>
</div>
