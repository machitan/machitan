<?php
/**
 * Created by PhpStorm.
 * User: adte
 * Date: 15/01/12
 * Time: 15:17
 */

class DirectionsJson {

    /**
     * @var ステップ情報
     */
    public $steps;

    /**
     * @var APIからの戻り値のオリジナルJSON
     */
    private $_original_directions_json;

    function __construct ($directions_json)
    {
        // オリジナルのJsonを保存
        $this->_original_directions_json = $directions_json;

        // Jsonをパースする
        $this->__parse();
    }

    /**
     * 次のステップを取得する
     *
     * @param $current_step 現在のステップ
     * @return $next_step
     */
    public function getNextStep($current_step)
    {
       if (count($this->steps) -1 == $current_step)
           return null;

        return $this->steps[$current_step + 1];
    }

    /**
     * Google APIからの戻りJSONに、情報を付与しながらパースする
     */
    private function __parse()
    {
        // JSONデコード
        $directions = json_decode($this->_original_directions_json);

        $steps = array();
        $step_count = 0; // 何ステップ目か
        $way_point_count = 0; // 何経由地目か

        foreach ($directions->routes[0]->legs as $key => $leg) {

            // 経由地の位置情報
            $end_lat = $leg->end_location->lat;
            $end_lng = $leg->end_location->lng;

            foreach ($leg->steps as $i) {

                // 何ステップ目かを付与
                $i->step_count = $step_count;

                // 何経由地目かを付与
                $i->way_point_count = $way_point_count;

                // ラストステップ情報を初期化
                $i->is_last = false;

                // 現在のステップが経由地かどうかを付与
                $i->is_way_point = $this->__isSameLocation($i->end_location->lat, $i->end_location->lng, $end_lat, $end_lng);

                array_push($steps, $i);

                $step_count++;
            }

            $way_point_count++;
        }

        // ラストステップ情報を付与
        $steps[count($steps) - 1]->is_last = true;

        // パースしたステップ情報を保存
        $this->steps = $steps;
    }

    /**
     * 2地点が同じかどうかを返す
     *
     * @param $lat_a
     * @param $lng_a
     * @param $lat_b
     * @param $lng_b
     * @return bool
     */
    private function __isSameLocation($lat_a, $lng_a, $lat_b, $lng_b)
    {
        return ($lat_a == $lat_b) && ($lng_a == $lng_b);
    }
}