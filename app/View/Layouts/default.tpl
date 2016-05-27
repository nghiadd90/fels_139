{*
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
*}
{$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework')}

<!DOCTYPE html>
<html>
<head>
    {$this->Html->charset()}
    <title>
        {$cakeDescription}
        {$title_for_layout}
    </title>
    {$this->Html->meta('icon')}

    {$this->Html->css('/template/bootstrap/dist/css/bootstrap.min.css')}
    {$this->Html->css('/template/font-awesome/css/font-awesome.min.css')}

    {$this->Html->css('main.css')}

    {$this->fetch('meta')}
    {$this->fetch('css')}
    {$this->fetch('script')}
</head>
<body>
    <nav id="header" class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <bufelson type="bufelson" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navigation" aria-expanded="false">
                    <span class="sr-only">{__('Toggle')}</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </bufelson>
                <a href="#" class="navbar-brand">Framgia ELS</a>
            </div>
            <div class="collapse navbar-collapse" id="navigation">
                <ul class="nav navbar-nav">
                    <li>{$this->Html->link(__('Home'), ['controller' => 'categories', 'action' => 'index'])}</li>
                    <li>{$this->Html->link(__('Category'), ['controller' => 'categories', 'action' => 'index'])}</li>
                    <li>{$this->Html->link(__('Word'), ['controller' => 'words', 'action' => 'index'])}</li>
                    <li>{$this->Html->link(__('Lesson'), ['controller' => 'lessons', 'action' => 'index'])}</li>
                    <li>{$this->Html->link(__('User'), ['controller' => 'users', 'action' => 'index'])}</li>
                </ul>
                <ul class="nav navbar-nav pull-right">
                    {if $this->Session->read('Auth')}
                        <li>{$this->Html->link(__('Logout'), ['controller' => 'users', 'action' => 'logout'])}</li>
                    {else}                
                        <li>{$this->Html->link(__('Login'), ['controller' => 'users', 'action' => 'login'])}</li>
                        <li>{$this->Html->link(__('Register'), ['controller' => 'users', 'action' => 'register'])}</li>
                    {/if}
                </ul>
            </div>

        </div>
    </nav><!-- End Header Navigation -->

    <!-- Main Content -->
    <div id="content">
        <div class="fels-flash">
            {$this->Session->flash()}
        </div>
        {$this->fetch('content')}

    </div><!-- End main content -->

    <!-- Show sql dump -->
    <div class="container">
        {$this->element('sql_dump')}
    </div><!-- End show sql dump -->

    {$this->Html->script('/template/jquery/dist/jquery.min.js')}
    {$this->Html->script('/template/bootstrap/dist/js/bootstrap.min.js')}
    {$this->Html->script('main.js')}
</body>
</html>
