<script type="text/javascript" charset="utf-8">
$(window).load(function () {
        $('.flexslider').flexslider();
        });
</script>
<div class="container">

<?php

App::uses('Helper', 'View');

class ListHelper extends Helper {
    
    public function getModal($spot_name, $spot_id, $spot_description, $lat, $lng, $num_like){
    
    echo "<div class=\"modal fade\" id=\"Modal" . $spot_id . "\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"ModalLabel" . $spot_id . "\" aria-hidden=\"true\">";
    echo "<div class=\"modal-dialog\">";
    echo "    <div class=\"modal-content\">";
    echo "        <div class=\"modal-header\">";
    echo "            <button type=\"button\" class=\"close\" data-dismiss=\"modal\">";
    echo "                <span aria-hidden=\"true\">&times;</span>";
    echo "                <span class=\"sr-only\">Close</span>";
    echo "            </button>";
    echo "            <h3 class=\"modal-title\" id=\"ModalLabel" . $spot_id . "\">「" . $spot_name . "」へぶらりする</h3>";
    echo "            <br>";
    echo "            <p>まちたん！がおすすめするお散歩ルートを通って「" . $spot_name . " 」へぶらりしましょう!</p>";
    echo "            <div class=\"panel panel-info\" id=\"about-info\">";
    echo "                <div class=\"panel-heading\"><span class=\"glyphicon glyphicon-camera\"></span> " . $spot_name . "</div>";
//    echo "                <div class=\"panel-body\">";
//    echo "                   <img src=\"" . $imagefile . "\" style=\"width:100%\">";
//    echo "                </div>";
    exec("ls img/machitan_pic/" . $spot_id , $files);
    if( count($files) > 0) {
        echo '<div class="flexslider">';
        echo '<ul class="slides">';
        for ($i = 0; $i < count($files) ; $i++){
        echo '<li>';
        echo '<img id="banner-left" border="0" src="img/machitan_pic/' . $spot_id . '/' . $files[$i] . '"';
        echo '</li>';
        }
    echo '</ul>';
    echo '</div>';
    }else{
        echo '<div class="flexslider">';
        echo '<ul class="slides">';
        echo '<li>';
        echo '<img id="banner-left" border="0" src="../img/no-image-1.jpg"';
        echo '</li>';
      echo '</ul>';
        echo '</div>';
    }
    echo "            </div>";
    echo "            <div class=\"panel panel-info\" id=\"about-info\">";
    echo "                <div class=\"panel-heading\"><span class=\"glyphicon glyphicon-info-sign\"></span> 「" . $spot_name . "」はどんなところ？</div>";
    echo "                <div class=\"panel-body\">";
    echo "                   <p>" . $spot_description . "</p>";
    echo "                </div>";
    echo "            </div>";
    echo "            <div class=\"panel panel-info\" id=\"about-info\">";
    echo "                <div class=\"panel-heading\"><span class=\"glyphicon glyphicon-thumbs-up\"></span> 「" . $spot_name . "」のいいね！の数</div>";
    echo "                <div class=\"panel-body\" style=\"text-align:center\">";
    echo "                   <h3>" . $num_like . "</h3>";
    echo "                </div>";
    echo "            </div>";
    echo "            <p>「" . $spot_name . "」に行くまでに寄り道してもいいよ、って方は「寄り道あり」を選択してください。</p>";
    echo "        </div>";
    echo "        <div class=\"modal-body\">";
    echo "            <form action=\"/play\" method=\"get\">";
    echo "                <div class=\"form-group\">";
    echo "                    <div class=\"radio radio-primary\">";
    echo "                    <label class=\"radio-inline\"><input type=\"radio\" name=\"waypoints_onoff\" value=on checked>寄り道をする</label>";
    echo "                    </div><div class=\"radio radio-primary\">";
    echo "                    <label class=\"radio-inline\"><input type=\"radio\" name=\"waypoints_onoff\" value=off>寄り道をしない</label>";
    echo "                    </div>";
    echo "                    <input type=\"hidden\" name=\"destination_spot_id\" value=\"" . $spot_id . "\">";
    echo "                    <input type=\"hidden\" name=\"lat\" value=\"" . $lat . "\">";
    echo "                    <input type=\"hidden\" name=\"lng\" value=\"" . $lng . "\">";
    echo "                </div>";
    echo "                <div class=\"modal-footer\">";
    echo "                    <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">キャンセル</button>";
    echo "                    <input type=\"submit\" class=\"btn btn-primary\" value=\"ぶらりする\"></input>";
    echo "                </div>";
    echo "            </form>";
    echo "        </div>";
    echo "    </div>";
    echo "</div>";
    echo "</div>";
    
    }

public function getTourModal($tour_name, $tour_id, $tour_description, $goal_spot_id, $lat, $lng){
    
    echo "<div class=\"modal fade\" id=\"TourModal" . $tour_id . "\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"ModalLabel" . $tour_id . "\" aria-hidden=\"true\">";
    echo "<div class=\"modal-dialog\">";
    echo "    <div class=\"modal-content\">";
    echo "        <div class=\"modal-header\">";
    echo "            <button type=\"button\" class=\"close\" data-dismiss=\"modal\">";
    echo "                <span aria-hidden=\"true\">&times;</span>";
    echo "                <span class=\"sr-only\">Close</span>";
    echo "            </button>";
    echo "            <h3 class=\"modal-title\" id=\"ModalLabel" . $tour_id . "\">「" . $tour_name . "」へぶらりする</h3>";
    echo "            <br>";
    echo "            <p>まちたん！がおすすめするお散歩ルートを通って「" . $tour_name . " 」へぶらりしましょう!</p>";
    echo "            <div class=\"panel panel-info\" id=\"about-info\">";
    echo "                <div class=\"panel-heading\"><span class=\"glyphicon glyphicon-camera\"></span> " . $tour_name . "</div>";
    exec("ls img/machitan_pic/" . $goal_spot_id , $files);
    if( count($files) > 0) {
        echo '<div class="flexslider">';
        echo '<ul class="slides">';
        for ($i = 0; $i < count($files) ; $i++){
        echo '<li>';
        echo '<img id="banner-left" border="0" src="img/machitan_pic/' . $goal_spot_id . '/' . $files[$i] . '"';
        echo '</li>';
        }
        echo '</ul>';
        echo '</div>';
    }else{
        echo '<div class="flexslider">';
        echo '<ul class="slides">';
        echo '<li>';
        echo '<img id="banner-left" border="0" src="../img/no-image-1.jpg"';
        echo '</li>';
        echo '</ul>';
        echo '</div>';
    }
    echo "            </div>";
    echo "            <div class=\"panel panel-info\" id=\"about-info\">";
    echo "                <div class=\"panel-heading\"><span class=\"glyphicon glyphicon-info-sign\"></span> 「" . $tour_name . "」はどんなところ？</div>";
    echo "                <div class=\"panel-body\">";
    echo "                   <p>" . $tour_description . "</p>";
    echo "                </div>";
    echo "            </div>";
    echo "        <div class=\"modal-body\">";
    echo "            <form action=\"/play\" method=\"get\">";
    echo "                <div class=\"form-group\">";
    echo "                    <input type=\"hidden\" name=\"tour_id\" value=\"" . $tour_id . "\">";
    echo "                    <input type=\"hidden\" name=\"lat\" value=\"" . $lat . "\">";
    echo "                    <input type=\"hidden\" name=\"lng\" value=\"" . $lng . "\">";
    echo "                </div>";
    echo "                <div class=\"modal-footer\">";
    echo "                    <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">キャンセル</button>";
    echo "                    <input type=\"submit\" class=\"btn btn-primary\" value=\"ぶらりする\"></input>";
    echo "                </div>";
    echo "            </form>";
    echo "        </div>";
    echo "    </div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    
    }
}
