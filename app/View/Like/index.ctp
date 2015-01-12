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

<script src="/js/app/like/index.js"></script>
<div class="container">

    <div style="text-align;center">
        <h4>あなたの見つけたお気に入りのスポットを登録しよう！</h4>
    </div>
    <br>
    
    <form method="post" enctype="multipart/form-data" action="like/add" id="add">
        <div class="panel panel-info" id="about-info">
            <div class="panel-heading"><span class="glyphicon glyphicon-info-sign"></span>　あなたの撮ったまちの写真（必須）</div>
            <div class="panel-body">
                <img id="image" width="100%">
                <input type="file" accept="image/*;capture=camera" id="imageFile" name="picture"/>
            </div>
        </div>

        <div class="panel panel-info" id="about-info">
            <div class="panel-heading"><span class="glyphicon glyphicon-info-sign"></span>　スポットのお名前を入力してください（必須）</div>
            <div class="panel-body">
                <input type="text" id="name" name="name" style="width:100%" class="form-control" required>
            </div>
        </div>

        <div class="panel panel-info" id="about-info">
            <div class="panel-heading"><span class="glyphicon glyphicon-info-sign"></span>カテゴリを選択してください</div>
            <div class="panel-body">
              <select class="selectpicker form-control" name="category_id" class="form-control">
                  <option value="1">食べる</option>
                  <option value="2">買う</option>
                  <option value="3">遊ぶ</option>
                  <option value="4">その他</option>
              </select>
            </div>
        </div>

        <div class="panel panel-info" id="about-info">
            <div class="panel-heading"><span class="glyphicon glyphicon-info-sign"></span>　スポットの説明を入力してください</div>
            <div class="panel-body">
                <textarea id="description" name="description"  style="width:100%" class="form-control"></textarea>
            </div>
        </div>
        <p>
            <input type="submit" value="登録" class="btn btn-primary btn-block btn-lg">
        </p>
        <input type="hidden" name="direction_id" value="<?php echo $direction_id?>">
        <input type="hidden" name="step_id" value="<?php echo $step_id?>">
        <input type="hidden" name="destination_spot_id" value="<?php echo $destination_spot_id?>">
    </form>
</div>
