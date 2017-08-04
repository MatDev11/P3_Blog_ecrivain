<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title></title>
    <!-- Bootstrap Core CSS
      <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">

      <link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' rel="stylesheet">-->

    <link rel="stylesheet" type="text/css"
          href="<?= $url; ?>/bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css"
          href="<?= $url; ?>bootstrap/css/bootstrap-responsive.min.css">
    <!-- Theme CSS -->
    <link rel="stylesheet" type="text/css"
          href="<?= $url; ?>css/clean-blog.css">
    <link rel="stylesheet" type="text/css"
          href="<?= $url; ?>css/style.css">

    <!-- Custom Fonts -->
    <link href="<?= $url; ?>font-awesome/css/font-awesome.min.css"
          rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet'
          type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800'
          rel='stylesheet' type='text/css'>


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-default navbar-custom navbar-fixed-top ">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header page-scroll">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                Menu <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand" href="http://localhost/Blog_Billet_simple_pour_l_Alaska/web/">Blog Billet simple
                pour l'Alaska</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="<?= $url; ?>">Accueil</a>
                </li>
                <li>
                    <a href="<?= $url; ?>admin/">Administration</a>
                </li>
                <?php if ($user->isAuthenticated()) { ?>
                    <li>
                        <a href="<?= $url; ?>admin/disconect/">Déconnexion</a>
                    </li>
                <?php } ?>

            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>

<!-- Page Header -->
<!-- Set your background image for this header on the line below. -->
<header class="intro-header"
        style="background-image: url('http://localhost/Blog_Billet_simple_pour_l_Alaska/Web/img/alaska.jpg')">

    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <div class="site-heading">
                    <h1><?= $titleSite ?></h1>
                    <hr class="small">
                    <span class="subheading">Jean Forteroche</span>
                </div>
            </div>
        </div>
    </div>
</header>


<!-- Main Content -->
<div class="container">
    <div class="row">

        <?php if ($name === 'Backend') { ?>
            <ul class="nav nav-tabs ">

                <li>
                    <a>Administration:</a>
                <li>
                    <a href="<?= $url; ?>admin/">Articles</a>
                </li>

                <li>
                    <a href="<?= $url; ?>admin/comments/">Commentaires</a>
                </li>

            </ul>

        <?php } ?>
        <?php if ($user->hasFlash()) $user->getFlash(); ?>

        <?= $content ?>
    </div>

</div>

<hr>

<!-- Footer -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <p class="copyright text-muted">Copyright &copy; Your Website 2017</p>
            </div>
        </div>
    </div>
</footer>

<!-- jQuery -->
<script src="<?= $url; ?>jquery/jquery.min.js"></script>

<script src="<?= $url; ?>js/tinymce/js/tinymce/tinymce.js" type="text/javascript"></script>

<!-- Bootstrap Core JavaScript -->
<script src="<?= $url; ?>bootstrap/js/bootstrap.min.js"></script>

<!-- Theme JavaScript -->
<script src="<?= $url; ?>js/clean-blog.min.js"></script>
<script src="<?= $url; ?>js/app.js"></script>
<script src="<?= $url; ?>js/bootstrap-paginator.min.js"></script>

</body>

</html>