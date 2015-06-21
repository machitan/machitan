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
    <!-- Modal Window Start -->
    <div class="modal active" id="instruction" style="">
       <div class="modal-dialog">
          <div class="modal-content">
             <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">遊び方</h4>
             </div>
             <div class="modal-body">
                <p>
                   <ol>
                        <li>
                            写真のスポットを探そう！
                        </li>
                        <li>
                            写真の場所が分からなかったら、「次の方向」と「地図」をヒントに進む！<br />
                            でも点数が下がってしまうから、使いすぎには気をつけましょー
                        </li>
                   </ol>
                </p>
             </div>
             <div class="modal-footer">
                <button type="button" class="btn btn-lg btn-primary" data-dismiss="modal">Start</button>
             </div>
          </div>
       </div>
    </div>
    <!-- Modal Window End -->

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

    <div id="distance-message" class="alert alert-dismissable alert-info">
       写真のスポットまでの距離を計測中...
    </div>

    <!--タブ-->
    <ul class="nav nav-tabs">
        <li class="active">
            <a href="#tab1" data-toggle="tab"><span class="glyphicon glyphicon-info-sign"></span> 次のスポット</a>
        </li>
        <li><a href="#tab2" data-toggle="tab"><span class="glyphicon glyphicon-circle-arrow-up"></span> 次の方向</a>
        </li>
        <li><a href="#tab3" data-toggle="tab"><span class="glyphicon glyphicon-map-marker"></span> 地図</a>
        </li>
    </ul>
    <!--タブコンテンツ-->
    <div id="myTabContent" class="tab-content">
        <!-- スポット情報 -->
        <div class="tab-pane fade in active" id="tab1">
            <div class="flexslider">
                <ul class="slides">
                    <li>
                        <img id="banner-left" border="0" src="http://maps.googleapis.com/maps/api/streetview?size=640x300&location=<?php echo $step->end_location->lat ?>,<?php echo $step->end_location->lng ?>8&fov=120&pitch=0&heading=0&sensor=false&key=AIzaSyDE_HtWXSjaSvlmyQvNcYpr3WFpSe2C68Y">
                    </li>
                    <li>
                        <img id="banner-left" border="0" src="http://maps.googleapis.com/maps/api/streetview?size=640x300&location=<?php echo $step->end_location->lat ?>,<?php echo $step->end_location->lng ?>8&fov=120&pitch=0&heading=90&sensor=false&key=AIzaSyDE_HtWXSjaSvlmyQvNcYpr3WFpSe2C68Y">
                    </li>
                    <li>
                        <img id="banner-left" border="0" src="http://maps.googleapis.com/maps/api/streetview?size=640x300&location=<?php echo $step->end_location->lat ?>,<?php echo $step->end_location->lng ?>8&fov=120&pitch=0&heading=180&sensor=false&key=AIzaSyDE_HtWXSjaSvlmyQvNcYpr3WFpSe2C68Y">
                    </li>
                    <li>
                        <img id="banner-left" border="0" src="http://maps.googleapis.com/maps/api/streetview?size=640x300&location=<?php echo $step->end_location->lat ?>,<?php echo $step->end_location->lng ?>8&fov=120&pitch=0&heading=270&sensor=false&key=AIzaSyDE_HtWXSjaSvlmyQvNcYpr3WFpSe2C68Y">
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- 次のスポットの方角を向いた写真 -->
        <div class="tab-pane fade" id="tab2">
            <img id="direction" border="0" class="img-thumbnail" style="width:100%;">
        </div>
        
        <!-- 次のスポット情報 -->
        <div class="tab-pane fade" id="tab3">
           <div id="map-canvas" style="height:300px;"></div>
        </div>
    </div>
<div class="container" >

    <?php   if ($spot != null){ ?>
    <form action="/spot" method="get">
        <input type="hidden" name="direction_id" value="<?php echo $direction_id ?>" />
        <input type="hidden" name="step_id" value="<?php echo $step_id ?>" />
        <input type="hidden" name="destination_spot_id" value="<?php echo $destination_spot_id ?>" />
        <input type="hidden" name="spot_id" value="<?php echo $spot['id'] ?>" />
        <input type="submit" class="btn btn-info btn-lg goalbutton" value="スポット到着！" style="width:100%;" onClick="return isGoal('スポット')"/>
    </form>
    <?php   } else {?>
    <form action="/play" method="get">
        <!--
        <input type="hidden" name="spot_id" value="<?php echo $spot_id ?>" />
        -->
        <input type="hidden" name="direction_id" value="<?php echo $direction_id ?>" />
        <input type="hidden" name="step_id" value="<?php echo $step_id ?>" />
        <input type="hidden" name="destination_spot_id" value="<?php echo $destination_spot_id ?>" />
        
        <!-- ここでゴール到着の判定がうまくいってない　高橋 -->
        
        <?php if ($step->is_last) { ?>
            <input type="submit" class="btn btn-info btn-lg goalbutton" value="ゴール到着！" style="width:100%;" onClick="return isGoal('ゴール')"/>
        <!--<?php //} else if ($step && $step->is_way_point) { ?>
            <input type="submit" class="btn btn-info btn-lg goalbutton" value="経由地到着！" style="width:100%;" onClick="return isGoal('経由地')"/>-->
        <?php } else {?>
            <input type="submit" class="btn btn-info btn-lg goalbutton" value="経由地到着！" style="width:100%;" onClick="return isGoal('経由地')"/>
        <?php } ?>
    </form>
    <?php } ?>
    <form action="/like" method="get">
        <input type="hidden" name="direction_id" value="<?php echo $direction_id ?>" />
        <input type="hidden" name="step_id" value="<?php echo $previous_step_id ?>" />
        <input type="hidden" name="destination_spot_id" value="<?php echo $destination_spot_id ?>" />
        <input type="submit" class="btn btn-info btn-lg" value="ナイススポット発見！" style="width:100%;" />
    </form>

</div>
