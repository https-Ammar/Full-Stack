"use strict";
let header_ = `
    <header class="header" data-header>
        <div class="container">

            <a href="#" class="#"> \xa9
                Code by Ammar</a>

            <nav class="navbar" data-navbar>
                <ul class="navbar-list">

                    <li>
                        <a href="http://localhost:8888/ammar/" class="navbar-link" data-nav-link>Home</a>
                    </li>

                    <li>
                        <a href="http://localhost:8888/ammar/About.php" class="navbar-link" data-nav-link>About</a>
                    </li>

                    <li>
                        <a href="http://localhost:8888/ammar/Skills.php" class="navbar-link" data-nav-link>Skills</a>
                    </li>

                    <li>
                        <a href="http://localhost:8888/ammar/Project.php" class="navbar-link" data-nav-link>Project</a>
                    </li>

                    <li>
                        <a href="tel:+201065424756" class="navbar-link" data-nav-link>phone</a>
                    </li>

                    <li>
                        <a href="http://localhost:8888/ammar/Servis.php" class="navbar-link" data-nav-link>Services</a>
                    </li>

                    <li>
                        <a href="http://localhost:8888/ammar/Contact.php" class="navbar-link" data-nav-link>Contact</a>
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

`,
  head = document.getElementById("head");
head.innerHTML = header_;
const addEventOnElem = function (a, e, n) {
    if (a.length > 1)
      for (let l = 0; l < a.length; l++) a[l].addEventListener(e, n);
    else a.addEventListener(e, n);
  },
  navbar = document.querySelector("[data-navbar]"),
  navLinks = document.querySelectorAll("[data-nav-link]"),
  navToggler = document.querySelector("[data-nav-toggler]"),
  toggleNavbar = function () {
    navbar.classList.toggle("active"), navToggler.classList.toggle("active");
  };
addEventOnElem(navToggler, "click", toggleNavbar);
const closeNavbar = function () {
  window.innerWidth < 992 &&
    (navbar.classList.remove("active"), navToggler.classList.remove("active"));
};
addEventOnElem(navLinks, "click", closeNavbar);
const header = document.querySelector("[data-header]");
function checkScreenWidth() {
  window.innerWidth >= 992
    ? (navbar.classList.add("active"), navToggler.classList.add("active"))
    : (navbar.classList.remove("active"),
      navToggler.classList.remove("active"));
}
window.addEventListener("scroll", function () {
  window.scrollY > 100
    ? header.classList.add("active")
    : header.classList.remove("active");
}),
  window.addEventListener("load", checkScreenWidth),
  window.addEventListener("resize", checkScreenWidth);
