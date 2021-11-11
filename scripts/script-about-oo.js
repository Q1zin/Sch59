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
    if (answer.includes("&^%@")) {
      answer = answer.split("&^%@")
      let wrap = doc.createElement("div")
      wrap.classList.add("sveden-oo__content-wrap")
      wrap.classList.add(`${title}`)
      wrap.innerHTML = `<h3 class="sveden-oo__content--title">${answer[0]}</h3>${answer[1]}`;
      dropListLinks(listLink)
      dropContent(content)
      setSelectLink(item)
      content.appendChild(wrap);
      history.pushState({}, null, href);
      if (getBodyScrollTop() - (doc.querySelector(".header").offsetHeight + 30) > 0) {
        scrollToElement(document.getElementById("sveden-oo__title"))
      }
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