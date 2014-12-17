<script src="/js/app/list/index.js"></script>
<div class="container">
    <br>
    <div style="text-align:center;">
        <a href="play" class="btn btn-info btn-lg" style="width:100%;">とりあえずぶらりする</a>
    </div>

    <h4>行きたいところも選んでぶらりする</h4>
    <!--タブ-->
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab1" data-toggle="tab">食べる</a>
        </li>
        <li><a href="#tab2" data-toggle="tab">遊ぶ</a>
        </li>
        <li><a href="#tab3" data-toggle="tab">買う</a>
        </li>
    </ul>
    <!--タブコンテンツ-->
    <div id="myTabContent" class="tab-content">
	<ul class="list-group">
	<?php 
    $count = 0;
    while($num_of_spots > $count){
        ?>
	    <li class="list-group-item">
            <a href="play?spot_id=<?php echo $spot_names[$count]['Spot']['id'] ?>">
                <?php echo $spot_names[$count]['Spot']['name'] ?>
            </a>
	    </li>
	<?php 
        $count++;
    };
        ?>
	</ul>
        
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
