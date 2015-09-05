<style>
    iframe {
        max-width: 100%;
        !important;
    }
</style>
<script src="/js/app/list/index.js"></script>
<script>
    $(document).ready(function() {
        if (location.hash == "#logout") {
            sweetAlert('ログアウトしました');
        }
        if (location.hash == "#addednewuser") {
            sweetAlert('ユーザ登録に成功しました！', 'ログインして、まちたん！をお楽しみください！', 'success');
        }
        if (location.hash == "#failedtoadduser") {
            sweetAlert('ユーザ登録に失敗しました', '再度登録をお試しください', 'error');
        }
    });
</script>
<div class="container-fluid" style="background-image:url('../img/top/1.jpg'); background-position: center center; background-size:cover;">
    <div class="container">

                <div style="color: #fff; text-shadow: 2px 2px 8px rgba(0,0,0,1);">
                    <br>
                    <h4>ツアーを選んで、まちをたんさく！</h4>
                    <h1>まちたん！</h1>
                    <!-- ここをトゴイメージに置き換えたい -->
                    <p>ウォーキングは、健康増進にも効果的。
                        <br> まちたん！でまちのたんさくもすれば、知らないまちも楽しく歩いて健康に。
                    </p>
                    <br>
                    <?php if(!isset($this->Session->read('Auth')['User']['id'])){?>
                    <!-- ログインしてプレイがまだ正常に動かない　→　ログイン処理してから現在地情報をつけるなどがうまくいかない-->
                    <form action="/users/login" id="UserLoginForm" method="post" accept-charset="utf-8">
                        <div id="hiddenpost" style="display:none;">
                            <input type="hidden" name="_method" value="POST" />
                            <input type="hidden" name="loginfrom" value="top" />
                        </div>
                        <fieldset>
                            <div class="orm-group input text required" style="background-color:rgba(255,255,255,0.8);">
                                <input class="form-control" name="data[User][username]" maxlength="50" type="text" id="UserUsername" required="required" placeholder="  ユーザ名" />
                            </div>
                            <br>
                            <div class="orm-group input password required" style="background-color:rgba(255,255,255,0.8);">
                                <input class="form-control" name="data[User][password]" type="password" id="UserPassword" required="required" placeholder=" パスワード" />
                            </div>
                        </fieldset>
                        <div class="form-group submit" style="text-align:center">
                            <button id="loginplay" type="submit" class="btn btn-primary btn-lg" value="Login" style="color: #fff; text-shadow: 2px 2px 8px rgba(0,0,0,1);">
                                ログインしてウォーキングする
                            </button>
                            <br>
                            <a href="/users/add">
                                新規登録はこちら
                            </a>
                        </div>
                    </form>
                    <?php }?>
                </div>
        <div style="text-align:center;">
            <div style="color: #fff; text-shadow: 2px 2px 8px rgba(0,0,0,1); ">
            <?php
                if($geo_info != null){
                    echo "<h3>現在地が取得できませんでした。もう一度ボタンをタッチしてください</h3>";
                } ?>
            <?php if(!isset($this->Session->read('Auth')['User']['id'])){ ?>
                    <a class="btn btn-info btn-lg" href="/list?geo_info=" >ログインせずウォーキングする</a>
            <?php }else{ ?>
                    <a class="btn btn-info btn-lg" href="/list?geo_info=">ウォーキングする</a>
            <?php } ?>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid" style="background-color:rgba(255,255,255,1)">
    <div class="container">
        <div style="text-align:center">
            <h3>まちたん！とは！？</h3>
        </div>
        <br>
        <div class="container">
            <div class="row">
                <div class="col-sm-4" style="text-align:center">
                    <div class="jumbotron">
                        <h4>知らないまちへ行く<br>ワクワク</h4>
                        <hr>
                        <span>
                            ツアーを選んでまちをたんさくしましょう。
                            <br>
                            ツアーはいくつかのスポットをつないだまちあるきのコースです。
                            ツアーに従って歩けば、今まで知らなかったまちを知ることができます。
                        </span>
                    </div>
                </div>
                <div class="col-sm-4" style="text-align:center">
                    <div class="jumbotron">
                        <h4>新たな発見の<br>喜び</h4>
                        <hr>
                        <span>
                            寄り道する時間はありますか？
                            <br>
                            まちたん！がおすすめのスポットも紹介します。
                            目的地へ行くついでに新しい発見に巡りあってみませんか。
                        </span>
                    </div>
                </div>
                <div class="col-sm-4" style="text-align:center">
                    <div class="jumbotron">
                        <h4>ウォーキングで<br>健康に</h4>
                        <hr>
                        <span>
                            スポットに行くだけが楽しみではありません。
                            <br>
                            スポットに行くまでにたくさん歩いて、健康になれます。
                            おいしいものをたくさん食べてもたくさん歩けば問題なし!?
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div style="text-align:center">
            <iframe width="560" height="315" src="https://www.youtube.com/embed/2tAv5Mwn-Ns" frameborder="0" allowfullscreen></iframe>
            <br>
            <span>※本動画は<a href="http://machitsumugi-hackathon.tumblr.com/symposium">社会実装型ハッカソン まちつむぎ まちつむぎシンポジウムin金沢</a>へ出展した時のものです。</span>
        </div>
    </div>
    <br>
</div>
<div class="container-fluid">
    <div class="container">
        <div style="text-align:center">
            <h3>まちたん！の遊び方</h3>
        </div>
        <br>
        <div class="container">
            <div class="row">
                <div class="col-sm-4" style="text-align:center">
                    <div class="jumbotron">
                        <h4>現在地近くのスポットを<br>選びましょう</h4>
                        <hr>
                        <span>
                            スポットまたはツアーを選びます。
                            <br>
                            スポットを選べば寄り道できるかも選べます。
                            ツアーを選べばまちたん！がオススメするスポットを巡るツアーを楽しむことができます。
                        </span>
                    </div>
                </div>
                <div class="col-sm-4" style="text-align:center">
                    <div class="jumbotron">
                        <h4>スポットへの道のりを<br>写真から探しましょう</h4>
                        <hr>
                        <span>
                            まずは写真をお見せします。
                            <br>
                            写真は次のスポットへ行くまでの道のりにある場所です。
                            その場所へ行き着くたび次のスポットへ近づいていきます。
                        </span>
                    </div>
                </div>
                <div class="col-sm-4" style="text-align:center">
                    <div class="jumbotron">
                        <h4>スポットに着いたら<br>スポットを楽しみましょう</h4>
                        <hr>
                        <span>
                            スポットにつくと情報が表示されます。
                            <br>
                            表示された情報を参考にしながらそのスポットを楽しみましょう。
                            楽しかったことをコメントやいいね！でまちたん！に教えてください。
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <br>
    </div>
    <br>
</div>
<div class="container-fluid" style="background-color:rgba(255,255,255,1)">
    <div class="container">
        <div style="text-align:center">
            <h3>まちたん！で遊ぼう</h3>
            <?php if(!isset($this->Session->read('Auth')['User']['id'])){ ?>
                <a href="/users/add" class="btn btn-primary btn-lg">
                    新規登録してウォーキングする
                </a>
                <br>
                <a class="btn btn-info btn-lg" href="/list?geo_info=">
                    ログインせずウォーキングする
                </a>
            <?php }else{ ?>
                <a class="btn btn-info btn-lg" href="/list?geo_info=">
                    ウォーキングする
                </a>
            <?php } ?>
        </div>
    </div>
    <br>
</div>
<div class="container-fluid">
    <div class="container">
        <div style="text-align:center">
            <h3>プレイランキング</h3>
            <br>
            <span>
            スポットとツアーの人気ランキングです。
            <br>
            いま人気のスポット・ツアーをチェック。
        </span>
        </div>
        <br>
        <div class="jumbotron">
            <h4><i class="mdi-action-room"></i> スポットプレイランキング（全国版）</h4>
            <div class="list-group" id="candidate_spots">
                <?php for($i = 0; $i < count($spot_ranking_all); $i++){ ?>
                    <div class="list-group-item">
                        <div class="row-action-primary">
                            <?php
                      exec("ls img/machitan_pic/" . $spot_ranking_all[$i]['Spot']['id'] , $files);
                      if(file_exists('img/machitan_pic/' . $spot_ranking_all[$i]['Spot']['id'] . '/'. $files[0])){
                        $image_src = 'img/machitan_pic/' . $spot_ranking_all[$i]['Spot']['id'] . '/'. $files[0];
                      }else{
                        $image_src = '../img/no-image-1.jpg';
                      };
                      unset($files);
                    ?>
                                <img class="circle" src="<?php echo $image_src?>" alt="icon">
                        </div>
                        <div class="row-content">
                            <div class="least-content">
                            </div>
                            <h5 class="list-group-item-heading">
                                    <i class="mdi-image-filter-<?php echo $i+1?>"></i>
                                     <?php echo $spot_ranking_all[$i]['Spot']['name'] ?>
                                </h5>
                            <span class="badge badge-info" style="left:10px">
                                    <span class="mdi-maps-directions-walk"></span>
                            <?php echo $spot_ranking_all[$i]['Spot']['played'] ?>
                                </span>
                                <span class="badge badge-info" style="left:10px">
                                    <span class="mdi-action-thumb-up"></span>
                                <?php echo $spot_ranking_all[$i]['Spot']['like_num']?>
                                    </span>
                        </div>
                        <div class="list-group-separator"></div>
                    </div>
                    <?php }?>
            </div>
        </div>

        <div class="jumbotron">
            <h4><i class="mdi-action-explore"></i> ツアープレイランキング（全国版）</h4>
            <div class="list-group" id="candidate_spots">
                <?php for($i = 0; $i < count($tour_ranking_all); $i++){ ?>
                    <div class="list-group-item">
                        <div class="row-action-primary">
                            <?php
                      for($k = 0; $k < count($tour_ranking_all_image); $k++){
                        if($tour_ranking_all_image[$k]['TourSpotRel']['tour_id'] == $tour_ranking_all[$i]['Tour']['id']){
                          exec("ls img/machitan_pic/" . $tour_ranking_all_image[$k]['TourSpotRel']['spot_id'] , $files);
                          if(file_exists('img/machitan_pic/' . $tour_ranking_all_image[$k]['TourSpotRel']['spot_id'] . '/'. $files[0])){
                            $image_src = 'img/machitan_pic/' . $tour_ranking_all_image[$k]['TourSpotRel']['spot_id'] . '/'. $files[0];
                          }else{
                            $image_src = '../img/no-image-1.jpg';
                          };
                        }else{
                          $image_src = '../img/no-image-1.jpg';
                        };
                      }
                    ?>
                                <img class="circle" src="<?php echo $image_src?>" alt="icon">
                        </div>
                        <div class="row-content">
                            <h5 class="list-group-item-heading">
                                    <i class="mdi-image-filter-<?php echo $i+1?>"></i>
                                     <?php echo $tour_ranking_all[$i]['Tour']['name'] ?>
                                 </h5>
                            <span class="badge badge-info" style="left:10px">
                                    <span class="mdi-action-favorite"></span>
                            <?php echo $tour_ranking_all[$i]['Tour']['finished_rate'] ?>
                                </span>
                        </div>
                        <div class="list-group-separator"></div>
                    </div>
                    <?php
              unset($files);
              }?>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid" style="background-color:white">
    <div style="text-align:center">
        <h3>まちたん！のこれまで</h3>
    </div>
    <br>
    <div class="container">
        <p>2014年12月 <a href="http://machitsumugi.tumblr.com/">社会実装型ハッカソン まちつむぎ ハッカソン</a> 商店街支援部門 優秀賞受賞</p>
        <p>2015年 3月 <a href="http://machitsumugi-hackathon.tumblr.com/symposium">社会実装型ハッカソン まちつむぎ まちつむぎシンポジウムin金沢</a> 商店街支援部門 出展</p>
    </div>
    <br>
</div>
<div class="container-fluid" style="text-align:center;">
    <br>
    <div class="row">
        <div class="col-lg-6">
            <h5 style="font-weight:bold;">まちたん！について</h5>
            <table class="table table-hover ">
                <tbody>
                    <tr>
                        <td><a href="machitan/manualplayer">まちたん！の使い方（まちあるきする方）</a></td>
                    </tr>
                    <tr>
                        <td>まちたん！の使い方（イベント企画者）</td>
                    </tr>
                    <tr>
                        <td>よくある質問</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-lg-6">
            <h5 style="font-weight:bold;">お問い合わせ・サービスについて</h5>
            <table class="table table-hover ">
                <tbody>
                    <tr>
                        <td>利用規約</td>
                    </tr>
                    <tr>
                        <td>プライバシーポリシー</td>
                    </tr>
                    <tr>
                        <td>お問い合わせ</td>
                    </tr>
                    <tr>
                        <td>運営者について</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <hr>
    <p class="muted credit">&copy; 2014
        <?php if(date("Y")!=2014) echo date("-Y"); ?> All rights reserved, まちたん！</p>
</div>
