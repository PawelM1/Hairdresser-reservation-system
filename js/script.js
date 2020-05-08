//scroll to element section
function smoothScroll(element) {
    document.querySelector(element).scrollIntoView({
        behaviour: 'smooth'
    })
}

window.onscroll = function () {
    scroll()
}
function scroll() {
    if (document.body.scrollTop > 30 || document.documentElement.scrollTop > 30) {
        document.getElementById('up-button').style.display = "block";
    } else {
        document.getElementById('up-button').style.display = "none";
    }
}
