<!-- ナビバー -->
<?php $this->Matome->getNavBarTop("top",$trends,$trendsDate) ?>
<!-- ナビバー -->

<div class="container">

    <!-- メインコンテンツ -->
    <br>

    <div id="trend-no1"> 
        <?php $this->Matome->getTrendTitle(1,$trends[0]['Trends']['rank1']) ?>
        <div class="row"><?php $this->Matome->getArchiveTileByKeyWord($rank1); ?></div>
    </div>

    <div id="trend-no2"> 
        <?php $this->Matome->getTrendTitle(2,$trends[0]['Trends']['rank2']) ?>
        <div class="row"><?php $this->Matome->getArchiveTileByKeyWord($rank2); ?></div>
    </div>

    <div id="trend-no3"> 
        <?php $this->Matome->getTrendTitle(3,$trends[0]['Trends']['rank3']) ?>
        <div class="row"><?php $this->Matome->getArchiveTileByKeyWord($rank3); ?></div>
    </div>

    <div id="trend-no4"> 
        <?php $this->Matome->getTrendTitle(4,$trends[0]['Trends']['rank4']) ?>
        <div class="row"><?php $this->Matome->getArchiveTileByKeyWord($rank4); ?></div>
    </div>

    <div id="trend-no5"> 
        <?php $this->Matome->getTrendTitle(5,$trends[0]['Trends']['rank5']) ?>
        <div class="row"><?php $this->Matome->getArchiveTileByKeyWord($rank5); ?></div>
    </div>

    <div id="trend-no6"> 
        <?php $this->Matome->getTrendTitle(6,$trends[0]['Trends']['rank6']) ?>
        <div class="row"><?php $this->Matome->getArchiveTileByKeyWord($rank6); ?></div>
    </div>

    <div id="trend-no7"> 
        <?php $this->Matome->getTrendTitle(7,$trends[0]['Trends']['rank7']) ?>
        <div class="row"><?php $this->Matome->getArchiveTileByKeyWord($rank7); ?></div>
    </div>

    <div id="trend-no8"> 
        <?php $this->Matome->getTrendTitle(8,$trends[0]['Trends']['rank8']) ?>
        <div class="row"><?php $this->Matome->getArchiveTileByKeyWord($rank8); ?></div>
    </div>

    <div id="trend-no9"> 
        <?php $this->Matome->getTrendTitle(9,$trends[0]['Trends']['rank9']) ?>
        <div class="row"><?php $this->Matome->getArchiveTileByKeyWord($rank9); ?></div>
    </div>

    <div id="trend-no10"> 
        <?php $this->Matome->getTrendTitle(10,$trends[0]['Trends']['rank10']) ?>
        <div class="row"><?php $this->Matome->getArchiveTileByKeyWord($rank10); ?></div>
    </div>

    <div id="new-archives"> 
        <h3>新着ピックアップ</h3>
        <div class="row">
            <?php
$count = 0;
while($num_of_archives > $count){
    $archive_date = $archives[$count]['Archives']['date'];
    $archive_title = $archives[$count]['Archives']['title'];
    $blog_title = $archives[$count]['Archives']['title_blog'];
    $archive_url = $archives[$count]['Archives']['url_archive'];
    $archive_imgurl = $archives[$count]['Archives']['imgurl'];
    $this->Matome->getArchiveTile($archive_date,$archive_title,$archive_url,"クリックして記事を読む",$archive_imgurl,$blog_title);
    $count++;
}
            ?>
        </div>
    </div>

</div><!--/row-->
<!-- メインコンテンツ -->

<br>

</div><!--/.container-->
