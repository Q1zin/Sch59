let doc = document

let listLink = doc.querySelectorAll(".sveden-oo__links-item--a")
let content = doc.querySelector(".sveden-oo__content")


for (let i = 0; i < listLink.length; i++) {
  listLink[i].onclick = function (event) {
    event.preventDefault()
    let item = event.target
    let href = item.href
    let title = href.split('/')[href.split('/').length - 1]

    setSelectContent(content, title, item, href)
  }
}

function dropListLinks(listLink) {
  for (let i = 0; i < listLink.length; i++) {
    listLink[i].classList.remove("sveden-oo__links-item--a--active")
  }
}

function dropContent(content) {
  for (let i = 0; i < content.childNodes.length; i++) {
    if (content.childNodes[i].nodeName == "#text") continue
    content.childNodes[i].classList.add("sveden-oo__content--close");
  }
}

function setSelectLink(link) {
  link.classList.add("sveden-oo__links-item--a--active")
}

function setSelectContent(content, title, item, href) {
  for (let i = 0; i < content.childNodes.length; i++) {
    if (content.childNodes[i].nodeName == "#text") continue
    if (content.childNodes[i].classList.contains(title)) {
      dropListLinks(listLink)
      dropContent(content)
      setSelectLink(item)
      content.childNodes[i].classList.remove("sveden-oo__content--close")
      history.pushState({}, null, href);
      if (getBodyScrollTop() - (doc.querySelector(".header").offsetHeight + 30) > 0) {
        scrollToElement(document.getElementById("sveden-oo__title"))
      }
      return;
    }
  }

  ajaxPost("/requests/get_content_about.php", `title=${title}`, function (answer) {
    answer = JSON.parse(answer)
    let wrap = doc.createElement("div")
    wrap.classList.add("sveden-oo__content-wrap")
    wrap.classList.add(`${title}`)
    wrap.innerHTML = `${answer['content']}`;
    dropListLinks(listLink)
    dropContent(content)
    setSelectLink(item)
    content.appendChild(wrap);
    history.pushState({}, null, href);
    if (getBodyScrollTop() - (doc.querySelector(".header").offsetHeight + 30) > 0) {
      scrollToElement(document.getElementById("sveden-oo__title"))
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

function scrollToElement(element) {
  element.scrollIntoView({
    behavior: 'smooth',
    block: 'start'
  })
}

function getBodyScrollTop() {
  return self.pageYOffset || (document.documentElement && document.documentElement.scrollTop) || (document.body && document.body.scrollTop);
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