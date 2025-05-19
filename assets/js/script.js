let header_ = `
    <header class="header" data-header>
        <div class="container">

            <a href="#" class="#"> ©
                Code by Ammar</a>

            <nav class="navbar" data-navbar>
                <ul class="navbar-list">

                    <li>
                        <a href="/index.php" class="navbar-link" data-nav-link>Home</a>
                    </li>

                    <li>
                        <a href="./assets/page/About.php" class="navbar-link" data-nav-link>About</a>
                    </li>

                    <li>
                        <a href="./assets/page/Skills.php" class="navbar-link" data-nav-link>Skills</a>
                    </li>

                    <li>
                        <a href="./assets/page/Project.php" class="navbar-link" data-nav-link>Project</a>
                    </li>

                    <li>
                        <a href="tel:+201065424756" class="navbar-link" data-nav-link>phone</a>
                    </li>

                    <li>
                        <a href="./assets/page/Servis.php" class="navbar-link" data-nav-link>Services</a>
                    </li>

                    <li>
                        <a href="./assets/page/Contact.php" class="navbar-link" data-nav-link>Contact</a>
                    </li>

                </ul>
            </nav>

            <button class="nav-toggle-btn" aria-label="toggle menu" data-nav-toggler>
                <span class="line line-1"></span>
                <span class="line line-2"></span>
                <span class="line line-3"></span>
            </button>

        </div>
    </header>

`;

let head = document.getElementById("head");
head.innerHTML = header_;

("use strict");

const addEventOnElem = function (elem, type, callback) {
  if (elem.length > 1) {
    for (let i = 0; i < elem.length; i++) {
      elem[i].addEventListener(type, callback);
    }
  } else {
    elem.addEventListener(type, callback);
  }
};

const navbar = document.querySelector("[data-navbar]");
const navLinks = document.querySelectorAll("[data-nav-link]");
const navToggler = document.querySelector("[data-nav-toggler]");

const toggleNavbar = function () {
  navbar.classList.toggle("active");
  navToggler.classList.toggle("active");
};

addEventOnElem(navToggler, "click", toggleNavbar);

const closeNavbar = function () {
  // لا تغلق المنيو في الشاشات الواسعة (992px فأكثر)
  if (window.innerWidth < 992) {
    navbar.classList.remove("active");
    navToggler.classList.remove("active");
  }
};

addEventOnElem(navLinks, "click", closeNavbar);

const header = document.querySelector("[data-header]");

window.addEventListener("scroll", function () {
  if (window.scrollY > 100) {
    header.classList.add("active");
  } else {
    header.classList.remove("active");
  }
});

function checkScreenWidth() {
  if (window.innerWidth >= 992) {
    navbar.classList.add("active");
    navToggler.classList.add("active");
  } else {
    navbar.classList.remove("active");
    navToggler.classList.remove("active");
  }
}

window.addEventListener("load", checkScreenWidth);
window.addEventListener("resize", checkScreenWidth);
