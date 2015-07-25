<div class="users form container">
  <div class="jumbotron">
    <form action="/users/login" id="UserLoginForm" method="post" accept-charset="utf-8">
      <div style="display:none;">
        <input type="hidden" name="_method" value="POST" />
      </div>
      <fieldset>
        <legend>
          まちたん！へようこそ。ログインしてください。
        </legend>
        <div class="orm-group input text required">
          <label class="control-label" for="UserUsername">ユーザ名</label>
          <input class="form-control" name="data[User][username]" maxlength="50" type="text" id="UserUsername" required="required" placeholder="Username" />
        </div>
        <div class="orm-group input password required">
          <label class="control-label" for="UserPassword">パスワード</label>
          <input class="form-control" name="data[User][password]" type="password" id="UserPassword" required="required" placeholder="Password" />
        </div>
      </fieldset>
      <div class="form-group submit">
        <button id="submit-button" type="submit" class="btn btn-primary" value="Login">ログイン</button>
      </div>
    </form>
  </div>
</div>
