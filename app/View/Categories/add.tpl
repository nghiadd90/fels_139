<!-- File: app/View/Categorys/add.tpl -->

<div class="fels-header">
    <div class="container">
        <h1>{__('Add Category')}</h1>
        <p>{__('Summary about add Category')}</p>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="fels-add-button col-sm-12">
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
        <div class="fels-index col-sm-12">
            {$this->Form->create(
                'Category',
                [
                    'class' => 'form-horizontal'
                ]
            )}
            {$this->Form->input(
                'Category.name',
                [
                    'div' => 'form-group',
                    'class' => 'form-control',
                    'between' => '<div class="col-sm-10">',
                    'after' => '</div>',
                    'label' => [
                        'text' => __('Category name'),
                        'class' => 'col-sm-2'
                    ]
                ]
            )}

            {$this->Form->submit(
                __('Add Category'),
                [
                    'div' => 'form-group',
                    'before' => '<div class="col-sm-10 col-sm-offset-2">',
                    'after' => '</div>',
                    'class' => 'btn btn-default btn-primary'
                ]
            )}
            {$this->Form->end()}
        </div>
    </div>
</div>
