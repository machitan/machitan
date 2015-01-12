<?php

App::uses('Helper', 'View');

class ListHelper extends Helper {

    public function getModal($spot_name, $spot_id, $spot_description, $lat, $lng, $imagefile, $num_like){
    
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
    echo "                <div class=\"panel-body\">";
    echo "                   <img src=\"" . $imagefile . "\" style=\"width:100%\">";
    echo "                </div>";
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
    echo "                    <input type=\"radio\" name=\"waypoints_onoff\" value=on checked>寄り道をする";
    echo "                    <input type=\"radio\" name=\"waypoints_onoff\" value=off>寄り道をしない";
    echo "                    <input type=\"hidden\" name=\"destination_spot_id\" value=\"" . $spot_id . "\">";
    echo "                    <input type=\"hidden\" name=\"lat\" value=\"" . $lat . "\">";
    echo "                    <input type=\"hidden\" name=\"lng\" value=\"" . $lng . "\">";
    echo "                </div>";
    echo "                <div class=\"modal-footer\">";
    echo "                    <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">キャンセル</button>";
    echo "                    <input type=\"submit\" value=\"ぶらりする\"></input>";
    echo "                </div>";
    echo "            </form>";
    echo "        </div>";
    echo "    </div>";
    echo "</div>";
    echo "</div>";
    
    }

}
