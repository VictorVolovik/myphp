<?php
require_once "config/view.php";

$inline_javascript = <<<EOD
  $(document).ready(function() {
    jQuery.validator.addMethod("noSpace", function(value, element) {
      return value.indexOf(" ") < 0 && value != "";
      }, "Пробелы недопустимы");
    $('#signup_form').validate({
      rules: {
        password: {
          minlength: 6
        },
        confirm_password: {
          minlength: 6,
          equalTo: "#password"
        },
        username: {
            required: true,
            minlength: 2,
            maxlength:15,
            noSpace: true
        }
      },
      messages: {
        password: {
          minlength: "Пароль должен быть не менее 6 символов"
        },
        confirm_password: {
          minlength: "Пароль должен быть не менее 6 символов",
          equalTo: "Ваши пароли не совпадают."
        }
      }
    });
  });
EOD;
page_start("Регистрация пользователя", $inline_javascript);
?>

  <div id="content">
    <h1>Вступайте в наш виртуальный клуб</h1>
    <p>Пожалуйста, введите ниже свои данные для связи в Интернете:</p>
    <p>Почему бы вам не набрать свое имя для меня:</p>
    <form id="signup_form" action="create_user.php" method="POST" enctype="multipart/form-data">
      <fieldset>
        <label for="first_name">Имя:</label>
        <input type="text" id="first_name" name="first_name" size="20" class="required">
        <br>
        <label for="last_name">Фамилия:</label>
        <input type="text" id="last_name" name="last_name" size="20" class="required">
        <br>
        <label for="username">Имя пользователя:</label>
        <input type="text" id="username" name="username" size="20" class="required">
        <br>
        <label for="password">Пароль</label>
        <input type="password" id="password" name="password" size="20" class="required password">
        <div class="password-meter">
          <div class="password-meter-message"></div>
          <div class="password-meter-bg">
            <div class="password-meter-bar"></div>
          </div>
        </div>
        <br>
        <label for="confirm_password">Подтверждение пароля:</label>
        <input type="password" id="confirm_password" name="confirm_password" size="20" class="required">
        <br>
        <label for="email">Адрес электронной почты:</label>
        <input type="text" id="email" name="email" size="30" class="required email">
        <br>
        <label for="facebook_url">URL в Facebook:</label>
        <input type="text" id="facebook_url" name="facebook_url">
        <br>
        <label for="twitter_handle">Идентификатор в Twitter:</label>
        <input type="text" id="twitter_handle" name="twitter_handle" size="20">
        <br>
        <label for="bio">Биография:</label>
        <textarea id="bio" name="bio" cols="40" rows="10"></textarea>
        <br>
        <label for="user_pic">Отправка изображения для профиля:</label>
        <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
        <input type="file" id="user_pic" name="user_pic" size="30">
      </fieldset>
      <br>
      <fieldset class="center">
        <input type="submit" value="Вступить в клуб">
        <input type="reset" value="Очистить и начать все сначала">
      </fieldset>
    </form>
  </div>
  <div id="footer">
  </div>
</body>

</html>
