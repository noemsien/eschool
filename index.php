<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-School</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <span class="material-icons-outlined">school</span>
                    <h2>CMS</h2>
                </div>
                <span class="material-icons-outlined close-sidebar">close</span>
            </div>
            <ul class="sidebar-menu">
                <li class="menu-item active" data-section="overview">
                    <span class="material-icons-outlined">dashboard</span>
                    <h3>Overview</h3>
                </li>
                <li class="menu-item" data-section="students">
                    <span class="material-icons-outlined">groups</span>
                    <h3>Students</h3>
                </li>
                <li class="menu-item" data-section="courses">
                    <span class="material-icons-outlined">menu_book</span>
                    <h3>Courses</h3>
                </li>
                <li class="menu-item" data-section="teachers">
                    <span class="material-icons-outlined">person</span>
                    <h3>Teachers</h3>
                </li>
                <li class="menu-item" data-section="admissions">
                    <span class="material-icons-outlined">how_to_reg</span>
                    <h3>Admissions</h3>
                </li>
                <li class="menu-item" data-section="settings">
                    <span class="material-icons-outlined">settings</span>
                    <h3>Settings</h3>
                </li>
                <li class="menu-item" data-section="logout">
                    <span class="material-icons-outlined">logout</span>
                    <h3>Logout</h3>
                </li>
            </ul>
        </aside>

        <main class="main-content">
            <header class="main-header">
                <div class="menu-icon">
                    <span class="material-icons-outlined">menu</span>
                </div>
                <div class="header-right">
                    <input type="text" placeholder="Search...">
                    <span class="material-icons-outlined">notifications</span>
                    <span class="material-icons-outlined">account_circle</span>
                </div>
            </header>

            <section id="overview" class="dashboard-section active">
                <h2>Overview</h2>
                <div class="overview-cards">
                    <div class="card">
                        <div class="card-icon"><span class="material-icons-outlined">groups</span></div>
                        <div class="card-content">
                            <h3>Total Students</h3>
                            <p id="totalStudents">0</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-icon"><span class="material-icons-outlined">menu_book</span></div>
                        <div class="card-content">
                            <h3>Total Courses</h3>
                            <p id="totalCourses">0</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-icon"><span class="material-icons-outlined">person</span></div>
                        <div class="card-content">
                            <h3>Total Teachers</h3>
                            <p id="totalTeachers">0</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-icon"><span class="material-icons-outlined">how_to_reg</span></div>
                        <div class="card-content">
                            <h3>Pending Admissions</h3>
                            <p id="pendingAdmissions">0</p>
                        </div>
                    </div>
                </div>

                <div class="recent-activities">
                    <h3>Recent Activities</h3>
                    <ul id="activityList">
                        </ul>
                </div>
            </section>

            <section id="students" class="dashboard-section">
                <h2>Students Management</h2>
                <button class="add-new-btn" id="addStudentBtn">Add New Student</button>

                <div class="form-popup" id="addStudentFormPopup">
                    <div class="form-container">
                        <h3>Add New Student</h3>
                        <form id="addStudentForm">
                            <label for="studentName"><b>Student Name</b></label>
                            <input type="text" placeholder="Enter Student Name" name="studentName" id="studentName" required>

                            <label for="studentEmail"><b>Email</b></label>
                            <input type="email" placeholder="Enter Email" name="studentEmail" id="studentEmail" required>

                            <label for="studentCourse"><b>Course</b></label>
                            <input type="text" placeholder="Enter Course" name="studentCourse" id="studentCourse" required>

                            <button type="submit" class="btn submit-btn">Add Student</button>
                            <button type="button" class="btn cancel-btn" id="cancelAddStudent">Cancel</button>
                        </form>
                    </div>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Course</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="studentsTableBody">
                            </tbody>
                    </table>
                </div>
            </section>

            <section id="courses" class="dashboard-section">
                <h2>Courses Management</h2>
                 <button class="add-new-btn" id="addCourseBtn">Add New Course</button>

                <div class="form-popup" id="addCourseFormPopup">
                    <div class="form-container">
                        <h3>Add New Course</h3>
                        <form id="addCourseForm">
                            <label for="courseTitle"><b>Course Title</b></label>
                            <input type="text" placeholder="Enter Course Title" name="courseTitle" id="courseTitle" required>

                            <label for="courseCredits"><b>Credits</b></label>
                            <input type="text" placeholder="Enter Credits (e.g., 3)" name="courseCredits" id="courseCredits" required>

                            <label for="courseDepartment"><b>Department</b></label>
                            <input type="text" placeholder="Enter Department" name="courseDepartment" id="courseDepartment" required>

                            <button type="submit" class="btn submit-btn">Add Course</button>
                            <button type="button" class="btn cancel-btn" id="cancelAddCourse">Cancel</button>
                        </form>
                    </div>
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Credits</th>
                                <th>Department</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="coursesTableBody">
                            </tbody>
                    </table>
                </div>
            </section>

            <section id="teachers" class="dashboard-section">
                <h2>Teachers Management</h2>
                 <button class="add-new-btn" id="addTeacherBtn">Add New Teacher</button>

                <div class="form-popup" id="addTeacherFormPopup">
                    <div class="form-container">
                        <h3>Add New Teacher</h3>
                        <form id="addTeacherForm">
                            <label for="teacherName"><b>Teacher Name</b></label>
                            <input type="text" placeholder="Enter Teacher Name" name="teacherName" id="teacherName" required>

                            <label for="teacherEmail"><b>Email</b></label>
                            <input type="email" placeholder="Enter Email" name="teacherEmail" id="teacherEmail" required>

                            <label for="teacherDepartment"><b>Department</b></label>
                            <input type="text" placeholder="Enter Department" name="teacherDepartment" id="teacherDepartment" required>

                            <button type="submit" class="btn submit-btn">Add Teacher</button>
                            <button type="button" class="btn cancel-btn" id="cancelAddTeacher">Cancel</button>
                        </form>
                    </div>
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Department</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="teachersTableBody">
                            </tbody>
                    </table>
                </div>
            </section>

            <section id="admissions" class="dashboard-section">
                <h2>Admissions</h2>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Application ID</th>
                                <th>Student Name</th>
                                <th>Course Applied</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="admissionsTableBody">
                            </tbody>
                    </table>
                </div>
            </section>

            <section id="settings" class="dashboard-section">
                <h2>Settings</h2>
                <p>Manage your college management system settings here.</p>
            </section>

            <section id="logout" class="dashboard-section">
                <h2>Logout</h2>
                <p>You have been logged out. Redirecting...</p>
            </section>

        </main>
    </div>

    <script src="script.js"></script>
</body>
</html>
