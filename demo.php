<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gurbhej Singh | Portfolio</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            scroll-behavior: smooth;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        body {
            background: #f5f5f7;
            color: #111;
            transition: .4s;
        }

        /* Navbar */
        .navbar {
            background: rgba(255, 255, 255, .75);
            backdrop-filter: blur(18px);
            border-bottom: 1px solid rgba(0, 0, 0, .05);
            padding: 14px 0;
            transition: .4s;
        }

        .navbar-brand {
            font-size: 28px;
            font-weight: 700;
            color: #111 !important;
        }

        .nav-link {
            color: #555 !important;
            margin-left: 18px;
            font-weight: 500;
            transition: .3s;
        }

        .nav-link:hover {
            color: #000 !important;
        }

        /* Theme Button */
        .theme-btn {
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: #111;
            color: #fff;
            font-size: 18px;
            cursor: pointer;
            transition: .3s;
        }

        .theme-btn:hover {
            transform: scale(1.08);
        }

        /* Hero */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 0 20px;
            background: linear-gradient(180deg, #fff, #f5f5f7);
            transition: .4s;
        }

        .hero h1 {
            font-size: 72px;
            font-weight: 800;
            line-height: 1.1;
            letter-spacing: -2px;
        }

        .hero span {
            color: #0071e3;
        }

        .hero p {
            font-size: 22px;
            color: #666;
            margin-top: 20px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .btn-main {
            margin-top: 30px;
            padding: 14px 34px;
            border: none;
            border-radius: 50px;
            background: #0071e3;
            color: #fff;
            font-weight: 600;
            transition: .3s;
        }

        .btn-main:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 25px rgba(0, 113, 227, .25);
        }

        /* Sections */
        section {
            padding: 110px 0;
        }

        .title {
            font-size: 50px;
            font-weight: 800;
            text-align: center;
            margin-bottom: -120px;
        }

        /* Cards */
        .card-box {
            background: #fff;
            padding: 35px;
            border-radius: 28px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .05);
            transition: .35s;
            height: 100%;
        }

        .card-box:hover {
            transform: translateY(-8px);
        }

        /* Skills */
        .pill {
            display: inline-block;
            padding: 12px 20px;
            border-radius: 50px;
            background: #fff;
            box-shadow: 0 6px 20px rgba(0, 0, 0, .05);
            margin: 8px;
            font-weight: 600;
        }

        /* Inputs */
        .input {
            width: 100%;
            padding: 16px;
            border: none;
            outline: none;
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 8px 20px rgba(0, 0, 0, .05);
            margin-bottom: 16px;
        }

        /* Footer */
        footer.site-footer {
            padding: 0;
            text-align: left;
            color: inherit;
        }

        /* Dark Mode */
        .dark-mode {
            background: #111;
            color: #fff;
        }

        .dark-mode .navbar {
            background: rgba(20, 20, 20, .85);
            border-bottom: 1px solid rgba(255, 255, 255, .08);
        }

        .dark-mode .navbar-brand,
        .dark-mode .nav-link {
            color: #fff !important;
        }

        .dark-mode .nav-link:hover {
            color: #0d6efd !important;
        }

        .dark-mode .theme-btn {
            background: #fff;
            color: #111;
        }

        .dark-mode .hero {
            background: linear-gradient(180deg, #111, #1c1c1c);
        }

        .dark-mode .hero p {
            color: #ccc;
        }

        .dark-mode .card-box,
        .dark-mode .pill,
        .dark-mode .input {
            background: #1c1c1c;
            color: #fff;
            box-shadow: none;
            border: 1px solid rgba(255, 255, 255, .05);
        }

        .dark-mode .text-secondary {
            color: #bbb !important;
        }

        .dark-mode .site-footer {
            background-color: #0b0b0b;
        }

        @media(max-width:768px) {
            .hero h1 {
                font-size: 42px;
            }

            .title {
                font-size: 34px;
            }
        }

        .progress-height {
            height: 10px;
            margin-bottom: 15px;
        }

        .skill-html {
            width: 95%;
        }

        .skill-css {
            width: 92%;
        }

        .skill-js {
            width: 85%;
        }

        .skill-bootstrap {
            width: 95%;
        }

        .skill-react {
            width: 70%;
        }

        .skill-php {
            width: 68%;
        }

        .skill-graphic {
            width: 88%;
        }

        .skill-ui {
            width: 90%;
        }

        /* ==========================================================================
   PREMIUM FOOTER STYLES
   ========================================================================== */
        .site-footer {
            background-color: #0f1115;
            color: #ffffff;
            font-family: inherit;
        }

        body.light-theme .site-footer {
            background-color: #f8f9fa;
            color: #212529;
        }

        .footer-logo {
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .footer-logo span {
            color: #0d6efd;
        }

        .footer-heading {
            font-size: 1.1rem;
            font-weight: 600;
            position: relative;
            padding-bottom: 8px;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: #6c757d;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .footer-links a:hover {
            color: #0d6efd;
            transform: translateX(5px);
        }

        .footer-social-links .social-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.05);
            color: #ffffff;
            border-radius: 50%;
            margin-right: 10px;
            font-size: 1.2rem;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        body.light-theme .footer-social-links .social-icon {
            background: rgba(0, 0, 0, 0.05);
            color: #212529;
        }

        .footer-social-links .social-icon:hover {
            background: #0d6efd;
            color: #fff;
            transform: translateY(-4px);
        }

        .footer-email-btn {
            background: #ffffff;
            color: #000000;
            border: 1px solid transparent;
            padding: 12px 24px;
            border-radius: 50px;
            font-weight: 500;
            font-size: 0.95rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        body.light-theme .footer-email-btn {
            background: #000000;
            color: #ffffff;
        }

        .footer-email-btn:hover {
            background: #0d6efd;
            color: #ffffff;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(13, 110, 253, 0.4);
        }

        .footer-copyright-bar p {
            font-size: 0.9rem;
        }

        /* ==========================================================================
           3D PROJECT CAROUSEL (scoped so it can't leak into body/navbar/footer)
           ========================================================================== */
        .carousel-scene-wrap {
            position: relative;
            width: 800px;
            max-width: 1200px;
            height: 700px;
            margin: 0 auto 70px;
            perspective: 1800px;
        }

        .carousel3d {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            transform-style: preserve-3d;
        }

        .card3d {
            position: absolute;
            left: 50%;
            top: 50%;
            width: 310px;
            height: 430px;
            margin-left: -150px;
            margin-top: -125px;
            border-radius: 18px;
            overflow: hidden;
            background: #111;
            cursor: pointer;
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
            opacity: .15;
            box-shadow: 0 25px 50px rgba(0, 0, 0, .45);
            transition: box-shadow .35s;
        }

        .card3d:hover {
            box-shadow: 0 35px 70px rgba(0, 0, 0, .35);
        }

        .card3d img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .card3d .card3d-label {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            padding: 14px 16px;
            background: linear-gradient(0deg, rgba(0, 0, 0, .8), transparent);
            color: #fff;
            font-size: .85rem;
            font-weight: 600;
            letter-spacing: .5px;
        }

        .carousel-hint {
            text-align: center;
            color: #888;
            font-size: .85rem;
            letter-spacing: 2px;
            margin-top: 140px;
            margin-bottom: 40px;
            text-transform: uppercase;
        }

        .dark-mode .carousel-hint {
            color: #aaa;
        }

        @media(max-width:768px) {
            .carousel-scene-wrap {
                height: 340px;
            }

            .card3d {
                width: 150px;
                height: 220px;
                margin-left: -75px;
                margin-top: -110px;
            }
        }


        .display-font {
            font-family: 'Archivo Black', sans-serif;
        }

        /* NAVBAR */
        .navbar {
            border-bottom: 1px solid var(--line);
        }

        .navbar-brand {
            font-family: 'Archivo Black', sans-serif;
            font-size: 1.4rem;
            letter-spacing: 1px;
            color: var(--white) !important;
        }

        .navbar-brand .dot {
            color: var(--red);
        }

        .nav-link {
            color: var(--white) !important;
            font-size: .78rem;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            font-weight: 500;
            padding: .5rem 1rem !important;
        }

        .nav-link:hover {
            color: var(--red) !important;
        }

        .btn-outline-talk {
            border: 1px solid var(--red);
            color: var(--white);
            font-size: .78rem;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: .5rem 1.2rem;
            border-radius: 30px;
            transition: all .25s ease;
        }

        .btn-outline-talk:hover {
            background: var(--red);
            color: var(--white);
        }

        /* HERO */
        .hero {
            min-height: 90vh;
            position: relative;
        }

        .eyebrow {
            color: var(--red);
            font-size: .8rem;
            letter-spacing: 3px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .headline {
            font-size: clamp(3rem, 8vw, 6.2rem);
            line-height: .92;
            letter-spacing: -1px;
            text-transform: uppercase;
        }

        .headline .accent {
            color: var(--red);
        }

        .lead-text {
            color: var(--muted);
            max-width: 360px;
            font-size: 1rem;
        }

        .btn-view-work {
            background: transparent;
            border: 1px solid var(--line);
            color: var(--white);
            border-radius: 30px;
            padding: .8rem 1.6rem;
            font-size: .8rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            gap: .6rem;
            transition: all .25s ease;
        }

        .btn-view-work:hover {
            background: var(--white);
            color: var(--bg);
        }

        /* PORTRAIT / SIGNATURE ELEMENT */
        .portrait-wrap {
            position: relative;
            height: 100%;
            min-height: 560px;
            display: flex;
            align-items: flex-end;
            justify-content: center;
        }

        .red-blob {
            position: absolute;
            top: 8%;
            right: 6%;
            width: 64%;
            height: 78%;
            background: var(--red);
            border-radius: 45% 55% 60% 40% / 55% 45% 55% 45%;
            filter: blur(0px);
            z-index: 0;
            opacity: .95;
        }

        .portrait-svg {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 520px;
            height: auto;
            filter: grayscale(100%) contrast(1.05);
        }

        .stat-box {
            position: absolute;
            bottom: 6%;
            left: -4%;
            z-index: 3;
            background: rgba(13, 13, 13, .55);
            backdrop-filter: blur(4px);
            padding: 1rem 1.4rem;
            border-left: 2px solid var(--red);
        }

        .stat-number {
            font-family: 'Archivo Black', sans-serif;
            color: var(--red);
            font-size: 2.4rem;
            line-height: 1;
        }

        .stat-label {
            font-size: .68rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--muted);
            margin-top: .3rem;
        }

        @media (max-width: 991.98px) {
            .portrait-wrap {
                min-height: 420px;
                margin-top: 3rem;
            }

            .stat-box {
                left: 0;
                bottom: -8%;
            }
        }

        :root {
            --bg: #0d0d0d;
            --bg-soft: #141414;
            --red: #e8382d;
            --white: #f5f5f3;
            --muted: #9a9a9a;
            --line: rgba(255, 255, 255, .12);
        }

        body {
            background-color: var(--bg);
            color: var(--white);
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Poppins", sans-serif;
            background: #0d0d0d;
            color: #fff;
            overflow-x: hidden;
        }

        /* Navbar */

        .logo {
            font-size: 32px;
            font-weight: 800;
        }

        .logo span {
            color: #ff2a2a;
        }

        .nav-link {
            color: #fff !important;
            margin: 0 12px;
            font-size: 14px;
            letter-spacing: 1px;
        }

        .talk-btn {
            color: #fff;
            border: 1px solid #ff2a2a;
            padding: 12px 22px;
            border-radius: 0;
        }

        .talk-btn:hover {
            background: #ff2a2a;
            color: #fff;
        }

        /* Hero */

        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
        }

        .small-title {
            color: #ff2a2a;
            letter-spacing: 3px;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .hero h1 {
            font-size: 110px;
            font-weight: 900;
            line-height: 0.9;
        }

        .hero h1 span {
            color: #ff2a2a;
        }

        .hero-text {
            color: #bdbdbd;
            max-width: 420px;
            margin: 30px 0;
        }

        .work-btn {
            border: 1px solid #555;
            color: #fff;
            padding: 14px 30px;
            border-radius: 0;
        }

        .work-btn:hover {
            background: #ff2a2a;
            border-color: #ff2a2a;
            color: #fff;
        }

        /* Right */

        /* Right Side */


        .image-wrapper{
    position: relative;
    width: 550px;
    height: 550px;
}

.circle{
    position: absolute;
    width: 470px;
    height: 470px;
    border-radius: 50%;
    background: #ff2020;
    top: 40px;
    left: 40px;
    overflow: hidden;      /* Image circle ke bahar nahi jayegi */
}

.hero-img{
    position: absolute;
    width: 390px;
    left: 50%;
    top: 0;
    bottom: 0;
    transform: translateX(-50%);
    filter: grayscale(100%);
    object-fit: contain;
    z-index: 2;
}



        .experience {
            position: absolute;
            bottom: 20px;
            left: 20px;
            z-index: 10;
        }


        .experience h2 {
            color: #ff2020;
            font-size: 60px;
            font-weight: 800;
            margin-bottom: 0;
        }

        .experience p {
            font-size: 14px;
            letter-spacing: 2px;
        }

        /* Responsive */

        @media (max-width: 991px) {
            .image-wrapper {
                width: 100%;
                height: 450px;
            }

            .circle {
                width: 320px;
                height: 320px;
            }

            .hero-img {
                width: 270px;
            }

            .experience {
                position: relative;
                left: 0;
                bottom: 0;
                margin-top: 20px;
            }
        }

        /* Responsive */

        @media (max-width: 991px) {
            .hero {
                padding: 100px 0;
            }

            .hero h1 {
                font-size: 70px;
            }

            .circle {
                width: 320px;
                height: 320px;
                left: 50%;
                transform: translateX(-50%);
                top: 100px;
            }

            .hero-img {
                margin-top: 50px;
                padding-left: -100px;
            }

            .experience {
                position: relative;
                bottom: auto;
                margin-top: 20px;
            }
        }

        .cstmmm {
            margin-left: 200px;
            margin-top: 140px;
        }
    </style>
</head>


<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">

            <a class="navbar-brand" href="#">Protfilo </a>

            <button id="themeToggle" class="theme-btn me-3">🌙</button>

            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#skills">Skills</a></li>
                    <li class="nav-item"><a class="nav-link" href="#projects">Projects</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                </ul>
            </div>

        </div>
    </nav>





    <!-- NAVBAR -->
    <!-- <nav class="navbar navbar-expand-lg py-3">
        <div class="container">
            <a class="navbar-brand" href="#">MK<span class="dot">.</span></a>
            <button class="navbar-toggler border-0 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
                <i class="bi bi-list fs-2 text-white"></i>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navContent">
                <ul class="navbar-nav align-items-lg-center gap-lg-2">
                    <li class="nav-item"><a class="nav-link" href="#">Work</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Process</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Journal</a></li>
                    <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                        <a href="#" class="btn btn-outline-talk">Let's Talk <i class="bi bi-arrow-up-right ms-1"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav> -->

    <!-- HERO -->
    <section class="hero">
        <div class="container">
            <div class="row align-items-center">
                <!-- Left -->

                <div class="col-lg-6">
                    <p class="small-title">WEB DESIGNER</p>

                    <h1>
                        DESIGN <br />
                        THAT <br />
                        <span>MOVES.</span>
                    </h1>

                    <p class="hero-text">
                        I design and build digital experiences that are bold, strategic
                        and unforgettable.
                    </p>

                    <a href="#" class="btn work-btn"> VIEW MY WORK ↗ </a>
                </div>

                <!-- Right -->

                <!-- Right -->

                <div class="col-lg-6 d-flex justify-content-center">
                    <div class="image-wrapper">
                        <div class="circle">
                            <img
                                src="img/Untitled - July 16, 2026 at 14.57.36.png"
                                class="hero-img img-fluid" />
                        </div>

                        <!-- <div class="experience">
                            <h2>6+</h2>
                            <p>YEARS OF EXPERIENCE</p>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Projects -->
    <section id="projects">
        <div class="container">
            <h2 class="title">Projects</h2>

            <!-- 3D Carousel Showcase -->
            <div class="carousel-scene-wrap">
                <div class="carousel3d" id="ring">

                    <div class="card3d" data-project="ecommerce">
                        <img src="img/Spotify Home Screen inspo.jpg" alt="Ecommerce Website">
                        <div class="card3d-label">Spotify</div>
                    </div>

                    <div class="card3d" data-project="dashboard">
                        <img src="img/Modern Electronics eCommerce Website UI Design _ Figma Landing Page.jpg" alt="Admin Dashboard">
                        <div class="card3d-label">Ecommerce</div>
                    </div>

                    <div class="card3d" data-project="portfolio">
                        <img src="img/Creative Portfolio Website Design Inspiration _ Modern Web Designer UI UX Portfolio.jpg" alt="Creative Portfolio">
                        <div class="card3d-label">Creative Portfolio</div>
                    </div>

                    <div class="card3d" data-project="carwash">
                        <img src="img/UI_UX Web.jpg" alt="ShineWash Car Wash">
                        <div class="card3d-label">Netflix</div>
                    </div>

                    <div class="card3d" data-project="college">
                        <img src="img/SOSH.jpg" alt="College Website">
                        <div class="card3d-label">College Website</div>
                    </div>

                    <div class="card3d" data-project="admin-panel">
                        <img src="img/download (7).jpg" alt="AquaShine Admin Panel">
                        <div class="card3d-label"> Admin Panel</div>
                    </div>

                </div>
            </div>
            <p class="carousel-hint">Scroll or drag to rotate</p>

            <!-- Project Details -->
            <!-- <div class="row g-4">

                <div class="col-md-4">
                    <div class="card-box">
                        <h4>Ecommerce Website</h4>
                        <p class="text-secondary mt-3">
                            Responsive online shopping website with modern design.
                        </p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card-box">
                        <h4>Admin Dashboard</h4>
                        <p class="text-secondary mt-3">
                            Clean dashboard UI for analytics and management.
                        </p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card-box">
                        <h4>Creative Portfolio</h4>
                        <p class="text-secondary mt-3">
                            Premium personal portfolio with modern layout.
                        </p>
                    </div>
                </div>

            </div> -->
        </div>
    </section>




    <section class="hero">
        <div class="container">
            <h1>Hi, I'm <span>Gurbhej Singh</span></h1>
            <p>
                19-year-old Full Stack Developer & Graphic Designer creating modern websites with clean UI and premium
                user experience.
            </p>
            <button class="btn-main">Hire Me</button>
        </div>
    </section>

    <!-- About -->
    <section id="about">
        <div class="container">
            <h2 class="title">About Me</h2>

            <div class="row g-4">

                <div class="col-md-6">
                    <div class="card-box">
                        <h3>Who I Am 👋</h3>
                        <p class="mt-3 text-secondary">
                            I'm Gurbhej Singh, passionate about web development and creative design. I love building
                            fast, responsive and modern websites.
                        </p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card-box">
                        <h3>My Journey 🚀</h3>
                        <p class="mt-3 text-secondary">
                            Strong in HTML, CSS, JavaScript and Bootstrap. Currently learning React and PHP to become a
                            Full Stack Developer.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>




    <!-- Skills -->
    <section id="skills">
        <div class="container">
            <h2 class="title">My Skills</h2>

            <div class="row g-4">

                <!-- Frontend -->
                <div class="col-md-4">
                    <div class="card-box">
                        <h4 class="mb-4">Frontend Development 💻</h4>

                        <p>HTML</p>
                        <div class="progress progress-height">
                            <div class="progress-bar bg-primary skill-html"></div>
                        </div>

                        <p>CSS</p>
                        <div class="progress progress-height">
                            <div class="progress-bar bg-info skill-css"></div>
                        </div>

                        <p>JavaScript</p>
                        <div class="progress progress-height">
                            <div class="progress-bar bg-warning skill-js"></div>
                        </div>

                        <p>Bootstrap</p>
                        <div class="progress progress-height">
                            <div class="progress-bar bg-success skill-bootstrap"></div>
                        </div>

                    </div>
                </div>

                <!-- Backend -->
                <div class="col-md-4">
                    <div class="card-box">
                        <h4 class="mb-4">Backend & Learning 🚀</h4>

                        <p>React</p>
                        <div class="progress progress-height">
                            <div class="progress-bar bg-primary skill-react"></div>
                        </div>

                        <p>PHP</p>
                        <div class="progress progress-height">
                            <div class="progress-bar bg-danger skill-php"></div>
                        </div>

                    </div>
                </div>

                <!-- Other Skills -->
                <div class="col-md-4">
                    <div class="card-box">
                        <h4 class="mb-4">Other Skills 💡</h4>

                        <p>Graphic Design</p>
                        <div class="progress progress-height">
                            <div class="progress-bar bg-dark skill-graphic"></div>
                        </div>

                        <p>UI Design</p>
                        <div class="progress progress-height">
                            <div class="progress-bar bg-secondary skill-ui"></div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Contact -->
    <section id="contact">
        <div class="container">
            <h2 class="title">Contact Me</h2>

            <div class="card-box">
                <input type="text" class="input" placeholder="Your Name">
                <input type="email" class="input" placeholder="Your Email">
                <textarea rows="5" class="input" placeholder="Your Message"></textarea>

                <button class="btn-main">Send Message</button>
            </div>

        </div>
    </section>

    <footer class="site-footer mt-5">
        <div class="container py-5">
            <div class="row g-4 justify-content-between">

                <!-- Left Side: Brand & About -->
                <div class="col-lg-4 col-md-6">
                    <h3 class="footer-logo mb-3">Portfolio<span>.</span></h3>
                    <p class="text-secondary">
                        19-year-old Full Stack Developer & Graphic Designer creating modern websites with clean UI and
                        premium user experience.
                    </p>
                    <!-- Social Media Links -->
                    <div class="footer-social-links mt-4">
                        <a href="https://github.com" target="_blank" class="social-icon"><i
                                class="bi bi-github"></i></a>
                        <a href="https://linkedin.com" target="_blank" class="social-icon"><i
                                class="bi bi-linkedin"></i></a>
                        <a href="https://instagram.com" target="_blank" class="social-icon"><i
                                class="bi bi-instagram"></i></a>
                    </div>
                </div>

                <!-- Middle Side: Quick Links -->
                <div class="col-lg-3 col-md-6">
                    <h5 class="footer-heading mb-3">Quick Links</h5>
                    <ul class="list-unstyled footer-links">
                        <li><a href="#about"><i class="bi bi-chevron-right me-1"></i> About</a></li>
                        <li><a href="#skills"><i class="bi bi-chevron-right me-1"></i> Skills</a></li>
                        <li><a href="#projects"><i class="bi bi-chevron-right me-1"></i> Projects</a></li>
                        <li><a href="#contact"><i class="bi bi-chevron-right me-1"></i> Contact</a></li>
                    </ul>
                </div>

                <!-- Right Side: Contact Button/Info -->
                <div class="col-lg-4 col-md-12">
                    <h5 class="footer-heading mb-3">Let's Work Together</h5>
                    <p class="text-secondary">Have a project in mind or just want to say hi? Feel free to reach out!</p>
                    <div class="mt-4">
                        <a href="mailto:Gurbhej.aatlia@gmail.com" class="btn footer-email-btn">
                            <i class="bi bi-envelope-fill me-2"></i> Gurbhej.aatlia@gmail.com
                        </a>
                    </div>
                </div>

            </div>
        </div>

        <!-- Copyright Bar -->
        <div class="footer-copyright-bar border-top border-secondary border-opacity-25 py-3">
            <div
                class="container d-flex flex-column flex-md-row justify-content-between align-items-center text-center text-md-start">
                <p class="mb-0 text-secondary">&copy; 2026 Gurbhej Singh. All Rights Reserved.</p>
                <p class="mb-0 text-secondary mt-2 mt-md-0">Designed & Built with ❤️</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    <script>
        // Theme toggle
        let btn = document.getElementById("themeToggle");

        // Default Dark Mode
        document.body.classList.add("dark-mode");
        btn.innerHTML = "☀️";

        btn.onclick = function() {
            document.body.classList.toggle("dark-mode");

            if (document.body.classList.contains("dark-mode")) {
                btn.innerHTML = "☀️";
            } else {
                btn.innerHTML = "🌙";
            }
        }

        // ================= 3D Project Carousel =================
        const ring = document.getElementById("ring");
        const cards = document.querySelectorAll(".card3d");

        const total = cards.length;
        const radius = 400;

        let rotation = 0;

        // Position cards around cylinder
        cards.forEach((card, i) => {
            let angle = (360 / total) * i;

            gsap.set(card, {
                rotationY: angle,
                transformOrigin: `50% 50% ${-radius}px`,
                z: radius
            });
        });

        function updateCards() {
            cards.forEach((card, i) => {
                let angle = ((360 / total) * i + rotation) % 360;

                if (angle < 0) angle += 360;

                let diff = Math.abs(angle);
                if (diff > 180) diff = 360 - diff;

                let opacity = Math.max(0, 1 - diff / 90);

                gsap.set(card, {
                    opacity: opacity,
                    scale: 0.8 + opacity * 0.2,
                    zIndex: Math.round(opacity * 100)
                });
            });
        }

        // Initial tilt
        gsap.set(ring, {
            rotationX: -8,
            rotationY: 0
        });

        // Rotate on scroll only while the carousel is in view
        const sceneWrap = document.querySelector(".carousel-scene-wrap");

        sceneWrap.addEventListener("wheel", (e) => {
            e.preventDefault();
            rotation += e.deltaY * 0.18;

            gsap.to(ring, {
                rotationY: rotation,
                duration: 1,
                ease: "power3.out",
                onUpdate: updateCards
            });
        }, {
            passive: false
        });

        // Drag to rotate (mouse + touch)
        let isDragging = false;
        let startX = 0;
        let startRotation = 0;

        function dragStart(x) {
            isDragging = true;
            startX = x;
            startRotation = rotation;
        }

        function dragMove(x) {
            if (!isDragging) return;
            rotation = startRotation + (x - startX) * 0.5;
            gsap.set(ring, {
                rotationY: rotation
            });
            updateCards();
        }

        function dragEnd() {
            isDragging = false;
        }

        sceneWrap.addEventListener("mousedown", (e) => dragStart(e.clientX));
        window.addEventListener("mousemove", (e) => dragMove(e.clientX));
        window.addEventListener("mouseup", dragEnd);

        sceneWrap.addEventListener("touchstart", (e) => dragStart(e.touches[0].clientX), {
            passive: true
        });
        sceneWrap.addEventListener("touchmove", (e) => dragMove(e.touches[0].clientX), {
            passive: true
        });
        sceneWrap.addEventListener("touchend", dragEnd);

        // Subtle tilt on mouse move (only over the carousel)
        sceneWrap.addEventListener("mousemove", (e) => {
            const rect = sceneWrap.getBoundingClientRect();
            let x = ((e.clientX - rect.left) / rect.width - .5) * 10;
            let y = ((e.clientY - rect.top) / rect.height - .5) * 8;

            gsap.to(ring, {
                rotationX: -3 - y,
                rotationZ: x * 0.15,
                duration: .8,
                ease: "power2.out"
            });
        });

        updateCards();

        // Floating animation
        cards.forEach((card, index) => {
            gsap.to(card, {
                y: -10,
                repeat: -1,
                yoyo: true,
                ease: "sine.inOut",
                duration: 2 + index * .25
            });
        });
    </script>

</body>

</html>