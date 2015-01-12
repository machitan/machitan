<!-- <script src="/js/app/list/index.js"></script> -->
<div class="container">
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
        <div class="panel-heading"><span class="glyphicon glyphicon-info-sign"></span>　行きたいところも選んでぶらりする</div>
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
      $count = 0;
      while($num_of_spots > $count){
          ?>
         <?php if($spots[$count]['Spot']['category_id'] == $i){ ?>
  	    <li class="list-group-item">
            <!--   <a href="play?destination_spot_id=<?php echo $spots[$count]['Spot']['id'] ?>&lat=<?php echo $lat ?>&lng=<?php echo $lng?>">
                  <?php echo $spots[$count]['Spot']['name'] ?>
              </a> -->
            <a style="width:100%;"  data-toggle="modal" data-target="#Modal<?php echo $spots[$count]['Spot']['id'] ?>"><?php echo $spots[$count]['Spot']['name'] ?></a>
  	    </li>
        <?php } ?>
  	<?php 
          $count++;
      };
          ?>
  	</ul>
    </div>
  <?php } ?>

  </div>
<!--
    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade in active" id="tab1">
            <ul class="list-group">
                <li class="list-group-item"><a href="play">居酒屋 くまもん</a>
                </li>
                <li class="list-group-item"><a href="play">レストラン KUMA</a>
                </li>
                <li class="list-group-item"><a href="play">お食事処 熊</a>
                </li>
            </ul>
        </div>
        <div class="tab-pane fade" id="tab2">
            <ul class="list-group">
                <li class="list-group-item"><a href="play">カラオケ KUMAX</a>
                </li>
                <li class="list-group-item"><a href="play">ゲームセンター KUUMA</a>
                </li>
            </ul>
        </div>
        <div class="tab-pane fade" id="tab3">
            <ul class="list-group">
                <li class="list-group-item"><a href="play">雑貨 くまちゃん</a>
                </li>
                <li class="list-group-item"><a href="play">Kuman Kuman</a>
                </li>
                <li class="list-group-item"><a href="play">KUMA CA ISM</a>
                </li>
                <li class="list-group-item"><a href="play">服飾屋 くまー</a>
                </li>
            </ul>
        </div>
    </div>
-->
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
                <p>まちたん！がおすすめするお散歩ルートでぶらりしましょう</p>
                <p>まちたん！が選ぶ目的地に行くまでに寄り道してもいいよ、って方は「寄り道あり」を選択してください。</p>
            </div>
            <div class="modal-body">
                <form action="/play" method="get">
                    <!-- input -->
                    <div class="form-group">
                        <input type="radio" name="waypoints_onoff" value=on checked>寄り道をする
                        <input type="radio" name="waypoints_onoff" value=off>寄り道をしない
                        <input type="hidden" name="destination_spot_id" value="<?php echo $rand_spot_id ?>">
                        <input type="hidden" name="lat" value="<?php echo $lat ?>">
                        <input type="hidden" name="lng" value="<?php echo $lng ?>">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            キャンセル
                        </button>
                        <input type="submit" value="ぶらりする"></input>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php 
$count = 0;
while($num_of_spots > $count){
    if(file_exists('/opt/web/app/webroot/img/machitan_pic/'.$spots[$count]['Spot']['id'].'.jpg')){
        $imagefile = "../img/machitan_pic/".$spots[$count]['Spot']['id'].".jpg";
    }else{
        $imagefile = "../img/no-image-1.jpg";
    }
    
    $this->List->getModal($spots[$count]['Spot']['name'],$spots[$count]['Spot']['id'],$spots[$count]['Spot']['description'],$lat,$lng,$imagefile, $spots[$count]['Spot']['like_num']);
    $count++;
};
?>
