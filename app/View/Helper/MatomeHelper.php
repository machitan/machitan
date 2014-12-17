<?php

App::uses('Helper', 'View');

class MatomeHelper extends Helper {

    /* トップ以外のナビバーの描画 */
    public function getNavBar($page){

        echo "<nav class=\"navbar navbar-inverse nav-sticky navbar-static-top\" role=\"navigation\">";
        echo "<div class=\"container\">";
        echo "<div class=\"navbar-header\">";
        echo "<button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\".navbar-collapse\">";
        echo "<span class=\"sr-only\">Toggle navigation</span>";
        echo "<span class=\"icon-bar\"></span>";
        echo "<span class=\"icon-bar\"></span>";
        echo "<span class=\"icon-bar\"></span>";
        echo "</button>";
        echo "</div>";
        echo "<div class=\"collapse navbar-collapse\">";
        echo "<ul class=\"nav navbar-nav\">";
        if(strcmp($page,"about") == 0){
            echo "<li><a href=\"/\"><span class=\"glyphicon glyphicon-home\"> トップ</a></li>";
            echo "<li class=\"dropdown\">";
            echo "<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\"><span class=\"glyphicon glyphicon-check\">　はやりあんてなとは？<b class=\"caret\"></b></a>";
            echo "<ul class=\"dropdown-menu\">";
            echo "<li><a href=\"/about\"><span class=\"glyphicon glyphicon-info-sign\"></span> はやりあんてな概要</a></li>";
            echo "<li><a href=\"/about/sites\"><span class=\"glyphicon glyphicon-list\"> 登録済サイト一覧</a></li>";
            echo "</ul>";
            echo "</li>";
        }else if(strcmp($page,"about-sites") == 0){
            echo "<li><a href=\"/\"><span class=\"glyphicon glyphicon-home\"> トップ</a></li>";
            echo "<li class=\"dropdown\">";
            echo "<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\"><span class=\"glyphicon glyphicon-check\">　はやりあんてなとは？<b class=\"caret\"></b></a>";
            echo "<ul class=\"dropdown-menu\">";
            echo "<li><a href=\"/about\"><span class=\"glyphicon glyphicon-info-sign\"></span> はやりあんてな概要</a></li>";
            echo "<li><a href=\"/about/sites\"><span class=\"glyphicon glyphicon-list\"> 登録済サイト一覧</a></li>";
            echo "</ul>";
            echo "</li>";
        }else if(strcmp($page,"words") == 0){
            echo "<li><a href=\"/\"><span class=\"glyphicon glyphicon-home\"> トップ</a></li>";
            echo "<li class=\"dropdown\">";
            echo "<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\"><span class=\"glyphicon glyphicon-check\">　はやりあんてなとは？<b class=\"caret\"></b></a>";
            echo "<ul class=\"dropdown-menu\">";
            echo "<li><a href=\"/about\"><span class=\"glyphicon glyphicon-info-sign\"></span> はやりあんてな概要</a></li>";
            echo "<li><a href=\"/about/sites\"><span class=\"glyphicon glyphicon-list\"> 登録済サイト一覧</a></li>";
            echo "</ul>";
            echo "</li>";
        }else if(strcmp($page,"error") == 0){
            echo "<li><a href=\"/\"><span class=\"glyphicon glyphicon-home\"> トップ</a></li>";
            echo "<li class=\"dropdown\">";
            echo "<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\"><span class=\"glyphicon glyphicon-check\">　はやりあんてなとは？<b class=\"caret\"></b></a>";
            echo "<ul class=\"dropdown-menu\">";
            echo "<li><a href=\"/about\"><span class=\"glyphicon glyphicon-info-sign\"></span> はやりあんてな概要</a></li>";
            echo "<li><a href=\"/about/sites\"><span class=\"glyphicon glyphicon-list\"> 登録済サイト一覧</a></li>";
            echo "</ul>";
            echo "</li>";
        }
        echo "</ul>";

        echo "</div><!--/.navbar-collapse -->";
        echo "</div><!-- /.container -->";
        echo "</nav><!-- /.navbar -->";
    }

    /* トップで表示するナビバーの描画 */
    public function getNavBarTop($page,$trends,$trendsDate){

        echo "<nav class=\"navbar navbar-inverse nav-sticky navbar-static-top\" role=\"navigation\">";
        echo "<div class=\"container\">";
        echo "<div class=\"navbar-header\">";
        echo "<button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\".navbar-collapse\">";
        echo "<span class=\"sr-only\">Toggle navigation</span>";
        echo "<span class=\"icon-bar\"></span>";
        echo "<span class=\"icon-bar\"></span>";
        echo "<span class=\"icon-bar\"></span>";
        echo "</button>";
        echo "</div>";
        echo "<div class=\"collapse navbar-collapse\">";
        echo "<ul class=\"nav navbar-nav\">";
        echo "<li class=\"active\"><a href=\"/\"><span class=\"glyphicon glyphicon-home\"> トップ</a></li>";
        echo "<li class=\"dropdown\">";
        echo "<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\"><span class=\"glyphicon glyphicon-list\">　トレンドワードランキング <b class=\"caret\"></b></a>";
        echo "<ul class=\"dropdown-menu\">";
        echo "<li><a href=\"#trend-no1\">No.1：" . $trends[0]['Trends']['rank1'] . "</a></li>";
        echo "<li><a href=\"#trend-no2\">No.2：" . $trends[0]['Trends']['rank2'] . "</a></li>";
        echo "<li><a href=\"#trend-no3\">No.3：" . $trends[0]['Trends']['rank3'] . "</a></li>";
        echo "<li><a href=\"#trend-no4\">No.4：" . $trends[0]['Trends']['rank4'] . "</a></li>";
        echo "<li><a href=\"#trend-no5\">No.5：" . $trends[0]['Trends']['rank5'] . "</a></li>";
        echo "<li><a href=\"#trend-no6\">No.6：" . $trends[0]['Trends']['rank6'] . "</a></li>";
        echo "<li><a href=\"#trend-no7\">No.7：" . $trends[0]['Trends']['rank7'] . "</a></li>";
        echo "<li><a href=\"#trend-no8\">No.8：" . $trends[0]['Trends']['rank8'] . "</a></li>";
        echo "<li><a href=\"#trend-no9\">No.9：" . $trends[0]['Trends']['rank9'] . "</a></li>";
        echo "<li><a href=\"#trend-no10\">No.10：" . $trends[0]['Trends']['rank10'] . "</a></li>";
        echo "</ul>";
        echo "</li>";
        echo "<li><a href=\"#new-archives\"><span class=\"glyphicon glyphicon-certificate\"> 新着ピックアップ</a></li>";
        echo "<li class=\"dropdown\">";
        echo "<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\"><span class=\"glyphicon glyphicon-check\">　はやりあんてなとは？<b class=\"caret\"></b></a>";
        echo "<ul class=\"dropdown-menu\">";
        echo "<li><a href=\"/about\"><span class=\"glyphicon glyphicon-info-sign\"></span> はやりあんてな概要</a></li>";
        echo "<li><a href=\"/about/sites\"><span class=\"glyphicon glyphicon-list\"> 登録済サイト一覧</a></li>";
        echo "</ul>";
        echo "</li>";
        echo "</ul>";
        echo "<h4><span class=\"label label-default\">トレンドワード更新時間：" . $trendsDate . "</span></h4>";
        echo "</div><!--/.navbar-collapse -->";
        echo "</div><!-- /.container -->";
        echo "</nav><!-- /.navbar -->";
    }

    /* トレンド表示の場合のタイトル閲覧 */
    public function getTrendTitle($number, $trend_word){
        echo "<form name=\"search_" . $trend_word ."\" method=\"get\" action=\"/words\" >";
        echo "<input type=hidden name=\"target_word\" value=\"" . $trend_word . "\">";
        echo "<h3>トレンドワード NO." . $number . "<br> 【<a href=\"javascript:search_" . $trend_word .".submit()\">" . $trend_word . "</a>】</h3>";
        echo "</form>";
    }

    /* キーワード閲覧の場合のタイトル描画 */
    public function getSearchedTitle($trend_word){
        if(!is_null($trend_word))
            echo "<h3>閲覧キーワード 【" . $trend_word . "】</h3>";
        else
            echo "<h3>閲覧キーワードが指定されていません、新着記事を表示します</h3>";
    }

    /* タイル部分の描画 */
    public function getArchiveTile($archive_date, $archive_title, $archive_url, $archive_summary, $archive_imgurl, $blog_title){

        if(mb_strlen($archive_title) > 35)
            $archive_title = mb_substr($archive_title, 0, 35) . "...";

        //画像URLがあるか確認し、なければデフォルトの画像を使用する
        if(substr($archive_imgurl, 0, strlen("http")) === "http")
            $url = $archive_imgurl;
        else if(substr($archive_imgurl, 0, strlen("../img")) === "../img")
            $url = $archive_imgurl;
            else
            $url = "../img/no-image-1.jpg";

            echo "<a href=\"$archive_url\" class=\"tile\"  target=\"_blank\">";
        echo "<figure class=\"col-xs-6 col-sm-4 col-lg-3 tile\" id=\"tile1\" style=\"background-image: url($url); \">";
        echo "<div class=\"tile-title\">";
        echo "<h3>$archive_title</h3>";
        echo "<p>$blog_title</p>";
        echo "</div>";
        echo "<figcaption>";
        echo "<br>";
        echo "<p>$archive_summary</p>";
        echo "<p>記事更新時間：$archive_date</p>";
        echo "</figcaption>";
        echo "</figure><!--/span-->";
        echo "</a>";
    }

    /* サイドバーのランキングリスト部分の描画 */
    public function getListComponent($archive_title, $archive_url, $badge_num){
        echo "<a href=\"$archive_url\" 
            class=\"list-group-item\">$archive_title
            <span class=\"badge\">$badge_num</span>　</a>";
    }

    /* キーワードで検索した記事の表示 */
    public function getArchiveTileByKeyWord($keyword){
        $num_of_archives = count($keyword);

        if($num_of_archives > 0){
            $count = 0;
            while($num_of_archives > $count){
                $archive_date = $keyword[$count]['Archives']['date'];
                $archive_title = $keyword[$count]['Archives']['title'];
                $blog_title = $keyword[$count]['Archives']['title_blog'];
                $archive_url = $keyword[$count]['Archives']['url_archive'];
                $archive_imgurl = $keyword[$count]['Archives']['imgurl'];
                $this->getArchiveTile($archive_date,$archive_title,$archive_url,"クリックして記事を読む",$archive_imgurl,$blog_title);
                $count++;
            }
        }
        else{
            $archive_imgurl = "../img/no-archive.jpg";

            echo "<figure class=\"col-xs-6 col-sm-4 col-lg-3 tile\" id=\"tile1\" style=\"background-image: url($archive_imgurl); \">";
            echo "<div class=\"tile-title\">";
            echo "<h3>該当の記事がありません</h3>";
            echo "<p>はやりあんてな</p>";
            echo "</div>";
            echo "<figcaption>";
            echo "<br>";
            echo "<p>クリックできません</p>";
            echo "</figcaption>";
            echo "</figure><!--/span-->";

        }
    }
}