<div class="container">

    <div id="spot-name">
        <div class="panel panel-info" id="about-info">
            <div class="panel-heading"><span class="glyphicon glyphicon-info-sign"></span>　スポット名</div>
            <div class="panel-body" style="text-align:center">
                <h3><?php echo $spot_info[0]['Spot']['name']?></h3>
            </div>
        </div>
    </div>

    <div id="spot-picture">
        <div id="spot-name">
            <div class="panel panel-info" id="about-info">
                <div class="panel-heading"><span class="glyphicon glyphicon-info-sign"></span>　スポットの写真</div>
                <div class="panel-body">
                    <?php 
                    if(file_exists('/opt/web/app/webroot/img/machitan_pic/'.$spot_info[0]['Spot']['id'].'.jpg')){
        $imagefile = "../img/machitan_pic/".$spot_info[0]['Spot']['id'].".jpg";
}
    else{
        $imagefile = "../img/no-image-1.jpg";
    }
                    ?>
                    <img src="<?php echo $imagefile ?>" style="width:100%">
                </div>
            </div>
        </div>
    </div>

    <div id="spot-description">
        <div id="spot-name">
            <div class="panel panel-info" id="about-info">
                <div class="panel-heading"><span class="glyphicon glyphicon-info-sign"></span> このスポットはどんなところ？</div>
                <div class="panel-body">
                    <p>
                        <?php echo $spot_info[0]['Spot']['description']?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <row>
            <div class="row">
                <div class="col-md-6 col-xs-6">
                    <form action="play/like" method="get">
                        <input type="hidden" name="direction_id" value="<?php echo $direction_id ?>" />
                        <input type="hidden" name="step_id" value="<?php echo $step_id ?>" />
                        <input type="hidden" name="spot_id" value="<?php echo $spot_id ?>" />
                        <input type="submit" class="btn btn-info btn-lg" value="いいね！" style="width:100%;" />
                    </form>
                </div>
 
                <div class="col-md-6 col-xs-6">
                    <form action="play" method="get">
                        <input type="hidden" name="direction_id" value="<?php echo $direction_id ?>" />
                        <input type="hidden" name="step_id" value="<?php echo $step_id ?>" />
                        <input type="submit" class="btn btn-info btn-lg" value="次のスポット" style="width:100%;" />
                    </form>
                </div>
            </div>
        </row>
        <br>
    </div>
