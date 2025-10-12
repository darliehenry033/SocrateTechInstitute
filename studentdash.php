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

        <button class="dashboard-tab-button" data-tab="1">Main/Overview</button>
        <button class="dashboard-tab-button" data-tab="2">Classes/Courses</button>
        <button class="dashboard-tab-button" data-tab="3">Attendance</button>
        <button class="dashboard-tab-button" data-tab="4">Profile</button>
        <button class="dashboard-tab-button" data-tab="5">Community</button>
        

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
                <div class="card-child-left student-card">
                <span class="fa-solid fa-clipboard-list"></span>
                </div>
                <div class="card-child-right">
                  <span>15</span>
                <h2>Assignment Due</h2>
                </div>
               
              </div>
              <div class="card-child">
                <div class="card-child-left student-card">
                 <span class="fa-solid fa-award"></span>
                </div>
                <div class="card-child-right">
                  <span>85</span>
                <h2>Average Grade(%)</h2>
                </div>
              </div>
              <div class="card-child">
                <div class="card-child-left student-card">
                 <span class="fa-solid fa-calendar-check"></span>
                </div>
                <div class="card-child-right">
                  <span>90</span>
                <h2>Attendance Rate(%)</h2>
                </div>
              </div>

              <div class="card-child">
                <div class="card-child-left student-card">
                 <span class="fa-solid fa-chart-line"></span>
                </div>
                <div class="card-child-right">
                  <span>90</span>
                <h2>Learning Progress(%)</h2>
                </div>
              </div>
             
            </div>
          </div>

        </div>
        <div class="dashboard-tabs-content" data-tab="2">A</div>
        <div class="dashboard-tabs-content" data-tab="3">B</div>
        <div class="dashboard-tabs-content" data-tab="4">C</div>
        <div class="dashboard-tabs-content" data-tab="5">D</div>
        
        
      
      
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

</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" integrity="sha384-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1DKg1ERo0BZlK" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</body>
</html>