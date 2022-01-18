let doc = document

doc.querySelector(".log-in__input-password-eye").addEventListener("click", function (event) {
  event.preventDefault()
  if (event.target.classList.contains("log-in__input-password-eye--active")) {
    event.target.classList.remove("log-in__input-password-eye--active")
    event.target.setAttribute("src", "../img/service/eye-close-admin.png")
    doc.querySelector(".log-in__input-password").setAttribute("type", "password")
  } else {
    event.target.classList.add("log-in__input-password-eye--active")
    event.target.setAttribute("src", "../img/service/eye-open-admin.png")
    doc.querySelector(".log-in__input-password").setAttribute("type", "text")
  }
})

doc.querySelector(".log-in__forgot-password").addEventListener("click", function (event) {
  event.preventDefault()
  doc.querySelector(".log-in-rem__input-login").value = doc.querySelector(".log-in__input-login").value
  if (doc.documentElement.clientWidth >= 600) {
    doc.querySelector(".log-in__disabled").style.left = "0"
    doc.querySelector(".log-in").style.left = "50%"
    doc.querySelector(".log-in-rem").style.left = "-50%"
    setTimeout(function () {
      doc.querySelector(".log-in").style.left = "25%"
      doc.querySelector(".log-in-rem").style.left = "-25%"
      doc.querySelector(".log-in-rem").style.zIndex = "10000"
    }, 350)
  } else {
    doc.querySelector(".log-in-rem").style.transitionDuration = "0s"
    doc.querySelector(".log-in__disabled").style.transitionDuration = "0s"
    doc.querySelector(".log-in__disabled").style.left = "0"
    doc.querySelector(".log-in-rem").style.zIndex = "10000"
  }
})

doc.querySelector(".log-in-rem__close").addEventListener("click", function (event) {
  event.preventDefault()
  if (doc.documentElement.clientWidth >= 600) {
    doc.querySelector(".log-in__disabled").style.left = "100%"
    doc.querySelector(".log-in").style.left = "50%"
    doc.querySelector(".log-in-rem").style.left = "-50%"
    doc.querySelector(".log-in-rem").style.zIndex = "-100"
    setTimeout(function () {
      doc.querySelector(".log-in").style.left = "0"
      doc.querySelector(".log-in-rem").style.left = "0"
    }, 350)
  } else {
    doc.querySelector(".log-in-rem").style.transitionDuration = "0s"
    doc.querySelector(".log-in__disabled").style.transitionDuration = "0s"
    doc.querySelector(".log-in__disabled").style.left = "100%"
    doc.querySelector(".log-in-rem").style.zIndex = "-100"
  }
})

doc.querySelector(".log-in__submit").addEventListener("click", function (event) {

  let login = doc.querySelector(".log-in__input-login").value,
    password = doc.querySelector(".log-in__input-password").value

  ajaxPost("/requests/login-check.php", `login=${login}&password=${password}`, function (answer) {
    answer = JSON.parse(answer)
    if (answer['connect']) {
      window.location.href = "https://sch59.su/admin/add-news.php"
    } else {
      if (answer['loginErorr']) {
        doc.querySelector(".log-in__input-error").innerHTML = "Логин неверный"
      } else if (answer['passwordErorr']) {
        doc.querySelector(".log-in__input-error").innerHTML = "Пароль неверный"
      } else if (answer['initErorr']) {
        doc.querySelector(".log-in__input-error").innerHTML = "Инициализация формы не прошла"
      } else {
        doc.querySelector(".log-in__input-error").innerHTML = "Неизвестная ошибка"
      }

    }
  })
})

doc.querySelector(".log-in-rem__submit").addEventListener("click", function (event) {

  let login = doc.querySelector(".log-in-rem__input-login").value

  ajaxPost("/send.php", `loginRecovery=${login}`, function (answer) {
    console.log(answer)
    answer = JSON.parse(answer)
    console.log(answer)

    if (!answer['error']) {
      doc.querySelector(".log-in-rem__input-success").innerHTML = "Инструкции отправлены на почту"
      doc.querySelector(".log-in-rem__input-error").innerHTML = ""
    } else {
      doc.querySelector(".log-in-rem__input-success").innerHTML = ""
      if (answer['queryError']) {
        doc.querySelector(".log-in-rem__input-error").innerHTML = "Такого логина не существует"
      } else if (answer['initErorr']) {
        doc.querySelector(".log-in-rem__input-error").innerHTML = "Инициализация формы не прошла"
      } else if (answer['sendError']) {
        doc.querySelector(".log-in-rem__input-error").innerHTML = "Ошибка отправки на почту"
      } else if (answer['exceptionError']) {
        doc.querySelector(".log-in-rem__input-error").innerHTML = "Техническая ошибка"
      } else {
        doc.querySelector(".log-in-rem__input-error").innerHTML = "Неизвестная ошибка"
      }
    }
  })
})

// console.log(navigator.userAgent); - вывод браузера пользователя


function ajaxPost(url, parameters, callback) {
  // parameters = encodeURIComponent(parameters)
  if (parameters === false || parameters === null || parameters === undefined) {
    parameters = "";
  }
  var request = new XMLHttpRequest();
  request.open('POST', url, true);
  request.addEventListener('readystatechange', function () {
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