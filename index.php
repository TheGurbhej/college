<?php
include "header.php";
?>
<?php
include "./admin/conn.php";
?>

<?php
$stmt = $conn->prepare("SELECT * FROM noticeboard ORDER BY id DESC LIMIT 5");

$stmt->execute();
$noticesrow = $stmt->fetchAll(PDO::FETCH_ASSOC);



$stmt = $conn->prepare("SELECT * FROM noticeboard ORDER BY id DESC ");

$stmt->execute();
$notices = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<section>
    <div>
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2000" ;>
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"></button>
            </div>

            <div class="carousel-inner">

                <div class="carousel-item active">
                    <img src="img/Gemini_Generated_Image_vzxybdvzxybdvzxy.png" class="d-block w-100" alt="College">

                    <div class="overlay"></div>

                    <div class="carousel-caption custom-caption">
                        <h1 class="fw-bold">Welcome to YouTube College of Technology</h1>
                        <p>
                            Empowering students with quality education, practical learning,
                            and innovative technology for a successful future.
                        </p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="img/high-level-description-a-wide-angle-arch_7rMY6IOZX8-E-EQGsRQoow_kLTzOXOXTzqNJolieEm12g.jpg" class="d-block w-100" alt="Campus">

                    <div class="carousel-caption d-none d-md-block">
                        <h5 class="fw-bold">Excellence in Education</h5>
                        <p>
                            Our experienced faculty, modern classrooms, and advanced
                            laboratories provide the perfect environment for academic growth.
                        </p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="img/high-level-description-a-wide-angle-arch_kpWTm3AoWAu6_xYDxvKoFw_kLTzOXOXTzqNJolieEm12g.jpg" class="d-block w-100" alt="Students">

                    <div class="carousel-caption d-none d-md-block">
                        <h5 class="fw-bold">Shape Your Future With Us</h5>
                        <p>
                            Join a vibrant campus community where knowledge, creativity,
                            and career opportunities come together to build tomorrow's leaders.
                        </p>
                    </div>
                </div>

            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>

            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>

        </div>


        <div class="top-bar">
            <div class="moving-text">
                <?php if (!empty($noticesrow)) { ?>
                    <?php foreach ($noticesrow as $notice) { ?>
                        <i class="bi bi-bell-fill"></i>
                        <span class="me-5">
                            <?= htmlspecialchars($notice['title']); ?>
                        </span>
                    <?php } ?>
                <?php } else { ?>
                    <span>No Notifications Available</span>
                <?php } ?>
            </div>
        </div>
    </div>
</section>



<section class="pb-4 bg-secondary-subtle" id="about">
    <div class="container">
        <div class="text-center">
            <h2 class="section-title">

            </h2>
        </div>

        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <img src="img/high-level-description-a-wide-angle-arch_7rMY6IOZX8-E-EQGsRQoow_kLTzOXOXTzqNJolieEm12g.jpg"
                    class="img-fluid rounded shadow">
            </div>

            <div class="col-lg-6" data-aos="fade-left">
                <h2 class="text-danger">Welcome to our college </h2>

                <p>
                    <span class="fw-bold">Youtube college of technology</span> provides quality education through experienced
                    faculty, modern laboratories, research opportunities,
                    innovation, and excellent campus facilities.
                </p>

                <p>
                    We offer undergraduate and postgraduate programs focused on
                    academic excellence and holistic student development.
                </p>

                <a href="#" class="btn btn-danger">
                    Read More
                </a>
            </div>

        </div>
    </div>
</section>


<!-- ========================================= -->
<!-- QUICK STATISTICS -->
<!-- ========================================= -->
<section class="py-3 bg-seconday-subtle">
    <div class="container">

        <div class="text-center mb-5">
            <span class="badge bg-danger px-3 py-2 mb-2">OUR ACHIEVEMENTS</span>
            <h2 class="fw-bold ">Quick Statistics</h2>
            <p class="text-secondary">
                Building future leaders through quality education, experienced faculty,
                and excellent placement opportunities.
            </p>
        </div>

        <div class="row g-4">

            <!-- Students -->
            <div class="col-6 col-md-4 col-lg-2" class="col-6 col-md-4 col-lg-2"
                data-aos="zoom-in-up"
                data-aos-duration="600"
                data-aos-delay="0">
                <div class="card border-0 shadow-sm h-100 text-center">
                    <div class="card-body">
                        <div class="display-5 text-danger mb-3">
                            <i class="bi bi-people-fill"></i>
                        </div>

                        <h3>
                            <span class="counter" data-target="5000">0</span>+
                        </h3>

                        <p class="text-secondary mb-0">
                            Students
                        </p>
                    </div>
                </div>
            </div>

            <!-- Faculty -->
            <div class="col-6 col-md-4 col-lg-2" class="col-6 col-md-4 col-lg-2"
                data-aos="zoom-in-up"
                data-aos-duration="600"
                data-aos-delay="50">
                <div class="card border-0 shadow-sm h-100 text-center">
                    <div class="card-body">
                        <div class="display-5 text-danger mb-3">
                            <i class="bi bi-person-workspace"></i>
                        </div>

                        <h3>
                            <span class="counter" data-target="250">0</span>+
                        </h3>

                        <p class="text-secondary mb-0">
                            Faculty
                        </p>
                    </div>
                </div>
            </div>

            <!-- Courses -->
            <div class="col-6 col-md-4 col-lg-2" class="col-6 col-md-4 col-lg-2"
                data-aos="zoom-in-up"
                data-aos-duration="600"
                data-aos-delay="200">
                <div class="card border-0 shadow-sm h-100 text-center">
                    <div class="card-body">
                        <div class="display-5 text-danger mb-3">
                            <i class="bi bi-book-half"></i>
                        </div>

                        <h3>
                            <span class="counter" data-target="40">0</span>+
                        </h3>

                        <p class="text-secondary mb-0">
                            Courses
                        </p>
                    </div>
                </div>
            </div>

            <!-- Placement -->
            <div class="col-6 col-md-4 col-lg-2" class="col-6 col-md-4 col-lg-2"
                data-aos="zoom-in-up"
                data-aos-duration="600"
                data-aos-delay="350">
                <div class="card border-0 shadow-sm h-100 text-center">
                    <div class="card-body">
                        <div class="display-5 text-danger mb-3">
                            <i class="bi bi-briefcase-fill"></i>
                        </div>

                        <h3>
                            <span class="counter" data-target="95">0</span>+
                        </h3>

                        <p class="text-secondary mb-0">
                            Placement
                        </p>
                    </div>
                </div>
            </div>

            <!-- Experience -->
            <div class="col-6 col-md-4 col-lg-2" class="col-6 col-md-4 col-lg-2"
                data-aos="zoom-in-up"
                data-aos-duration="600"
                data-aos-delay="500">
                <div class="card border-0 shadow-sm h-100 text-center">
                    <div class="card-body">
                        <div class="display-5 text-danger mb-3">
                            <i class="bi bi-building-fill"></i>
                        </div>

                        <h3>
                            <span class="counter" data-target="25">0</span>+
                        </h3>

                        <p class="text-secondary mb-0">
                            Years Experience
                        </p>
                    </div>
                </div>
            </div>

            <!-- Accreditation -->
            <div class="col-6 col-md-4 col-lg-2" class="col-6 col-md-4 col-lg-2"
                data-aos="zoom-in-up"
                data-aos-duration="600"
                data-aos-delay="650">
                <div class="card border-0 shadow-sm h-100 text-center">
                    <div class="card-body">
                        <div class="display-5 text-danger mb-3">
                            <i class="bi bi-award-fill"></i>
                        </div>

                        <h3 class="fw-bold text-danger mb-1">A+</h3>

                        <p class="text-secondary mb-0">
                            NAAC Grade
                        </p>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- ========================================= -->
<!-- ADMISSION OPEN -->
<!-- ========================================= -->



<section class="py-2 bg-secondary-subtle rounded-5 ">
    <div class="container mb-5">

        <div class="text-center mb-5" data-aos="fade-down">
            <h2 class="fw-bold ">Our Courses</h2>
            <p class="">
                Explore our wide range of undergraduate and postgraduate programs.
            </p>
        </div>


        <div class="row g-4">

            <div class="col-md-6 col-lg-4" data-aos="fade-right">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">B.Tech</h5>
                        <p class="card-text">
                            Engineering programs with specializations in Computer Science, Civil, Mechanical, and Electronics.
                        </p>
                        <a href="#" class="btn btn-danger">Learn More</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4" data-aos="fade" data-aos-delay="100">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">BCA</h5>
                        <p class="card-text">
                            Build a strong foundation in software development, programming, and IT technologies.
                        </p>
                        <a href="#" class="btn btn-danger">Learn More</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4" data-aos="fade-left">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">BBA</h5>
                        <p class="card-text">
                            Develop leadership, business management, and entrepreneurship skills.
                        </p>
                        <a href="#" class="btn btn-danger">Learn More</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4" data-aos="fade-right">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">B.Com</h5>
                        <p class="card-text">
                            Learn accounting, finance, taxation, and business law from experienced faculty.
                        </p>
                        <a href="#" class="btn btn-danger">Learn More</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4" data-aos="fade-up">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">B.Sc</h5>
                        <p class="card-text">
                            Science programs in Physics, Chemistry, Mathematics, Biology, and Computer Science.
                        </p>
                        <a href="#" class="btn btn-danger">Learn More</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4" data-aos="fade-left">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">MBA</h5>
                        <p class="card-text">
                            Advance your career with a Master's degree in Business Administration.
                        </p>
                        <a href="#" class="btn btn-danger">Learn More</a>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>


<!-- ========================================= -->
<!-- DEPARTMENTS -->
<!-- ========================================= -->
<section class="py-3 bg-light">
    <div class="container">

        <!-- Section Heading -->
        <div class="text-center mb-5" data-aos="fade-in">
            <span class="badge bg-danger px-3 py-2 mb-2">
                ACADEMIC DEPARTMENTS
            </span>

            <h2 class="fw-bold">Explore Our Departments</h2>

            <p class="text-secondary">
                Our academic departments provide industry-focused education,
                practical learning, and research opportunities to help students
                build successful careers.
            </p>
        </div>

        <div class="row g-4">

            <!-- Computer Science -->
            <div class="col-md-6 col-lg-4" data-aos="fade-right">
                <div class="card department-card shadow-sm border-0 h-100">

                    <img src="img/images.jpg"
                        class="card-img-top"
                        alt="Computer Science">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold mb-0">
                                <i class="bi bi-pc-display-horizontal text-danger me-2"></i>
                                Computer Science
                            </h5>

                            <span class="badge bg-danger">
                                6 Programs
                            </span>
                        </div>

                        <p class="text-secondary">
                            Learn programming, web development,
                            AI, cybersecurity and software engineering.
                        </p>

                        <ul class="list-group list-group-flush mb-3">

                            <li class="list-group-item px-0">
                                <i class="bi bi-check-circle-fill text-danger me-2"></i>
                                BCA & MCA
                            </li>

                            <li class="list-group-item px-0">
                                <i class="bi bi-check-circle-fill text-danger me-2"></i>
                                Modern Computer Labs
                            </li>

                            <li class="list-group-item px-0">
                                <i class="bi bi-check-circle-fill text-danger me-2"></i>
                                Experienced Faculty
                            </li>

                        </ul>

                        <a href="#" class="btn btn-outline-danger w-100">
                            View Department
                        </a>

                    </div>

                </div>
            </div>

            <!-- Commerce -->
            <div class="col-md-6 col-lg-4" data-aos="fade-up">
                <div class="card department-card shadow-sm border-0 h-100">

                    <img src="img/images (1).jpg"
                        class="card-img-top w-100"
                        alt="Commerce">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold mb-0">
                                <i class="bi bi-bank text-danger me-2"></i>
                                Commerce
                            </h5>

                            <span class="badge bg-danger">
                                4 Programs
                            </span>
                        </div>

                        <p class="text-secondary">
                            Develop expertise in accounting, finance,
                            taxation and business management.
                        </p>

                        <ul class="list-group list-group-flush mb-3">

                            <li class="list-group-item px-0">
                                <i class="bi bi-check-circle-fill text-danger me-2"></i>
                                B.Com & M.Com
                            </li>

                            <li class="list-group-item px-0">
                                <i class="bi bi-check-circle-fill text-danger me-2"></i>
                                Finance Lab
                            </li>

                            <li class="list-group-item px-0">
                                <i class="bi bi-check-circle-fill text-danger me-2"></i>
                                Industry Projects
                            </li>

                        </ul>

                        <a href="#" class="btn btn-outline-danger w-100">
                            View Department
                        </a>

                    </div>

                </div>
            </div>

            <!-- Management -->
            <div class="col-md-6 col-lg-4" data-aos="fade-left">
                <div class="card department-card shadow-sm border-0 h-100">

                    <img src="img/images (2).jpg"
                        class="card-img-top w-100"
                        alt="Management">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold mb-0">
                                <i class="bi bi-briefcase-fill text-danger me-2"></i>
                                Management
                            </h5>

                            <span class="badge bg-danger">
                                5 Programs
                            </span>
                        </div>

                        <p class="text-secondary">
                            Build leadership skills through practical
                            business education and internships.
                        </p>

                        <ul class="list-group list-group-flush mb-3">

                            <li class="list-group-item px-0">
                                <i class="bi bi-check-circle-fill text-danger me-2"></i>
                                BBA & MBA
                            </li>

                            <li class="list-group-item px-0">
                                <i class="bi bi-check-circle-fill text-danger me-2"></i>
                                Business Incubation
                            </li>

                            <li class="list-group-item px-0">
                                <i class="bi bi-check-circle-fill text-danger me-2"></i>
                                Placement Support
                            </li>

                        </ul>

                        <a href="#" class="btn btn-outline-danger w-100">
                            View Department
                        </a>

                    </div>

                </div>
            </div>

        </div>

        <!-- Bottom CTA -->
        <div class="text-center mt-5">

            <a href="#" class="btn btn-danger btn-lg me-2">
                View All Departments
            </a>

            <a href="#" class="btn btn-outline-danger btn-lg">
                Explore Courses
            </a>

        </div>

    </div>
</section>





<section class="py-3">
    <div class="container">

        <!-- Section Heading -->
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="badge bg-danger px-3 py-2 mb-2">
                CAMPUS FACILITIES
            </span>

            <h2 class="fw-bold">
                Why Choose Our College?
            </h2>

            <p class="text-secondary mx-auto" style="max-width:700px;">
                Our campus is equipped with modern infrastructure and
                student-friendly facilities to provide the best learning
                environment and an enjoyable campus life.
            </p>
        </div>

        <div class="row g-4">

            <!-- Library -->
            <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="100">
                <div class="card shadow-sm border-0 h-100 campus-card">
                    <img src="img/library-1.jpg" class="card-img-top" alt="Library">

                    <div class="card-body text-center">
                        <i class="bi bi-book-half display-5 text-danger"></i>

                        <h5 class="fw-bold mt-3">
                            Central Library
                        </h5>

                        <p class="text-secondary">
                            Thousands of books, journals and digital learning resources.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Computer Lab -->
            <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="200">
                <div class="card shadow-sm border-0 h-100 campus-card">
                    <img src="img/IMG_2174.jpg" class="card-img-top" alt="Computer Lab">

                    <div class="card-body text-center">
                        <i class="bi bi-pc-display display-5 text-danger"></i>

                        <h5 class="fw-bold mt-3">
                            Computer Labs
                        </h5>

                        <p class="text-secondary">
                            Modern computers with high-speed internet and latest software.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Smart Classrooms -->
            <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="300">
                <div class="card shadow-sm border-0 h-100 campus-card">
                    <img src="img/images (3).jpg" class="card-img-top" alt="Classroom">

                    <div class="card-body text-center">
                        <i class="bi bi-display display-5 text-danger"></i>

                        <h5 class="fw-bold mt-3">
                            Smart Classrooms
                        </h5>

                        <p class="text-secondary">
                            Digital classrooms with projectors and interactive learning.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Hostel -->
            <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="400">
                <div class="card shadow-sm border-0 h-100 campus-card">
                    <img src="img/images (4).jpg" class="card-img-top" alt="Hostel">

                    <div class="card-body text-center">
                        <i class="bi bi-house-door-fill display-5 text-danger"></i>

                        <h5 class="fw-bold mt-3">
                            Hostel
                        </h5>

                        <p class="text-secondary">
                            Safe and comfortable accommodation for boys and girls.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Sports -->
            <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="500">
                <div class="card shadow-sm border-0 h-100 campus-card">
                    <img src="img/sport.jpg" class="card-img-top" alt="Sports">

                    <div class="card-body text-center">
                        <i class="bi bi-trophy-fill display-5 text-danger"></i>

                        <h5 class="fw-bold mt-3">
                            Sports Complex
                        </h5>

                        <p class="text-secondary">
                            Indoor and outdoor sports facilities for all students.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Cafeteria -->
            <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="600">
                <div class="card shadow-sm border-0 h-100 campus-card">
                    <img src="img/cafeteria.jpg" class="card-img-top" alt="Cafeteria">

                    <div class="card-body text-center">
                        <i class="bi bi-cup-hot-fill display-5 text-danger"></i>

                        <h5 class="fw-bold mt-3">
                            Cafeteria
                        </h5>

                        <p class="text-secondary">
                            Hygienic food court serving healthy meals and snacks.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Transport -->
            <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="700">
                <div class="card shadow-sm border-0 h-100 campus-card">
                    <img src="img/transport.jpg" class="card-img-top" alt="Transport">

                    <div class="card-body text-center">
                        <i class="bi bi-bus-front-fill display-5 text-danger"></i>

                        <h5 class="fw-bold mt-3">
                            Transport
                        </h5>

                        <p class="text-secondary">
                            Bus facilities covering major routes across the city.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Wi-Fi -->
            <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="800">
                <div class="card shadow-sm border-0 h-100 campus-card">
                    <img src="img/wifi.jpg" class="card-img-top" alt="WiFi">

                    <div class="card-body text-center">
                        <i class="bi bi-wifi display-5 text-danger"></i>

                        <h5 class="fw-bold mt-3">
                            Wi-Fi Campus
                        </h5>

                        <p class="text-secondary">
                            High-speed Wi-Fi connectivity available across the campus.
                        </p>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>



<section class="py-5  bg-secondary-subtle">
    <div class="container">

        <!-- Heading -->
        <div class="text-center mb-5">
            <span class="badge bg-danger px-3 py-2 mb-2">
                OUR FACULTY
            </span>

            <h2 class="fw-bold">Meet Our Expert Faculty</h2>

            <p class="text-secondary mx-auto" style="max-width:700px;">
                Our experienced faculty members are dedicated to delivering
                quality education, innovative research, and mentorship that
                prepares students for successful careers.
            </p>
        </div>

        <div class="row g-4">

            <!-- Faculty 1 -->
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="0">
                <div class="card faculty-card border-0 shadow-sm h-100">

                    <img src="img/download (5).jpg" class="faculty-img" alt="Faculty">

                    <div class="card-body text-center">

                        <h5 class="fw-bold mb-1">Dr. Nirmala Sitharaman</h5>

                        <span class="badge bg-danger mb-3">
                            Professor
                        </span>

                        <p class="text-muted small mb-3">
                            Department of Computer Science
                        </p>

                        <div class="d-flex justify-content-center gap-3">

                            <a href="#" class="text-danger fs-5">
                                <i class="bi bi-envelope-fill"></i>
                            </a>

                            <a href="#" class="text-primary fs-5">
                                <i class="bi bi-linkedin"></i>
                            </a>

                            <a href="#" class="text-dark fs-5">
                                <i class="bi bi-globe"></i>
                            </a>

                        </div>

                    </div>

                </div>
            </div>

            <!-- Faculty 2 -->
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="150">
                <div class="card faculty-card border-0 shadow-sm h-100">

                    <img src="img/Modi I love Rahul Gandhi t shirt 👕🎽.jpg" class="faculty-img" alt="Faculty">

                    <div class="card-body text-center">

                        <h5 class="fw-bold mb-1">Dr. Meowdi</h5>

                        <span class="badge bg-danger mb-3">
                            Associate Professor
                        </span>

                        <p class="text-muted small mb-3">
                            Department of Commerce
                        </p>
                        <p class="text-muted small mb-3">
                            Aṅgena gātraṁ, nayanena vaktraṁ Nyāyena rājyaṁ, lavaṇena bhojyam

                        </p>

                        <div class="d-flex justify-content-center gap-3">

                            <a href="#" class="text-danger fs-5">
                                <i class="bi bi-envelope-fill"></i>
                            </a>

                            <a href="#" class="text-primary fs-5">
                                <i class="bi bi-linkedin"></i>
                            </a>

                            <a href="#" class="text-dark fs-5">
                                <i class="bi bi-globe"></i>
                            </a>

                        </div>

                    </div>

                </div>
            </div>

            <!-- Faculty 3 -->
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                <div class="card faculty-card border-0 shadow-sm h-100">

                    <img src="img/Bapuji 😂👁️.jpg" class="faculty-img" alt="Faculty">

                    <div class="card-body text-center">

                        <h5 class="fw-bold mb-1">Dr. Champaklal</h5>

                        <span class="badge bg-danger mb-3">
                            HOD
                        </span>

                        <p class="text-muted small mb-3">
                            Department of Management
                        </p>

                        <div class="d-flex justify-content-center gap-3">

                            <a href="#" class="text-danger fs-5">
                                <i class="bi bi-envelope-fill"></i>
                            </a>

                            <a href="#" class="text-primary fs-5">
                                <i class="bi bi-linkedin"></i>
                            </a>

                            <a href="#" class="text-dark fs-5">
                                <i class="bi bi-globe"></i>
                            </a>

                        </div>

                    </div>

                </div>
            </div>

            <!-- Faculty 4 -->
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="450">
                <div class="card faculty-card border-0 shadow-sm h-100 ">

                    <img src="img/Hain.jpg" class="faculty-img" alt="Faculty">

                    <div class="card-body text-center">

                        <h5 class="fw-bold mb-1">Dr. Acp Pradyuman</h5>

                        <span class="badge bg-danger mb-3">
                            Assistant Professor
                        </span>

                        <p class="text-muted small mb-3">
                            Department of Arts
                        </p>
                        <p class="text-muted small mb-3">
                            Padhne likhne ki umr h
                        </p>

                        <div class="d-flex justify-content-center gap-3">

                            <a href="#" class="text-danger fs-5">
                                <i class="bi bi-envelope-fill"></i>
                            </a>

                            <a href="#" class="text-primary fs-5">
                                <i class="bi bi-linkedin"></i>
                            </a>

                            <a href="#" class="text-dark fs-5">
                                <i class="bi bi-globe"></i>
                            </a>

                        </div>

                    </div>

                </div>
            </div>

        </div>

        <div class="text-center mt-5">
            <a href="#" class="btn btn-danger btn-lg">
                View All Faculty
            </a>
        </div>

    </div>
</section>


<section>



    <div class="py-5 bg-light ">
        <div class="container">

            <div class="text-center mb-5" data-aos="zoom-in">
                <h2 class="fw-bold text-black">Events in College</h2>
                <p class=" text-black">
                    Be part of exciting cultural festivals, technical events, sports competitions, workshops, seminars, and celebrations that make every moment memorable.
                </p>
            </div>
            <div class="row g-4">


                <div class="col-md-6 col-lg-4" data-aos="fade-right">
                    <div class="card border-0 shadow-sm h-100">
                        <img src="https://images.unsplash.com/photo-1511578314322-379afb476865?w=800"
                            class="card-img-top" alt="Annual Tech Fest">

                        <div class="card-body">

                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-danger text-white rounded text-center p-2 me-3" style="width:65px;">
                                    <h4 class="mb-0">15</h4>
                                    <small>Aug</small>
                                </div>

                                <div>
                                    <h5 class="mb-1">Annual Tech Fest 2026</h5>
                                    <small class="text-muted">
                                        📍 Main Auditorium
                                    </small>
                                </div>
                            </div>

                            <p class="text-muted">
                                Explore innovation, coding competitions, robotics exhibitions,
                                and inspiring keynote sessions from industry experts.
                            </p>

                        </div>

                        <div class="card-footer bg-white border-0">
                            <a href="#" class="btn btn-outline-danger w-100">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4" data-aos="zoom-in">
                    <div class="card border-0 shadow-sm h-100">
                        <img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=800"
                            class="card-img-top" alt="Cultural Fest">

                        <div class="card-body">

                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-danger text-white rounded text-center p-2 me-3" style="width:65px;">
                                    <h4 class="mb-0">28</h4>
                                    <small>Sep</small>
                                </div>

                                <div>
                                    <h5 class="mb-1">Cultural Festival</h5>
                                    <small class="text-muted">
                                        📍 College Ground
                                    </small>
                                </div>
                            </div>

                            <p class="text-muted">
                                Celebrate music, dance, drama, fashion shows, and cultural performances
                                by talented students from different departments.
                            </p>

                        </div>

                        <div class="card-footer bg-white border-0">
                            <a href="#" class="btn btn-outline-danger w-100">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4" data-aos="fade-left">
                    <div class="card border-0 shadow-sm h-100">
                        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800"
                            class="card-img-top" alt="Career Fair">

                        <div class="card-body">

                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-danger text-white rounded text-center p-2 me-3" style="width:65px;">
                                    <h4 class="mb-0">10</h4>
                                    <small>Oct</small>
                                </div>

                                <div>
                                    <h5 class="mb-1">Career & Placement Fair</h5>
                                    <small class="text-muted">
                                        📍 Placement Cell
                                    </small>
                                </div>
                            </div>

                            <p class="text-muted">
                                Meet top recruiters, attend career guidance sessions,
                                and explore internship and placement opportunities.
                            </p>

                        </div>

                        <div class="card-footer bg-white border-0">
                            <a href="#" class="btn btn-outline-danger w-100">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>

            </div>
            <div class="text-center mt-5">
                <a href="#" class="btn btn-outline-dark btn-lg px-4">
                    View All Events
                </a>
            </div>

        </div>
</section>

<!-- ========================================= -->
<!-- PLACEMENTS -->
<!-- ========================================= -->
<section class="py-3 bg-secondary-subtle     pb-5">
    <div class="container">

        <!-- Section Heading -->
        <div class="text-center mb-5">
            <span class="badge bg-danger px-3 py-2 mb-2">
                TRAINING & PLACEMENT
            </span>

            <h2 class="fw-bold">
                Excellent Placement Opportunities
            </h2>

            <p class="text-secondary mx-auto" style="max-width:700px;">
                Our dedicated Training & Placement Cell prepares students
                for successful careers through skill development, internships,
                campus recruitment drives, and industry partnerships.
            </p>
        </div>

        <!-- Statistics -->
        <div class="row g-4 mb-5">

            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm text-center h-100">
                    <div class="card-body">

                        <i class="bi bi-graph-up-arrow display-4 text-danger"></i>

                        <h2 class="fw-bold text-danger mt-3">
                            95%
                        </h2>

                        <p class="mb-0">
                            Placement Rate
                        </p>

                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm text-center h-100">
                    <div class="card-body">

                        <i class="bi bi-currency-rupee display-4 text-danger"></i>

                        <h2 class="fw-bold text-danger mt-3">
                            ₹18 LPA
                        </h2>

                        <p class="mb-0">
                            Highest Package
                        </p>

                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm text-center h-100">
                    <div class="card-body">

                        <i class="bi bi-briefcase-fill display-4 text-danger"></i>

                        <h2 class="fw-bold text-danger mt-3">
                            250+
                        </h2>

                        <p class="mb-0">
                            Recruiters
                        </p>

                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm text-center h-100">
                    <div class="card-body">

                        <i class="bi bi-people-fill display-4 text-danger"></i>

                        <h2 class="fw-bold text-danger mt-3">
                            1500+
                        </h2>

                        <p class="mb-0">
                            Students Placed
                        </p>

                    </div>
                </div>
            </div>

        </div>



    </div>
</section>
<section class="py-5">
    <div class="card w-100  border-0">
        <div class="card-body">
            <div class="text-center mb-4">
                <h4 class="fw-bold">
                    Our Top Recruiters
                </h4>
            </div>
            <div class="row g-3 text-center">
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="border rounded p-3 bg-white">
                        <img src="img/tcs.jpg" class="w-25" alt="">
                        <!-- <h6 class="mb-0 fw-bold">TCS</h6>
                         -->
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="border rounded p-3 bg-white">
                        <img src="img/Infosys.png" class="w-25" alt="">
                        <!-- <h6 class="mb-0 fw-bold">Infosys</h6> -->
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="border rounded p-3 bg-white">
                        <img src="img/wipro_logo_new.webp" class="w-25" alt="">
                        <!-- <h6 class="mb-0 fw-bold">Wipro</h6> -->
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="border rounded p-3 bg-white">
                        <img src="img/ava.png" class="w-25" alt="">
                        <!-- <h6 class="mb-0 fw-bold">Accenture</h6> -->
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="border rounded p-3 bg-white">
                        <h6 class="mb-0 fw-bold">Capgemini</h6>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="border rounded p-3 bg-white">
                        <h6 class="mb-0 fw-bold">HCL</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h1 class="modal-title fs-5 text-white " id="exampleModalLabel">College Notification</h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    <div>
                        <div>
                            <div>
                                <div>
                                    <div class="row g-2">
                                        <?php if (count($notices) > 0) { ?>
                                            <?php foreach ($notices as $notice) { ?>
                                                <div class="list-group list-group-flush" data-aos="zoom-in-up">
                                                    <div class="list-group-item shadow-sm">
                                                        <div class="d-flex justify-content-between">
                                                            <h5 class="mb-1 text-dark ">
                                                                <?= htmlspecialchars($notice['title']); ?>
                                                            </h5>

                                                            <?php if (!empty($notice['link'])) { ?>
                                                                <a href="<?= htmlspecialchars($notice['link']); ?>"
                                                                    target="_blank"
                                                                    class="btn btn-outline-danger btn-sm">
                                                                    Check more information
                                                                </a>
                                                            <?php } ?>
                                                            <small class="text-muted">05 Jul 2026</small>
                                                        </div>
                                                        <p class="mb-1">
                                                            <?= nl2br(htmlspecialchars($notice['body'])); ?>
                                                        </p>
                                                    </div>
                                                </div>

                                            <?php } ?>

                                        <?php } else { ?>

                                            <div class="col-12">
                                                <div class="alert alert-info text-center">
                                                    No Notices Available.
                                                </div>
                                            </div>

                                        <?php } ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>







<?php
include "footer.php";
?>