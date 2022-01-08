let doc = document

let wrapMessage = doc.createElement('div');
wrapMessage.classList.add("show-message__wrap")

doc.querySelector("body").appendChild(wrapMessage)

wrapMessage = doc.querySelector(".show-message__wrap")

function showMessage(type, text) {
  if (type == 'error') {
    let modal = doc.createElement('div');
    modal.classList.add("show-message", "show-message__error")
    modal.innerHTML = `<h3 class="show-message__title"><img src="/img/service/info-error.svg" alt="icon: !" class="show-message__icon">Произошла ошибка</h3>
    <p class="show-message__text">${text}</p>
    <a href="#" class="show-message__close" onclick="this.parentNode.style.display = 'none'"><img class="show-message__close--img" src="/img/service/close-modal-white.svg" alt="icon: close"></a>`
    wrapMessage.appendChild(modal)
    let isMouseHover = true;
    wrapMessage.addEventListener("mouseout", function () {
      isMouseHover = true;
    })
    wrapMessage.addEventListener("mouseover", function () {
      isMouseHover = false;
    })

    function closeModal(modal) {
      setTimeout(function () {
        if (isMouseHover) {
          modal.remove()
          isMouseHover = false
        } else {
          closeModal(modal)
        }
      }, 5000)
    }
    setTimeout(function () {
      closeModal(modal)
    }, 100)
  } else {
    let modal = doc.createElement('div');
    modal.classList.add("show-message", "show-message__success")
    modal.innerHTML = `<h3 class="show-message__title"><img src="/img/service/info-success.svg" alt="icon: !" class="show-message__icon">Запрос прошёл успешно</h3>
    <p class="show-message__text">${text}</p>
    <a href="#" class="show-message__close" onclick="this.parentNode.style.display = 'none'"><img class="show-message__close--img" src="/img/service/close-modal-white.svg" alt="icon: close"></a>`
    wrapMessage.appendChild(modal)
    let isMouseHover = true;
    wrapMessage.addEventListener("mouseout", function () {
      isMouseHover = true;
    })
    wrapMessage.addEventListener("mouseover", function () {
      isMouseHover = false;
    })

    function closeModal(modal) {
      setTimeout(function () {
        if (isMouseHover) {
          modal.remove()
          isMouseHover = false
        } else {
          closeModal(modal)
        }
      }, 5000)
    }
    setTimeout(function () {
      closeModal(modal)
    }, 100)
  }
}

// -------------------------------
// Обработка cookie
// -------------------------------

if (doc.getElementById("accept-cookie") != null) {
  doc.querySelector(".accept-cookie__close").addEventListener("click", function (event) {
    event.preventDefault()
    doc.querySelector(".accept-cookie").remove()
  })
  doc.querySelector(".accept-cookie__btn").addEventListener("click", function (event) {
    doc.querySelector(".accept-cookie").remove()
    setCookie('accept-cookie', 'true');
  })
}

function setCookie(name, value, options = {}) {

  options = {
    path: '/'
  };

  if (options.expires instanceof Date) {
    options.expires = options.expires.toUTCString();
  }

  let updatedCookie = encodeURIComponent(name) + "=" + encodeURIComponent(value);

  for (let optionKey in options) {
    updatedCookie += "; " + optionKey;
    let optionValue = options[optionKey];
    if (optionValue !== true) {
      updatedCookie += "=" + optionValue;
    }
  }

  document.cookie = updatedCookie;
}

// -------------------------------
// Обработка menu
// -------------------------------

doc.querySelector(".header__menu-btn").addEventListener("click", function (event) {
  event.preventDefault()
  doc.querySelector(".header__menu").classList.add("header__menu--active")
  doc.querySelector(".header__menu-bg").classList.add("header__menu-bg--active")
  doc.querySelector("body").style.paddingRight = scrollWidthGet() + "px"
  doc.querySelector("body").classList.add("stop-scroll")
})

doc.querySelector(".menu__hide").addEventListener("click", function (event) {
  event.preventDefault()
  doc.querySelector(".header__menu").classList.remove("header__menu--active")
  doc.querySelector(".header__menu-bg").classList.remove("header__menu-bg--active")
  doc.querySelector("body").style.paddingRight = 0
  doc.querySelector("body").classList.remove("stop-scroll")
})

doc.querySelector(".header__menu-bg").addEventListener("click", function (event) {
  event.preventDefault()
  doc.querySelector(".header__menu").classList.remove("header__menu--active")
  doc.querySelector(".header__menu-bg").classList.remove("header__menu-bg--active")
  doc.querySelector("body").style.paddingRight = 0
  doc.querySelector("body").classList.remove("stop-scroll")
})

function scrollWidthGet() {
  let div = document.createElement('div');
  div.style.overflowY = 'scroll';
  div.style.width = '50px';
  div.style.height = '50px';
  document.body.append(div);
  let scrollWidth = div.offsetWidth - div.clientWidth;
  div.remove();
  return scrollWidth
}