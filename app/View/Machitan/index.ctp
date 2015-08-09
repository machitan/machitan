<script src="/js/app/list/index.js"></script>
<script>
$(document).ready(function () {
  if(location.hash=="#logout"){
    sweetAlert('ログアウトしました');
  }
  if(location.hash=="#addednewuser"){
    sweetAlert('ユーザ登録に成功しました！','ログインして、まちたん！をお楽しみください！','success');
  }
  if(location.hash=="#failedtoadduser"){
    sweetAlert('ユーザ登録に失敗しました','再度登録をお試しください','error');
  }
});
</script>
<div class="jumbotron" style="background-image:url('../img/top/1.jpg'); background-position: center center; background-size:cover;">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
            <!-- <img src='../img/machitan_logo.png'> -->
            </div>
            <div class="col-md-6" style="background: rgba(0,0,0,.6);">
                <div style="color: #fff; text-shadow: 2px 2px 8px rgba(0,0,0,1); ">
                    <br>
                    <h2>散歩して健康増進してみませんか？？</h2>
                    <br>
                    <br>
                    <!--
                    <p style="font-size:100%;">お近くの町、片町をお散歩しましょう。</p>
                    <p style="font-size:100%;">行き先はお任せください。</p>
                    <p style="font-size:100%;">あなたの片町発見に適したコースをご提供します。</p>
                    -->
                    <p style="font-size:100%;">横浜をお散歩して、健康増進に役立てましょう。</p>
                    <p style="font-size:100%;">行き先はお任せください。</p>
                    <p style="font-size:100%;">あなたのヘルスケアに適したウォーキングコースをご提供します。</p>
                    <p style="font-size:100%;">もちろん歩いていて飽きないコースです。</p>
                    <br>
                    <br>

                </div>
            </div>
        </div>
        <br>
        <br>
        <div style="text-align:center;">
            <div style="color: #fff; text-shadow: 2px 2px 8px rgba(0,0,0,1); ">
            <?php
                if($geo_info != null){
                echo "<h3>現在地が取得できませんでした。もう一度ボタンをタッチしてください</h3>";
            } ?>
            <a class="btn btn-info btn-lg" href="list?geo_info=" style="width:100%;">ウォーキングする</a>
            </div>
        </div>
    </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-lg-6">
      <div class="jumbotron">
        <h3>スポットプレイランキング（全国版）</h3>
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
                      <span class="badge badge-info" style="left:10px">
                        <span class="glyphicon glyphicon-thumbs-up"></span><?php echo ' '.$spot_ranking_all[$i]['Spot']['like_num']?>
                      </span>
                    </div>
                    <h3 class="list-group-item-heading"><?php echo $spot_ranking_all[$i]['Spot']['name'] ?></h3>
                    <p class="list-group-item-text">プレイ回数：<?php echo $spot_ranking_all[$i]['Spot']['played'] ?></p>
                  </div>
                  <div class="list-group-separator"></div>
                </div>
              <?php }?>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="jumbotron">
        <h3>ツアープレイランキング（全国版）</h3>
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
                    <!--
                    <div class="least-content">
                      <span class="badge badge-info" style="left:10px">
                        <span class="glyphicon glyphicon-thumbs-up"></span><?php //echo ' '.$spot_ranking_all[$i]['Spot']['like_num']?>
                      </span>
                    </div>
                    -->
                    <h3 class="list-group-item-heading"><?php echo $tour_ranking_all[$i]['Tour']['name'] ?></h3>
                    <p class="list-group-item-text">ツアー人気度：<?php echo $tour_ranking_all[$i]['Tour']['finished_rate'] ?></p>
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
</div>
