let doc = document

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