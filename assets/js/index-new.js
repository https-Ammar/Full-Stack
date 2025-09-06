gsap.registerPlugin(ScrollTrigger);
let scroll;
const body = document.body,
      select = e => document.querySelector(e),
      selectAll = e => document.querySelectorAll(e);

function initLoaderHome() {
  var e = gsap.timeline();
  e.set(".loading-screen", {top: "0"}), 
  $(window).width() > 540 ? e.set("main .once-in", {y: "50vh"}) : e.set("main .once-in", {y: "10vh"}),
  e.set(".loading-words", {opacity: 0, y: -50}),
  e.set(".loading-words .active", {display: "none"}),
  e.set(".loading-words .home-active, .loading-words .home-active-last", {display: "block", opacity: 0}),
  e.set(".loading-words .home-active-first", {opacity: 1}),
  $(window).width() > 540 ? e.set(".loading-screen .rounded-div-wrap.bottom", {height: "10vh"}) : e.set(".loading-screen .rounded-div-wrap.bottom", {height: "5vh"}),
  e.set("html", {cursor: "wait"}),
  e.call(() => scroll.stop()),
  e.to(".loading-words", {duration: .8, opacity: 1, y: -50, ease: "Power4.easeOut", delay: .5}),
  e.to(".loading-words .home-active", {duration: .01, opacity: 1, stagger: .15, ease: "none", onStart: () => gsap.to(".loading-words .home-active", {duration: .01, opacity: 0, stagger: .15, ease: "none", delay: .15})}, "=-.4"),
  e.to(".loading-words .home-active-last", {duration: .01, opacity: 1, delay: .15}),
  e.to(".loading-screen", {duration: .8, top: "-100%", ease: "Power4.easeInOut", delay: .2}),
  e.to(".loading-screen .rounded-div-wrap.bottom", {duration: 1, height: "0vh", ease: "Power4.easeInOut"}, "=-.8"),
  e.to(".loading-words", {duration: .3, opacity: 0, ease: "linear"}, "=-.8"),
  e.set(".loading-screen", {top: "calc(-100%)"}),
  e.set(".loading-screen .rounded-div-wrap.bottom", {height: "0vh"}),
  e.to("main .once-in", {duration: 1.5, y: "0vh", stagger: .07, ease: "Expo.easeOut", clearProps: !0}, "=-.8"),
  e.set("html", {cursor: "auto"}, "=-1.2"),
  e.call(() => scroll.start());
}

function initLoader() {
  var e = gsap.timeline();
  e.set(".loading-screen", {top: "0"}),
  $(window).width() > 540 ? e.set("main .once-in", {y: "50vh"}) : e.set("main .once-in", {y: "10vh"}),
  e.set(".loading-words", {opacity: 1, y: -50}),
  $(window).width() > 540 ? e.set(".loading-screen .rounded-div-wrap.bottom", {height: "10vh"}) : e.set(".loading-screen .rounded-div-wrap.bottom", {height: "5vh"}),
  e.set("html", {cursor: "wait"}),
  e.to(".loading-screen", {duration: .8, top: "-100%", ease: "Power4.easeInOut", delay: .5}),
  e.to(".loading-screen .rounded-div-wrap.bottom", {duration: 1, height: "0vh", ease: "Power4.easeInOut"}, "=-.8"),
  e.to(".loading-words", {duration: .3, opacity: 0, ease: "linear"}, "=-.8"),
  e.set(".loading-screen", {top: "calc(-100%)"}),
  e.set(".loading-screen .rounded-div-wrap.bottom", {height: "0vh"}),
  e.to("main .once-in", {duration: 1, y: "0vh", stagger: .05, ease: "Expo.easeOut", clearProps: "true"}, "=-.8"),
  e.set("html", {cursor: "auto"}, "=-.8");
}

function pageTransitionIn() {
  var e = gsap.timeline();
  e.call(() => scroll.stop()),
  e.set(".loading-screen", {top: "100%"}),
  e.set(".loading-words", {opacity: 0, y: 0}),
  e.set("html", {cursor: "wait"}),
  $(window).width() > 540 ? e.set(".loading-screen .rounded-div-wrap.bottom", {height: "10vh"}) : e.set(".loading-screen .rounded-div-wrap.bottom", {height: "5vh"}),
  e.to(".loading-screen", {duration: .5, top: "0%", ease: "Power4.easeIn"}),
  e.to(".loading-screen .rounded-div-wrap.top", {duration: .4, height: "10vh", ease: "Power4.easeIn"}, "=-.5"),
  e.to(".loading-words", {duration: .8, opacity: 1, y: -50, ease: "Power4.easeOut", delay: .05}),
  e.set(".loading-screen .rounded-div-wrap.top", {height: "0vh"}),
  e.to(".loading-screen", {duration: .8, top: "-100%", ease: "Power3.easeInOut"}, "=-.2"),
  e.to(".loading-words", {duration: .6, opacity: 0, ease: "linear"}, "=-.8"),
  e.to(".loading-screen .rounded-div-wrap.bottom", {duration: .85, height: "0", ease: "Power3.easeInOut"}, "=-.6"),
  e.set("html", {cursor: "auto"}, "=-0.6"),
  $(window).width() > 540 ? e.set(".loading-screen .rounded-div-wrap.bottom", {height: "10vh"}) : e.set(".loading-screen .rounded-div-wrap.bottom", {height: "5vh"}),
  e.set(".loading-screen", {top: "100%"}),
  e.set(".loading-words", {opacity: 0});
}

function pageTransitionOut() {
  var e = gsap.timeline();
  $(window).width() > 540 ? e.set("main .once-in", {y: "50vh"}) : e.set("main .once-in", {y: "20vh"}),
  e.call(() => scroll.start()),
  e.to("main .once-in", {duration: 1, y: "0vh", stagger: .05, ease: "Expo.easeOut", delay: .8, clearProps: "true"});
}

function initPageTransitions() {
  function e(e) {
    scroll = new LocomotiveScroll({el: e.querySelector("[data-scroll-container]"), smooth: !0}),
    window.onresize = scroll.update(),
    scroll.on("scroll", () => ScrollTrigger.update()),
    ScrollTrigger.scrollerProxy("[data-scroll-container]", {
      scrollTop(e) {return arguments.length ? scroll.scrollTo(e, 0, 0) : scroll.scroll.instance.scroll.y},
      getBoundingClientRect: () => ({top: 0, left: 0, width: window.innerWidth, height: window.innerHeight}),
      pinType: e.querySelector("[data-scroll-container]").style.transform ? "transform" : "fixed"
    }),
    ScrollTrigger.defaults({scroller: document.querySelector("[data-scroll-container]")});
    let t = selectAll(".c-scrollbar");
    t.length > 1 && t[0].remove(),
    ScrollTrigger.addEventListener("refresh", () => scroll.update()),
    ScrollTrigger.refresh();
  }

  barba.hooks.before(() => select("html").classList.add("is-transitioning")),
  barba.hooks.after(() => {
    select("html").classList.remove("is-transitioning"),
    scroll.init(),
    scroll.stop();
  }),
  barba.hooks.enter(() => scroll.destroy()),
  barba.hooks.afterEnter(() => {
    window.scrollTo(0, 0),
    initCookieViews();
  }),
  $(window).width() > 540 && barba.hooks.leave(() => {
    $(".btn-hamburger, .btn-menu").removeClass("active"),
    $("main").removeClass("nav-active");
  }),
  barba.init({
    sync: !0,
    debug: !1,
    timeout: 7e3,
    transitions: [{
      name: "default",
      once(t) {
        e(t.next.container),
        initScript(),
        initCookieViews(),
        initLoader();
      },
      async leave(e) {
        pageTransitionIn(e.current),
        await delay(495),
        e.current.container.remove();
      },
      async enter(e) {
        pageTransitionOut(e.next),
        initNextWord(e);
      },
      async beforeEnter(t) {
        ScrollTrigger.getAll().forEach(e => e.kill()),
        scroll.destroy(),
        e(t.next.container),
        initScript();
      }
    }, {
      name: "to-home",
      from: {},
      to: {namespace: ["home"]},
      once(t) {
        e(t.next.container),
        initScript(),
        initCookieViews(),
        initLoaderHome();
      }
    }]
  });
}

function initNextWord(e) {
  let t = new DOMParser().parseFromString(e.next.html, "text/html").querySelector(".loading-words");
  document.querySelector(".loading-words").innerHTML = t.innerHTML;
}

function delay(e) {
  return e = e || 2e3, new Promise(t => setTimeout(() => t(), e));
}

function initScript() {
  select("body").classList.remove("is-loading"),
  initWindowInnerheight(),
  initCheckTouchDevice(),
  initHamburgerNav(),
  initMagneticButtons(),
  initStickyCursorWithDelay(),
  initVisualFilter(),
  initScrolltriggerNav(),
  initScrollLetters(),
  initTricksWords(),
  initContactForm(),
  initTimeZone(),
  initLazyLoad(),
  initPlayVideoInview(),
  initScrolltriggerAnimations();
}

function initWindowInnerheight() {
  $(document).ready(() => {
    let e = .01 * window.innerHeight;
    document.documentElement.style.setProperty("--vh", `${e}px`),
    $(".btn-hamburger").click(() => {
      let e = .01 * window.innerHeight;
      document.documentElement.style.setProperty("--vh", `${e}px`);
    });
  });
}

function initCheckTouchDevice() {
  function e() {return "ontouchstart" in window || navigator.maxTouchPoints;}
  e() ? ($("main").addClass("touch"), $("main").removeClass("no-touch")) : ($("main").removeClass("touch"), $("main").addClass("no-touch")),
  $(window).resize(() => e() ? ($("main").addClass("touch"), $("main").removeClass("no-touch")) : ($("main").removeClass("touch"), $("main").addClass("no-touch")));
}

function initHamburgerNav() {
  $(document).ready(() => {
    $(".btn-hamburger, .btn-menu").click(() => {
      $(".btn-hamburger, .btn-menu").hasClass("active") ? 
        ($(".btn-hamburger, .btn-menu").removeClass("active"), 
         $("main").removeClass("nav-active"), 
         scroll.start()) : 
        ($(".btn-hamburger, .btn-menu").addClass("active"), 
         $("main").addClass("nav-active"), 
         scroll.stop());
    }),
    $(".fixed-nav-back").click(() => {
      $(".btn-hamburger, .btn-menu").removeClass("active"),
      $("main").removeClass("nav-active"),
      scroll.start();
    });
  }),
  $(document).keydown(e => 27 == e.keyCode && $("main").hasClass("nav-active") && 
    ($(".btn-hamburger, .btn-menu").removeClass("active"), 
     $("main").removeClass("nav-active"), 
     scroll.start()));
}

function initMagneticButtons() {
  var e = document.querySelectorAll(".magnetic");
  if (window.innerWidth > 540) {
    e.forEach(e => {
      e.addEventListener("mousemove", t),
      $(this.parentNode).removeClass("not-active"),
      e.addEventListener("mouseleave", function(e) {
        gsap.to(e.currentTarget, 1.5, {x: 0, y: 0, ease: Elastic.easeOut}),
        gsap.to($(this).find(".btn-text"), 1.5, {x: 0, y: 0, ease: Elastic.easeOut});
      });
    });
    function t(e) {
      var t = e.currentTarget,
          o = t.getBoundingClientRect(),
          i = t.getAttribute("data-strength"),
          n = t.getAttribute("data-strength-text");
      gsap.to(t, 1.5, {x: ((e.clientX - o.left) / t.offsetWidth - .5) * i, y: ((e.clientY - o.top) / t.offsetHeight - .5) * i, rotate: "0.001deg", ease: Power4.easeOut}),
      gsap.to($(this).find(".btn-text"), 1.5, {x: ((e.clientX - o.left) / t.offsetWidth - .5) * n, y: ((e.clientY - o.top) / t.offsetHeight - .5) * n, rotate: "0.001deg", ease: Power4.easeOut});
    }
  }
  $(".btn-click.magnetic").on("mouseenter", function() {
    $(this).find(".btn-fill").length && gsap.to($(this).find(".btn-fill"), .6, {startAt: {y: "76%"}, y: "0%", ease: Power2.easeInOut}),
    $(this).find(".btn-text-inner.change").length && gsap.to($(this).find(".btn-text-inner.change"), .3, {startAt: {color: "#1C1D20"}, color: "#FFFFFF", ease: Power3.easeIn}),
    $(this.parentNode).removeClass("not-active");
  }),
  $(".btn-click.magnetic").on("mouseleave", function() {
    $(this).find(".btn-fill").length && gsap.to($(this).find(".btn-fill"), .6, {y: "-76%", ease: Power2.easeInOut}),
    $(this).find(".btn-text-inner.change").length && gsap.to($(this).find(".btn-text-inner.change"), .3, {color: "#1C1D20", ease: Power3.easeOut, delay: .3}),
    $(this.parentNode).removeClass("not-active");
  });
}

function initStickyCursorWithDelay() {
  var e = $(".mouse-pos-list-image"),
      t = $(".mouse-pos-list-btn"),
      o = $(".mouse-pos-list-span"),
      i = 0, n = 0, s = 0, a = 0, r = 0, l = 0, c = 0, d = 0;
  document.querySelector(".mouse-pos-list-image, .mouse-pos-list-btn, .mouse-post-list-span") && 
    gsap.to({}, .0083333333, {
      repeat: -1,
      onRepeat: function() {
        document.querySelector(".mouse-pos-list-image") && 
          (i += (c - i) / 12, n += (d - n) / 12, gsap.set(e, {css: {left: i, top: n}})),
        document.querySelector(".mouse-pos-list-btn") && 
          (s += (c - s) / 7, a += (d - a) / 7, gsap.set(t, {css: {left: s, top: a}})),
        document.querySelector(".mouse-pos-list-span") && 
          (r += (c - r) / 6, l += (d - l) / 6, gsap.set(o, {css: {left: r, top: l}}));
      }
    }),
  $(document).on("mousemove", function(e) {c = e.clientX, d = e.clientY}),
  $(".mouse-pos-list-image-wrap a").on("mouseenter", () => $(".mouse-pos-list-image, .mouse-pos-list-btn, .mouse-pos-list-span, .mouse-pos-list-span-big").addClass("active")),
  $(".mouse-pos-list-image-wrap a").on("mouseleave", () => $(".mouse-pos-list-image, .mouse-pos-list-btn, .mouse-pos-list-span, .mouse-pos-list-span-big").removeClass("active")),
  $(".single-tile-wrap a, .mouse-pos-list-archive a, .next-case-btn").on("mouseenter", () => $(".mouse-pos-list-btn, .mouse-pos-list-span").addClass("active-big")),
  $(".single-tile-wrap a, .mouse-pos-list-archive a, .next-case-btn").on("mouseleave", () => $(".mouse-pos-list-btn, .mouse-pos-list-span").removeClass("active-big")),
  $("main").on("mousedown", () => $(".mouse-pos-list-btn, .mouse-pos-list-span").addClass("pressed")),
  $("main").on("mouseup", () => $(".mouse-pos-list-btn, .mouse-pos-list-span").removeClass("pressed")),
  $(".mouse-pos-list-image-wrap li.visible").on("mouseenter", function() {
    var e = $(".mouse-pos-list-image-wrap li.visible").index($(this)),
        t = $(".mouse-pos-list-image li.visible").length;
    $(".float-image-wrap") && gsap.to($(".float-image-wrap"), {y: 100 * e / (-1 * t) + "%", duration: .6, ease: Power2.easeInOut}),
    $(".mouse-pos-list-image.active .mouse-pos-list-image-bounce").addClass("active").delay(400).queue(function(e) {
      $(this).removeClass("active"), e();
    });
  }),
  $(".archive-work-grid li").on("mouseenter", () => $(".mouse-pos-list-btn").addClass("hover").delay(100).queue(function(e) {
    $(this).removeClass("hover"), e();
  }));
}

function initVisualFilter() {
  $(document).ready(() => {
    $(".toggle-row .btn").click(function() {
      $(this).hasClass("active") || 
        ($(".work-tiles li, .work-items li").addClass("tile-fade-out"),
         scroll.stop(),
         setTimeout(() => {
           $(".work-tiles li, .work-items li").removeClass("tile-fade-out"),
           $(".work-tiles li, .work-items li").addClass("tile-fade-in"),
           scroll.scrollTo("top", {offset: 0, duration: 700, easing: [.7, 0, .35, 1], disableLerp: !0});
         }, 300),
         setTimeout(() => {
           $(".work-tiles li, .work-items li").removeClass("tile-fade-in"),
           scroll.update(),
           ScrollTrigger.refresh(),
           scroll.start();
         }, 700),
         setTimeout(() => scroll.update(), 1e3));
    }),
    $(".all-btn").click(function() {
      $(this).hasClass("active") || 
        ($(".toggle-row .btn-normal").removeClass("active"),
         $(".toggle-row .btn-normal").addClass("not-active"),
         $(this).addClass("active"),
         $(this).removeClass("not-active"),
         setTimeout(() => $(".mouse-pos-list-image li, .mouse-pos-list-image-wrap li, .work-tiles li").addClass("visible"), 300));
    }),
    $(".design-btn").click(function() {
      $(this).hasClass("active") || 
        ($(".toggle-row .btn-normal").removeClass("active"),
         $(".toggle-row .btn-normal").addClass("not-active"),
         $(this).addClass("active"),
         $(this).removeClass("not-active"),
         setTimeout(() => {
           $(".mouse-pos-list-image li, .mouse-pos-list-image-wrap li, .work-tiles li").removeClass("visible"),
           $(".mouse-pos-list-image li.design, .mouse-pos-list-image-wrap li.design, .work-tiles li.design").addClass("visible");
         }, 300));
    }),
    $(".development-btn").click(function() {
      $(this).hasClass("active") || 
        ($(".toggle-row .btn-normal").removeClass("active"),
         $(".toggle-row .btn-normal").addClass("not-active"),
         $(this).addClass("active"),
         $(this).removeClass("not-active"),
         setTimeout(() => {
           $(".mouse-pos-list-image li, .mouse-pos-list-image-wrap li, .work-tiles li").removeClass("visible"),
           $(".mouse-pos-list-image li.development, .mouse-pos-list-image-wrap li.development, .work-tiles li.development").addClass("visible");
         }, 300));
    }),
    $(".grid-row .btn").click(function() {
      $(this).hasClass("active") || 
        ($(".grid-fade").addClass("grid-fade-out"),
         scroll.stop(),
         scroll.scrollTo("top", {offset: 0, duration: 700, easing: [.7, 0, .35, 1], disableLerp: !0}),
         setTimeout(() => $(".grid-fade").removeClass("grid-fade-out"), 300),
         setTimeout(() => $(".grid-fade").addClass("grid-fade-in"), 300),
         setTimeout(() => {
           $(".grid-fade").removeClass("grid-fade-in"),
           scroll.update(),
           ScrollTrigger.refresh(),
           scroll.start();
         }, 700));
    }),
    $(".grid-row .rows-btn").click(function() {
      $(this).hasClass("active") || 
        ($(".grid-row .btn-normal").removeClass("active"),
         $(".grid-row .btn-normal").addClass("not-active"),
         Cookies.set("view", "rows", {expires: 14}),
         $(this).addClass("active"),
         $(this).removeClass("not-active"),
         setTimeout(() => {
           $(".grid-columns-part").removeClass("visible"),
           $(".grid-rows-part").addClass("visible");
         }, 300));
    }),
    $(".grid-row .columns-btn").click(function() {
      $(this).hasClass("active") || 
        ($(".grid-row .btn-normal").removeClass("active"),
         $(".grid-row .btn-normal").addClass("not-active"),
         Cookies.set("view", "columns", {expires: 14}),
         $(this).addClass("active"),
         $(this).removeClass("not-active"),
         setTimeout(() => {
           $(".grid-rows-part").removeClass("visible"),
           $(".grid-columns-part").addClass("visible");
         }, 300));
    });
  });
}

function initCookieViews() {
  "columns" == Cookies.get("view") && 
    ($(".grid-row .rows-btn").removeClass("active"),
     $(".grid-row .columns-btn").addClass("active"),
     $("#work .grid-rows-part").removeClass("visible"),
     $("#work .grid-columns-part").addClass("visible"),
     scroll.update(),
     ScrollTrigger.refresh());
}

function initScrolltriggerNav() {
  ScrollTrigger.create({
    start: "top -30%",
    onUpdate(e) {$("main").addClass("scrolled")},
    onLeaveBack() {$("main").removeClass("scrolled")}
  });
}

function initScrollLetters() {
  let e = 1,
      t = i(".big-name .name-wrap", {duration: 18}),
      o = i(".rollingText02", {duration: 10}, !0);
  
  function i(e, t, o) {
    (t = t || {}).ease || (t.ease = "none");
    let i = gsap.timeline({
      repeat: -1,
      onReverseComplete() {this.totalTime(this.rawTime() + 10 * this.duration());}
    }),
    n = gsap.utils.toArray(e),
    s = n.map(e => {
      let t = e.cloneNode(!0);
      return e.parentNode.appendChild(t), t;
    }),
    a = () => n.forEach((e, t) => gsap.set(s[t], {
      position: "absolute",
      overwrite: !1,
      top: e.offsetTop,
      left: e.offsetLeft + (o ? -e.offsetWidth : e.offsetWidth)
    }));
    return a(),
    n.forEach((e, n) => i.to([e, s[n]], {xPercent: o ? 100 : -100, ...t}, 0)),
    window.addEventListener("resize", () => {
      let e = i.totalTime();
      i.totalTime(0), a(), i.totalTime(e);
    }),
    i;
  }
  
  ScrollTrigger.create({
    trigger: document.querySelector("[data-scroll-container]"),
    onUpdate(i) {
      i.direction !== e && (e *= -1, gsap.to([t, o], {timeScale: e, overwrite: !0}));
    }
  });
}

function initTricksWords() {
  for (var e = document.getElementsByClassName("span-lines"), t = 0; t < e.length; t++) {
    var o = e.item(t);
    o.innerHTML = o.innerHTML.replace(/(^|<\/?[^>]+>|\s+)([^\s<]+)/g, '$1<span class="span-line"><span class="span-line-inner">$2</span></span>');
  }
}

function initContactForm() {
  $(".field").on("input", function() {
    $(this).parent().toggleClass("not-empty", this.value.trim().length > 0);
  }),
  $(function() {
    $(".field").focusout(function() {
      var e = $(this).val();
      $(this).parent().toggleClass("not-empty", "" !== e);
    }).focusout();
  });
}

function initTimeZone() {
  if (document.querySelector("#timeSpan")) {
    let e = document.querySelector("#timeSpan"),
        t = new Intl.DateTimeFormat([], {
          timeZone: "Africa/Cairo",
          timeZoneName: "short",
          hour: "2-digit",
          hour12: "true",
          minute: "numeric"
        });
    
    function o() {
      let o = new Date,
          i = t.format(o);
      e.textContent = i;
    }
    o(), setInterval(o, 1e3);
  }
}

function initLazyLoad() {
  new LazyLoad({elements_selector: ".lazy"});
}

function initPlayVideoInview() {
  gsap.utils.toArray(".playpauze").forEach((e, t) => {
    let o = e.querySelector("video");
    ScrollTrigger.create({
      scroller: document.querySelector("[data-scroll-container]"),
      trigger: o,
      start: "0% 120%",
      end: "100% -20%",
      onEnter: () => o.play(),
      onEnterBack: () => o.play(),
      onLeave: () => o.pause(),
      onLeaveBack: () => o.pause()
    });
  });
}

function initScrolltriggerAnimations() {
  document.querySelector(".footer-wrap") && $(".footer-wrap").each(function(e) {
    let t = $(this),
        o = $(".btn-hamburger .btn-click");
    gsap.timeline({
      scrollTrigger: {
        trigger: t,
        start: "50% 100%",
        end: "100% 120%",
        scrub: 0
      }
    }).from(o, {boxShadow: "0px 0px 0px 0px rgb(0, 0, 0)", ease: "none"});
  }),
  document.querySelector(".span-lines.animate") && $(".span-lines.animate").each(function(e) {
    let t = $(this),
        o = $(".span-lines.animate .span-line-inner"),
        i = gsap.timeline({
          scrollTrigger: {
            trigger: t,
            toggleActions: "play none none reset",
            start: "0% 100%",
            end: "100% 0%"
          }
        });
    o && i.from(o, {y: "100%", stagger: .01, ease: "power3.out", duration: 1, delay: 0});
  }),
  document.querySelector(".fade-in.animate") && $(".fade-in.animate").each(function(e) {
    let t = $(this),
        o = $(this),
        i = gsap.timeline({
          scrollTrigger: {
            trigger: t,
            toggleActions: "play none none reset",
            start: "0% 110%",
            end: "100% 0%"
          }
        });
    o && i.from(o, {y: "2em", opacity: 0, ease: "expo.out", duration: 1.75, delay: 0});
  }),
  document.querySelector(".awwwards-badge") && $(".awwwards-badge").each(function(e) {
    let t = $(this),
        o = $(".awwwards-badge svg:nth-child(1)");
    gsap.timeline({
      scrollTrigger: {
        trigger: t,
        start: "0% 100%",
        end: "100% 0%",
        scrub: 0
      }
    }).to(o, {rotate: -90, ease: "none"});
  }),
  ScrollTrigger.matchMedia({
    "(min-width: 721px)": function() {
      document.querySelector(".home-header .arrow") && $(".home-header").each(function(e) {
        let t = $(this),
            o = $(".home-header .arrow");
        gsap.timeline({
          scrollTrigger: {
            trigger: t,
            start: "100% 100%",
            end: "100% 0%",
            scrub: 0
          }
        }).to(o, {rotate: 90, ease: "none"}, 0);
      }),
      document.querySelector(".footer-footer-wrap") && $(".footer-footer-wrap").each(function(e) {
        let t = $(this),
            o = $(".footer-rounded-div .rounded-div-wrap"),
            i = $("footer .arrow");
        gsap.timeline({
          scrollTrigger: {
            trigger: t,
            start: "0% 100%",
            end: "100% 100%",
            scrub: 0
          }
        }).to(o, {height: 0, ease: "none"}, 0).from(i, {rotate: 15, ease: "none"}, 0);
      }),
      document.querySelector(".footer-case-wrap") && $(".footer-case-wrap").each(function(e) {
        let t = $(this),
            o = $(".footer-rounded-div .rounded-div-wrap");
        gsap.timeline({
          scrollTrigger: {
            trigger: t,
            start: "0% 100%",
            end: "100% 100%",
            scrub: 0
          }
        }).to(o, {height: 0, ease: "none"}, 0);
      }),
      document.querySelector(".about-image .single-about-image") && $(".about-image .single-about-image").each(function(e) {
        let t = $(this),
            o = $(".about-image .arrow");
        gsap.timeline({
          scrollTrigger: {
            trigger: t,
            start: "15% 100%",
            end: "100% 0%",
            scrub: 0
          }
        }).to(o, {rotate: 60, ease: "none"}, 0);
      }),
      document.querySelector(".about-services") && $(".about-services").each(function(e) {
        let t = $(this),
            o = $(".about-header, .line-globe, .about-image, .about-services"),
            i = gsap.timeline({
              scrollTrigger: {
                trigger: t,
                start: "-25% 100%",
                end: "100% 100%",
                scrub: 0
              }
            });
        i.set(o, {backgroundColor: "#FFFFFF"}),
        i.to(o, {backgroundColor: "#E9EAEB", ease: "none"});
      }),
      document.querySelector(".digital-ball .globe") && $("main").each(function(e) {
        let t = $(this),
            o = $(".digital-ball .globe");
        gsap.timeline({
          scrollTrigger: {
            trigger: t,
            start: "100% 100%",
            end: "100% 0%",
            scrub: 0
          }
        }).to(o, {ease: "none", rotate: 90});
      });
    },
    "(max-width: 720px)": function() {
      document.querySelector(".footer-wrap") && $(".footer-wrap").each(function(e) {
        let t = $(this),
            o = $(".footer-rounded-div .rounded-div-wrap");
        gsap.timeline({
          scrollTrigger: {
            trigger: t,
            start: "0% 100%",
            end: "100% 100%",
            scrub: 0
          }
        }).to(o, {height: 0, ease: "none"}, 0);
      });
    }
  });
}

initPageTransitions();