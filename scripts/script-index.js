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

  doc.cookie = updatedCookie;
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
  let div = doc.createElement('div');
  div.style.overflowY = 'scroll';
  div.style.width = '50px';
  div.style.height = '50px';
  doc.body.append(div);
  let scrollWidth = div.offsetWidth - div.clientWidth;
  div.remove();
  return scrollWidth
}


// -------------------------------
// Новости (показ новостей)
// -------------------------------


if (doc.querySelector(".news-show__close")) {
  doc.querySelector(".news-show__close").addEventListener("click", function (event) {
    event.preventDefault()
    doc.querySelector(".news-show").style.display = "none"
    doc.querySelector(".body").classList.remove("stop-scroll")
    let href = "/"
    history.pushState({}, null, href);
  })
}

doc.querySelector(".news-wrap").addEventListener("click", function (event) {
  if (event.target.closest("div.news__item") == null) return

  // console.log(event.target.closest("div.news__item").dataset.id)

  // ajax запрос на получение новости

  ajaxPost("/requests/show_news.php", `id=${event.target.closest("div.news__item").dataset.id}`, function (answer) {
    answer = JSON.parse(answer)
    doc.querySelector(".news-show-wrap").innerHTML = answer['content']
  })

  // alert("Новость " + event.target.closest("div.news__item").dataset.id)

  doc.querySelector(".news-show").style.display = "flex"
  doc.querySelector(".body").classList.add("stop-scroll")

  let href = `?art=${event.target.closest("div.news__item").dataset.id}`
  history.pushState({}, null, href);

  doc.querySelector(".news-show__close").addEventListener("click", function (event) {
    event.preventDefault()
    doc.querySelector(".news-show").style.display = "none"
    doc.querySelector(".body").classList.remove("stop-scroll")
    let href = "/"
    history.pushState({}, null, href);
  })
})

// -------------------------------
// Новости (меню новостей)
// -------------------------------
doc.querySelector(".news__menu").addEventListener("click", function (event) {
  event.preventDefault()
  if (!event.target.classList.contains("news__menu-item") || event.target.classList.contains("news__menu-item--active")) return
  doc.querySelector(".news__btn-more").style.display = "none"
  closeAllMenu()
  event.target.classList.add("news__menu-item--active")
  if (doc.getElementById(`news__${event.target.dataset.title}`)) {
    closeAllNews()
    doc.getElementById(`news__${event.target.dataset.title}`).classList.add("news--active")
    if (doc.getElementById(`news__${event.target.dataset.title}`).dataset.count <= 12) {
      doc.querySelector(".news__btn-more").style.display = "none"
    } else {
      doc.querySelector(".news__btn-more").style.display = "block"
    }
  } else {
    closeAllNews()
    let item = doc.createElement("div")
    item.classList.add("news-wrap", "news--active")
    item.id = `news__${event.target.dataset.title}`

    ajaxPost("/requests/get_block_news.php", `tag=${event.target.innerHTML}`, function (answer) {
      answer = JSON.parse(answer)
      item.innerHTML = answer['content']
      let countNews = answer['count']

      if (countNews <= 12) {
        doc.querySelector(".news__btn-more").style.display = "none"
      } else {
        doc.querySelector(".news__btn-more").style.display = "block"
      }
      item.dataset.count = countNews
      doc.querySelector(".news-container").appendChild(item)
      item.addEventListener("click", function (event) {
        if (event.target.closest("div.news__item") == null) return

        ajaxPost("/requests/show_news.php", `id=${event.target.closest("div.news__item").dataset.id}`, function (answer) {
          answer = JSON.parse(answer)
          doc.querySelector(".news-show-wrap").innerHTML = answer['content']
        })

        doc.querySelector(".news-show").style.display = "flex"
        doc.querySelector(".news-show-wrap").innerHTML = "Новость, id = " + event.target.closest("div.news__item").dataset.id
        doc.querySelector(".body").classList.add("stop-scroll")

        let href = `?art=${event.target.closest("div.news__item").dataset.id}`
        history.pushState({}, null, href);

        doc.querySelector(".news-show__close").addEventListener("click", function (event) {
          event.preventDefault()
          doc.querySelector(".news-show").style.display = "none"
          doc.querySelector(".body").classList.remove("stop-scroll")
          let href = "/"
          history.pushState({}, null, href);
        })
      })
    })
  }
})

doc.querySelector(".news__btn-more").addEventListener("click", function () {
  console.log(doc.querySelector(".news--active").childNodes.length)
  console.log(doc.querySelector(".news--active").childNodes.length - 2)
  ajaxPost("/requests/get_item_news.php", `tag=${doc.querySelector(".news__menu-item--active").innerHTML}&start=${doc.querySelector(".news--active").childNodes.length}`, function (answer) {
    answer = JSON.parse(answer)
    doc.querySelector(".news--active").innerHTML += answer['content'];
  })

  doc.querySelector(".news--active").dataset.count = doc.querySelector(".news--active").dataset.count - 12
  if (0 >= doc.querySelector(".news--active").dataset.count - 12) {
    doc.querySelector(".news__btn-more").style.display = "none"
  } else {
    doc.querySelector(".news__btn-more").style.display = "block"
  }
})


function closeAllMenu() {
  for (let i = 0; i < doc.querySelector(".news__menu").children.length; i++) {
    doc.querySelector(".news__menu").children[i].classList.remove("news__menu-item--active")
  }
}

function closeAllNews() {
  for (let i = 0; i < doc.querySelectorAll(".news-wrap").length; i++) {
    doc.querySelectorAll(".news-wrap")[i].classList.remove("news--active")
  }
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