<!-- File: app/View/Lessons/learn.tpl -->
<div class="fels-header">
    <div class="container">
        <h1>{h($category['Category']['name'])}</h1>
    </div>
</div>
<div class="container">
    <div class="row">
        <!-- index content -->
        <div class="fels-index col-sm-12">
            {$this->Form->create(
                'Lesson',
                [
                    'class' => 'form-horizontal'
                ]
            )}
            {assign var="counter" value=1}
            {foreach $wordList as $word}
            <div class="">
                <h4>{$counter} - {$word['Word']['content']}</h4>
                <div class="row">

               {$this->Form->input(
                    "LessonWord.{$counter}.word_id",
                    [
                        'type' => 'hidden',
                        'value' => $word['Word']['id']
                    ]
               )}

               {$options=[]}
               {foreach $word['wa'] as $each}
                    {$options[$each['WordAnswer']['id']] = $each['WordAnswer']['content']}
               {/foreach}

               {$this->Form->radio(
                    "LessonWord.{$counter++}.word_answer_id",
                    $options,
                    [
                        'legend' => false
                    ]
               )}
                </div>
            </div>
            {/foreach}

            {$this->Form->input(
                'Lesson.category_id',
                [
                    'type' => 'hidden',
                    'value' => $category['Category']['id']
                ]
            )}

            {$this->Form->submit(
                __('Finish lesson'),
                [
                    'div' => 'form-group',
                    'before' => '<div class="col-sm-12">',
                    'after' => '</div>',
                    'class' => 'btn btn-default btn-primary'
                ]
            )}
            {$this->Form->end()}
        </div>
    </div>
</div>
