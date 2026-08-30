<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>College | Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/2.3.8/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Custom scrollbar for sidebar */
        #sidebar .overflow-y-auto::-webkit-scrollbar {
            width: 5px;
        }

        #sidebar .overflow-y-auto::-webkit-scrollbar-thumb {
            background-color: #495057;
            border-radius: 10px;
        }

        /* Rotate chevron icon on collapse open */
        .nav-link[data-bs-toggle="collapse"][aria-expanded="true"] .bi-chevron-down {
            transform: rotate(180deg);
            transition: transform 0.3s ease;
        }

        .nav-link[data-bs-toggle="collapse"] .bi-chevron-down {
            transition: transform 0.3s ease;
        }
    </style>
</head>

<body>
    <div class="wrapper d-flex vh-100 overflow-hidden">

        <!-- SIDEBAR -->
        <aside id="sidebar" class="bg-dark text-white flex-shrink-0" style="width: 264px;">
            <div class="d-flex flex-column h-100 p-3">

                <!-- 1. FIXED TOP: College Brand -->
                <a href="dashboard.php" class="d-flex align-items-center text-white text-decoration-none px-2 mb-3">
                    <i class="bi bi-building-fill fs-3 me-2 text-primary"></i>
                    <span class="fs-4 fw-bold">College ERP</span>
                </a>
                <hr class="my-2 border-secondary">

                <!-- 2. SCROLLABLE MIDDLE: Menu Items -->
                <div class="flex-grow-1 overflow-y-auto pe-1 my-2">
                    <ul class="nav nav-pills flex-column gap-1">

                        <!-- Dashboard -->
                        <li class="nav-item">
                            <a href="dashboard.php" class="nav-link <?= ($current_page == 'dashboard.php') ? 'active' : 'text-white'; ?>">
                                <i class="bi bi-speedometer2 me-2"></i> Dashboard
                            </a>
                        </li>

                        <!-- Academic Setup -->
                        <li class="nav-item">
                            <a class="nav-link text-white d-flex justify-content-between align-items-center"
                                data-bs-toggle="collapse" href="#academicSetupMenu" role="button"
                                aria-expanded="<?= in_array($current_page, ['collegesetup.php', 'departments.php', 'courses.php', 'semsters.php', 'sections.php', 'subject.php']) ? 'true' : 'false'; ?>">
                                <span><i class="bi bi-gear-fill me-2 text-warning"></i> Academic Setup</span>
                                <i class="bi bi-chevron-down small"></i>
                            </a>
                            <div class="collapse <?= in_array($current_page, ['collegesetup.php', 'departments.php', 'courses.php', 'semsters.php', 'sections.php', 'subject.php']) ? 'show' : ''; ?>" id="academicSetupMenu">
                                <ul class="nav flex-column ms-3 mt-1 gap-1">
                                    <li><a href="collegesetup.php" class="nav-link text-white-50 <?= ($current_page == 'collegesetup.php') ? 'active text-white' : ''; ?>"><i class="bi bi-sliders me-2"></i>College Setup</a></li>
                                    <li><a href="departments.php" class="nav-link text-white-50 <?= ($current_page == 'departments.php') ? 'active text-white' : ''; ?>"><i class="bi bi-diagram-3 me-2"></i>Departments</a></li>
                                    <li><a href="semsters.php" class="nav-link text-white-50 <?= ($current_page == 'semsters.php') ? 'active text-white' : ''; ?>"><i class="bi bi-calendar3 me-2"></i>Semesters</a></li>
                                    <li><a href="courses.php" class="nav-link text-white-50 <?= ($current_page == 'courses.php') ? 'active text-white' : ''; ?>"><i class="bi bi-journal-bookmark me-2"></i>Courses</a></li>
                                    <li><a href="sections.php" class="nav-link text-white-50 <?= ($current_page == 'sections.php') ? 'active text-white' : ''; ?>"><i class="bi bi-view-list me-2"></i>Sections</a></li>
                                    <li><a href="syllbus.php" class="nav-link text-white-50 <?= ($current_page == 'syllbus.php') ? 'active text-white' : ''; ?>"><i class="bi bi-book me-2"></i>Subjects & Syllabus</a></li>
                                </ul>
                            </div>
                        </li>

                        <!-- Student Management -->
                        <li class="nav-item">
                            <a class="nav-link text-white d-flex justify-content-between align-items-center"
                                data-bs-toggle="collapse" href="#studentMenu" role="button"
                                aria-expanded="<?= in_array($current_page, ['student.php', 'AddStudent.php', 'studentprofile.php']) ? 'true' : 'false'; ?>">
                                <span><i class="bi bi-people-fill me-2 text-info"></i> Students Info</span>
                                <i class="bi bi-chevron-down small"></i>
                            </a>
                            <div class="collapse <?= in_array($current_page, ['student.php', 'AddStudent.php', 'studentprofile.php']) ? 'show' : ''; ?>" id="studentMenu">
                                <ul class="nav flex-column ms-3 mt-1 gap-1">
                                    <li><a href="AddStudent.php" class="nav-link text-white-50 <?= ($current_page == 'AddStudent.php') ? 'active text-white' : ''; ?>"><i class="bi bi-person-plus-fill me-2"></i>Add Student</a></li>
                                    <li><a href="student.php" class="nav-link text-white-50 <?= ($current_page == 'student.php') ? 'active text-white' : ''; ?>"><i class="bi bi-list-ul me-2"></i>Students List</a></li>
                                    <li><a href="studentprofile.php" class="nav-link text-white-50 <?= ($current_page == 'studentprofile.php') ? 'active text-white' : ''; ?>"><i class="bi bi-person-badge me-2"></i>Student Profiles</a></li>
                                </ul>
                            </div>
                        </li>

                        <!-- Admissions Management -->
                        <li class="nav-item">
                            <a class="nav-link text-white d-flex justify-content-between align-items-center"
                                data-bs-toggle="collapse" href="#admissionsMenu" role="button"
                                aria-expanded="<?= in_array($current_page, ['onlineadmisson.php', 'admission_list.php', 'Pendingapplication.php']) ? 'true' : 'false'; ?>">
                                <span><i class="bi bi-card-checklist me-2 text-success"></i> Admissions</span>
                                <i class="bi bi-chevron-down small"></i>
                            </a>
                            <div class="collapse <?= in_array($current_page, ['onlineadmisson.php', 'admission_list.php', 'Pendingapplication.php']) ? 'show' : ''; ?>" id="admissionsMenu">
                                <ul class="nav flex-column ms-3 mt-1 gap-1">
                                    <li><a href="onlineadmisson.php" class="nav-link text-white-50 <?= ($current_page == 'onlineadmisson.php') ? 'active text-white' : ''; ?>"><i class="bi bi-globe me-2"></i>Online Inquiries</a></li>
                                    <li><a href="admission_list.php" class="nav-link text-white-50 <?= ($current_page == 'admission_list.php') ? 'active text-white' : ''; ?>"><i class="bi bi-card-text me-2"></i>All Applications</a></li>
                                    <li><a href="Pendingapplication.php" class="nav-link text-white-50 <?= ($current_page == 'Pendingapplication.php') ? 'active text-white' : ''; ?>"><i class="bi bi-clock-history me-2"></i>Pending Apps</a></li>
                                </ul>
                            </div>
                        </li>

                        <!-- Staff & Teachers -->
                        <li class="nav-item">
                            <a href="teacher.php" class="nav-link <?= ($current_page == 'teacher.php' || $current_page == 'teachers.php') ? 'active' : 'text-white'; ?>">
                                <i class="bi bi-person-workspace me-2 text-danger"></i> Teachers & Staff
                            </a>
                        </li>

                        <!-- Attendance -->
                        <li class="nav-item">
                            <a href="teacher_attendance.php" class="nav-link <?= ($current_page == 'teacher_attendance.php') ? 'active' : 'text-white'; ?>">
                                <i class="bi bi-calendar-check me-2 text-primary"></i> Attendance
                            </a>
                        </li>

                        <!-- Timetable -->
                        <li class="nav-item">
                            <a href="timetable.php" class="nav-link <?= ($current_page == 'timetable.php') ? 'active' : 'text-white'; ?>">
                                <i class="bi bi-table me-2 text-info"></i>
                                 Time Table
                            </a>
                        </li>

                        <!-- Examinations & Results -->
                        <li class="nav-item">
                            <a class="nav-link text-white d-flex justify-content-between align-items-center"
                                data-bs-toggle="collapse" href="#examMenu" role="button">
                                <span><i class="bi bi-file-earmark-spreadsheet me-2 text-warning"></i> Examinations</span>
                                <i class="bi bi-chevron-down small"></i>
                            </a>
                            <div class="collapse <?= in_array($current_page, ['exams.php', 'results.php']) ? 'show' : ''; ?>" id="examMenu">
                                <ul class="nav flex-column ms-3 mt-1 gap-1">
                                    <li><a href="exams.php" class="nav-link text-white-50 <?= ($current_page == 'exams.php') ? 'active text-white' : ''; ?>"><i class="bi bi-pencil-square me-2"></i>Exam Schedule</a></li>
                                    <li><a href="results.php" class="nav-link text-white-50 <?= ($current_page == 'results.php') ? 'active text-white' : ''; ?>"><i class="bi bi-award me-2"></i>Results & Marks</a></li>
                                </ul>
                            </div>
                        </li>

                        <!-- Fees & Finance -->
                        <li class="nav-item">
                            <a class="nav-link text-white d-flex justify-content-between align-items-center"
                                data-bs-toggle="collapse" href="#financeMenu" role="button">
                                <span><i class="bi bi-cash-stack me-2 text-success"></i> Finance</span>
                                <i class="bi bi-chevron-down small"></i>
                            </a>
                            <div class="collapse <?= in_array($current_page, ['fees.php', 'accounts.php', 'payroll.php']) ? 'show' : ''; ?>" id="financeMenu">
                                <ul class="nav flex-column ms-3 mt-1 gap-1">
                                    <li><a href="fees.php" class="nav-link text-white-50 <?= ($current_page == 'fees.php') ? 'active text-white' : ''; ?>"><i class="bi bi-wallet2 me-2"></i>Fees Management</a></li>
                                    <li><a href="accounts.php" class="nav-link text-white-50 <?= ($current_page == 'accounts.php') ? 'active text-white' : ''; ?>"><i class="bi bi-calculator me-2"></i>Accounts & Expenses</a></li>
                                    <li><a href="payroll.php" class="nav-link text-white-50 <?= ($current_page == 'payroll.php') ? 'active text-white' : ''; ?>"><i class="bi bi-receipt me-2"></i>HR & Payroll</a></li>
                                </ul>
                            </div>
                        </li>

                        <!-- Facilities (Library, Hostel, Transport) -->
                        <li class="nav-item">
                            <a class="nav-link text-white d-flex justify-content-between align-items-center"
                                data-bs-toggle="collapse" href="#facilitiesMenu" role="button">
                                <span><i class="bi bi-building me-2 text-secondary"></i> Facilities</span>
                                <i class="bi bi-chevron-down small"></i>
                            </a>
                            <div class="collapse <?= in_array($current_page, ['library.php', 'hostel.php', 'transport.php']) ? 'show' : ''; ?>" id="facilitiesMenu">
                                <ul class="nav flex-column ms-3 mt-1 gap-1">
                                    <li><a href="library.php" class="nav-link text-white-50 <?= ($current_page == 'library.php') ? 'active text-white' : ''; ?>"><i class="bi bi-book-half me-2"></i>Library</a></li>
                                    <li><a href="hostel.php" class="nav-link text-white-50 <?= ($current_page == 'hostel.php') ? 'active text-white' : ''; ?>"><i class="bi bi-house-door me-2"></i>Hostel</a></li>
                                    <li><a href="transport.php" class="nav-link text-white-50 <?= ($current_page == 'transport.php') ? 'active text-white' : ''; ?>"><i class="bi bi-bus-front me-2"></i>Transport</a></li>
                                </ul>
                            </div>
                        </li>

                        <!-- Communication & Others -->
                        <li class="nav-item">
                            <a href="notice.php" class="nav-link <?= ($current_page == 'notice.php') ? 'active' : 'text-white'; ?>">
                                <i class="bi bi-megaphone me-2"></i> Notice Board
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="events.php" class="nav-link <?= ($current_page == 'events.php') ? 'active' : 'text-white'; ?>">
                                <i class="bi bi-calendar-event me-2"></i> Events & Placement
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="settings.php" class="nav-link <?= ($current_page == 'settings.php') ? 'active' : 'text-white'; ?>">
                                <i class="bi bi-shield-lock me-2"></i> Roles & Permissions
                            </a>
                        </li>

                    </ul>
                </div>

                <hr class="my-2 border-secondary">

                <!-- 3. FIXED BOTTOM: Profile -->
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle p-1" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://github.com/mdo.png" alt="User" width="32" height="32" class="rounded-circle me-2 border border-secondary">
                        <strong>Admin User</strong>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                        <li><a class="dropdown-item" href="settings.php"><i class="bi bi-gear me-2"></i> Settings</a></li>
                        <li><a class="dropdown-item" href="profile.php"><i class="bi bi-person me-2"></i> Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item text-danger" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i> Sign out</a></li>
                    </ul>
                </div>

            </div>
        </aside>

        <!-- MAIN CONTENT AREA -->
        <div class="main flex-grow-1 d-flex flex-column overflow-y-auto">

            <!-- NAVBAR -->
            <nav class="navbar navbar-expand bg-dark navbar-dark px-3 sticky-top shadow-sm">

                <button class="btn btn-outline-light btn-sm me-3" id="sidebar-toggle">
                    <i class="bi bi-list fs-5"></i>
                </button>

                <!-- Right Menu Nav -->
                <div class="d-flex align-items-center gap-2 ms-auto">

                    <!-- Notification Icon -->
                    <div class="dropdown">
                        <button class="btn btn-dark position-relative border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-bell fs-5"></i>
                            <span class="position-absolute top-2 start-75 translate-middle p-1 bg-danger border border-dark rounded-circle">
                                <span class="visually-hidden">New alerts</span>
                            </span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow mt-2">
                            <li>
                                <h6 class="dropdown-header">Notifications</h6>
                            </li>
                            <li><a class="dropdown-item small" href="#">1 New Inquiry Received</a></li>
                            <li><a class="dropdown-item small" href="#">Fee Payment Pending</a></li>
                        </ul>
                    </div>

                    <!-- User Profile -->
                    <div class="d-flex align-items-center ms-2">
                        <img src="https://github.com/mdo.png" alt="Profile" class="rounded-circle border border-light" style="width: 36px; height: 36px;">
                        <span class="text-white fw-semibold ms-2 d-none d-md-inline">Administrator</span>
                    </div>

                    <!-- Action Dropdown -->
                    <div class="dropdown ms-1">
                        <button class="btn btn-dark p-1 border-0" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots-vertical fs-5 text-white"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow mt-2">
                            <li><a class="dropdown-item" href="settings.php"><i class="bi bi-gear me-2"></i> Settings</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-danger" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
                        </ul>
                    </div>

                </div>
            </nav>

            <!-- Page Content will go here -->