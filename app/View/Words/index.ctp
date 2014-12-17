<!-- ナビバー -->
<?php $this->Matome->getNavBar("words") ?>
<!-- ナビバー -->

<div class="container">

   <!-- メインコンテンツ -->
    <br>

    <div> 
        <?php $this->Matome->getSearchedTitle($target_word) ?>
        <p>キーワードに関連する記事を最新のものから最大50記事まで表示します</p>
        <div class="row"><?php $this->Matome->getArchiveTileByKeyWord($searched_archives); ?></div>
    </div>
    
    <br>
    
</div>