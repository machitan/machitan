<!-- ナビバー -->
<?php $this->Matome->getNavBar("about") ?>
<!-- ナビバー -->

<div class="container">
    <br>
    <div class="row">
        <div class="col-md-9">

            <?php
    if(isset($save_result)){
            ?>
            <h3>お問い合わせ内容の送信が完了しました！</h3>
            <p>貴重なご意見・ご感想を頂きましてありがとうございました。</p>
            <p>頂戴しましたご意見・ご感想をもとにより一層のサービスに努めてまいります。</p>
            <?php
}
            ?>

            <div class="panel panel-info" id="about-info">
                <div class="panel-heading"><span class="glyphicon glyphicon-info-sign"></span>　サイト概要</div>
                <div class="panel-body">
                    <p>当サイトは、独自にブログ記事を収集し、今はやりのワードをベースに記事を表示するアンテナサイトです。</p>
                    <p>ブログ記事収集対象のブログは、本ページ下部に表示しています。</p>
                    <p>本サイトへの掲載登録をご要望の場合には、ページ最下部の<a href="#footer-bottom">登録フォーム</a>より掲載サイト登録を行ってください。</p>
                    <p>ただし、アダルト向けサイトは対象としておりません。</p>
                </div>
            </div>

            <div class="panel panel-info" id="about-function">
                <div class="panel-heading"><span class="glyphicon glyphicon-off"></span>　機能・特徴</div>
                <div class="panel-body">
                    <p>今のはやりのワードを、Googleの急上昇ワードから収集します。</p>
                    <p>抽出したはやりのワードに合わせて記事を選択・表示します。</p>
                    <p>常に記事をクローリングしているため、表示する記事は常に最新です。</p>
                </div>
            </div>

            <div class="panel panel-info" id="about-blog">
                <div class="panel-heading"><span class="glyphicon glyphicon-road"></span>　巡回先ブログについて</div>
                <div class="panel-body">
                    <p>記事収集対象としているブログは、<a href="about/sites">サイト一覧</a>のとおりとなります。</p>
                    <p>本サイトに登録済の巡回先ブログは、当サイト管理人による登録及び、各ブログ管理者様による<a href="#footer-bottom">登録フォーム</a>からの登録で成り立っております。</p>
                    <p>ただし、アダルト向けサイトは本サイトのリンク対象外とさせていただいていますので、登録を発見次第、巡回先より削除させていただきます。</p>
                </div>
            </div>

            <div class="panel panel-info" id="about-update">
                <div class="panel-heading"><span class="glyphicon glyphicon-ok"></span>　更新履歴</div>
                <div class="panel-body">
                    <table class="table table-striped table-hover">
                        <tbody>
                            <tr>
                                <th>日付</th>
                                <th>更新内容</th>
                            </tr>
                            <tr>
                                <td>2014/11/3</td>
                                <td>はやりあんてな リリース！</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="panel panel-info" id="about-link">
                <div class="panel-heading"><span class="glyphicon glyphicon-link"></span>　リンク</div>
                <div class="panel-body">
                    <p>当サイトはリンクフリーです。</p>
                    <p>リンクを貼るにあたってご連絡を頂く必要はありません。</p>
                </div>
            </div>

            <div class="panel panel-info" id="about-warn">
                <div class="panel-heading">
                    <span class="glyphicon glyphicon-warning-sign"></span>　免責
                </div>
                <div class="panel-body">
                    <p>サイト内に転載されている動画、画像等の著作権は各権利所有者に帰属致します。</p>
                    <p>また当サイト及びリンク先のサイトを利用したことにより発生した、いかなる損害及びトラブルに関して当方では一切の責任と義務を負いかねますので予めご了承下さい。</p>
                    <p>記事の削除依頼は掲載されているブログ様へ直接ご連絡ください。</p>
                </div>
            </div>

            <div class="panel panel-info" id="about-contact">
                <div class="panel-heading">
                    <span class="glyphicon glyphicon glyphicon-envelope"></span>　お問い合わせ
                </div>
                <div class="panel-body">
                    <p>本サイトについてのご意見・ご感想、及びお問い合わせは以下のフォームよりお願い致します。</p>
                    <div class="container">
                        <button class="btn btn-warning btn-lg" data-toggle="modal" data-target="#contactModal">
                            はやりあんてなへ問い合わせる
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <!-- 登録フォーム-Modal -->
        <div class="modal fade" id="contactModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <div class="container">
                            <h3 class="modal-title" id="myModalLabel">はやりあんてな お問い合わせフォーム</h3>
                            <br>
                            <p>はやりあんてなへのお問い合わせフォームです</p>
                            <p>はやりあんてなへのご意見・ご感想をお寄せください</p>
                        </div>
                    </div>
                    <div class="modal-body">
                        <form action="/about" method="post">
                            <!-- input -->
                            <div class="form-group">
                                <label class="control-label">問い合わせ件名（30字まで）</label>
                                <input type="text" class="form-control" placeholder="" required name="contact_title">
                            </div>
                            <div class="form-group">
                                <label class="control-label">お問い合わせ内容（300字まで）</label>
                                <textarea class="form-control" placeholder="" required name="contact_body">
                                </textarea>
                            </div>
                            <div class="form-group">
                                <label class="control-label">連絡先（e-mailアドレス）</label>
                                <input type="email" class="form-control" required name="contact_email">
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                    キャンセル
                                </button>
                                <input type="submit" value="送信する"></input>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
    <!-- 登録フォーム-Modal -->


    <div class="col-md-3">
        <div class="list-group">
            <a href="#about-info" class="list-group-item">
                <span class="glyphicon glyphicon-check"></span> サイト概要
            </a>
            <a href="#about-function" class="list-group-item">
                <span class="glyphicon glyphicon-check"></span> 機能・特徴
            </a>
            <a href="#about-blog" class="list-group-item">
                <span class="glyphicon glyphicon-check"></span> 巡回先ブログについて
            </a>
            <a href="#about-update" class="list-group-item">
                <span class="glyphicon glyphicon-check"></span> 更新履歴
            </a>
            <a href="#about-link" class="list-group-item">
                <span class="glyphicon glyphicon-check"></span> リンク
            </a>
            <a href="#about-warn" class="list-group-item">
                <span class="glyphicon glyphicon-check"></span> 免責
            </a>
            <a href="#about-warn" class="list-group-item">
                <span class="glyphicon glyphicon-envelope"></span> お問い合わせ
            </a>
        </div>
    </div>

</div>

<br>

</div>
