<script type="text/javascript">
    $(document).ready(function () {
        // simple jRating call
        $(".basic").jRating();

        // more complex jRating call
        $(".basic").jRating({
            step: true,
            length: 20, // nb of stars
            onSuccess: function () {
                alert('Success : your rate has been saved :)');
            }
        });

        // you can rate 3 times ! After, jRating will be disabled
        $(".basic").jRating({
            canRateAgain: true,
            nbRates: 3
        });

        // get the clicked rate !
        $(".basic").jRating({
            onClick: function (element, rate) {
                alert(rate);
            }
        });
    });
</script>
<div class="container">

    <div class="panel panel-info" id="about-info">
        <div class="panel-heading"><span class="glyphicon glyphicon-info-sign"></span>　今のお散歩コース</div>
        <div class="panel-body">
            <img src="../img/2014-12-14 141604.png" width=100%>
        </div>
    </div>

    <div class="panel panel-info" id="about-info">
        <div class="panel-heading"><span class="glyphicon glyphicon-info-sign"></span>　今のお散歩コースはいかがでしたか？</div>
        <div class="panel-body">
            <p>5（最高！）〜1（おもしろくなかった…）で評価してください</p>
            <div class="basic" data-average="12" data-id="1"></div>
        </div>
    </div>

    <div style="text-align:center;">
        <a class="btn btn-info btn-lg" href="list" style="width:100%;">もう一度ぶらりする</a>
    </div>
    <br>

</div>