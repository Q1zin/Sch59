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
doc.querySelector(".news-wrap").addEventListener("click", function (event) {
  if (event.target.closest("div.news__item") == null) return

  // console.log(event.target.closest("div.news__item").dataset.id)

  // ajax запрос на получение новости

  // alert("Новость " + event.target.closest("div.news__item").dataset.id)

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

// -------------------------------
// Новости (меню новостей)
// -------------------------------
doc.querySelector(".news__menu").addEventListener("click", function (event) {
  event.preventDefault()
  if (!event.target.classList.contains("news__menu-item") || event.target.classList.contains("news__menu-item--active")) return

  // ajax запрос на получение новостей

  closeAllMenu()
  event.target.classList.add("news__menu-item--active")

  if (doc.getElementById(`news__${event.target.dataset.title}`)) {
    closeAllNews()
    doc.getElementById(`news__${event.target.dataset.title}`).classList.add("news--active")
    if (doc.getElementById(`news__${event.target.dataset.title}`).dataset.count <= 8) {
      doc.querySelector(".news__btn-more").style.display = "none"
    } else {
      doc.querySelector(".news__btn-more").style.display = "block"
    }
  } else {
    closeAllNews()
    let item = doc.createElement("div")
    item.classList.add("news-wrap", "news--active")
    item.id = `news__${event.target.dataset.title}`

    // ajax запрос, получение карточек и кол-во карточек
    item.innerHTML = `<div class="news__item" data-id="1">
    <div class="news__item-top">
      <img src="/img/service/news-1-123.jpg" alt="img: news img" class="news__item-img">
    </div>
    <div class="news__item-bottom">
      <h4 class="news__item-title">День учителя</h4>
      <p class="news__item-text">Поздравление учителей нашей школы за многолетний творческий труд!</p>
    </div>
    <div class="news__item-more">
      <span class="news__item-more-item">28.10.21</span>
      <span class="news__item-more-item">#поздравления</span>
    </div>
  </div>`
    let countNews = 1

    if (countNews <= 8) {
      doc.querySelector(".news__btn-more").style.display = "none"
    } else {
      doc.querySelector(".news__btn-more").style.display = "block"
    }
    item.dataset.count = countNews
    doc.querySelector(".news-container").appendChild(item)
    item.addEventListener("click", function (event) {
      if (event.target.closest("div.news__item") == null) return

      // console.log(event.target.closest("div.news__item").dataset.id)

      // ajax запрос на получение новости

      // alert("Новость " + event.target.closest("div.news__item").dataset.id)

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
  }

})


doc.querySelector(".news__btn-more").addEventListener("click", function () {
  if (8 >= doc.querySelector(".news--active").dataset.count - 8) {
    doc.querySelector(".news__btn-more").style.display = "none"
  } else {
    doc.querySelector(".news__btn-more").style.display = "block"
  }
  doc.querySelector(".news--active").dataset.count = doc.querySelector(".news--active").dataset.count - 8

  // ajax запрос сортировка от 9 до ... по doc.querySelector(".news--active").id

  doc.querySelector(".news--active").innerHTML += `<div class="news__item" data-id="9">
  <div class="news__item-top">
    <img src="/img/service/news-1-123.jpg" alt="img: news img" class="news__item-img">
  </div>
  <div class="news__item-bottom">
    <h4 class="news__item-title">День учителя</h4>
    <p class="news__item-text">Поздравление учителей нашей школы за многолетний творческий труд!</p>
  </div>
  <div class="news__item-more">
    <span class="news__item-more-item">28.10.21</span>
    <span class="news__item-more-item">#поздравления</span>
  </div>
</div>`
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