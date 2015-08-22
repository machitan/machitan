<script>
  $(document).ready(function() {
    $('#term_check_box').click(function() {
      if ($('#term_check_box').prop('checked')) {
        $("#submit-button").prop("disabled", false);
      } else {
        $("#submit-button").prop("disabled", true);
      }
    });
  });
</script>
<div class="container">
  <div class="jumbotron">
    <h3>まちたん！へようこそ！</h3>
    <p style="font-size:16px;">利用規約をお読みの上、同意いただける方は下記のチェックを入れて登録してください</p>
    <div class="row">
      <form action="/users/add" id="UserAddForm" method="post" accept-charset="utf-8" class="form-horizontal">
        <div class="col-lg-6">
          <div class="container">
            <div style="display:none;">
              <input type="hidden" name="_method" value="POST" />
              <input type="hidden" name="data[User][role]" value="author" />
            </div>
            <fieldset>
              <div class="form-group required">
                <label class="control-label" for="UserUsername">ユーザ名</label>
                <input class="form-control" name="data[User][username]" maxlength="50" type="text" id="UserUsername" required="required" placeholder="Username" />
              </div>
              <div class="input password required form-group">
                <label class="control-label" for="UserPassword">パスワード</label>
                <input class="form-control" name="data[User][password]" type="password" id="UserPassword" required="required" placeholder="Password" />
              </div>
            </fieldset>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="container">
            <fieldset>
              <div class="form-group required">
                <label class="control-label" for="UserHeight">身長(cm)</label>
                <input class="form-control" name="data[User][height]" maxlength="50" type="text" id="UserUsername" required="required" placeholder="height" />
              </div>
              <div class="input password required form-group">
                <label class="control-label" for="UserWeight">体重(kg)</label>
                <input class="form-control" name="data[User][weight]" type="text" id="UserPassword" required="required" placeholder="weight" />
              </div>
              <div class="input password required form-group">
                <label class="control-label" for="UserAge">年齢</label>
                <input class="form-control" name="data[User][age]" type="text" id="UserPassword" required="required" placeholder="age" />
              </div>
              <label class="control-label" for="UserWalkingSpeed">歩く速さ（主観で選んでください）</label>
              <div class="form-group radio radio-primary required">
                <label>
                  <input type="radio" name="speed_level" value="0"> ゆっくり
                </label>
                <label>
                  <input type="radio" name="speed_level" value="1" checked=""> ふつう
                </label>
                <label>
                  <input type="radio" name="speed_level" value="2"> はやめ
                </label>
              </div>
            </fieldset>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="container">
            <fieldset>
              <div class="form-group checkbox">
                <label>
                  <input id="term_check_box" type="checkbox" name="terms_check"> 利用規約に同意します。
                </label>
              </div>
              <br>
              <div class="form-group submit">
                <button id="submit-button" type="submit" class="btn btn-primary" disabled>登録</button>
              </div>
            </fieldset>
          </div>
        </div>
      </form>
    </div>
  </div>
  <div class="jumbotron">
    <h4 style="text-align:center">利用規約</h4>
    <pre>
    利用規約をここに記載する
  </pre>
  </div>
</div>
