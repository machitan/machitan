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

$cakeDescription = __d('cake_dev', 'まちつむぎ！');
/*$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())*/
$time_newest = time();
//header( "Last-Modified: " . gmdate( "D, d M Y H:i:s", $time_newest ) . " GMT" );
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>
            <?php echo $cakeDescription ?>
        </title>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
        <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

        <?php
    echo $this->Html->meta('icon');

/*original cake css*/
//echo $this->Html->css('cake.generic');

/*grid css in body*/
echo $this->Html->css('tileindex.css');

/*bootstrap files*/
echo $this->Html->css('bootstrap.min.css');

echo $this->Html->css('flexslider.css');
//echo $this->Html->js('jquery.flexslider.js');
//echo $this->Html->script('bootstrap.min.js');



echo $this->fetch('meta');
echo $this->fetch('css');
echo $this->fetch('script');
        ?>
        
        <script src="/js/jRating.jquery.min.js"></script>
        <style src="/css/jRating.jquery.css"></style>
       
         <script src="/js/jquery.rateyo.min.js"></script>
        <style src="/css/jquery.rateyo.min.css"></style>
       
        
        <script src="/js/jquery.flexslider.js"></script>

        <style async src="/css/cake.generic"></style>
       
        <script async src="/js/bootstrap.min.js"></script>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

        <script async src="/js/jquery.easing.compatibility.js"></script>
        <script async src="/js/jquery.vgrid.min.js"></script>

        <script async src="/js/bootstrap-transition.js"></script>

        <script async src="/js/matome.js"></script>
    </head>

    <body>

        <header>
            <!-- タイトルヘッダ -->
            <div class="page-banner">
                <nav class="navbar navbar-inverse" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/">まちたん！</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        
      </ul>
        <p class="navbar-text navbar-right">いってらっしゃい！ <a href="#" class="navbar-link">くまなみ</a>さん</p>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
                <div class="container"></div>
                </div>
            <!-- タイトルヘッダ -->
        </header>    

            
        <!-- コンテンツ -->
        <div class="main-content">
            <?php echo $this->Session->flash(); ?>
            <?php echo $this->fetch('content'); ?>
        </div><!--/.main-content-->
        <!-- コンテンツ -->

        <!-- フッター -->
        <footer>
        <!-- 最下段フッター -->
        <div id="footer-bottom">
            <p  class="muted credit">&copy; 2014<?php if(date("Y")!=2014) echo date("-Y"); ?> All rights reserved, まちたん！＠社会実装型ハッカソン まちつむぎ</p>                
            <br>
        </div>
        <!-- 最下段フッター -->

        </footer>
    <!-- フッター -->
    </body>
</html>
