let doc = document

doc.querySelector(".log-in__input-password-eye-1").addEventListener("click", function (event) {
  event.preventDefault()
  if (event.target.classList.contains("log-in__input-password-eye--active")) {
    event.target.classList.remove("log-in__input-password-eye--active")
    event.target.setAttribute("src", "../img/service/eye-close-admin.png")
    doc.querySelector(".log-in__input-password-1").setAttribute("type", "password")
  } else {
    event.target.classList.add("log-in__input-password-eye--active")
    event.target.setAttribute("src", "../img/service/eye-open-admin.png")
    doc.querySelector(".log-in__input-password-1").setAttribute("type", "text")
  }
})

doc.querySelector(".log-in__input-password-eye-2").addEventListener("click", function (event) {
  event.preventDefault()
  if (event.target.classList.contains("log-in__input-password-eye--active")) {
    event.target.classList.remove("log-in__input-password-eye--active")
    event.target.setAttribute("src", "../img/service/eye-close-admin.png")
    doc.querySelector(".log-in__input-password-2").setAttribute("type", "password")
  } else {
    event.target.classList.add("log-in__input-password-eye--active")
    event.target.setAttribute("src", "../img/service/eye-open-admin.png")
    doc.querySelector(".log-in__input-password-2").setAttribute("type", "text")
  }
})

doc.querySelector(".log-in-rem__submit").addEventListener("click", function () {
  if (doc.querySelector(".log-in__input-password-1").value == doc.querySelector(".log-in__input-password-2").value) {
    doc.querySelector(".log-in__input-error").innerHTML = ""
    var params = window
      .location
      .search
      .replace('?', '')
      .split('&')
      .reduce(
        function (p, e) {
          var a = e.split('=');
          p[decodeURIComponent(a[0])] = decodeURIComponent(a[1]);
          return p;
        }, {}
      );
    let recovery = params["hash"]
    ajaxPost("/requests/reset-password.php", `password=${doc.querySelector(".log-in__input-password-1").value}&recovery=${recovery}`, function (answer) {
      answer = JSON.parse(answer)
      if (answer['error']) {
        doc.querySelector(".log-in__input-error").innerHTML = "Произошла ошибка"
      } else {
        doc.querySelector(".log-in__input-error").innerHTML = ""
        window.location.href = "https://sch59.su/admin/log-in.php"
      }
    })
  } else {
    doc.querySelector(".log-in__input-error").innerHTML = "Пароли не совпадают"
  }
})

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