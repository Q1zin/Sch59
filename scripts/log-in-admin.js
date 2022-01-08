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
  // ajax

  if (false) {
    // редирект в админку
  } else {
    // Логин неверный
    // Пароль неверный
    doc.querySelector(".log-in__input-error").innerHTML = "Логин неверный"
  }
})

doc.querySelector(".log-in-rem__submit").addEventListener("click", function (event) {
  // ajax

  if (false) {
    doc.querySelector(".log-in-rem__input-success").innerHTML = "Инструкции отправлены на почту"
    doc.querySelector(".log-in-rem__input-error").innerHTML = ""
  } else {
    doc.querySelector(".log-in-rem__input-success").innerHTML = ""
    doc.querySelector(".log-in-rem__input-error").innerHTML = "Такого логина не существует"
  }
})