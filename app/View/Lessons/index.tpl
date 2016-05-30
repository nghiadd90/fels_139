<!-- File: app/View/Lessons/index.tpl -->
<div class="fels-header">
    <div class="container">
        <h1>{__('Lesson List')}</h1>
    </div>
</div>
<div class="container">
    <div class="row">
        <!-- index content -->
        <div class="fels-index col-sm-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>{__('Id')}</th>
                        <th>{__('Content')}</th>
                        <th>{__('View result')}</th>
                        <th>{__('Time')}</th>
                    </tr>
                    {assign var="view_result" value="<i class='fa fa-pencil'></i>  {__('View result')}"}
                    {foreach $lessons as $lesson}
                    <tr>
                        <td>{$lesson['Lesson']['id']}</td>
                        <td>{__('You learned one lesson from "')}{$lesson['Category']['name']}{__('" course')}</td>
                        <td>
                            {$this->Html->link(
                                $view_result,
                                [
                                    'action' => 'result',
                                    $lesson['Lesson']['id']
                                ],
                                [
                                    'class' => 'btn btn-default btn-primary',
                                    'escape' => false
                                ]
                            )}
                        </td>
                        <td>{$lesson['Lesson']['created']}</td>
                    </tr>
                    {/foreach}
                </table>
            </div><!-- end table-responsive -->
        </div><!-- end index content -->
    </div>
</div>
