        <?php
        session_start();
        include 'database.php';
        include 'partials/functions.php';   
        include 'partials/header.php';
        

        /* ---------- Helpers ---------- */
        function h($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
        function getAllRows($conn, $sql){
        $res = mysqli_query($conn, $sql);
        return $res ? mysqli_fetch_all($res, MYSQLI_ASSOC) : [];
        }

        /* ---------- Different Cards(Overview) ---------- */
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
            'Student ID'  => 'student_id',
            'Last Name'   => 'last_name',
            'First Name'  => 'first_name',
            'Grade'       => 'grade_level',
            'Parent Email'=> 'parent_email',
          ],
          'sql' => "SELECT s.student_id, s.last_name, s.first_name, s.grade_level, p.email AS parent_email
                    FROM students s
                    LEFT JOIN parents p ON p.parent_id = s.parent_id
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
            'Relation'    => 'relation',
          ],
          'sql' => "SELECT parent_id, last_name, first_name, email, relation
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
        </style>

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

          <!--TAB 1: OVERVIEW -->
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

          <!--TAB 2: USER MANAGEMENT-->
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

          <!-------TAB 3 placeholders--------->
          <div class="dashboard-tabs-content" data-tab="3">
            <!-- Classes & Courses content -->
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

              <div class="classes-content-container classesContentContainerActive" data-tab="1">
  <!------ 7e ---->
  <div class="classes-buttons-info-container">
    <button class="class-button-tab-info button" data-tab="1">Basic Info</button>
    <button class="class-button-tab-info button" data-tab="2">Courses</button>
    <button class="class-button-tab-info button" data-tab="3">Schedule</button>
    <button class="class-button-tab-info button" data-tab="4">Students</button>
  </div>

  <div class="classes-content-info-container" data-tab="1">
  <section class="diagonal-section diagonal--left-to-right">

</section>

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
   
  </div>
</div>

    </div>
  
   

  </div>
  <div class="classes-content-info-container" data-tab="2">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ex consectetur minus animi odio expedita...</div>
  <div class="classes-content-info-container" data-tab="3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum quam, a, non illo incidunt totam...</div>
  <div class="classes-content-info-container" data-tab="4">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Animi, veniam. Sequi, ullam est...</div>
</div>

<!------ 8e ---->
<div class="classes-content-container" data-tab="2">
  <div class="classes-buttons-info-container">
    <button class="class-button-tab-info button" data-tab="1">Basic Info</button>
    <button class="class-button-tab-info button" data-tab="2">Courses</button>
    <button class="class-button-tab-info button" data-tab="3">Schedule</button>
    <button class="class-button-tab-info button" data-tab="4">Students</button>
  </div>

  <div class="classes-content-info-container" data-tab="1">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Et, tempora magnam ut, perspiciatis commodi...</div>
  <div class="classes-content-info-container" data-tab="2">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ex consectetur minus animi odio expedita...</div>
  <div class="classes-content-info-container" data-tab="3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum quam, a, non illo incidunt totam...</div>
  <div class="classes-content-info-container" data-tab="4">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Animi, veniam. Sequi, ullam est...</div>
</div>

<!------ 9e ---->
<div class="classes-content-container" data-tab="3">
  <div class="classes-buttons-info-container">
    <button class="class-button-tab-info button" data-tab="1">Basic Info</button>
    <button class="class-button-tab-info button" data-tab="2">Courses</button>
    <button class="class-button-tab-info button" data-tab="3">Schedule</button>
    <button class="class-button-tab-info button" data-tab="4">Students</button>
  </div>

  <div class="classes-content-info-container" data-tab="1">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Et, tempora magnam ut, perspiciatis commodi...</div>
  <div class="classes-content-info-container" data-tab="2">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ex consectetur minus animi odio expedita...</div>
  <div class="classes-content-info-container" data-tab="3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum quam, a, non illo incidunt totam...</div>
  <div class="classes-content-info-container" data-tab="4">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Animi, veniam. Sequi, ullam est...</div>
</div>

<!------ NS1 ---->
<div class="classes-content-container" data-tab="4">
  <div class="classes-buttons-info-container">
    <button class="class-button-tab-info button" data-tab="1">Basic Info</button>
    <button class="class-button-tab-info button" data-tab="2">Courses</button>
    <button class="class-button-tab-info button" data-tab="3">Schedule</button>
    <button class="class-button-tab-info button" data-tab="4">Students</button>
  </div>

  <div class="classes-content-info-container" data-tab="1">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Et, tempora magnam ut, perspiciatis commodi...</div>
  <div class="classes-content-info-container" data-tab="2">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ex consectetur minus animi odio expedita...</div>
  <div class="classes-content-info-container" data-tab="3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum quam, a, non illo incidunt totam...</div>
  <div class="classes-content-info-container" data-tab="4">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Animi, veniam. Sequi, ullam est...</div>
</div>

<!------ NS2 ---->
<div class="classes-content-container" data-tab="5">
  <div class="classes-buttons-info-container">
    <button class="class-button-tab-info button" data-tab="1">Basic Info</button>
    <button class="class-button-tab-info button" data-tab="2">Courses</button>
    <button class="class-button-tab-info button" data-tab="3">Schedule</button>
    <button class="class-button-tab-info button" data-tab="4">Students</button>
  </div>

  <div class="classes-content-info-container" data-tab="1">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Et, tempora magnam ut, perspiciatis commodi...</div>
  <div class="classes-content-info-container" data-tab="2">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ex consectetur minus animi odio expedita...</div>
  <div class="classes-content-info-container" data-tab="3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum quam, a, non illo incidunt totam...</div>
  <div class="classes-content-info-container" data-tab="4">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Animi, veniam. Sequi, ullam est...</div>
</div>

<!------ NS3 ---->
<div class="classes-content-container" data-tab="6">
  <div class="classes-buttons-info-container">
    <button class="class-button-tab-info button" data-tab="1">Basic Info</button>
    <button class="class-button-tab-info button" data-tab="2">Courses</button>
    <button class="class-button-tab-info button" data-tab="3">Schedule</button>
    <button class="class-button-tab-info button" data-tab="4">Students</button>
  </div>

  <div class="classes-content-info-container" data-tab="1">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Et, tempora magnam ut, perspiciatis commodi...</div>
  <div class="classes-content-info-container" data-tab="2">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ex consectetur minus animi odio expedita...</div>
  <div class="classes-content-info-container" data-tab="3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum quam, a, non illo incidunt totam...</div>
  <div class="classes-content-info-container" data-tab="4">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Animi, veniam. Sequi, ullam est...</div>
</div>

<!------ NS4 ---->
<div class="classes-content-container" data-tab="7">
  <div class="classes-buttons-info-container">
    <button class="class-button-tab-info button" data-tab="1">Basic Info</button>
    <button class="class-button-tab-info button" data-tab="2">Courses</button>
    <button class="class-button-tab-info button" data-tab="3">Schedule</button>
    <button class="class-button-tab-info button" data-tab="4">Students</button>
  </div>

  <div class="classes-content-info-container" data-tab="1">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Et, tempora magnam ut, perspiciatis commodi...</div>
  <div class="classes-content-info-container" data-tab="2">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ex consectetur minus animi odio expedita...</div>
  <div class="classes-content-info-container" data-tab="3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum quam, a, non illo incidunt totam...</div>
  <div class="classes-content-info-container" data-tab="4">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Animi, veniam. Sequi, ullam est...</div>
</div>


          
          <div class="dashboard-tabs-content" data-tab="4">Documents & Admissions…</div>
          <div class="dashboard-tabs-content" data-tab="5">Announcements / Notifications…</div>
          <div class="dashboard-tabs-content" data-tab="6">System Settings…</div>

        </main>
        </section>

        <script>
        document.addEventListener('DOMContentLoaded', () => {
        /* ---- Dashboard top-level tabs----*/
        const dashBtns = document.querySelectorAll('.dashboard-tab-button');
        const dashPanes = document.querySelectorAll('.dashboard-tabs-content');

        dashBtns.forEach(btn => {
          btn.addEventListener('click', () => {
            const tab = btn.dataset.tab;
            dashBtns.forEach(b => b.classList.remove('dashboards-btn-active'));
            dashPanes.forEach(p => p.classList.remove('dashboards-content-active'));
            btn.classList.add('dashboards-btn-active');
            document.querySelector(`.dashboard-tabs-content[data-tab="${tab}"]`)?.classList.add('dashboards-content-active');

            // Render charts only when Overview is visible
            if (tab === '1') {
              initChart();
              initPerformanceChart();
            }
          });
        });

        // Set initial active states
        dashBtns[0]?.classList.add('dashboards-btn-active');

        /* ====== User-Management inner tabs ====== */
        const umBtns = document.querySelectorAll('.user-management-tab-button');
        const umPanes = document.querySelectorAll('.user-management-content-container');

        umBtns.forEach((btn) => {
          btn.addEventListener('click', () => {
            const tab = btn.dataset.tab;
            umBtns.forEach(b => b.classList.remove('userManagementActiveButton'));
            umPanes.forEach(p => p.classList.remove('userManagementActiveContentContainer'));
            btn.classList.add('userManagementActiveButton');
            document.querySelector(`.user-management-content-container[data-tab="${tab}"]`)?.classList.add('userManagementActiveContentContainer');
          });
        });
        umBtns[0]?.classList.add('userManagementActiveButton');

        /* ====== Classes & Courses inner tabs ====== */
        const classBtns = document.querySelectorAll('.class-button-tab');
        const classPanes = document.querySelectorAll('.classes-content-container');

        classBtns.forEach((btn) => {
          btn.addEventListener('click', () => {
            const tab = btn.dataset.tab;
            classBtns.forEach(b => b.classList.remove('classesButtonsActive'));
            classPanes.forEach(p => p.classList.remove('classesContentContainerActive'));
            btn.classList.add('classesButtonsActive');
            document.querySelector(`.classes-content-container[data-tab="${tab}"]`)?.classList.add('classesContentContainerActive');
          });
        });
        classBtns[0]?.classList.add('classesButtonsActive');

        /* ====== Render charts on first load (Overview active by default) ====== */
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

        document.addEventListener('DOMContentLoaded', () => {
      const classInfoButtons = document.querySelectorAll('.class-button-tab-info');
      const classInfoContents = document.querySelectorAll('.classes-content-info-container');

      classInfoButtons.forEach(button => {
        button.addEventListener('click', () => {
          const tab = button.dataset.tab;

          classInfoButtons.forEach(btn => btn.classList.remove('classInfoActiveButton'));
          classInfoContents.forEach(content => content.classList.remove('classInfoActiveContent'));

          button.classList.add('classInfoActiveButton');
          document
            .querySelector(`.classes-content-info-container[data-tab="${tab}"]`)
            .classList.add('classInfoActiveContent');
        });
      });

      classInfoButtons[0].classList.add('classInfoActiveButton');
      classInfoContents[0].classList.add('classInfoActiveContent');
    });
    </script>

    <style>
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


        

        

        




        </script>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
        </body>
        </html>
