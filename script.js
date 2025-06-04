document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.querySelector('.sidebar');
    const menuIcon = document.querySelector('.menu-icon');
    const closeSidebarBtn = document.querySelector('.close-sidebar');
    const mainContent = document.querySelector('.main-content');
    const menuItems = document.querySelectorAll('.sidebar-menu .menu-item');
    const dashboardSections = document.querySelectorAll('.dashboard-section');

    // Add Students Form elements
    const addStudentBtn = document.getElementById('addStudentBtn');
    const addStudentFormPopup = document.getElementById('addStudentFormPopup');
    const cancelAddStudentBtn = document.getElementById('cancelAddStudent');
    const addStudentForm = document.getElementById('addStudentForm');

    // NEW: Add Courses Form elements
    const addCourseBtn = document.getElementById('addCourseBtn');
    const addCourseFormPopup = document.getElementById('addCourseFormPopup');
    const cancelAddCourseBtn = document.getElementById('cancelAddCourse');
    const addCourseForm = document.getElementById('addCourseForm');

    // NEW: Add Teachers Form elements
    const addTeacherBtn = document.getElementById('addTeacherBtn');
    const addTeacherFormPopup = document.getElementById('addTeacherFormPopup');
    const cancelAddTeacherBtn = document.getElementById('cancelAddTeacher');
    const addTeacherForm = document.getElementById('addTeacherForm');


    // Global variable to store fetched data
    let appData = {
        students: [],
        courses: [],
        teachers: [],
        admissions: [],
        activities: []
    };

    // --- Sidebar Toggle Functionality ---
    menuIcon.addEventListener('click', () => {
        sidebar.classList.add('active');
        mainContent.classList.add('sidebar-active');
    });

    closeSidebarBtn.addEventListener('click', () => {
        sidebar.classList.remove('active');
        mainContent.classList.remove('sidebar-active');
    });

    mainContent.addEventListener('click', (event) => {
        if (sidebar.classList.contains('active') && !sidebar.contains(event.target) && !menuIcon.contains(event.target)) {
            sidebar.classList.remove('active');
            mainContent.classList.remove('sidebar-active');
        }
    });

    // --- Navigation (Show/Hide Sections) ---
    menuItems.forEach(item => {
        item.addEventListener('click', () => {
            menuItems.forEach(i => i.classList.remove('active'));
            item.classList.add('active');

            const targetSectionId = item.dataset.section;

            dashboardSections.forEach(section => {
                section.classList.remove('active');
            });

            const targetSection = document.getElementById(targetSectionId);
            if (targetSection) {
                targetSection.classList.add('active');
                loadSectionData(targetSectionId);
            }

            if (window.innerWidth <= 992) {
                sidebar.classList.remove('active');
                mainContent.classList.remove('sidebar-active');
            }
        });
    });

    // --- Add Student Form Functionality ---
    addStudentBtn.addEventListener('click', () => {
        addStudentFormPopup.style.display = 'flex';
    });

    cancelAddStudentBtn.addEventListener('click', () => {
        addStudentFormPopup.style.display = 'none';
        addStudentForm.reset();
    });

    addStudentForm.addEventListener('submit', async (event) => {
        event.preventDefault();

        const studentName = document.getElementById('studentName').value;
        const studentEmail = document.getElementById('studentEmail').value;
        const studentCourse = document.getElementById('studentCourse').value;

        if (!studentName || !studentEmail || !studentCourse) {
            alert('All fields are required!');
            return;
        }

        const formData = new FormData();
        formData.append('studentName', studentName);
        formData.append('studentEmail', studentEmail);
        formData.append('studentCourse', studentCourse);

        try {
            const response = await fetch('php/add_student.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            if (result.success) {
                alert(result.message);
                addStudentFormPopup.style.display = 'none';
                addStudentForm.reset();
                loadSectionData('students'); // Reload students data and overview
            } else {
                alert('Error: ' + result.message);
            }
        } catch (error) {
            console.error('Error adding student:', error);
            alert('Failed to add student due to a network error. Please check your connection.');
        }
    });

    // NEW: --- Add Course Form Functionality ---
    addCourseBtn.addEventListener('click', () => {
        addCourseFormPopup.style.display = 'flex';
    });

    cancelAddCourseBtn.addEventListener('click', () => {
        addCourseFormPopup.style.display = 'none';
        addCourseForm.reset();
    });

    addCourseForm.addEventListener('submit', async (event) => {
        event.preventDefault();

        const courseTitle = document.getElementById('courseTitle').value;
        const courseCredits = document.getElementById('courseCredits').value;
        const courseDepartment = document.getElementById('courseDepartment').value;

        if (!courseTitle || !courseCredits || !courseDepartment) {
            alert('All fields are required!');
            return;
        }
        if (isNaN(courseCredits) || parseInt(courseCredits) <= 0) {
            alert('Credits must be a positive number!');
            return;
        }

        const formData = new FormData();
        formData.append('courseTitle', courseTitle);
        formData.append('courseCredits', courseCredits);
        formData.append('courseDepartment', courseDepartment);

        try {
            const response = await fetch('php/add_course.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            if (result.success) {
                alert(result.message);
                addCourseFormPopup.style.display = 'none';
                addCourseForm.reset();
                loadSectionData('courses'); // Reload courses data and overview
            } else {
                alert('Error: ' + result.message);
            }
        } catch (error) {
            console.error('Error adding course:', error);
            alert('Failed to add course due to a network error. Please check your connection.');
        }
    });

    // NEW: --- Add Teacher Form Functionality ---
    addTeacherBtn.addEventListener('click', () => {
        addTeacherFormPopup.style.display = 'flex';
    });

    cancelAddTeacherBtn.addEventListener('click', () => {
        addTeacherFormPopup.style.display = 'none';
        addTeacherForm.reset();
    });

    addTeacherForm.addEventListener('submit', async (event) => {
        event.preventDefault();

        const teacherName = document.getElementById('teacherName').value;
        const teacherEmail = document.getElementById('teacherEmail').value;
        const teacherDepartment = document.getElementById('teacherDepartment').value;

        if (!teacherName || !teacherEmail || !teacherDepartment) {
            alert('All fields are required!');
            return;
        }

        const formData = new FormData();
        formData.append('teacherName', teacherName);
        formData.append('teacherEmail', teacherEmail);
        formData.append('teacherDepartment', teacherDepartment);

        try {
            const response = await fetch('php/add_teacher.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            if (result.success) {
                alert(result.message);
                addTeacherFormPopup.style.display = 'none';
                addTeacherForm.reset();
                loadSectionData('teachers'); // Reload teachers data and overview
            } else {
                alert('Error: ' + result.message);
            }
        } catch (error) {
            console.error('Error adding teacher:', error);
            alert('Failed to add teacher due to a network error. Please check your connection.');
        }
    });


    // --- Data Loading Functions ---
    async function loadSectionData(sectionId) {
        try {
            const response = await fetch('php/fetch_data.php');
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            appData = await response.json(); // Update global appData

            switch (sectionId) {
                case 'overview':
                    renderOverview();
                    break;
                case 'students':
                    renderStudentsTable();
                    break;
                case 'courses':
                    renderCoursesTable();
                    break;
                case 'teachers':
                    renderTeachersTable();
                    break;
                case 'admissions':
                    renderAdmissionsTable();
                    break;
                case 'logout':
                    handleLogout();
                    break;
                default:
                    console.warn('Unknown section ID:', sectionId);
                    break;
            }
        } catch (error) {
            console.error('Error fetching data:', error);
            alert('Failed to load data from the server. Please ensure the backend is running and configured correctly.');
        }
    }

    function renderOverview() {
        const students = appData.students || [];
        const courses = appData.courses || [];
        const teachers = appData.teachers || [];
        const admissions = appData.admissions || [];
        const activities = appData.activities || [];

        document.getElementById('totalStudents').textContent = students.length;
        document.getElementById('totalCourses').textContent = courses.length;
        document.getElementById('totalTeachers').textContent = teachers.length;
        document.getElementById('pendingAdmissions').textContent = admissions.filter(app => app.status === 'Pending').length;

        const activityList = document.getElementById('activityList');
        activityList.innerHTML = '';
        activities.slice(0, 5).forEach(activity => {
            const li = document.createElement('li');
            li.textContent = activity;
            activityList.appendChild(li);
        });
    }

    function renderStudentsTable() {
        const students = appData.students || [];
        const tableBody = document.getElementById('studentsTableBody');
        tableBody.innerHTML = '';

        students.forEach(student => {
            const row = tableBody.insertRow();
            row.insertCell().textContent = 'S' + String(student.id).padStart(3, '0');
            row.insertCell().textContent = student.name;
            row.insertCell().textContent = student.email;
            row.insertCell().textContent = student.course;
            const actionsCell = row.insertCell();
            actionsCell.innerHTML = `
                <div class="action-btns">
                    <button title="Edit"><span class="material-icons-outlined">edit</span></button>
                    <button class="delete" title="Delete" data-id="${student.id}" data-type="student"><span class="material-icons-outlined">delete</span></button>
                </div>
            `;
        });
        addDeleteListeners();
    }

    function renderCoursesTable() {
        const courses = appData.courses || [];
        const tableBody = document.getElementById('coursesTableBody');
        tableBody.innerHTML = '';

        courses.forEach(course => {
            const row = tableBody.insertRow();
            row.insertCell().textContent = 'C' + String(course.id).padStart(3, '0');
            row.insertCell().textContent = course.title;
            row.insertCell().textContent = course.credits;
            row.insertCell().textContent = course.department;
            const actionsCell = row.insertCell();
            actionsCell.innerHTML = `
                <div class="action-btns">
                    <button title="Edit"><span class="material-icons-outlined">edit</span></button>
                    <button class="delete" title="Delete" data-id="${course.id}" data-type="course"><span class="material-icons-outlined">delete</span></button>
                </div>
            `;
        });
        addDeleteListeners();
    }

    function renderTeachersTable() {
        const teachers = appData.teachers || [];
        const tableBody = document.getElementById('teachersTableBody');
        tableBody.innerHTML = '';

        teachers.forEach(teacher => {
            const row = tableBody.insertRow();
            row.insertCell().textContent = 'T' + String(teacher.id).padStart(3, '0');
            row.insertCell().textContent = teacher.name;
            row.insertCell().textContent = teacher.email;
            row.insertCell().textContent = teacher.department;
            const actionsCell = row.insertCell();
            actionsCell.innerHTML = `
                <div class="action-btns">
                    <button title="Edit"><span class="material-icons-outlined">edit</span></button>
                    <button class="delete" title="Delete" data-id="${teacher.id}" data-type="teacher"><span class="material-icons-outlined">delete</span></button>
                </div>
            `;
        });
        addDeleteListeners();
    }

    function renderAdmissionsTable() {
        const admissions = appData.admissions || [];
        const tableBody = document.getElementById('admissionsTableBody');
        tableBody.innerHTML = '';

        admissions.forEach(admission => {
            const row = tableBody.insertRow();
            row.insertCell().textContent = 'A' + String(admission.app_id).padStart(3, '0');
            row.insertCell().textContent = admission.student_name;
            row.insertCell().textContent = admission.course_applied;
            row.insertCell().textContent = admission.status;
            row.insertCell().textContent = admission.date;
            const actionsCell = row.insertCell();
            actionsCell.innerHTML = `
                <div class="action-btns">
                    <button title="View Details"><span class="material-icons-outlined">visibility</span></button>
                    <button title="Approve"><span class="material-icons-outlined">check_circle</span></button>
                    <button title="Reject"><span class="material-icons-outlined">cancel</span></button>
                </div>
            `;
        });
    }

    // --- Dynamic Actions (e.g., Delete) ---
    function addDeleteListeners() {
        document.querySelectorAll('.table-container .delete').forEach(button => {
            button.removeEventListener('click', handleDelete);
            button.addEventListener('click', handleDelete);
        });
    }

    async function handleDelete(event) {
        const button = event.currentTarget;
        const idToDelete = button.dataset.id;
        const typeToDelete = button.dataset.type;

        if (confirm(`Are you sure you want to delete this ${typeToDelete} with ID: ${idToDelete}?`)) {
            const formData = new FormData();
            formData.append('id', idToDelete);
            formData.append('type', typeToDelete);

            try {
                const response = await fetch('php/delete_data.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                if (result.success) {
                    alert(result.message);
                    // Reload the relevant section's data to update the UI
                    loadSectionData(typeToDelete + 's');
                } else {
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                console.error('Error deleting data:', error);
                alert('Failed to delete data due to a network error.');
            }
        }
    }

    // --- Logout Handler ---
    function handleLogout() {
        alert('Logging out... (In a real system, you would clear session data and redirect to a login page)');
        setTimeout(() => {
            // window.location.href = 'login.html'; // Example: Redirect to a login page
        }, 1500);
    }

    // Initial load: Render the overview section when the page loads
    loadSectionData('overview');
});
