<?php if(count($events) > 0){
    for($i = 0; $i < count($events); $i++){ ?>
        <div class="jumbotron">
            <h3><?php echo $events[$i]['Event']['name']?></h3>
            <p><?php echo $events[$i]['Event']['description']?></p>
            <p><a class="btn btn-primary btn-lg" href="#">このイベントに参加する！</a></p>
        </div>
<?php }
}?>


   <!-- <script src="/js/app/list/index.js"></script> -->
    <?php if($num_of_spots > 0){?>
    <br>
    <div style="text-align:center;">
    <!--    <a href="play?spot_id=<?php echo $rand_spot_id ?>&lat=<?php echo $lat ?>&lng=<?php echo $lng?>" class="btn btn-info btn-lg" style="width:100%;">とりあえずぶらりする</a> -->
    <button class="btn btn-info btn-lg" style="width:100%;"  data-toggle="modal" data-target="#myModal">とりあえずぶらりする</button>

    </div>
    <br>
    <?php }else{?>
    <br>
    <h3>近くにスポットがありません。</h3>
    <?php }?>
    <div style="text-align:center;">
        <a href="like?first=true" class="btn btn-info btn-lg" style="width:100%;">ナイススポット発見！</a>
    </div>
    <br>
    <div class="panel panel-info" id="about-info">
      <div class="panel-heading"><span class="glyphicon glyphicon-info-sign"></span>　スポットプレイランキング</div>
      <div class="panel-body">
        <ul class="list-group">
        <?php
          for($i = 0; $i < count($spot_ranking); $i++){
        ?>
            <li class="list-group-item">
              <button class="btn btn-default" style="width:100%;"  data-toggle="modal" data-target="#Modal<?php echo $spot_ranking[$i]['Spot']['id'] ?>"><?php echo $spot_ranking[$i]['Spot']['name']?>
                  <span class="badge badge-info" style="left:10px">
                      <span class="mdi-maps-directions-walk"></span> <?php  echo $spot_ranking[$i]['Spot']['played'] ?>
                  </span>
                  <span class="badge badge-info" style="left:10px">
                      <span class="mdi-action-thumb-up"></span> <?php  echo $spot_ranking[$i]['Spot']['like_num'] ?>
                  </span>
              </button>
          </li>
        <?php };?>
        </ul>
      </div>
    </div>
<div class="panel panel-info" id="about-info">
        <div class="panel-heading"><span class="glyphicon glyphicon-info-sign"></span>　行きたいところを選んでぶらりする</div>
        <div class="panel-body">

    <!--<h4>行きたいところも選んでぶらりする</h4>-->
    <!--タブ-->
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab1" data-toggle="tab"><span class="glyphicon glyphicon-cutlery"></span> 食べる</a>
        </li>
        <li><a href="#tab2" data-toggle="tab"><span class="glyphicon glyphicon-shopping-cart"></span> 買う</a>
        </li>
        <li><a href="#tab3" data-toggle="tab"><span class="glyphicon glyphicon-music"></span> 遊ぶ</a>
        </li>
        <li><a href="#tab4" data-toggle="tab"><span class="glyphicon glyphicon-heart"></span> その他</a>
        </li>
        <li><a href="#tab5" data-toggle="tab"><span class="glyphicon glyphicon-flag"></span> ツアー</a>
        </li>
    </ul>
    <!--タブコンテンツ-->
  <div id="myTabContent" class="tab-content">

  <?php for ($i = 1; $i <= 4 ; $i++){?>

    <?php if($i == 1){ ?>
        <div class="tab-pane fade in active" id="tab<?php echo $i ?>">
  	<?php }else{ ?>
        <div class="tab-pane fade" id="tab<?php echo $i ?>">
  	<?php }?>

    <ul class="list-group">
  	<?php
      $existsItem = false;
      for($count = 0; $num_of_spots > $count ; $count++){
    ?>
    <?php if($spots[$count]['Spot']['category_id'] == $i){ ?>
        <li class="list-group-item">
            <button class="btn btn-default" style="width:100%;"  data-toggle="modal" data-target="#Modal<?php echo $spots[$count]['Spot']['id'] ?>"><?php echo $spots[$count]['Spot']['name']?>
              <span class="badge badge-info" style="left:10px">
                  <span class="mdi-maps-directions-walk"></span> <?php  echo $spots[$count]['Spot']['played'] ?>
              </span>
                <span class="badge badge-info" style="left:10px">
                    <span class="mdi-action-thumb-up"></span> <?php  echo $spots[$count]['Spot']['like_num'] ?>
                </span>
            </button>
  	    </li>
    <?php
            $existsItem = true;
        }
        ?>
    <?php };
        if(!$existsItem){
    ?>
        <li class="list-group-item">
            <button class="btn btn-default" style="width:100%;">
            <span class="mdi-action-report-problem"></span>付近にこのカテゴリのスポットはありません<span class="mdi-action-report-problem"></span>
            </button>
        </li>
    <?php } ?>
  	</ul>
    </div>
  <?php } ?>

  <!--ツアータブコンテンツ-->
  <div class="tab-pane fade" id="tab5">
    <ul class="list-group">
	<?php
    $count = 0;
    while($num_of_tours > $count){
    ?>
    <li class="list-group-item">
    <button class="btn btn-default" style="width:100%;"  data-toggle="modal" data-target="#TourModal<?php echo $tours[$count]['Tour']['id'] ?>"><?php echo $tours[$count]['Tour']['name']?></button>
    </li>
	<?php
        $count++;
    };
        ?>
	</ul>
  </div>
  </div>

</div>
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
