<!-- File: app/View/Lessons/index.tpl -->
<div class="fels-header">
    <div class="container">
        <h1>{$lessonResult[0]['ct']['name']}{__(' Lesson Result')} {$lessonResult[0]['Lesson']['result']}/{sizeof($lessonResult)}</h1>
    </div>
</div>
<div class="container">
    <div class="row">
        <!-- index content -->
        <div class="fels-index col-sm-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>{__('Word')}</th>
                        <th>{__('Answer')}</th>
                        <th>{__('Correct')}</th>
                    </tr>

                    {foreach $lessonResult as $lessonWord}
                    <tr>
                        <td>{$lessonWord['w']['content']}</td>
                        <td>{$lessonWord['wa']['content']}</td>
                        <td>{($lessonWord['wa']['correct'])? 'Correct' : 'Incorrect'}
                        </td>
                    </tr>
                    {/foreach}
                </table>
            </div><!-- end table-responsive -->
        </div><!-- end index content -->
    </div>
</div>
