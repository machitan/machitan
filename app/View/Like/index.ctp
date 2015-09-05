<meta charset="utf-8">
<meta name="viewport" content="initial-scale=1.0" />
<script src="/js/app/like/index.js"></script>
<script src="/js/lib/resize.js"></script>
<script>
function onFileSelect(evt) {
  console.log("onFileSelect() File selected.");
  procFiles(evt.target.files);
}


function procFiles(files) {
  //console.log("procFiles() START");
  for (var i = 0; i < files.length; i++) {
    resizeImageFile(files[i]);
  }
  //console.log("procFiles() END");
}


function resizeImageFile(file) {

  //console.log("resizeImageFile() name=" + file.name);
  var side = $("#selSide").val();
  //var length = $("#numLength").val();
  var length = 240;

  $("#imgResizer").attr("src", "img/loading.gif");

  resizeByOneSideLength(file, "Resizer", side, length, function (data) {
    console.log("resized! by Resizer");
    $("#imgResizer").attr("src", data);

    $("#reseizedImage").attr("value", data);
  });

}


function resizeByOneSideLength(file, method, mode, length, callback) {
    loadImage(file, function (img) {
        var mode ="longest";

        //calc new width and height
        var ow = img.width;
        var oh = img.height;
        var nw;
        var nh;
        switch (mode) {
          case "longest":
            if (ow > oh) {
              nw = length;
              nh = oh * length / ow;
            } else {
              nw = ow * length / oh;
              nh = length;
            }
            break;
          case "height":
            nw = ow * length / oh;
            nh = length;
            break;
          case "width":
            nw = length;
            nh = oh * length / ow;
            break;
    }
    console.log("resizeByOneSideLength() name=" + file.name
                + " method=" + method + " mode=" + mode
                + " ow=" + ow + " oh=" + oh
                + " nw=" + nw + " nh=" + nh);

    //Resize by Resizer
    if (method == "Resizer") {

        //Resizer Object
        var resizer = new Resize(ow, oh, nw, nh, true, true, false, function (frameBuffer) {
        var cvDst = document.createElement("canvas");
        cvDst.width = nw;
        cvDst.height = nh;
        var cxtDst = cvDst.getContext("2d");
        var imageBuffer = cxtDst.createImageData(nw, nh);
        var data = imageBuffer.data;
        var length = data.length;
        for (var x = 0; x < length; ++x) {
          data[x] = frameBuffer[x] & 0xFF;
        }
        cxtDst.putImageData(imageBuffer, 0, 0);
        callback.call(this, cvDst.toDataURL());
      });

      //Source Canvas
      var cvSrc = document.createElement("canvas");
      cvSrc.width = ow;
      cvSrc.height = oh;
      var cxtSrc = cvSrc.getContext("2d");
      cxtSrc.drawImage(img, 0, 0, ow, oh);
      var dataToScale = cxtSrc.getImageData(0, 0, ow, oh).data;

      //Resizer Start
      resizer.resize(dataToScale);

    } // END Resizer


  }); // END loadImage()
} // END resizeByOneSideLength()


function loadImage(file, callback) {
  var reader = new FileReader();
  reader.onload = function(evt) {
    var img = new Image();
    img.onload = function() {
      callback.call(this, img);
    };
    img.src = evt.target.result;
  };
  reader.readAsDataURL(file);
}
</script>
<div class="container">

    <div style="text-align;center">
        <h4>あなたの見つけたお気に入りのスポットを登録しよう！</h4>
    </div>
    <br>

    <form method="post" enctype="multipart/form-data" action="like/add" id="add">
        <div class="panel panel-info" id="about-info">
            <div class="panel-heading"><span class="glyphicon glyphicon-info-sign"></span>　あなたの撮ったまちの写真（必須）</div>
            <div class="panel-body" id="imageFilePanel">
                <img id="image" width="100%">
                <!--<img id="imgResizer">-->
                <input type="file" accept="image/*;capture=camera" id="imageFile" name="picture" onchange="onFileSelect(event);"/>
                <!--<input type="hidden" id="reseizedImage" name="reseizedImage">-->
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
        <input type="hidden" name="tour_id" value="<?php echo $tour_id?>">
    </form>
</div>
