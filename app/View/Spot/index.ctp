<script type="text/javascript" charset="utf-8">
$(window).load(function () {
        $('.flexslider').flexslider();
        });
</script>
<script src="/js/app/spot/index.js"></script>

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
                <div class="panel-heading"><span class="glyphicon glyphicon-camera"></span>　スポットの写真</div>
                <div class="flexslider">
                    <ul class="slides">
                    <?php 
                    if(file_exists('/opt/web/app/webroot/img/machitan_pic/'.$spot_info[0]['Spot']['id'])){
                        exec("ls img/machitan_pic/" . $spot_info[0]['Spot']['id'] , $files);
                        for ($i = 0; $i < count($files); $i++){
                    ?>
                    <li data-thumb="img/machitan_pic/<?php echo $spot_info[0]['Spot']['id']?>/<?php echo $files[$i] ?>">
                    <img id="banner-left" border="0" src="img/machitan_pic/<?php echo $spot_info[0]['Spot']['id']?>/<?php echo $files[$i] ?>" style="width:100%">
                    </li>
                    <?php
                    }
                    }
                    else{
                        $files = array("../img/no-image-1.jpg");
                    ?>
                     <li>
                        <img id="banner-left" border="0" src="<?php echo $files[0] ?>" style="width:100%">
                    </li>
                    <?php
                    } ?>
                    </ul>
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

    <div id="spot-like_num">
        <div class="panel panel-info" id="about-info">
            <div class="panel-heading"><span class="glyphicon glyphicon-thumbs-up"></span>　いいね！の数</div>
            <div class="panel-body" style="text-align:center">
                <h3><?php echo $spot_info[0]['Spot']['like_num']?></h3>
            </div>
        </div>
    </div>

    <div id="spot-like_comment">
        <div class="panel panel-info" id="about-info">
            <div class="panel-heading"><span class="glyphicon glyphicon-thumbs-up"></span>　みんなのコメント</div>
            <div class="panel-body">
                <?php if($comments == null){ ?>
                    <p>コメントがありません</p>
                <?php }else{
                    for($i = 0 ; $i < count($comments); $i++){
                ?>
                    <p><?php echo $comments[$i]['Comments']['comment']?> ( <?php echo $comments[$i]['Comments']['time']?> )</p>
                <?php }
                    }?>
            </div>
        </div>
    </div>
    <div id="spot_image">
        <form method="post" enctype="multipart/form-data" action="spot/add_image" id="add">
            <div class="panel panel-info" id="about-info">
                <div class="panel-heading"><span class="glyphicon glyphicon-info-sign"></span>　あなたの撮ったスポットの写真を追加</div>
                    <div class="panel-body">
                        <img id="image" width="100%">
                        <input type="file" accept="image/*;capture=camera" id="imageFile" name="picture"/>
                    </div>
                    <p>
                    <input type="submit" value="登録" class="btn btn-primary btn-block btn-lg">
                    </p>
                    <input type="hidden" name="spot_id" value="<?php echo $spot_id?>">
                    <input type="hidden" name="direction_id" value="<?php echo $direction_id?>">
                </div>
            </div>
        </form>
    </div>
    <div class="container">
        <row>
            <div class="row">
                <div class="col-md-6 col-xs-6">
                    <form id="like_form" action="spot/like" method="get">
                        <input type="hidden" name="direction_id" value="<?php echo $direction_id ?>" />
                        <input type="hidden" name="step_id" value="<?php echo $step_id ?>" />
                        <input type="hidden" name="spot_id" value="<?php echo $spot_id ?>" />
                        <input type="hidden" name="destination_spot_id" value="<?php echo $destination_spot_id ?>" />
                        <input type="submit" class="btn btn-info btn-lg" value="いいね！" style="width:100%;" />
                    </form>
                </div>
 
                <div class="col-md-6 col-xs-6">
                    <button class="btn btn-info btn-lg" style="width:100%;"  data-toggle="modal" data-target="#myModal">コメントする</button>
                </div>
            </div>
        </row>
        <br>
        <form action="play" method="get">
            <input type="hidden" name="direction_id" value="<?php echo $direction_id ?>" />
            <input type="hidden" name="step_id" value="<?php echo $step_id ?>" />
            <input type="hidden" name="destination_spot_id" value="<?php echo $destination_spot_id ?>" />
            <input type="hidden" name="previous_spot_id" value="<?php echo $spot_id ?>" />
            <input type="submit" class="btn btn-info btn-lg" value="次のスポット" style="width:100%;" />
        </form>
        <br>
    </div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h3 class="modal-title" id="myModalLabel">「<?php echo $spot_info[0]['Spot']['name']?>」</h3>
                <br>
                <p>「<?php echo $spot_info[0]['Spot']['name']?>」にコメントしましょう！</p>
            </div>
            <div class="modal-body">
                <form action="/spot" method="get">
                    <!-- input -->
                    <div class="form-group">
                        <label class="control-label">コメント内容（300字まで）</label>
                        <input type="hidden" name="direction_id" value="<?php echo $direction_id ?>" />
                        <input type="hidden" name="step_id" value="<?php echo $step_id ?>" />
                        <input type="hidden" name="spot_id" value="<?php echo $spot_id ?>" />
                        <input type="hidden" name="destination_spot_id" value="<?php echo $destination_spot_id ?>" />
                        <textarea class="form-control" placeholder="" required name="comment_body"></textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            キャンセル
                        </button>
                        <input type="submit" value="コメントする"></input>
                    </div>
                </form>
            </div>
            </div>
            </div>
</div>
