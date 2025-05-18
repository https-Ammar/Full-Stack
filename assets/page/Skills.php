<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Stats</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/main.css" />
    <link rel="stylesheet" href="../css/style.css" />

    <style>
        body {
            font-family: 'Mulish', sans-serif !important;
            color: #1c1f2a !important;
        }

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

        h1.fw-bold {
            font-size: xx-large;
            margin-bottom: 5vh;
        }
    </style>
</head>

<body>

    <aside id="head"></aside>

    <main class="container" style="margin-top:15vh;">

        <h3 class="mb-2">Dashboard Overview</h3>
        <p class="mb-5">Here’s a summary of your current tools and skills.</p>

        <section class="cards d-flex gap-4 row mb-5" id="cards-container"></section>
    </main>

    <script src="../js/script.js"></script>

    <script>
        const skillsData = {
            "Front End Developer": [{
                    title: "Skill",
                    value: "HTML",
                    info: "Used in structure"
                },
                {
                    title: "Skill",
                    value: "CSS",
                    info: "Styling pages"
                },
                {
                    title: "Skill",
                    value: "SASS",
                    info: "Advanced CSS"
                },
                {
                    title: "Skill",
                    value: "JavaScript",
                    info: "Dynamic content"
                },
                {
                    title: "Skill",
                    value: "Jquery",
                    info: "DOM manipulation"
                },
                {
                    title: "Skill",
                    value: "Bootstrap",
                    info: "UI framework"
                },
                {
                    title: "Skill",
                    value: "API",
                    info: "External data handling"
                }
            ],
            "Basics in Programming": [{
                    title: "Language",
                    value: "C++",
                    info: "OOP basics"
                },
                {
                    title: "Language",
                    value: "C",
                    info: "Low-level programming"
                },
                {
                    title: "Language",
                    value: "Python",
                    info: "General purpose"
                },
                {
                    title: "Language",
                    value: "PHP",
                    info: "Server-side scripting"
                },
                {
                    title: "Language",
                    value: "SQL",
                    info: "Databases queries"
                },
                {
                    title: "Language",
                    value: "CS",
                    info: "General computer science"
                },
                {
                    title: "Framework",
                    value: "Vue.js",
                    info: "Frontend framework"
                },
                {
                    title: "Technology",
                    value: "AI",
                    info: "Artificial Intelligence basics"
                }
            ],
            "Libraries": [{
                    title: "Library",
                    value: "Get Waves",
                    info: "UI wave effect"
                },
                {
                    title: "Library",
                    value: "Owl Carousel",
                    info: "Image slider plugin"
                },
                {
                    title: "Library",
                    value: "AOS",
                    info: "Scroll animations"
                },
                {
                    title: "Library",
                    value: "Swiper.js",
                    info: "Modern mobile slider"
                },
                {
                    title: "Library",
                    value: "Animation",
                    info: "CSS/JS effects"
                }
            ],
            "System Tools": [{
                    title: "Tool",
                    value: "Git",
                    info: "Version control"
                },
                {
                    title: "Tool",
                    value: "GitHub",
                    info: "Code hosting platform"
                },
                {
                    title: "Tool",
                    value: "Vercel",
                    info: "Frontend deployment"
                },
                {
                    title: "Tool",
                    value: "Cmdr",
                    info: "Terminal emulator"
                },
                {
                    title: "Tool",
                    value: "Command Line",
                    info: "Shell interface"
                },
                {
                    title: "Tool",
                    value: "VS Code",
                    info: "Source-code editor"
                },
                {
                    title: "Tool",
                    value: "ChatGPT",
                    info: "AI coding assistant"
                }
            ],
            "Other Tools": [{
                    title: "Tool",
                    value: "Font Awesome",
                    info: "Icon library"
                },
                {
                    title: "Tool",
                    value: "SVG",
                    info: "Vector graphics"
                },
                {
                    title: "Tool",
                    value: "Google Fonts",
                    info: "Web typography"
                },
                {
                    title: "Tool",
                    value: "Search",
                    info: "Search functionality"
                },
                {
                    title: "Tool",
                    value: "Figma",
                    info: "UI/UX design tool"
                },
                {
                    title: "Tool",
                    value: "Photoshop",
                    info: "Design editing"
                }
            ]
        };

        const container = document.getElementById("cards-container");

        Object.keys(skillsData).forEach((category) => {
            const header = document.createElement("div");
            header.className = "col-12 mt-4";
            header.innerHTML = `<h4 class="fw-bold border-bottom pb-2">${category}</h4>`;
            container.appendChild(header);

            skillsData[category].forEach((card, index) => {
                const section = document.createElement("section");
                const bgClass = index % 3 === 0 ? "one" : index % 3 === 1 ? "two" : "three";
                section.className = `info ${bgClass} p-4 col-12 col-sm-6 col-md-4 col-lg-3`;

                section.innerHTML = `
                    <span class="title fw-bold d-block mb-3">${card.title}</span>
                    <h1 class="fw-bold">${card.value}</h1>
                    <span class="infos d-block">${card.info}</span>
                `;
                container.appendChild(section);
            });
        });
    </script>

</body>

</html>