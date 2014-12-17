<!-- ナビバー -->
<?php $this->Matome->getNavBar("about-sites") ?>
<!-- ナビバー -->

<div class="container">

    <br>

    <?php
    if(isset($save_result)){
    ?>
    <div class="container">
        <h3>ブログの登録が完了しました！</h3>
        <p>記事が反映されるには少しお時間がかかります。登録結果は以下よりご確認ください。</p>
    </div>
    <?php
}
    ?>

    <div class="panel panel-info" id="about-blog">
        <div class="panel-heading"><span class="glyphicon glyphicon-road"></span>　巡回先ブログについて</div>
        <div class="panel-body">
            <p>記事収集対象としているブログは、以下のサイト一覧のとおりとなります。</p>
            <p>本サイトの巡回先ブログは、当サイト管理人による追加及び、各ブログ管理者様による<a href="#footer-bottom">登録フォーム</a>から追加されています。</p>
            <p>ただし、アダルト向けサイトは本サイトのリンク対象外とさせていただいていますので、登録を発見次第、巡回先より削除させていただきます。</p>
        </div>
    </div>
    <div class="panel panel-info" id="about-blogs">
        <div class="panel-heading"><span class="glyphicon glyphicon-th-list">　登録済の巡回先ブログ</div>
            <div class="panel-body">
                <table class="table table-striped table-hover">
                    <tbody>
                        <tr>
                            <th>ブログタイトル</th>
                            <th>ブログURL</th>
                        </tr>
                        <?php
while($num_of_blogs_livedoor > 0){
    echo "<tr>" ;
    echo "<td>" . $blogs_datas_livedoor[$num_of_blogs_livedoor-1]['Blogs']['title'] . "</td>";
    echo "<td>" . $blogs_datas_livedoor[$num_of_blogs_livedoor-1]['Blogs']['url'] . "</td>";
    echo "</tr>" ;
    $num_of_blogs_livedoor--;
}
                        ?>
                        <?php
while($num_of_blogs_fc2 > 0){
    echo "<tr>" ;
    echo "<td>" . $blogs_datas_fc2[$num_of_blogs_fc2-1]['Blogs']['title'] . "</td>";
    echo "<td>" . $blogs_datas_fc2[$num_of_blogs_fc2-1]['Blogs']['url'] . "</td>";
    echo "</tr>" ;
    $num_of_blogs_fc2--;
}
                        ?>
                        <?php
while($num_of_blogs_ameblo > 0){
    echo "<tr>" ;
    echo "<td>" . $blogs_datas_ameblo[$num_of_blogs_ameblo-1]['Blogs']['title'] . "</td>";
    echo "<td>" . $blogs_datas_ameblo[$num_of_blogs_ameblo-1]['Blogs']['url'] . "</td>";
    echo "</tr>" ;
    $num_of_blogs_ameblo--;
}
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>