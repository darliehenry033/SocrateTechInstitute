<?php
session_start();
include 'database.php';
include 'partials/functions.php';
include 'partials/header.php';

//Add course And generated Course_ID
if (isset($_POST['add_course'])) {

    $course_name = $_POST['course_name'];
    $coefficient = $_POST['coefficient'];
    $description = $_POST['description'];
    $class_id = $_POST['class_id'];
    $teacher_id = $_POST['teacher_id'];

    // Insert without course_code
    mysqli_query($connect, "
        INSERT INTO courses (course_name, coefficient, description, class_id, teacher_id)
        VALUES ('$course_name', '$coefficient', '$description', '$class_id', '$teacher_id')
    ");

    // Get AUTO_INCREMENT ID
    $course_id = mysqli_insert_id($connect);

    // Generate final course code
    $course_code = strtoupper(substr($course_name, 0, 3)) . $course_id;

    // Update row
    mysqli_query($connect, "
        UPDATE courses
        SET course_code = '$course_code'
        WHERE course_id = '$course_id'
    ");
}
/* ---------- Helpers ---------- */
function h($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }

function getAllRows($connect, $sql){
  $res = mysqli_query($connect, $sql);
  return $res ? mysqli_fetch_all($res, MYSQLI_ASSOC) : [];
}

/* ---------- Overview cards ---------- */
$sqlCounts = "
  SELECT
    (SELECT COUNT(*) FROM teachers) AS teachers,
    (SELECT COUNT(*) FROM admin)    AS admins,
    (SELECT COUNT(*) FROM students) AS students,
    (SELECT COUNT(*) FROM parents)  AS parents
";
$counts = mysqli_fetch_assoc(mysqli_query($connect, $sqlCounts));

$cards = [
  ['key' => 'teachers', 'title' => 'Teachers',   'img' => 'images/dashboardImage/teachers.png'],
  ['key' => 'admins',   'title' => 'S. Members', 'img' => 'images/dashboardImage/staff.png'],
  ['key' => 'students', 'title' => 'Students',   'img' => 'images/dashboardImage/students.png'],
  ['key' => 'parents',  'title' => 'Parents',    'img' => 'images/dashboardImage/family.png'],
];

/* ---------- User Management tabs config ---------- */
$userTabs = [
  'admins' => [
    'title' => 'Admins',
    'primary_key' => 'admin_id',
    'columns' => [
      'Admin ID'    => 'admin_id',
      'Last Name'   => 'admin_lastname',
      'First Name'  => 'admin_firstname',
      'Age'         => 'admin_age',
      'Email'       => 'email',
      'Description' => 'admin_function',
    ],
    'sql' => "SELECT admin_id, admin_lastname, admin_firstname, admin_age, email, admin_function
              FROM admin ORDER BY admin_id",
  ],
  'teachers' => [
    'title' => 'Teachers',
    'primary_key' => 'teacher_id',
    'columns' => [
      'Teacher ID'  => 'teacher_id',
      'Last Name'   => 'last_name',
      'First Name'  => 'first_name',
      'Email'       => 'email',
      'Department'  => 'department_id',
    ],
    'sql' => "SELECT teacher_id, last_name, first_name, email, department_id
              FROM teachers ORDER BY teacher_id",
  ],
  'students' => [
    'title' => 'Students',
    'primary_key' => 'student_id',
    'columns' => [
      'Student ID'   => 'student_id',
      'Last Name'    => 'last_name',
      'First Name'   => 'first_name',
      'Grade'        => 'class_name',
      'Parent Email' => 'parent_email',
    ],
    'sql' => "SELECT 
                s.student_id,
                s.last_name,
                s.first_name,
                cl.class_name AS class_name,
                GROUP_CONCAT(DISTINCT p.email SEPARATOR ', ') AS parent_email
              FROM students s
              INNER JOIN classes cl
                ON cl.class_id = s.class_id
              LEFT JOIN student_parents sp
                ON sp.student_id = s.student_id
              LEFT JOIN parents p
                ON p.parent_id = sp.parent_id
              GROUP BY s.student_id, s.last_name, s.first_name, cl.class_name
              ORDER BY s.student_id",
  ],
  'parents' => [
    'title' => 'Parents',
    'primary_key' => 'parent_id',
    'columns' => [
      'Parent ID'   => 'parent_id',
      'Last Name'   => 'last_name',
      'First Name'  => 'first_name',
      'Email'       => 'email',
    ],
    'sql' => "SELECT parent_id, last_name, first_name, email
              FROM parents ORDER BY parent_id",
  ],
];

$tablesData = [];
foreach ($userTabs as $key => $def) {
  $tablesData[$key] = getAllRows($connect, $def['sql']);
}
?>
<style>
  .dashboard-tabs-content { display: none; }
  .dashboards-content-active { display: block; }

  .user-management-content-container { display: none; }
  .userManagementActiveContentContainer { display: block; }

  .user-management-content-container .table-container thead {
    position: sticky; top: 0; z-index: 1; background:#0e1223; color:#fff;
  }

  .classes-content-info-container {
    display: none;
    padding: 15px;
    background: #fff;
    border-radius: 10px;
  }
  .classInfoActiveContent {
    display: block;
  }
  .class-button-tab-info {
    margin-right: 8px;
    border: none;
    padding: 8px 15px;
    border-radius: 5px;
    cursor: pointer;
  }
  .classInfoActiveButton {
    background-color: #0e1223;
    color: white;
  }
</style>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>
<body>

<section class="dashboard-container">
  <aside id="sidebar">
    <div class="dashboard-logo-container">
      <a href="index.html"><img src="images/logowhite.png" alt=""></a>
    </div>

    <button class="dashboard-tab-button" data-tab="1">Overview/Analytics</button>
    <button class="dashboard-tab-button" data-tab="2">User Management</button>
    <button class="dashboard-tab-button" data-tab="3">Classes & Courses</button>
    <button class="dashboard-tab-button" data-tab="4">Documents & Admissions</button>
    <button class="dashboard-tab-button" data-tab="5">Announcements / Notifications</button>
    <button class="dashboard-tab-button" data-tab="6">System Settings</button>
  </aside>

  <main id="main-content">
    <div class="dashboards-header-outer-container">
      <div class="dashboards-header">
        <div class="dashboards-header-left">
          <h1>Welcome to STI</h1>
        </div>
        <div class="dashboard-middle-header">
          <form action="" class="search-form">
            <input type="search" placeholder="Search students, teachers, classes...">
            <button type="submit"><i class="fa-brands fa-searchengin"></i></button>
          </form>
        </div>
        <div class="dashboards-header-right">
          <span>Academic Year: 2025-2026</span>
          <div class="dashboard-icons-container">
            <i class="fa-solid fa-user"></i>
            <i class="fa-solid fa-bell"></i>
            <i class="fa-solid fa-gear"></i>
            <i class="fa-solid fa-question"></i>
          </div>
        </div>
      </div>
    </div>

    <!-- TAB 1: OVERVIEW -->
    <div class="dashboard-tabs-content dashboards-content-active" data-tab="1">
      <div class="dashboard-card-outer-container">
        <div class="dashboard-card-container">
          <?php foreach ($cards as $c): ?>
            <div class="card-child">
              <div class="card-child-left">
                <img src="<?= h($c['img']) ?>" alt="">
              </div>
              <div class="card-child-right">
                <span><?= (int)($counts[$c['key']] ?? 0) ?></span>
                <h2><?= h($c['title']) ?></h2>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="socratetech-statistic">
        <div class="socratetech-statistic-left">
          <h1>Attendance Rate</h1>
          <div id="chart"></div>
        </div>
        <div class="socratetech-statistic-right">
          <h1>Performance Statistics</h1>
          <div id="performanceChart"></div>
        </div>
      </div>
    </div>

    <!-- TAB 2: USER MANAGEMENT -->
    <div class="dashboard-tabs-content" data-tab="2">
      <div class="user-management-tab-container">

        <!-- UM Buttons -->
        <div class="user-management-button-container">
          <?php $umIndex=1; foreach ($userTabs as $key=>$def): ?>
            <button class="user-management-tab-button" data-tab="<?= $umIndex ?>"><?= h($def['title']) ?></button>
          <?php $umIndex++; endforeach; ?>
        </div>

        <!-- UM Content -->
        <?php $umIndex=1; foreach ($userTabs as $key=>$def): ?>
          <div class="user-management-content-container<?= $umIndex===1 ? ' userManagementActiveContentContainer' : '' ?>" data-tab="<?= $umIndex ?>">
            <div class="admin-table-container">
              <table class="table-container">
                <thead>
                  <tr>
                    <?php foreach ($def['columns'] as $label => $field): ?>
                      <th><?= h($label) ?></th>
                    <?php endforeach; ?>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($tablesData[$key])): ?>
                    <?php foreach ($tablesData[$key] as $row): ?>
                      <tr>
                        <?php foreach ($def['columns'] as $field): ?>
                          <td><?= h($row[$field] ?? '') ?></td>
                        <?php endforeach; ?>
                        <td>
                          <button class="button delete"
                                  data-type="<?= h($key) ?>"
                                  data-id="<?= h($row[$def['primary_key']] ?? '') ?>">
                            <i class="fa-solid fa-trash"></i>
                          </button>
                          <button class="button edit"
                                  data-type="<?= h($key) ?>"
                                  data-id="<?= h($row[$def['primary_key']] ?? '') ?>">
                            <i class="fa-solid fa-pen"></i>
                          </button>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr><td colspan="<?= count($def['columns']) + 1 ?>">No data available</td></tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        <?php $umIndex++; endforeach; ?>

      </div>
    </div>

    <!-- TAB 3: CLASSES & COURSES -->
    <div class="dashboard-tabs-content" data-tab="3">
      <div class="classes-main-container">
        <div class="classes-buttons-tab-container">
          <button class="class-button-tab button" data-tab="1">7e</button>
          <button class="class-button-tab button" data-tab="2">8e</button>
          <button class="class-button-tab button" data-tab="3">9e</button>
          <button class="class-button-tab button" data-tab="4">NSI</button>
          <button class="class-button-tab button" data-tab="5">NSII</button>
          <button class="class-button-tab button" data-tab="6">NSIII</button>
          <button class="class-button-tab button" data-tab="7">NSIV</button>
        </div>

        <!-- 7e -->
        <div class="classes-content-container classesContentContainerActive" data-tab="1">
          <div class="classes-buttons-info-container">
            <button class="class-button-tab-info button" data-tab="1">Basic Info</button>
            <button class="class-button-tab-info button" data-tab="2">Courses</button>
            <button class="class-button-tab-info button" data-tab="3">Schedule</button>
            <button class="class-button-tab-info button" data-tab="4">Students</button>
          </div>

          <!-- 7e: Basic info -->
          <div class="classes-content-info-container" data-tab="1">
            <div class="basic-info-container">
              <div class="basic-info">
                <span>7e Année Fondamentale</span>
                <h2>Academic Year: 2025-2026</h2>
                <h2>Classroom #: 0245</h2>
                <h2>Capacity: 45</h2>
                <h2>Number of Students: 56</h2>
                <h2>Number of Teachers: 14</h2>
                <h2>Number of courses: 14</h2>
              </div>
              <div class="tutor-info">
                <div class="tutor-info-left">
                  <img src="images/0016_3.JPG" alt="">
                </div>
                <div class="tutor-info-right">
                  <h2>Prof. JEAN W. LEYDER</h2>
                  <h4>Sciences & Mathematics</h4>
                  <p><strong>Email:</strong> <a href="#">leyder.jean@sti.edu.ht</a></p>
                  <p><strong>Phone:</strong> <a href="#">+509 42 36 89 15</a></p>
                  <p><strong>Degree:</strong> Bachelor in Informatics</p>
                  <p><strong>Experience:</strong> 7 years of teaching experience</p>
                  <p>Dedicated to making science clear and exciting for students through logic and daily examples.</p>
                  <p><strong>Courses handled in 7e:</strong> Mathematics, Physics, General Science</p>
                </div>
              </div>
            </div>
          </div>
          
          <!-- 7e: Courses -->
          <div class="classes-content-info-container" data-tab="2">
          <button class="new-course button">Add a New Course<i class="fa-solid fa-plus cross"></i></button>
            <div class="courses-container">    
            <table class="courses-table">
              <thead>
                <tr>
                  <th>Course Code</th>
                  <th>Course Name</th>
                  <th>Teacher</th>
                  <th>Coefficient</th>
                  <th>Description</th>
                  <th>Actions</th>
                </tr>
              </thead>

              <tbody>
<?php
$result = mysqli_query($connect, "
  SELECT 
    c.course_id,
    c.course_code,
    c.course_name,
    CONCAT(t.last_name, ' ', t.first_name) AS teacher_fullname,
    c.coefficient,
    c.description,
    cl.class_name
  FROM courses c
  INNER JOIN teachers t 
    ON c.teacher_id = t.teacher_id
  INNER JOIN classes cl 
    ON c.class_id = cl.class_id
  ORDER BY c.course_id ASC
");


  while ($row = mysqli_fetch_assoc($result)): ?>
    <tr>
      <td><?= h($row['course_code'] ?? '') ?></td>
      <td><?= h($row['course_name'] ?? '') ?></td>
      <td><?= h($row['teacher_fullname'] ?? '') ?></td>
      <td><?= h($row['coefficient'] ?? '') ?></td>
      <td><?= h($row['description'] ?? '') ?></td>
      <td>
        <button class="button edit">
          <i class="fa-solid fa-pen"></i>
        </button>
        <button class="button delete">
          <i class="fa-solid fa-trash"></i>
        </button>
      </td>
    </tr>
<?php
  endwhile;
 ?>
    

</tbody>

            </table>

                      </div>
                </div>
             

           <!-- 7e: Schedule (with breaks / flag) -->
          <div class="classes-content-info-container schedule-container" data-tab="3">
            <?php
            $result = mysqli_query(
              $connect,
              "SELECT 
                d.day        AS day_name,
                t.time_id    AS time_id,
                t.start_time AS start_time,
                t.end_time   AS end_time,
                c.course_name AS course_name
              FROM days d
              CROSS JOIN time_slots t
              LEFT JOIN schedule s
                ON s.day_id  = d.day_id
                AND s.time_id = t.time_id
              LEFT JOIN classes cl
                ON cl.class_id = s.class_id
                AND cl.class_name = '7e'
              LEFT JOIN courses c
                ON c.course_id = s.course_id
              ORDER BY t.start_time, d.day_id"
            );

            $days       = [];
            $timeLabels = [];
            $timeMeta   = [];
            $map        = [];

            if ($result) {
              while ($r = mysqli_fetch_assoc($result)) {
                $day    = $r['day_name'];
                $timeId = $r['time_id'];

                $startShort = substr($r['start_time'], 0, 5);
                $endShort   = substr($r['end_time'],   0, 5);
                $label      = $startShort . ' - ' . $endShort;

                if (!in_array($day, $days, true)) {
                  $days[] = $day;
                }

                if (!isset($timeLabels[$timeId])) {
                  $timeLabels[$timeId] = $label;
                  $timeMeta[$timeId]   = [
                    'start' => $startShort,
                    'end'   => $endShort,
                  ];
                }

                if (!empty($r['course_name'])) {
                  $map[$timeId][$day] = $r['course_name'];
                }
              }
            }
            ?>
            <table>
              <thead>
                <tr>
                  <th>Time</th>
                  <?php foreach ($days as $dayName): ?>
                    <th><?= h($dayName) ?></th>
                  <?php endforeach; ?>
                </tr>
              </thead>
              <tbody>
  <?php if (empty($timeLabels)): ?>
    <tr>
      <td colspan="<?= count($days) + 1 ?>">No schedule data</td>
    </tr>
  <?php else: ?>
    <?php foreach ($timeLabels as $timeId => $label): ?>
      <tr>
        <td><?= h($label) ?></td>
        <?php
          $start = $timeMeta[$timeId]['start'];
          $end   = $timeMeta[$timeId]['end'];
        ?>
        <?php foreach ($days as $dayName): ?>
          <?php
            // default from DB
            $value     = $map[$timeId][$dayName] ?? '';
            $cellClass = '';

            // Add custom labels + classes when empty
            if ($value === '') {
              if ($start === '08:00' && $end === '10:00') {
                $value     = 'Flag / Exercises';
                $cellClass = 'schedule-flag';
              } elseif ($start === '12:00' && $end === '13:00') {
                $value     = 'Break';
                $cellClass = 'schedule-break';
              } elseif ($start === '15:00' && $end === '15:30') {
                $value     = 'Break';
                $cellClass = 'schedule-break';
              }
            }
          ?>
          <td class="<?= h($cellClass) ?>"><?= h($value) ?></td>
        <?php endforeach; ?>
      </tr>
    <?php endforeach; ?>
  <?php endif; ?>
              </tbody>
            </table>
          </div>

          <div class="classes-content-info-container schedule-container student-container" data-tab="4">
  <!------ Students by Class ----->
  <table class="student-table-container">
    <thead>
      <tr>
        <th>ID</th>
        <th>F.Name</th>
        <th>L.Name</th>
        <th>Grade</th>
        <th>D.Birth</th>
        <th>Gender</th>
        <th>Phone</th>
        <th>Email</th>
        <th>P.Birth</th>
        <th>Parent(s)</th>
        <th>Address</th>
        <th>Age</th>
        <th>Actions</th>
      </tr>
    </thead>

    <tbody>
      <?php
   $result = mysqli_query($connect, "
   SELECT
     s.student_id,
     s.first_name,
     s.last_name,
     c.class_name AS grade_level,
     s.date_of_birth,
     g.gender_name,
     s.phone,
     s.email,
     s.place_of_birth,
     s.address,
     s.age,
     GROUP_CONCAT(
       DISTINCT CONCAT(p.first_name, ' ', p.last_name)
       SEPARATOR ', '
     ) AS parents_fullname
   FROM students s
   INNER JOIN classes c 
     ON c.class_id = s.class_id
   INNER JOIN gender g 
     ON g.gender_id = s.gender_id
   INNER JOIN student_parents sp 
     ON sp.student_id = s.student_id
   INNER JOIN parents p 
     ON p.parent_id = sp.parent_id
   GROUP BY
     s.student_id,
     s.first_name,
     s.last_name,
     c.class_name,
     s.date_of_birth,
     g.gender_name,
     s.phone,
     s.email,
     s.place_of_birth,
     s.address,
     s.age
   ORDER BY s.student_id
 ");
 

      while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
          <td><?= htmlspecialchars($row['student_id']); ?></td>
          <td><?= htmlspecialchars($row['first_name']); ?></td>
          <td><?= htmlspecialchars($row['last_name']); ?></td>
          <td><?= htmlspecialchars($row['grade_level']); ?></td>
          <td><?= htmlspecialchars($row['date_of_birth']); ?></td>
          <td><?= htmlspecialchars($row['gender_name']); ?></td>
          <td><?= htmlspecialchars($row['phone']); ?></td>
          <td><?= htmlspecialchars($row['email']); ?></td>
          <td><?= htmlspecialchars($row['place_of_birth']); ?></td>
          <td>   
              <?= htmlspecialchars($row['parents_fullname']); ?>
          </td>
          <td><?= htmlspecialchars($row['address']); ?></td>
          <td><?= htmlspecialchars($row['age']); ?></td>
          <td>
            <button class="button edit">
              <i class="fa-solid fa-pen"></i>
            </button>
            <button class="button delete">
              <i class="fa-solid fa-trash"></i>
            </button>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>


        <!-- 8e -->
        <div class="classes-content-container" data-tab="2">
          <div class="classes-buttons-info-container">
            <button class="class-button-tab-info button" data-tab="1">Basic Info</button>
            <button class="class-button-tab-info button" data-tab="2">Courses</button>
            <button class="class-button-tab-info button" data-tab="3">Schedule</button>
            <button class="class-button-tab-info button" data-tab="4">Students</button>
          </div>

          <div class="classes-content-info-container" data-tab="1">8e basic info…</div>
          <div class="classes-content-info-container" data-tab="2">8e courses…</div>
          <div class="classes-content-info-container" data-tab="3">8e schedule…</div>
          <div class="classes-content-info-container" data-tab="4">8e students…</div>
        </div>

        <!-- 9e -->
        <div class="classes-content-container" data-tab="3">
          <div class="classes-buttons-info-container">
            <button class="class-button-tab-info button" data-tab="1">Basic Info</button>
            <button class="class-button-tab-info button" data-tab="2">Courses</button>
            <button class="class-button-tab-info button" data-tab="3">Schedule</button>
            <button class="class-button-tab-info button" data-tab="4">Students</button>
          </div>

          <div class="classes-content-info-container" data-tab="1">9e basic info…</div>
          <div class="classes-content-info-container" data-tab="2">9e courses…</div>
          <div class="classes-content-info-container" data-tab="3">9e schedule…</div>
          <div class="classes-content-info-container" data-tab="4">9e students…</div>
        </div>

        <!-- NSI -->
        <div class="classes-content-container" data-tab="4">
          <div class="classes-buttons-info-container">
            <button class="class-button-tab-info button" data-tab="1">Basic Info</button>
            <button class="class-button-tab-info button" data-tab="2">Courses</button>
            <button class="class-button-tab-info button" data-tab="3">Schedule</button>
            <button class="class-button-tab-info button" data-tab="4">Students</button>
          </div>

          <div class="classes-content-info-container" data-tab="1">NSI basic info…</div>
          <div class="classes-content-info-container" data-tab="2">NSI courses…</div>
          <div class="classes-content-info-container" data-tab="3">NSI schedule…</div>
          <div class="classes-content-info-container" data-tab="4">NSI students…</div>
        </div>

        <!-- NSII -->
        <div class="classes-content-container" data-tab="5">
          <div class="classes-buttons-info-container">
            <button class="class-button-tab-info button" data-tab="1">Basic Info</button>
            <button class="class-button-tab-info button" data-tab="2">Courses</button>
            <button class="class-button-tab-info button" data-tab="3">Schedule</button>
            <button class="class-button-tab-info button" data-tab="4">Students</button>
          </div>

          <div class="classes-content-info-container" data-tab="1">NSII basic info…</div>
          <div class="classes-content-info-container" data-tab="2">NSII courses…</div>
          <div class="classes-content-info-container" data-tab="3">NSII schedule…</div>
          <div class="classes-content-info-container" data-tab="4">NSII students…</div>
        </div>

        <!-- NSIII -->
        <div class="classes-content-container" data-tab="6">
          <div class="classes-buttons-info-container">
            <button class="class-button-tab-info button" data-tab="1">Basic Info</button>
            <button class="class-button-tab-info button" data-tab="2">Courses</button>
            <button class="class-button-tab-info button" data-tab="3">Schedule</button>
            <button class="class-button-tab-info button" data-tab="4">Students</button>
          </div>

          <div class="classes-content-info-container" data-tab="1">NSIII basic info…</div>
          <div class="classes-content-info-container" data-tab="2">NSIII courses…</div>
          <div class="classes-content-info-container" data-tab="3">NSIII schedule…</div>
          <div class="classes-content-info-container" data-tab="4">NSIII students…</div>
        </div>

        <!-- NSIV -->
        <div class="classes-content-container" data-tab="7">
          <div class="classes-buttons-info-container">
            <button class="class-button-tab-info button" data-tab="1">Basic Info</button>
            <button class="class-button-tab-info button" data-tab="2">Courses</button>
            <button class="class-button-tab-info button" data-tab="3">Schedule</button>
            <button class="class-button-tab-info button" data-tab="4">Students</button>
          </div>

          <div class="classes-content-info-container" data-tab="1">NSIV basic info…</div>
          <div class="classes-content-info-container" data-tab="2">NSIV courses…</div>
          <div class="classes-content-info-container" data-tab="3">NSIV schedule…</div>
          <div class="classes-content-info-container" data-tab="4">NSIV students…</div>
        </div>

      </div>
    </div>

    <!-- Other top-level tabs -->
    <div class="dashboard-tabs-content" data-tab="4">Documents & Admissions…</div>
    <div class="dashboard-tabs-content" data-tab="5">Announcements / Notifications…</div>
    <div class="dashboard-tabs-content" data-tab="6">System Settings…</div>

  </main>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
  /* ---- Dashboard top-level tabs ---- */
  const dashBtns  = document.querySelectorAll('.dashboard-tab-button');
  const dashPanes = document.querySelectorAll('.dashboard-tabs-content');

  dashBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      const tab = btn.dataset.tab;

      dashBtns.forEach(b => b.classList.remove('dashboards-btn-active'));
      dashPanes.forEach(p => p.classList.remove('dashboards-content-active'));

      btn.classList.add('dashboards-btn-active');

      const pane = document.querySelector(`.dashboard-tabs-content[data-tab="${tab}"]`);
      if (pane) {
        pane.classList.add('dashboards-content-active');
      }

      if (tab === '1') {
        initChart();
        initPerformanceChart();
      }
    });
  });
  if (dashBtns[0]) {
    dashBtns[0].classList.add('dashboards-btn-active');
  }

  /* ---- User-Management inner tabs ---- */
  const umBtns  = document.querySelectorAll('.user-management-tab-button');
  const umPanes = document.querySelectorAll('.user-management-content-container');

  umBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      const tab = btn.dataset.tab;

      umBtns.forEach(b => b.classList.remove('userManagementActiveButton'));
      umPanes.forEach(p => p.classList.remove('userManagementActiveContentContainer'));

      btn.classList.add('userManagementActiveButton');

      const pane = document.querySelector(`.user-management-content-container[data-tab="${tab}"]`);
      if (pane) {
        pane.classList.add('userManagementActiveContentContainer');
      }
    });
  });
  if (umBtns[0]) {
    umBtns[0].classList.add('userManagementActiveButton');
  }

  /* ---- Classes & Courses top-level (7e, 8e, ...) ---- */
  const classBtns  = document.querySelectorAll('.class-button-tab');
  const classPanes = document.querySelectorAll('.classes-content-container');

  classBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      const tab = btn.dataset.tab;

      classBtns.forEach(b => b.classList.remove('classesButtonsActive'));
      classPanes.forEach(p => p.classList.remove('classesContentContainerActive'));

      btn.classList.add('classesButtonsActive');

      const pane = document.querySelector(`.classes-content-container[data-tab="${tab}"]`);
      if (pane) {
        pane.classList.add('classesContentContainerActive');
      }
    });
  });
  if (classBtns[0]) {
    classBtns[0].classList.add('classesButtonsActive');
  }

  /* ---- Inner tabs inside a class (Basic info / Courses / Schedule / Students) ---- */
  const classInfoButtons  = document.querySelectorAll('.class-button-tab-info');
  const classInfoContents = document.querySelectorAll('.classes-content-info-container');

  classInfoButtons.forEach(button => {
    button.addEventListener('click', () => {
      const tab = button.dataset.tab;

      classInfoButtons.forEach(btn => btn.classList.remove('classInfoActiveButton'));
      classInfoContents.forEach(content => content.classList.remove('classInfoActiveContent'));

      button.classList.add('classInfoActiveButton');

      const pane = document.querySelector(`.classes-content-info-container[data-tab="${tab}"]`);
      if (pane) {
        pane.classList.add('classInfoActiveContent');
      }
    });
  });
  if (classInfoButtons[0] && classInfoContents[0]) {
    classInfoButtons[0].classList.add('classInfoActiveButton');
    classInfoContents[0].classList.add('classInfoActiveContent');
  }

  /* ---- Render charts on first load (Overview active by default) ---- */
  initChart();
  initPerformanceChart();
});

/* ====== Charts ====== */
function initChart(){
  const el = document.querySelector('#chart');
  if (!el || el.dataset.rendered) return;
  el.dataset.rendered = '1';

  const options = {
    series: [{ name:'Inflation', data:[2.3,3.1,4.0,10.1,4.0,3.6,3.2,2.3,1.4,0.8,0.5,0.2] }],
    chart: { height: 350, type: 'bar' },
    plotOptions: { bar: { borderRadius: 10, dataLabels: { position: 'top' } } },
    dataLabels: { enabled: true, formatter: (v)=>v+"%", offsetY: -20, style: { fontSize: '12px', colors: ['#304758'] } },
    xaxis: {
      categories: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
      position:'top', axisBorder:{show:false}, axisTicks:{show:false},
      crosshairs:{ fill:{ type:'gradient', gradient:{ colorFrom:'#D8E3F0', colorTo:'#BED1E6', stops:[0,100], opacityFrom:0.4, opacityTo:0.5 } } },
      tooltip:{ enabled:true }
    },
    yaxis: { axisBorder:{show:false}, axisTicks:{show:false}, labels:{ show:false, formatter:(v)=>v+'%' } },
    title: { text: 'Monthly Inflation in Argentina, 2002', floating:true, offsetY:330, align:'center', style:{ color:'#444' } }
  };
  new ApexCharts(el, options).render();
}

function initPerformanceChart(){
  const el = document.querySelector('#performanceChart');
  if (!el || el.dataset.rendered) return;
  el.dataset.rendered = '1';

  const options = {
    series: [44, 55, 41, 17, 15],
    chart: { type: 'donut', height: 350 },
    labels: ['Excellent', 'Good', 'Average', 'Below Avg', 'Poor'],
    responsive: [{ breakpoint: 480, options: { chart: { width: 200 }, legend: { position: 'bottom' }}}],
    legend: { position: 'right', offsetY: 0, height: 230 }
  };
  new ApexCharts(el, options).render();
}
</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
</body>
</html>
