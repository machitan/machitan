<?php
/**
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

$cakeDescription = __d('cake_dev', 'まちたん！');
/*$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())*/
$time_newest = time();
//header( "Last-Modified: " . gmdate( "D, d M Y H:i:s", $time_newest ) . " GMT" );
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimal-ui">
        <meta name="apple-mobile-web-app-capable" content="yes" />

        <title>
            <?php echo $cakeDescription ?>
        </title>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
        <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

        <?php
            echo $this->Html->meta('icon');

            /*grid css in body*/
            //echo $this->Html->css('tileindex.css');

            /*bootstrap files*/
            echo $this->Html->css('bootstrap.min.css');

            echo $this->Html->css('flexslider.css');

            echo $this->fetch('meta');
            echo $this->fetch('css');
            echo $this->fetch('script');
        ?>
       
        <script src="/js/jquery.rateyo.min.js"></script>
        <style src="/css/jquery.rateyo.min.css"></style>
        
        <script src="/js/jquery.flexslider.js"></script>

        <style async src="/css/cake.generic"></style>
       
        <script async src="/js/bootstrap.js"></script>
        <script src="/js/material.min.js"></script>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <script async src="/js/jquery.easing.compatibility.js"></script>
        <!-- <script async src="/js/jquery.vgrid.min.js"></script> -->

        <script async src="/js/bootstrap-transition.js"></script>

        <!-- Material Design for bootstrap -->
        <link href="/css/material-css/roboto.min.css" rel="stylesheet">
        <link href="/css/material-css/material.min.css" rel="stylesheet">
        <link href="/css/material-css/ripples.min.css" rel="stylesheet">
        
        <style>
        .main-content { 
        }
        #map-canvas {
            height: 100%;
            margin: 0px;
            padding: 0px
        }
        </style>
        <script>
             $(document).ready(function() {
                 // This command is used to initialize some elements and make them work properly
                 $.material.init();
             });
         </script>
         
         <!--  sweetalert -->
        <script src="/vendors/sweetalert2-master/dist/sweetalert2.min.js"></script>
        <link rel="stylesheet" type="text/css" href="/vendors/sweetalert2-master/dist/sweetalert2.css">

        <!-- intro js -->
        <script src="/vendors/intro.js-1.1.1/minified/intro.min.js"></script>
        <link rel="stylesheet" type="text/css" href="/vendors/intro.js-1.1.1/minified/introjs.min.css">

    </head>

    <body>

        <div class="main-content">
            <?php echo $this->Session->flash(); ?>
            <?php echo $this->fetch('content'); ?>
        </div><!--/.main-content-->

    </body>
</html>
