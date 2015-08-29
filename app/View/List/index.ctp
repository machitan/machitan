<?php if(count($events) > 0){ ?>
  <div class="container">
    <?php for($i = 0; $i < count($events); $i++){ ?>
      <div class="jumbotron" style="background-color: rgba(100,100,100,1);">
        <div style="background-image:url('img/<?php echo $events[$i]['Event']['pic_url']?>'); background-position: center center; background-size:cover;">
          <div class="container" style="background-color: rgba(255,255,255,0.2);">
            <br>
            <span class="badge"><span>開催中イベント</span><i class="mdi-action-announcement"></i></span>
            <h3 style="color: #fff; text-shadow: 2px 2px 8px rgba(0,0,0,1);">
            <?php echo $events[$i]['Event']['name']?>
          </h3>
            <span style="color: #fff; text-shadow: 2px 2px 8px rgba(0,0,0,1);">
            <?php echo $events[$i]['Event']['description']?>
          </span>
            <p>
              <a class="btn btn-primary btn-lg btn-raised" href="#">このイベントに参加する！</a>
            </p>
          </div>
        </div>
      </div>
      <?php } ?>
  </div>
  <?php }?>

    <!-- <script src="/js/app/list/index.js"></script> -->
    <div class="container">
      <div style="text-align:center;">
        <a href="like?first=true" class="btn btn-warning btn-fab btn-raised mdi-communication-location-on" style="position:fixed;bottom:15px;right:15px;z-index: 5"></a>
      </div>

      <?php if($num_of_spots > 0){?>
        <!--
        <div style="text-align:center;">
          <button class="btn btn-info btn-lg" style="width:100%;"  data-toggle="modal" data-target="#myModal">とりあえずぶらりする</button>
        </div>
        -->
        <?php }else{?>
          <div class="alert alert-dismissable alert-danger">
            <strong class="h4">近くにスポットがありません！</strong>
            <br>
            <span>お近くに遊べるスポットやツアーがありません。<a href="like?first=true" style="font-weight:bold;">スポットの登録</a>をして遊べる場所を増やしましょう！</span>
          </div>
          <?php }?>

          <div class="jumbotron">
            <h4><i class="mdi-action-explore"></i> ツアーをえらんでぶらり</h4>
            <hr>
            <div class="list-group">
              <?php for($i = 0; $i < count($tours); $i++){
                exec("ls img/machitan_pic/" . $tours[$i]['tour_spot_rels']['spot_id'] , $files);
                if(isset($files[0])){
                  if(file_exists('img/machitan_pic/' . $tours[$i]['tour_spot_rels']['spot_id'] . '/'. $files[0])){
                    $image_src = 'img/machitan_pic/' . $tours[$i]['tour_spot_rels']['spot_id'] . '/'. $files[0];
                  }else{
                    $image_src = '../img/no-image-1.jpg';
                  }
                }else{
                  $image_src = '../img/no-image-1.jpg';
                };
                unset($files);
              ?>
                <div class="list-group-item btn btn-defaul btn-raised" data-toggle="modal" data-target="#TourModal<?php echo $tours[$i]['Tour']['id'] ?>" style="width:100%; background-image:url('<?php echo $image_src?>'); background-position: center center; background-size:cover;">
                    <div style="background-color: rgba(255,255,255,0.3); margin-left:-100px; margin-right:-100px;">
                        <div class="row-content">
                            <h5 class="list-group-item-heading" style="color: #fff; text-shadow: 2px 2px 8px rgba(0,0,0,1);">
                                <?php echo $tours[$i]['Tour']['name'] ?>
                            </h5>
                            <span class="badge badge-info">
                                    <span class="mdi-action-favorite"></span>
                            <?php echo $tours[$i]['Tour']['finished_rate'] ?>
                            </span>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
          </div>

            <div class="jumbotron">
              <h4><i class="mdi-communication-location-on"></i>スポットをえらんでぶらり</h4>
              <hr>
              <div class="flexslider">
                <ul class="slides">
                  <li style="width: 100%; float: left; margin-right: -100%; position: relative; opacity: 0; display: block; z-index: 1;">
                    <div style="text-align:center">
                      <h4>
                        <i class="mdi-action-trending-up"></i>
                        プレイランキング
                        <i class="mdi-action-trending-up"></i>
                      </h4>
                      <hr>
                      <div class="list-group">
                        <?php for($i = 0; $i < count($spot_ranking); $i++){
                          exec("ls img/machitan_pic/" . $spot_ranking[$i]['Spot']['id'] , $files);
                          if(isset($files[0])){
                            if(file_exists('img/machitan_pic/' . $spot_ranking[$i]['Spot']['id'] . '/'. $files[0])){
                              $image_src = 'img/machitan_pic/' . $spot_ranking[$i]['Spot']['id'] . '/'. $files[0];
                            }else{
                              $image_src = '../img/no-image-1.jpg';
                            }
                          }else{
                            $image_src = '../img/no-image-1.jpg';
                          };
                          unset($files);
                        ?>
                          <div class="list-group-item btn btn-default btn-raised" data-toggle="modal" data-target="#Modal<?php echo $spot_ranking[$i]['Spot']['id'] ?>" style="background-image:url('<?php echo $image_src?>'); background-position: center center; background-size:cover;">
                            <div style="background-color: rgba(255,255,255,0.3); margin-left:-100px; margin-right:-100px;">
                              <div class="row-content">
                                <h5 class="list-group-item-heading" style="color: #fff; text-shadow: 2px 2px 8px rgba(0,0,0,1);">
                                    <?php echo $spot_ranking[$i]['Spot']['name'] ?>
                                  </h5>
                                <span class="badge badge-info">
                                    <span class="mdi-maps-directions-walk"></span>
                                <?php echo $spot_ranking[$i]['Spot']['played'] ?>
                                  </span>
                                  <span class="badge badge-info">
                                    <span class="mdi-action-thumb-up"></span>
                                  <?php echo $spot_ranking[$i]['Spot']['like_num']?>
                                    </span>
                              </div>
                            </div>
                          </div>
                          <?php } ?>
                      </div>
                    </div>
                  </li>
                  <?php for ($category_id = 1; $category_id <= 4 ; $category_id++){?>
                    <li style="width: 100%; float: left; margin-right: -100%; position: relative; opacity: 0; display: block; z-index: 1;">
                      <div style="text-align:center">
                        <h4>
                        <?php
                        if($category_id == 1)
                          echo '<i class="mdi-maps-local-restaurant"></i> 食べる <i class="mdi-maps-local-restaurant"></i>';
                        else if($category_id == 2){
                          echo '<i class="mdi-action-shopping-cart"></i> 買う <i class="mdi-action-shopping-cart"></i>';
                        }else if($category_id == 3){
                          echo '<i class="mdi-social-group"></i> 遊ぶ <i class="mdi-social-group"></i>';
                        }else if($category_id == 4){
                          echo '<i class="mdi-image-camera"></i> その他 <i class="mdi-image-camera"></i>';
                        }
                        ?>
                      </h4>
                        <hr>
                        <div class="list-group">
                          <?php for($i = 0; $i < count($spots); $i++){
                              if($spots[$i]['Spot']['category_id'] == $category_id){
                              exec("ls img/machitan_pic/" . $spots[$i]['Spot']['id'] , $files);
                              if(isset($files[0])){
                                if(file_exists('img/machitan_pic/' . $spots[$i]['Spot']['id'] . '/'. $files[0])){
                                  $image_src = 'img/machitan_pic/' . $spots[$i]['Spot']['id'] . '/'. $files[0];
                                }else{
                                  $image_src = '../img/no-image-1.jpg';
                                }
                              }else{
                                $image_src = '../img/no-image-1.jpg';
                              };
                              unset($files);
                            ?>
                            <div class="list-group-item btn btn-default btn-raised" data-toggle="modal" data-target="#Modal<?php echo $spots[$i]['Spot']['id'] ?>" style="background-image:url('<?php echo $image_src?>'); background-position: center center; background-size:cover;">
                              <div style="background-color: rgba(255,255,255,0.3); margin-left:-100px; margin-right:-100px;">
                                <div class="row-content">
                                  <h5 class="list-group-item-heading" style="color: #fff; text-shadow: 2px 2px 8px rgba(0,0,0,1);">
                                        <?php echo $spots[$i]['Spot']['name'] ?>
                                      </h5>
                                  <span class="badge badge-info" style="left:10px">
                                        <span class="mdi-maps-directions-walk"></span>
                                  <?php echo $spots[$i]['Spot']['played'] ?>
                                    </span>
                                    <span class="badge badge-info" style="left:10px">
                                        <span class="mdi-action-thumb-up"></span>
                                    <?php echo $spots[$i]['Spot']['like_num']?>
                                      </span>
                                </div>
                              </div>
                            </div>
                            <?php }
                          }
                          ?>
                        </div>
                      </div>
                    </li>
                    <?php } ?>
                </ul>
                <ul class="flex-direction-nav">
                  <li class="flex-nav-prev"><a class="flex-prev" href="#">Previous</a></li>
                  <li class="flex-nav-next"><a class="flex-next" href="#">Next</a></li>
                </ul>
              </div>
            </div>

            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                      <span aria-hidden="true">&times;</span>
                      <span class="sr-only">Close</span>
                    </button>
                    <h3 class="modal-title" id="myModalLabel">とりあえずぶらりする</h3>
                    <br>
                  </div>
                  <div class="modal-body">
                    <p>まちたん！がおすすめするお散歩ルートでぶらりしましょう</p>
                    <form action="/play" method="get">
                      <!-- input -->
                      <div class="form-group">
                        <input type="hidden" name="waypoints_onoff" value=on>
                        <input type="hidden" name="destination_spot_id" value="<?php echo $rand_spot_id ?>">
                        <input type="hidden" name="lat" value="<?php echo $lat ?>">
                        <input type="hidden" name="lng" value="<?php echo $lng ?>">
                      </div>

                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                          キャンセル
                        </button>
                        <input type="submit" class="btn btn-primary" value="ぶらりする"></input>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
    </div>

    <?php
// Spot Modal作成
$count = 0;
while($num_of_spots > $count){
    $this->List->getModal($spots[$count]['Spot']['name'],$spots[$count]['Spot']['id'],$spots[$count]['Spot']['description'],$lat,$lng,$spots[$count]['Spot']['like_num']);
    $count++;
};

// Tour Modal作成
$count = 0;
while($num_of_tours > $count){
    $this->List->getTourModal($tours[$count]['Tour']['name'],$tours[$count]['Tour']['id'],$tours[$count]['Tour']['description'],$tours[$count]['tour_spot_rels']['spot_id'],$lat,$lng);
    $count++;
};
?>
