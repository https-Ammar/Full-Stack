<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Document</title>

    <!-- CSS Files -->
    <link href="../css/normalize.css" rel="stylesheet">
    <link href="../css/locomotive-scroll.css" rel="stylesheet">
    <link href="../css/styleguide.css" rel="stylesheet">
    <link href="../css/components.css" rel="stylesheet">
    <link href="../css/style-new.css" rel="stylesheet">

    <!-- Custom Inline Style -->
    <style>
        /* --- General Styles --- */
        h1.fw-bold {
            font-size: xx-large;
            margin-bottom: 5vh;
        }

        h4.fw-bold.border-bottom.pb-2.mb-5.pb-5 {
            margin-bottom: 4vh;
            border-bottom: 1px solid;
            padding-bottom: 2vh;
        }

        .mb-5 { margin: 5vh 0; }
        .cards-grid.d-grid.gap-4 {
            display: grid;
            gap: 5px;
        }

        section.info { padding: 20px; }
        section#cards-container section h1 {
            color: black;
            font-size: 20px !important;
        }

        .wid-title h3 {
            display: flex;
            align-items: center;
            gap: 10px;
            color: white;
        }

        .single-sidebar-widget, .single-sidebar-widget.mb-4 {
            background: black !important;
        }

        li.audio-player {
            background: #ffffff !important;
        }

        .news-widget-categories ul li,
        .content h3,
        .news-content h3 a {
            color: white !important;
        }

        a.page-numbers {
            color: black !important;
        }

        .card-details {
            display: none;
        }

        .card-details:first-child {
            display: block;
        }

        figure.card-banner.img-holder {
            width: 333px;
        }

        @media screen and (max-width: 992px) {
            .single-sidebar-widget.mb-4 {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                overflow: auto;
                z-index: 999999999999999999;
                border-radius: 0;
            }

            .container.p-0 {
                padding: 20px !important;
            }

            div#Customer {
                display: none;
            }
        }

        /* --- Cards Backgrounds --- */
        main .cards .info.one {
            background: linear-gradient(to bottom right, #fff1f1, #f1ffec);
            border-radius: 10px;
        }

        main .cards .info.two {
            background: linear-gradient(to bottom right, #fff1fe, #ecfffe);
            border-radius: 10px;
        }

        main .cards .info.three {
            background: linear-gradient(to bottom right, #f1f7ff, #ffecec);
            border-radius: 10px;
        }

        main .cards .title,
        main .cards .infos {
            font-size: 0.875rem;
        }
        section#cards-container {
    display: block;
}
    </style>
</head>

<body data-barba="wrapper">

    <!-- Loading Screen -->
    <?php include './loading.php'; ?>

    <main class="main" id="work" data-barba="container" data-barba-namespace="work">
        
        <!-- Mouse Interaction Elements -->
        <div class="mouse-pos-list-btn no-select"></div>
        <div class="mouse-pos-list-span no-select"><p>View</p></div>

        <!-- Hamburger Button -->
        <div class="btn btn-hamburger">
            <div class="btn-click magnetic" data-strength="50" data-strength-text="25">
                <div class="btn-fill"></div>
                <div class="btn-text">
                    <div class="btn-bars"></div>
                    <span class="btn-text-inner">Menu</span>
                </div>
            </div>
        </div>

        <!-- Fixed Navigation Menu -->
        <div class="overlay fixed-nav-back"></div>
        <div class="fixed-nav theme-dark">
            <div class="fixed-nav-rounded-div">
                <div class="rounded-div-wrap">
                    <div class="rounded-div"></div>
                </div>
            </div>
            <div class="fixed-nav-inner">
                <div class="row nav-row">
                    <h5>Navigation</h5>
                    <div class="stripe"></div>
                    <ul class="links-wrap">
                        <li class="btn btn-link"><a href="https://dennissnellenberg.com" class="btn-click magnetic"><span class="btn-text"><span class="btn-text-inner">Home</span></span></a></li>
                        <li class="btn btn-link active"><a href="https://dennissnellenberg.com/work" class="btn-click magnetic"><span class="btn-text"><span class="btn-text-inner">Work</span></span></a></li>
                        <li class="btn btn-link"><a href="https://dennissnellenberg.com/about" class="btn-click magnetic"><span class="btn-text"><span class="btn-text-inner">About</span></span></a></li>
                        <li class="btn btn-link"><a href="https://dennissnellenberg.com/contact" class="btn-click magnetic"><span class="btn-text"><span class="btn-text-inner">Contact</span></span></a></li>
                    </ul>
                </div>
                <div class="row social-row">
                    <div class="stripe"></div>
                    <div class="socials">
                        <h5>Socials</h5>
                        <ul>
                            <li class="btn btn-link btn-link-external"><a href="https://www.awwwards.com/dennissnellenberg/" target="_blank" class="btn-click magnetic"><span class="btn-text"><span class="btn-text-inner">Awwwards</span></span></a></li>
                            <li class="btn btn-link btn-link-external"><a href="https://www.instagram.com/codebydennis/" target="_blank" class="btn-click magnetic"><span class="btn-text"><span class="btn-text-inner">Instagram</span></span></a></li>
                            <li class="btn btn-link btn-link-external"><a href="https://twitter.com/codebydennis" target="_blank" class="btn-click magnetic"><span class="btn-text"><span class="btn-text-inner">Twitter</span></span></a></li>
                            <li class="btn btn-link btn-link-external"><a href="https://www.linkedin.com/in/dennissnellenberg/" target="_blank" class="btn-click magnetic"><span class="btn-text"><span class="btn-text-inner">LinkedIn</span></span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-wrap" data-scroll-container>
            <header class="section default-header work-header" data-scroll-section>
                <div class="nav-bar">
                    <div class="credits-top">
                        <div class="btn btn-link btn-left-top">
                            <a href="https://dennissnellenberg.com" class="btn-click magnetic">
                                <span class="btn-text">
                                    <div class="credit"><span>©</span></div>
                                    <div class="cbd">
                                        <span class="code-by">Code by </span>
                                        <span class="dennis"><span class="dennis-span">Dennis</span> <span class="snellenberg">Snellenberg</span></span>
                                    </div>
                                </span>
                            </a>
                        </div>
                    </div>
                    <ul class="links-wrap">
                        <li class="btn btn-link active"><a href="https://dennissnellenberg.com/work" class="btn-click magnetic"><span class="btn-text"><span class="btn-text-inner">Work</span></span></a></li>
                        <li class="btn btn-link"><a href="https://dennissnellenberg.com/about" class="btn-click magnetic"><span class="btn-text"><span class="btn-text-inner">About</span></span></a></li>
                        <li class="btn btn-link"><a href="https://dennissnellenberg.com/contact" class="btn-click magnetic"><span class="btn-text"><span class="btn-text-inner">Contact</span></span></a></li>
                        <li class="btn btn-link btn-menu"><div class="btn-click magnetic"><div class="btn-text"><span class="btn-text-inner">Menu</span></div></div></li>
                    </ul>
                </div>

                <div class="container medium">
                    <div class="row">
                        <div class="flex-col once-in">
                            <h1><span>Creating next level </span><span>digital products</span></h1>
                        </div>
                    </div>
                </div>
            </header>

            <section class="section work-filters" data-scroll-section>
                <div class="container once-in">
                    <section class="cards d-block gap-4 row mb-5" id="cards-container"></section>
                </div>
            </section>

            <!-- Footer -->
            <?php include './footer.php'; ?>
        </div>
    </main>

    <!-- JS Libraries -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/2.2.0/js.cookie.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/ScrollTrigger.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@barba/core@2.10.3"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.6.1/dist/lazyload.min.js"></script>
    <script src="../js/locomotive-scroll.min.js"></script>
    <script defer src="../js/index-new.js"></script>

    <!-- Skills Rendering Script -->
    <script>
        const skillsData = {
            "Front End Developer": [
                { title: "Skill", value: "HTML", info: "Used in structure" },
                { title: "Skill", value: "CSS", info: "Styling pages" },
                { title: "Skill", value: "SASS", info: "Advanced CSS" },
                { title: "Skill", value: "JavaScript", info: "Dynamic content" },
                { title: "Skill", value: "Jquery", info: "DOM manipulation" },
                { title: "Skill", value: "Bootstrap", info: "UI framework" },
                { title: "Skill", value: "API", info: "External data handling" }
            ],
            "Basics in Programming": [
                { title: "Language", value: "C++", info: "OOP basics" },
                { title: "Language", value: "C", info: "Low-level programming" },
                { title: "Language", value: "Python", info: "General purpose" },
                { title: "Language", value: "PHP", info: "Server-side scripting" },
                { title: "Language", value: "SQL", info: "Databases queries" },
                { title: "Language", value: "CS", info: "General computer science" },
                { title: "Framework", value: "Vue.js", info: "Frontend framework" },
                { title: "Technology", value: "AI", info: "Artificial Intelligence basics" }
            ],
            "Libraries": [
                { title: "Library", value: "Get Waves", info: "UI wave effect" },
                { title: "Library", value: "Owl Carousel", info: "Image slider plugin" },
                { title: "Library", value: "AOS", info: "Scroll animations" },
                { title: "Library", value: "Swiper.js", info: "Modern mobile slider" },
                { title: "Library", value: "Animation", info: "CSS/JS effects" }
            ],
            "System Tools": [
                { title: "Tool", value: "Git", info: "Version control" },
                { title: "Tool", value: "GitHub", info: "Code hosting platform" },
                { title: "Tool", value: "Vercel", info: "Frontend deployment" },
                { title: "Tool", value: "Cmdr", info: "Terminal emulator" },
                { title: "Tool", value: "Command Line", info: "Shell interface" },
                { title: "Tool", value: "VS Code", info: "Source-code editor" },
                { title: "Tool", value: "ChatGPT", info: "AI coding assistant" }
            ],
            "Other Tools": [
                { title: "Tool", value: "Font Awesome", info: "Icon library" },
                { title: "Tool", value: "SVG", info: "Vector graphics" },
                { title: "Tool", value: "Google Fonts", info: "Web typography" },
                { title: "Tool", value: "Search", info: "Search functionality" },
                { title: "Tool", value: "Figma", info: "UI/UX design tool" },
                { title: "Tool", value: "Photoshop", info: "Design editing" }
            ]
        };

        const container = document.getElementById("cards-container");

        Object.keys(skillsData).forEach((category) => {
            const categoryWrapper = document.createElement("div");
            categoryWrapper.className = "mb-5";

            const header = document.createElement("div");
            header.className = "col-12 mb-3";
            header.innerHTML = `<h4 class="fw-bold border-bottom pb-2 mb-5 pb-5">${category}</h4>`;
            categoryWrapper.appendChild(header);

            const gridWrapper = document.createElement("div");
            gridWrapper.className = "cards-grid d-grid gap-4";
            gridWrapper.style.gridTemplateColumns = "repeat(auto-fit, minmax(250px, 1fr))";

            skillsData[category].forEach((card, index) => {
                const section = document.createElement("section");
                const bgClass = index % 3 === 0 ? "one" : index % 3 === 1 ? "two" : "three";
                section.className = `info ${bgClass} p-4`;

                section.innerHTML = `
                    <span class="title fw-bold d-block mb-3">${card.title}</span>
                    <h1 class="fw-bold">${card.value}</h1>
                    <span class="infos d-block">${card.info}</span>
                `;
                gridWrapper.appendChild(section);
            });

            categoryWrapper.appendChild(gridWrapper);
            container.appendChild(categoryWrapper);
        });
    </script>
</body>
</html>
