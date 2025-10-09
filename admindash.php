<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STI | Admin Dashboard</title>
    <link rel="stylesheet" href="design.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Quicksand:wght@300..700&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">



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

        <!--------
        <button class="dashboard-tab-button" >Documents & Admissions</button>
        <button class="dashboard-tab-button" >Annoucements/Notifications</button>
        <button class="dashboard-tab-button" >System Settings</button>
        <button class="dashboard-tab-button" ></button>
        <button class="dashboard-tab-button" ></button>
        <button class="dashboard-tab-button"></button>
        ------>
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
        
        <div class="dashboard-tabs-content" data-tab="1">
          <div class="dashboard-card-outer-container">
            <div class="dashboard-card-container">
              <div class="card-child">
                <div class="card-child-left">
                <img src="images/dashboardImage/teachers.png" alt="">
                </div>
                <div class="card-child-right">
                  <span>50</span>
                <h2>Teachers</h2>
                </div>
               
              </div>
              <div class="card-child">
                <div class="card-child-left">
                 <img src="images/dashboardImage/staff.png" alt="">
                </div>
                <div class="card-child-right">
                  <span>100</span>
                <h2>S. Members</h2>
                </div>
              </div>
              <div class="card-child">
                <div class="card-child-left">
                 <img src="images/dashboardImage/students.png" alt="">
                </div>
                <div class="card-child-right">
                  <span>200</span>
                <h2>Students</h2>
                </div>
              </div>
              <div class="card-child">
                <div class="card-child-left">
                  <img src="images/dashboardImage/family.png" alt="">
                </div>
                <div class="card-child-right">
                  <span>150</span>
                <h2>Parents</h2>
                </div>
              </div>
            </div>
          </div>


         <div class="socratetech-statistic">
          <div class="socratetech-statistic-left">
            <h1>Attendance Rate</h1>
            <div id="chart">
            <script>initChart();</script>
            </div>
          </div>
          <div class="socratetech-statistic-right">
            <h1>Performance Statistics</h1>
            <div id="performanceChart">
              <script>initPerformanceChart();</script>
            </div>
          </div>
         </div>

          
        </div>
        <div class="dashboard-tabs-content user-management" data-tab="2">
          <button class="button add-admin-button">Add a New Member
            <span><i class="fa-solid fa-plus"></i></span></button>
        <div class="user-management-tab-container">
          <div class="user-management-button-container">
            <button class="user-management-tab-button" data-tab="1">Admin</button>
            <button class="user-management-tab-button" data-tab="2">Teachers</button>
            <button class="user-management-tab-button" data-tab="3">Students</button>
            <button class="user-management-tab-button" data-tab="4">Staff M.</button>
          
            </div>
               <div class="user-management-content-container " data-tab="1">
                <div class="admin-table-container">
                  <table class="table-container">
                    <thead>
                      <tr>
                        <th>Admin ID</th>
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>Age</th>
                        <th>Email</th>
                        <th>Description</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>

                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>

                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>

                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>

                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>

                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>

                    </tbody>
                    
                  </table>
                </div>
                

               </div>
               <div class="user-management-content-container" data-tab="2">
                <div class="admin-table-container">
                  <table class="table-container">
                    <thead>
                      <tr>
                        <th>Admin ID</th>
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>Age</th>
                        <th>Email</th>
                        <th>Description</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>

                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>

                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>

                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>

                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>

                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>

                    </tbody>
                    
                  </table>
                </div>
               </div>
               <div class="user-management-content-container" data-tab="3">

                <div class="admin-table-container">
                  <table class="table-container">
                    <thead>
                      <tr>
                        <th>Admin ID</th>
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>Age</th>
                        <th>Email</th>
                        <th>Description</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>

                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>

                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>

                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>

                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>

                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>

                    </tbody>
                    
                  </table>
                </div>
               </div>
               <div class="user-management-content-container" data-tab="4">
                <div class="admin-table-container">
                  <table class="table-container">
                    <thead>
                      <tr>
                        <th>Admin ID</th>
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>Age</th>
                        <th>Email</th>
                        <th>Description</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>

                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>

                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>

                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>

                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>

                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>JEAN</td>
                        <td>W. Leyder</td>
                        <td>22</td>
                        <td>jean@gmail.com</td>
                        <td>Principal</td>
                        <td>
                          <button id="delete" class="button"><i class="fa-solid fa-trash"></i></button>
                          <button id="modify" class="button"><i class="fa-solid fa-pen"></i></button>
                        </td>
  
                      </tr>

                    </tbody>
                    
                  </table>
                </div>
               </div>


            </div>


        </div>





        </div>
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
             <div class="classes-content-container" data-tab="1">
              <div class="informations-per-classes-main-container">
                <div class="informations-perclass-buttons-container">
                     <button class="informations-perclass-button button" data-tab="1">Basic Info</button>
                     <button class="informations-perclass-button button" data-tab="2">Courses</button>
                     <button class="informations-perclass-button button" data-tab="3">Students</button>
                     <button class="informations-perclass-button button" data-tab="4">Teachers</button>
                </div>
                       <div class="informations-perclass-content-container" data-tab="1">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Provident blanditiis exercitationem alias vel veritatis ea sint, earum magnam illo, dicta error minus natus, quasi nihil soluta? Sapiente, id ad. Modi.</div>
                       <div class="informations-perclass-content-container" data-tab="2">Lorem ipsum dolor sit, amet consectetur adipisicing elit. In quibusdam consectetur iure placeat porro illum debitis quo illo, eligendi fugiat, amet a obcaecati facere eos, est consequuntur ipsa asperiores. Autem!</div>
                       <div class="informations-perclass-content-container" data-tab="3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rerum, asperiores veritatis doloribus deserunt ipsa nobis porro dolores, magnam accusantium nemo odio? Animi tempora expedita ratione veritatis temporibus ut, eos praesentium.</div>
                       <div class="informations-perclass-content-container" data-tab="4">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Perspiciatis animi possimus quas. Sunt repellendus voluptatem voluptatibus. Animi deserunt non libero, sequi voluptate sapiente commodi fuga dolorem, tempora architecto, consequuntur impedit.</div>
                  
              </div>

             </div>
             <div class="classes-content-container" data-tab="2">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Dignissimos, maxime corrupti cupiditate ex voluptate, reiciendis autem magni aliquid accusantium, eos sapiente asperiores voluptates eaque ut sunt reprehenderit vel ab ipsum.</div>
             <div class="classes-content-container" data-tab="3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quod dicta repudiandae dolorem autem dignissimos necessitatibus magnam ipsum nihil ullam nesciunt tempore, amet nemo praesentium, eligendi voluptatum corporis? Quibusdam, sed tempora.</div>
             <div class="classes-content-container" data-tab="4">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Doloribus quasi sunt voluptate sapiente a, aut sint officia aperiam ab voluptates sit perspiciatis numquam illum similique adipisci placeat veritatis quibusdam tempore?</div>
             <div class="classes-content-container" data-tab="5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet quia, accusamus quo ab soluta doloribus distinctio nam ullam culpa, voluptatum sunt vitae similique, facere inventore. Odit quas corporis alias fugit.</div>
             <div class="classes-content-container" data-tab="6">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Fugit nulla necessitatibus tempore officiis ad ab fuga velit, impedit non tenetur blanditiis eligendi nobis pariatur nisi sit magnam sed ratione eum!</div>
             <div class="classes-content-container" data-tab="7">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ducimus accusantium magni quia nemo reiciendis, quas explicabo recusandae at consequuntur, architecto cum illo libero? Architecto qui consequuntur aut expedita eveniet necessitatibus?</div>
             


          </div>


        </div>
        <div class="dashboard-tabs-content" data-tab="4">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Non voluptates deleniti libero similique nulla voluptate fuga. Odit, corrupti numquam. Molestiae necessitatibus reprehenderit ipsam placeat soluta suscipit et laboriosam, tenetur optio!
        </div>
        <div class="dashboard-tabs-content" data-tab="5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Placeat minus itaque quo. Expedita, iusto corporis et itaque numquam odit veniam harum molestias placeat, modi consequatur, labore nesciunt cupiditate delectus omnis.</div>
        <div class="dashboard-tabs-content" data-tab="6">Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio amet possimus culpa, autem ad obcaecati in perspiciatis, perferendis repellendus dolorum et non excepturi quisquam debitis iste cupiditate dolore minima ipsa!</div>
        
      
      
      </main>
    </section>
    



<script>
    document.addEventListener('DOMContentLoaded',()=>{
const dashboardButtons = document.querySelectorAll('.dashboard-tab-button');
const dashboardContents = document.querySelectorAll('.dashboard-tabs-content');

for(let i = 0; i < dashboardButtons.length;i++){
  dashboardButtons[i].addEventListener('click',()=>{
      const dashboardTab = dashboardButtons[i].dataset.tab;

      for(let j = 0; j < dashboardButtons.length;j++){
        dashboardButtons[j].classList.remove('dashboards-btn-active');
        dashboardContents[j].classList.remove('dashboards-content-active');
      }
      dashboardButtons[i].classList.add('dashboards-btn-active');
      document.querySelector(`.dashboard-tabs-content[data-tab="${dashboardTab}"]`).classList.add('dashboards-content-active');
  });
}
dashboardButtons[0].classList.add('dashboards-btn-active');
dashboardContents[0].classList.add('dashboards-content-active');
});

//Charts
function initChart(){
  const el = document.querySelector('#chart');
  if (!el) { console.warn('#chart not found'); return; }

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

  const chart = new ApexCharts(el, options);
  chart.render();
}
document.addEventListener('DOMContentLoaded', initChart);


//Chart 2
function initPerformanceChart(){
  const el = document.querySelector('#performanceChart');
  if (!el) return;

  const options = {
    series: [44, 55, 41, 17, 15],  // example data
    chart: {
      type: 'donut',
      height: 350
    },
    labels: ['Excellent', 'Good', 'Average', 'Below Avg', 'Poor'],
    responsive: [{
      breakpoint: 480,
      options: {
        chart: { width: 200 },
        legend: { position: 'bottom' }
      }
    }],
    legend: {
      position: 'right',
      offsetY: 0,
      height: 230
    }
  };

  const chart = new ApexCharts(el, options);
  chart.render();
}

// Call it once DOM is ready
document.addEventListener('DOMContentLoaded', () => {
  initPerformanceChart();
});


//User Management Tab UI
document.addEventListener('DOMContentLoaded', () => {
  const userManagementButtons = document.querySelectorAll('.user-management-tab-button');
  const userManagementContentContainer = document.querySelectorAll('.user-management-content-container');

  for (let i = 0; i < userManagementButtons.length; i++) {
    userManagementButtons[i].addEventListener('click', () => {

      const userManagementTab = userManagementButtons[i].dataset.tab;
      for (let j = 0; j < userManagementButtons.length; j++) {
        userManagementButtons[j].classList.remove('userManagementActiveButton');
        userManagementContentContainer[j].classList.remove('userManagementActiveContentContainer');
      }

      userManagementButtons[i].classList.add('userManagementActiveButton');
      document
        .querySelector(`.user-management-content-container[data-tab="${userManagementTab}"]`)
        .classList.add('userManagementActiveContentContainer');
    });
  }

  userManagementButtons[0].classList.add('userManagementActiveButton');
  userManagementContentContainer[0].classList.add('userManagementActiveContentContainer');
});

//Classes & Courses Management Tab UI

document.addEventListener('DOMContentLoaded',()=>{

  const classesButtons = document.querySelectorAll('.class-button-tab');
  const classesMainContentContainer = document.querySelectorAll('.classes-content-container');

  for(let i = 0; i <  classesButtons.length; i++){
    classesButtons[i].addEventListener('click',()=>{
       const classestab =  classesButtons[i].dataset.tab;
 
       for(let j = 0; j < classesButtons.length; j++){
        classesButtons[j].classList.remove('classesButtonsActive');
        classesMainContentContainer[j].classList.remove('classesContentContainerActive');
       }

       classesButtons[i].classList.add('classesButtonsActive');
       document.querySelector(`.classes-content-container[data-tab="${classestab}"]`).classList.add('classesContentContainerActive');
    });
  };
  classesButtons[0].classList.add('classesButtonsActive');
  classesMainContentContainer[0].classList.add('classesContentContainerActive');
});

//Informations per class Tab UI
document.addEventListener('DOMContentLoaded',()=>{
const informationsClassButton = document.querySelectorAll('.informations-perclass-button');
const informationsClassContent = document.querySelectorAll('.informations-perclass-content-container');

for(let i = 0; i < informationsClassButton.length;i++){
  informationsClassButton[i].addEventListener('click',()=>{
    const informationClassTab = informationsClassButton[i].dataset.tab;

  for(let j = 0; j < informationsClassButton.length;j++){
    informationsClassButton[j].classList.remove('informations-perclass-button-active');
    informationsClassContent[j].classList.remove('informations-perclass-content-container-active');
  }
  informationsClassButton[i].classList.add('informations-perclass-button-active');
  document.querySelector(`.informations-perclass-content-container[data-tab="${informationClassTab}"]`).classList.add('informations-perclass-content-container-active');
  });
}
informationsClassButton[0].classList.add('informations-perclass-button-active');
informationsClassContent[0].classList.add('informations-perclass-content-container-active');

});





</script>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" integrity="sha384-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1DKg1ERo0BZlK" crossorigin="anonymous"></script>


<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</body>
</html>