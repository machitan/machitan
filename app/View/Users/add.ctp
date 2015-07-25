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
      <div class="col-lg-6">
        <div class="container">
          <form action="/users/add" id="UserAddForm" method="post" accept-charset="utf-8" class="form-horizontal">
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
          </form>

        </div>
      </div>
      <div class="col-lg-6">
        <div class="container">
          <h4>まちたん！にユーザ登録すると、こんないいことが！</h4>
          <ul>
            <li>
              <p>メリット１</p>
            </li>
            <li>
              <p>メリット２</p>
            </li>
            <li>
              <p>メリット３</p>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="jumbotron">
    <h4 style="text-align:center">利用規約</h4>
    <pre>
    利用規約をここに記載する
  </pre>
  </div>
</div>
