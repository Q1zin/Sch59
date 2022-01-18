<?php

include '../config.php';

$main_base = new DataBase(BASE_NAME, BASE_USER, BASE_PASS, CHARSET, BASE_HOST);
$user = new User($main_base);

var_dump($user);

echo '<br><br><br><br>';

if ($user->get_chack_status() != 'admin') {
  header("Location: https://" . SITE_HOST . "/");
  exit;
}

?>
<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Добавление новостей - ДЕМО</title>
  <style>
    .wrap {
      display: flex;
      flex-direction: column;
      width: 30%;
      margin: auto;
    }

    .input {
      width: 100%;
      margin-bottom: 10px;
    }

    .input-content {
      width: 100%;
      height: 150px;
    }

    .success {
      color: green
    }

    .error {
      color: red
    }

    .exit-login {
      position: absolute;
      bottom: 50px;
      right: 50px;
    }
  </style>
</head>

<body>
  <div class="wrap">
    <label for="img" class="label">Картинка (https://sch59.su/img/service/news-1-123.jpg)</label>
    <input name="img" type="text" class="input" id="img">
    <label for="title" class="label">Заголовок</label>
    <input name="title" type="text" class="input" id="title">
    <label for="sub-title" class="label">Под-заголовок</label>
    <input name="sub-title" type="text" class="input" id="sub-title">
    <label for="date" class="label">Дата</label>
    <input name="date" type="date" class="input" id="date">
    <label for="tags" class="label">Теги</label>
    <select class="input" name="tags" id="tags">
      <option>
        #важные
      </option>
      <option>
        #администрация
      </option>
      <option>
        #поздравления
      </option>
      <option>
        #школьная жизнь
      </option>
      <option>
        #статьи
      </option>
    </select>
    <label for="content" class="label">Контент</label>
    <textarea name="content" id="content" class="input-content"></textarea>
    <br>
    <button name="send" class="send">Отправить</button>
    <span class="error"></span>
    <span class="success"></span>
  </div>
  <button class="exit-login">Выйти из аккаунта</button>


  <script>
    let doc = document

    doc.querySelector(".send").onclick = function() {
      let img = doc.querySelector("#img").value,
        title = doc.querySelector("#title").value,
        subTitle = doc.querySelector("#sub-title").value,
        date = doc.querySelector("#date").value.replace("-", ".").replace("-", "."),
        tags = doc.querySelector("#tags").value,
        content = doc.querySelector("#content").value

      if (img == "" || title == "" || subTitle == "" || date == "" || tags == "" || content == "") {
        doc.querySelector(".error").innerHTML = "Введите корректные значения!"
        return;
      }

      ajaxPost("/requests/add_news.php", `img=${img}&title=${title}&subTitle=${subTitle}&date=${date}&tags=${tags}&content=${content}`, function(answer) {
        answer = JSON.parse(answer)
        if (answer.error) {
          doc.querySelector(".error").innerHTML = "Что-то пошло не так"
          doc.querySelector(".success").innerHTML = ""
        } else {
          doc.querySelector(".error").innerHTML = ""
          doc.querySelector(".success").innerHTML = "Новость успешно добавлена!"
        }
      })

    }

    doc.querySelector(".exit-login").onclick = function() {
      ajaxPost("/requests/logout_admin.php", ``, function(answer) {
        console.log(answer)
        answer = JSON.parse(answer)
        if (!answer['error']) {
          window.location.href = "/"
        }
      })
    }

    function ajaxPost(url, parameters, callback) {
      // parameters = encodeURIComponent(parameters)
      if (parameters === false || parameters === null || parameters === undefined) {
        parameters = "";
      }
      var request = new XMLHttpRequest();
      request.open('POST', url, true);
      request.addEventListener('readystatechange', function() {
        if ((request.readyState == 4) && (request.status == 200)) {
          callback(request.responseText)
        } else {
          if (request.readyState == 0) {
            showError(1, "Request not initialized")
          }
          if (request.status == 403) {
            showError(2, "Forbidden")
          }
          if (request.status == 404) {
            showError(3, "Not Found")
          }

        }
      });
      request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
      request.send(parameters);
    }
  </script>
</body>

</html>