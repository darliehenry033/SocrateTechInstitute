const hamburgerMenu = document.querySelector(".hamburger-menu");
const navigationBar = document.querySelector(".navigation-bar");
const closeIcon = document.querySelector('.close-x');
window.addEventListener('click', (e)=>{
    if(navigationBar && !navigationBar.contains(e.target)){
        navigationBar.classList.remove('open-navigation-bar');
    }
});
hamburgerMenu.addEventListener("click", (e)=>{
    e.stopPropagation();
    navigationBar.classList.toggle('open-navigation-bar');
});
closeIcon.addEventListener('click', ()=>{
    navigationBar.classList.remove('open-navigation-bar');
});
/*Tab UI */






/*Modals Register and Login

document.addEventListener('DOMContentLoaded', () => {
  const registerModal = document.querySelector('.regislog-container');
  const registerBtn = document.querySelector('.register-btn');
  const overlayBg = document.querySelector('.register-container-overlay-bg');
  const closeBtn = document.querySelector('.closing-icon');

   registerBtn.addEventListener('click', () => {
    registerModal.classList.add('displayRegister');
    overlayBg.classList.add('disableBg-register');
  });

  closeBtn.addEventListener('click', () => {
    registerModal.classList.remove('displayRegister');
    overlayBg.classList.remove('disableBg-register');
  });

  window.addEventListener('mouseup', function (e) {
    if (!registerModal.contains(e.target) && !registerBtn.contains(e.target)) {
      registerModal.classList.remove('displayRegister');
      overlayBg.classList.remove('disableBg-register');
    }
  });
});

document.addEventListener('DOMContentLoaded', () => {
  const loginModal = document.querySelector('.login-container');
  const loginBtn = document.querySelector('.connexion-btn');
  const overlayBg = document.querySelector('.login-container-overlay-bg');
  const closeBtn = document.querySelector('.closingIconLogin');

  loginBtn.addEventListener('click', () => {
    loginModal.classList.add('displayLogin');
    overlayBg.classList.add('disableBg-login');
  });

  closeBtn.addEventListener('click', () => {
    loginModal.classList.remove('displayLogin');
    overlayBg.classList.remove('disableBg-login');
  });

  window.addEventListener('mouseup', function (e) {
    if (!registerModal.contains(e.target) && !registerBtn.contains(e.target)) {
      loginModal.classList.remove('displayLogin');
      overlayBg.classList.remove('disableBg-login');
    }
  });
});
*/


//API Cities of Haiti

async function loadHaitiCities() {
  const select = document.getElementById("birthplace");

  try {
    const url = "https://public.opendatasoft.com/api/records/1.0/search/"+
      "?dataset=geonames-all-cities-with-a-population-1000"+
      "&refine.cou_name_en=Haiti&rows=500";

    const res = await fetch(url);
    const data = await res.json();

    const cities = data.records.map(r => r.fields.name);

    cities.sort((a,b)=>a.localeCompare(b,'fr'));

    cities.forEach(city => {
      const opt = document.createElement("option");
      opt.value = city;
      opt.textContent = city;
      select.appendChild(opt);
    });
  } catch (err) {
    console.error("Erreur lors du chargement des villes:", err);
  }
}

document.addEventListener("DOMContentLoaded", loadHaitiCities);



/*Live Preview Image while uploading*/
const input = document.getElementById('photoInput');
const frame = document.getElementById('photoFrame');

input.addEventListener('change', (e) => {
  const file = e.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = (ev) => {
      frame.innerHTML = `<img src="${ev.target.result}" alt="Photo d'identité">`;
    };
    reader.readAsDataURL(file);
  } else {
    frame.innerHTML = `<span>Ajouter Photo</span>`;
  }
});

/*Documents Boxes : BrirthAct and Transcripts */
document.addEventListener('DOMContentLoaded', () => {
  const birthInput = document.getElementById('birthActInput');
  const birthBox = document.getElementById('birthActBox').querySelector('.file-name');

  const transcriptsInput = document.getElementById('transcriptsInput');
  const transcriptsBox = document.getElementById('transcriptsBox').querySelector('.file-name');

  birthInput.addEventListener('change', (e) => {
    const file = e.target.files[0];
    birthBox.textContent = file ? file.name : "Aucun fichier choisi";
  });

  transcriptsInput.addEventListener('change', (e) => {
    const files = Array.from(e.target.files).map(f => f.name);
    transcriptsBox.textContent = files.length ? files.join(', ') : "Aucun fichier choisi";
  });
});

/*Dashboards Logic / tabs handling */

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


//Admin related JS














  