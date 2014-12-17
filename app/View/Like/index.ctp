<meta charset="utf-8">
<meta name="viewport" content="initial-scale=1.0" />
<script>
    window.addEventListener("load", function () {

        if (!window.File) {
            result.innerHTML = "File API 使用不可";
            return;
        }

        document.getElementById("imageFile").addEventListener("change", function () {
            var reader = new FileReader();

            reader.onload = function (event) {
                document.getElementById("image").src = reader.result;
            }
            var file = document.getElementById("imageFile").files[0];
            reader.readAsDataURL(file);
        }, true);
    }, true);
</script>



<div class="container">

    <div style="text-align;center">
        <h4>あなたの見つけたお気に入りのスポットを登録しよう！</h4>
    </div>
    <br>
    
    <form method="get" action="play">
        <div class="panel panel-info" id="about-info">
            <div class="panel-heading"><span class="glyphicon glyphicon-info-sign"></span>　あなたの撮ったまちの写真</div>
            <div class="panel-body">
                <img id="image" width="100%">
                <input type="file" accept="image/*;capture=camera" id="imageFile" />
            </div>
        </div>


        <div class="panel panel-info" id="about-info">
            <div class="panel-heading"><span class="glyphicon glyphicon-info-sign"></span>　スポットのお名前を入力してください</div>
            <div class="panel-body">
                <input type="text" id="name" style="width:100%">
            </div>
        </div>

        <div class="panel panel-info" id="about-info">
            <div class="panel-heading"><span class="glyphicon glyphicon-info-sign"></span>　スポットの説明を入力してください</div>
            <div class="panel-body">
                <textarea id="description" style="width:100%"></textarea>
            </div>
        </div>
        <p>
            <input type="submit" value="登録">
        </p>
        <input type="hidden" name="direction_id" value="<?php echo $direction_id?>">
        <input type="hidden" name="step_id" value="<?php echo $step_id?>">

    </form>
</div>
