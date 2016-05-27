<!-- File: app/View/Words/add.tpl -->

<div class="fels-header">
    <div class="container">
        <h1>{__('Add Word')}</h1>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="fels-add-button col-sm-12">
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
        <div class="fels-index col-sm-12">
            {$this->Form->create(
                'Word',
                [
                    'class' => 'form-horizontal'
                ]
            )}
            {$this->Form->input(
                'Word.content',
                [
                    'div' => 'form-group',
                    'class' => 'form-control',
                    'between' => '<div class="col-sm-10">',
                    'after' => '</div>',
                    'label' => [
                        'text' => __('Word content'),
                        'class' => 'col-sm-2'
                    ]
                ]
            )}

            {$this->Form->input('Word.category_id')}

            <h4>{__('Add answers')}</h4>
            {for $i = 0 to 3}
                <div class="form-group">
                    {$this->Form->input(
                        "WordAnswer.$i.content",
                        [
                            'class' => 'form-control',
                            'label' => false
                        ]
                    )}
                    {$this->Form->checkbox(
                        "WordAnswer.$i.correct"
                    )}
                    {$this->Form->label(
                        __('Correct'),
                        null,
                        [
                            'for' => "WordAnswer{$i}correct"
                        ]
                    )}
                    {$this->Form->hidden("WordAnswer.$i.id")}
                </div>
            {/for}

            {$this->Form->submit(
                __('Add Word'),
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
