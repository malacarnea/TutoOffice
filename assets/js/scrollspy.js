const ratio = .6
let observer = null

const callback = function (entries) {
    entries.forEach(function (entry) {
        if (entry.isIntersecting) {
            activate(entry.target)
        }
    })
}
const activate = function (elem) {
    const id = elem.getAttribute('id')
    if (id !== "video") {
        const anchor = document.querySelector(`a[href="/#${id}"]`)
        if (anchor === null) {
            return null
        }
        anchor.parentElement.parentElement
                .querySelectorAll('.active')
                .forEach(node => node.classList.remove('active'))
        anchor.classList.add('active')
    }
    displayHeader(id)
}

const displayHeader = function (id) {
    let header = document.querySelector("header")
    if (id === "accueil") {
        if (!header.classList.contains("transparent-header")) {
            header.classList.add("transparent-header")
        }
    } else {
        header.classList.remove("transparent-header")
    }
}

const debounce = function (callback, delay) {
    let timer;
    return function () {
        let args = arguments;
        let context = this;
        clearTimeout(timer);
        timer = setTimeout(function () {
            callback.apply(context, args);
        }, delay)
    }
}

const observe = function (elems) {
    if (observer !== null) {
        elems.forEach(elem => observer.unobserve(elem))
    }
    const y = Math.round(window.innerHeight * ratio)
    observer = new IntersectionObserver(callback, {
        rootMargin: `-${window.innerHeight - y - 1}px 0px -${y}px 0px`
    })
    spies.forEach(elem => observer.observe(elem))
}

const spies = document.querySelectorAll('[data-spy]')


if (spies.length > 0) {
    observe(spies)
    let windowH = window.innerHeight
    window.addEventListener('resize', debounce(function () {
        if (window.innerHeight !== windowH) {
            observe(spies)
            windowH = window.innerHeight
        }
    }, 500))
}

