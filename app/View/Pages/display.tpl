<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{__('Framgia E Learning System')}</title>

    <!-- Bootstrap Core CSS -->
    {$this->Html->css('/template/bootstrap/dist/css/bootstrap.min.css')}

    <!-- Custom CSS -->
    {$this->Html->css('/template/bootstrap/dist/css/stylish-portfolio.css')}

    <!-- Custom Fonts -->
    {$this->Html->css('/template/font-awesome/css/font-awesome.min.css')}
    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <a id="menu-toggle" href="#" class="btn btn-dark btn-lg toggle"><i class="fa fa-bars"></i></a>
    <nav id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <a id="menu-close" href="#" class="btn btn-light btn-lg pull-right toggle"><i class="fa fa-times"></i></a>
            <li class="sidebar-brand">
                <a href="#top" onclick = $("#menu-close").click();> {__('FELS 2016')}</a>
                {if $this->Session->read('Auth.User')}
                    <li>
                        {$this->Html->link(__(' Profile'), [
                            'controller' => 'users',
                            'action' => 'view',
                            $authUser
                        ])}
                    </li>
                {else}
                    <li>
                        {$this->Html->link(__(' Login'), [
                            'controller' => 'users',
                            'action' => 'login'
                        ])}
                    </li>
                    <li>
                        {$this->Html->link(__(' Register'), [
                            'controller' => 'users',
                            'action' => 'register'
                        ])}
                    </li>
                {/if}
            </li>
        </ul>
    </nav>

    <!-- Header -->
    <header id="top" class="header">
        <div class="text-vertical-center">
            <h1>{__('Framgia E Learning System')}</h1>
            <h3>{__('Study more and more')}</h3>
            <br>
            <a href="#about" class="btn btn-dark btn-lg">Find Out More</a>
        </div>
    </header>

    <!-- About -->
    <section id="about" class="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>{__('Framgia E Learning System Where you can get best knowledges and skills')}</h2>
                    <p class="lead">{__('Register now for discount')}{$this->Html->link(__(' Register'), [
                        'controller' => 'users',
                        'action' => 'register'
                    ])}</p>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-lg-offset-1 text-center">
                    <h4><strong>{__('Framgia E Learning System')}</strong>
                    </h4>
                    <p>{__('13th Floor Keaang Nam LandMark 72 Tower')}<br>{__('Tu Liem District, Ha Noi')}</p>
                    <ul class="list-unstyled">
                        <li><i class="fa fa-phone fa-fw"></i> 04 3795 5417</li>
                        <li><i class="glyphicon glyphicon-home"></i>{$this->Html->link(' Framgia VietNam', 'http://recruit.framgia.vn/')}
                    </ul>
                    <br>
                    <ul class="list-inline">
                        <li>
                            <a href="#"><i class="fa fa-facebook fa-fw fa-3x"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-twitter fa-fw fa-3x"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-dribbble fa-fw fa-3x"></i></a>
                        </li>
                    </ul>
                    <hr class="small">
                    <p class="text-muted">Copyright &copy; Framgia E Learning System</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- jQuery -->
    {$this->Html->script('/template/jquery/dist/jquery.min.js')}

    <!-- Bootstrap Core JavaScript -->
    {$this->Html->script('/template/bootstrap/dist/js/bootstrap.min.js')}

    <!-- Custom Theme JavaScript -->
    <script>
    // Closes the sidebar menu
    $("#menu-close").click(function(e) {
        e.preventDefault();
        $("#sidebar-wrapper").toggleClass("active");
    });

    // Opens the sidebar menu
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#sidebar-wrapper").toggleClass("active");
    });

    // Scrolls to the selected menu item on the page
    $(function() {
        $('a[href*=#]:not([href=#])').click(function() {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') || location.hostname == this.hostname) {

                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html,body').animate({
                        scrollTop: target.offset().top
                    }, 1000);
                    return false;
                }
            }
        });
    });
    </script>

</body>

</html>
