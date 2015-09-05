<link href="/css/app/play/index.css" rel="stylesheet" type="text/css" >
<script type="text/javascript" charset="utf-8">
    var app = {};
    app.params = {}; // PHPからの値を受け取る

    /**
    * PHP -> JS への値の受け渡し
    */
    app.params.direction_id = <?php echo($direction_id)?>;
    app.params.total_distance = <?php echo $total_distance; ?>;
    app.params.total_duration = <?php echo $total_duration; ?>;

    app.params.start_location = {};
    app.params.start_location.lat = <?php echo $step->start_location->lat ?>;
    app.params.start_location.lng = <?php echo $step->start_location->lng ?>;

    app.params.end_location = {};
    app.params.end_location.lat = <?php echo $step->end_location->lat ?>;
    app.params.end_location.lng = <?php echo $step->end_location->lng ?>;

</script>
<script type="text/javascript" src="/js/lib/vibrator.js"></script>
<script type="text/javascript"
  src="http://maps.googleapis.com/maps/api/js?libraries=geometry&sensor=true">
</script>
<script type="text/javascript" src="/js/app/play/index.js">
</script>

    <div class="progress" style="position:relative;overflow: visible;">
        <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="<?php echo $current_progress; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $current_progress; ?>%">
        </div>
        <!--div id="katamacchi" onClick="touchKatamacchi()">
            <img src="/img/katamacchi.png" style="left: <?php echo $current_progress; ?>%" />
        </div-->
        <span class="goal fa-stack fa-lg">
            <i class="fa fa-flag-checkered fa-stack-1x"></i>
        </span>
    </div>


    <div id="myTabContent" class="tab-content">
       
       <div id="distance-message" class="alert alert-dismissable alert-info" data-step="2" data-intro="スポットまでの距離です。距離をヒントにスポットを探しましょう。">
         <i class="fa-li fa fa-refresh fa-spin fa-3x"></i>
         <div style="display:none;">
           残り <br /> <span></span>
         </div>
       </div>
       
       <!-- スポット情報 -->
        <div class="tab-pane fade in active" id="tab1"  data-step="1" data-intro="写真に写っているスポットを探しましょう！スポットはあなたのすぐそばにあります。">
            <div class="flexslider">
                <ul class="slides">
                    <li>
                        <img id="banner-left" border="0" src="http://maps.googleapis.com/maps/api/streetview?size=640x300&location=<?php echo $step->end_location->lat ?>,<?php echo $step->end_location->lng ?>8&fov=120&pitch=0&heading=0&sensor=false&key=<?php echo $google_api_key ?>">
                    </li>
                    <li>
                        <img id="banner-left" border="0" src="http://maps.googleapis.com/maps/api/streetview?size=640x300&location=<?php echo $step->end_location->lat ?>,<?php echo $step->end_location->lng ?>8&fov=120&pitch=0&heading=90&sensor=false&key=<?php echo $google_api_key ?>">
                    </li>
                    <li>
                        <img id="banner-left" border="0" src="http://maps.googleapis.com/maps/api/streetview?size=640x300&location=<?php echo $step->end_location->lat ?>,<?php echo $step->end_location->lng ?>8&fov=120&pitch=0&heading=180&sensor=false&key=<?php echo $google_api_key ?>">
                    </li>
                    <li>
                        <img id="banner-left" border="0" src="http://maps.googleapis.com/maps/api/streetview?size=640x300&location=<?php echo $step->end_location->lat ?>,<?php echo $step->end_location->lng ?>8&fov=120&pitch=0&heading=270&sensor=false&key=<?php echo $google_api_key ?>">
                    </li>
                </ul>
            </div>
        </div>
    </div>

   <div class="info">
      <i class="mdi-action-info-outline" style="font-size:3em;"></i> <br/>
      横向き推奨<br />
      <i class="mdi-device-screen-rotation" style="font-size:3em;"></i>
   </div>

    <a href="#" data-toggle="modal" data-target="#next-direction" class="btn btn-info btn-fab  btn-raised mdi-maps-directions btn-left2"
      data-step="4" data-intro="ヒント機能1: スポットの方向が分からなくなったらコチラ。スポットの方向が分かります。" data-position="top"></a>
    <a href="#" data-toggle="modal" data-target="#next-spot-map" class="btn btn-info btn-fab  btn-raised mdi-maps-map btn-left"
      data-step="5" data-intro="ヒント機能2: 道に迷ってしまったら、次のスポットまでの地図を見ることも出来ます。"  data-position="top"></a>
    <a href="/like?direction_id=<?php echo $direction_id ?>&step_id=<?php echo $previous_step_id ?>&destination_spot_id=<?php echo $destination_spot_id ?>&tour_id=<?php echo $tour_id ?>" 
       class="btn btn-info btn-fab  btn-raised mdi-image-camera-alt btn-right"
         data-step="6" data-intro="プレイ中に街の素敵な風景を見つけたら、スポット登録もしてみましょう！" data-position="top"></a>

    <form id="arrival" action="<?php if ($spot != null){ ?>/spot<?php } else {?>/play<?php } ?>" method="get">
        <input type="hidden" name="direction_id" value="<?php echo $direction_id ?>" />
        <input type="hidden" name="step_id" value="<?php echo $step_id ?>" />
        <input type="hidden" name="destination_spot_id" value="<?php echo $destination_spot_id ?>" />
        <?php if ($spot != null){ ?>
            <input type="hidden" name="spot_id" value="<?php echo $spot['id'] ?>" />
        <?php } ?>
        <input type="hidden" name="tour_id" value="<?php echo $tour_id ?>" />
        <button type="submit" class="btn btn-warning btn-fab  btn-raised mdi-maps-beenhere btn-center" style="margin-left:-28px;" 
       data-step="3" data-intro="写真のスポットに到着したら、押しましょう！次のスポットに進みます。"  data-position="top"></button>
    </form>

<!-- 次に進む方向dialog start -->
<div class="modal fade" id="next-direction" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">次に進む方向</h4>
      </div>
      <div class="modal-body">
        <img id="direction" border="0" class="img-thumbnail" style="width:100%;">
      </div>
    </div>
  </div>
</div>
<!-- 次に進む方向dialog /end -->

<!-- 次のスポットの地図dialog start -->
<div class="modal fade" id="next-spot-map" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">次のスポットまでの地図</h4>
      </div>
      <div class="modal-body">
        <div id="map-canvas" style="height:300px;"></div>
      </div>
    </div>
  </div>
</div>
<!-- 次のスポットの地図dialog /end -->
