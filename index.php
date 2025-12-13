<?php
session_start();
include 'database/database.php';
include 'partials/functions.php'; 
include 'partials/header.php';

$error = '';
?>


  
    <?php  include 'partials/linkheader.php';?>
    <section class="new-hero-ui-wrapper">
    <section class="new-hero-ui">
     <div class="new-hero-ui-left">
        <h1>Socrate Tech Institute</h1>
     </div>  
     <div class="new-hero-button-ui">
     <a href="application.html"><button class="button postuler" type="submit">Postuler</button></a>
     </div>
    </section>
    </section>
    
    
    <!-----
    <section class="bg-main-container">
    <section class="hero">
      <div class="icon-background">
        <i class="fas fa-code"></i>
        <i class="fas fa-dna"></i>
        <i class="fas fa-brain"></i>
        <i class="fas fa-laptop-code"></i>
        <i class="fas fa-atom"></i>
        <i class="fas fa-book"></i>
        <i class="fas fa-calculator"></i>
        <i class="fas fa-microchip"></i>
        <i class="fas fa-flask"></i>
        <i class="fas fa-network-wired"></i>
        <i class="fas fa-globe"></i>
        <i class="fas fa-chalkboard-teacher"></i>
        <i class="fas fa-graduation-cap"></i>
        <i class="fas fa-lightbulb"></i>
        <i class="fas fa-square-root-variable"></i>
        <i class="fas fa-vials"></i>
        <i class="fas fa-seedling"></i>
        <i class="fas fa-wifi"></i>
        <i class="fas fa-terminal"></i>
        <i class="fas fa-head-side-brain"></i>
      </div>
      
      
      <div class="hero-left">
          <h1>Socrate Tech Institute</h1>
          <div class="subtitled-wrapper">
              <p class="subtitle1"><span>L’éducation classique</span> et <span>l’innovation au service</span> d’une Haïti nouvelle.</p>
              <p class="subtitle2">Une école secondaire <span>moderne</span>  qui forme des jeunes citoyens responsables, capables d’ <span>intervenir</span>, de <span>créer</span>, d’ <span>innover</span>  et de <span>comprendre</span> leur pays.</p>
             <div class="hero-button-wrapper">
              <a href="application.html"><button class="button postuler" type="submit">Postuler</button></a>
               <button class="button explorer">Explorer</button>
               
             </div>
          </div>
      </div>
      <div class="hero-right">
          <img src="images/hero-image.png" alt="">
      </div>
    </section>
    </section>
    ---->
  


    <main>
 
    <section class="explore-tab-ui">
  <h1>La Vie sur le Campus</h1>

  <div class="tabs">
    <button class="tabs-buttons btn-active" data-tab="1">Infrastructures</button>
    <button class="tabs-buttons" data-tab="2">Laboratoires</button>
    <button class="tabs-buttons" data-tab="3">Espaces Sportifs</button>
    <button class="tabs-buttons" data-tab="4">Gym & Détente</button>
  </div>

  <div class="tabs-content tabs-content-active campusgrid-container" data-tab="1">
  <img src="images/tabUIImages/building/batimentacademique.jpg" alt="">
  <img src="images/tabUIImages/building/library2.jpg" alt="">
  <img src="images/tabUIImages/building/salled'etude.jpg" alt="">
  <img src="images/tabUIImages/building/building2.jpg" alt="">
  </div>

  <div class="tabs-content campusgrid-container" data-tab="2">
    <div class="image"><img src="images/tabUIImages/building/classroom1.jpg" alt=""></div>
    <div class="image"><img src="images/tabUIImages/building/salled'etude.jpg" alt=""></div>
    <div class="image"><img src="images/tabUIImages/building/salledediscussion.jpg" alt=""></div>
    <div class="image"><img src="images/tabUIImages/building/salledeconference.jpg" alt=""></div>
  </div>

  <div class="tabs-content campusgrid-container" data-tab="3">
    <div class="image"><img src="images/tabUIImages/sport/terrainfootball.jpg" alt=""></div>
    <div class="image"><img src="images/tabUIImages/sport/terrainfutsal.jpg" alt=""></div>
    <div class="image"><img src="images/tabUIImages/sport/terrainvolleyball.png" alt=""></div>
    <div class="image"><img src="images/tabUIImages/sport/terrainbasket.webp" alt=""></div>
  </div>

  <div class="tabs-content campusgrid-container" data-tab="4">
    <div class="image"><img src="images/tabUIImages/sport/gym.jpg" alt=""></div>
    <div class="image"><img src="images/tabUIImages/sport/parcdedetente.jpg" alt=""></div>
    <div class="image"><img src="images/tabUIImages/sport/espaceconcert.jpg" alt=""></div>
    <div class="image"><img src="images/tabUIImages/building/library2.jpg" alt=""></div>
  </div>
</section>

          <h1 style="text-align:center;">Pourquoi Nous Choisir ?</h1>
      <section class="choose-us-container">
       <div class="grid-element-1">
        <div class="grid-element-title">
        <h2>Apprentissage Moderne</h2>
        </div>
          
       </div>
       <div class="grid-element-2">
        <div class="grid-element-title">
        <h2>Collaboration & Communauté</h2>
        </div>
        
       </div>
       <div class="grid-element-3">
        <div class="grid-element-title">
        <h2>Parcours Personnalisé</h2>
        </div>
        
       </div>
       <div class="grid-element-4">
        <div class="grid-element-title">
        <h2>Compétences du Futur</h2> 
        </div>
         
       </div>
    </section>

<!------
      <section class="why-choose-us">
        <h1 class="choose-title">Pourquoi Nous Choisir</h1>
      
        <div class="why-choose-us-element">
          <i class="fas fa-graduation-cap"></i>
          <div class="text-block">
            <h2>Une éducation tournée vers l’avenir</h2>
            <p>Nous préparons nos élèves aux défis de demain avec des cours intégrant technologie, pensée critique et créativité.</p>
          </div>
        </div>
      
        <div class="why-choose-us-element">
          <i class="fas fa-user-check"></i>
          <div class="text-block">
            <h2>Une pédagogie personnalisée</h2>
            <p>Chaque élève est unique. Nous adaptons notre approche pour encourager autonomie, collaboration et progression individuelle.</p>
          </div>
        </div>
      
        <div class="why-choose-us-element">
          <i class="fas fa-globe"></i>
          <div class="text-block">
            <h2>Un esprit ouvert sur le monde</h2>
            <p>Anglais, numérique, culture générale : nos élèves développent les compétences pour évoluer dans un monde globalisé.</p>
          </div>
        </div>
      
        <div class="why-choose-us-element">
          <i class="fas fa-school"></i>
          <div class="text-block">
            <h2>Des infrastructures modernes</h2>
            <p>Nos espaces sont pensés pour favoriser l’apprentissage actif : laboratoires, bibliothèques, espaces de détente, etc.</p>
          </div>
        </div>
      
        <div class="why-choose-us-element">
          <i class="fas fa-rocket"></i>
          <div class="text-block">
            <h2>Un tremplin vers la réussite</h2>
            <p>Stages, projets, accompagnement : nous formons des jeunes prêts à s’intégrer dans le monde professionnel et à innover.</p>
          </div>
        </div>
      </section>

      <section class="filieres-wrapper">
        <h1>Parcours Académiques & Cours Modernes Professionnalisants</h1>
        <div class="table-container">
          <table class="table">
            <thead>
              <tr>
                <th>Filière</th>
                <th>Objectif de la Filière</th>
                <th>Cours Modernes & Professionnels Associés</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td data-label="Filière">Sciences Mathématiques et Physiques (SMP)</td>
                <td data-label="Objectif de la Filière">
                  Former des esprits logiques et analytiques capables de résoudre des problèmes complexes dans des domaines scientifiques et technologiques.
                </td>
                <td data-label="Cours Modernes & Professionnels Associés">
                  <ul>
                    <li>Programmation Web</li>
                    <li>Résolution de Problèmes</li>
                    <li>Intelligence Artificielle</li>
                  </ul>
                </td>
              </tr>
              <tr>
                <td data-label="Filière">Sciences de la Vie et de la Terre (SVT)</td>
                <td data-label="Objectif de la Filière">
                  Développer une compréhension approfondie du vivant et des phénomènes naturels pour préparer à des carrières scientifiques ou médicales.
                </td>
                <td data-label="Cours Modernes & Professionnels Associés">
                  <ul>
                    <li>Premiers Soins</li>
                    <li>Introduction à l’Intelligence Artificielle</li>
                    <li>Compétences Numériques</li>
                  </ul>
                </td>
              </tr>
              <tr>
                <td data-label="Filière">Sciences Économiques et Sociales (SES)</td>
                <td data-label="Objectif de la Filière">
                  Initier les élèves aux mécanismes économiques, sociaux et politiques pour comprendre et agir dans le monde contemporain.
                </td>
                <td data-label="Cours Modernes & Professionnels Associés">
                  <ul>
                    <li>Entrepreneuriat</li>
                    <li>Éducation à la Citoyenneté</li>
                    <li>Culture Numérique</li>
                  </ul>
                </td>
              </tr>
              <tr>
                <td data-label="Filière">Lettres, Langues et Arts (LLA)</td>
                <td data-label="Objectif de la Filière">
                  Cultiver l’expression, l’analyse critique, la créativité et l’ouverture culturelle à travers les langues, la littérature et les arts.
                </td>
                <td data-label="Cours Modernes & Professionnels Associés">
                  <ul>
                    <li>Éducation à la Citoyenneté & Leadership avec la Réintégration du livre J’aime Haïti</li>
                    <li>Communication Digitale</li>
                  </ul>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </section>
      <div class="comment-postuler-title">
        <h1>Prêt(e) à Nous Rejoindre ? Voici Comment Faire !</h1>
      </div>
   
      <section class="commentpostuler">
       
        <div class="commentpostuler-element">
          <div class="check"><i class="fa-solid fa-check"></i></div>
          <span>1</span>
          <p>Remplir le formulaire d'inscription en ligne</p>
          <div class="line"></div>
        </div>
      
        <div class="commentpostuler-element">
          <div class="check"><i class="fa-solid fa-check"></i></div>
          <span>2</span>
          <p>Passer les examens d’admission</p>
          <div class="line"></div>
        </div>
      
        <div class="commentpostuler-element">
          <div class="check"><i class="fa-solid fa-check"></i></div>
          <span>3</span>
          <p>Entretien de motivation</p>
          <div class="line"></div>
        </div>
      
        <div class="commentpostuler-element">
          <div class="check"><i class="fa-solid fa-check"></i></div>
          <span>4</span>
          <p>Soumettre les pièces justificatives</p>
          <div class="line"></div>
        </div>
      
        <div class="commentpostuler-element">
          <div class="check"><i class="fa-solid fa-check"></i></div>
          <span>5</span>
          <p>Finaliser l'inscription</p>
        </div>
      </section>
      ------>

      <section class="testimonials-wrapper">
          <h1>Témoignages de Confiance</h1>
          <p class="testimonial-paragraph">À SocrateTech, chaque voix compte. Découvrez ce que nos élèves et leurs parents pensent de notre approche éducative moderne et humaine. Leurs expériences sont notre plus belle preuve d’impact.</p>
        <div class="testimonial-container">
          <div class="testimonial-element">

          <div class="testimonial-top">     
            <img src="images/testimonial/testimonial1.jpg" alt="">
          </div>
          <div class="testimonial-text">
            <p><i class="fa-solid fa-quote-left"></i>Ce que j’aime le plus à SocrateTech, c’est la manière dont on apprend. On travaille sur des projets concrets et ça me motive à donner le meilleur de moi-même chaque jour.<i class="fa-solid fa-quote-right"></i></p>
            <div class="extra-student-info">
              <h2>Lauriane M.</h2>
            <p>Etudiante en NS2</p>
            </div>
          </div> 
         
          
        </div>
        <div class="testimonial-element">

          <div class="testimonial-top">     
            <img src="images/testimonial/testimonial2.png" alt="">
          </div>
          <div class="testimonial-text">
            <p><i class="fa-solid fa-quote-left"></i>Grâce aux ateliers pratiques, j’ai pris confiance et appris à mieux collaborer. SocrateTech m’aide à progresser chaque jour dans un environnement stimulant.<i class="fa-solid fa-quote-right"></i></p>
            <div class="extra-student-info">
              <h2>Naomi B.</h2>
            <p>Etudiante en NS3</p>
            </div>
          </div> 
         
          
        </div>
        <div class="testimonial-element">

          <div class="testimonial-top">     
            <img src="images/testimonial/testimonial3.jpg" alt="">
          </div>
          <div class="testimonial-text">
            <p><i class="fa-solid fa-quote-left"></i>Grâce aux projets en équipe et aux cours modernes, je découvre chaque jour mes capacités. SocrateTech m’encourage à croire en moi et à viser plus haut.<i class="fa-solid fa-quote-right"></i></p>
            <div class="extra-student-info">
              <h2>Sabrina L.</h2>
            <p>Etudiante en NS1</p>
            </div>
          </div> 
         
          
        </div>
        </div>

      </section>

      <section class="ourpartners-wrapper">
        <h1>Un Réseau Solide de Partenaires</h1>
        <p>SocrateTech Institute est fier de collaborer avec des institutions prestigieuses qui partagent notre vision d’une éducation moderne, inclusive et tournée vers l’avenir. Ces partenariats renforcent notre impact sur la jeunesse haïtienne et soutiennent notre engagement à offrir une formation de qualité, ancrée dans les besoins du monde professionnel et de la société.</p>
        <div class="ourpartners-container">
          <figure class="ourpartners-element"><img src="images/testimonial/codingnobg.png" alt=""></figure>
          <figure class="ourpartners-element"><img src="images/testimonial/sogebanknobg.png" alt=""></figure>
          <figure class="ourpartners-element"><img src="images/testimonial/digicelnobg.png" alt=""></figure>
          <figure class="ourpartners-element"> <img src="images/testimonial/henridesnobg.png" alt=""></figure>
          <figure class="ourpartners-element"><img src="images/testimonial/fokalnobg.png" alt=""></figure>
          <figure class="ourpartners-element"><img src="images/testimonial/brananobg.png" alt=""></figure>
          <figure class="ourpartners-element"><img src="images/testimonial/menfpnobg.png" alt=""></figure>
          <figure class="ourpartners-element"><img src="images/testimonial/bnhnobg.png" alt=""> </figure>
                    
        </div>
      </section>






      <a href="../chatbot_folder/chatbot.php"> Chatbot</a>
    </main>

    <section class="footer-wrapper">
    <footer class="footer">
      <section class="footer-top">
        <h1>Connectés pour Inspirer et Éduquer</h1>
          <div class="logo-container">
            <a href="index.html"><img src="images/logowhite.png" alt=""></a>
          </div>
          <div class="social-media-container">
            <a href=""><i class="fa-brands fa-facebook"></i></a>
            <a href=""><i class="fa-brands fa-square-instagram"></i></a>
            <a href=""><i class="fa-solid fa-envelope"></i></a>
            <a href=""><i class="fa-solid fa-phone"></i></a>
            <a href=""><i class="fa-brands fa-square-x-twitter"></i></a>
            <a href=""><i class="fa-brands fa-linkedin"></i></a>
          </div>
      </section>
      <section class="footer-body">
        <div class="links-container">
          <h2>Accueil</h2>
          <a href="">Présentation</a>
          <a href="">Pourquoi SocrateTech ?</a>
          <a href="">Témoignages</a>
          <a href="">Nos Partenaires</a>
        </div>
        <div class="links-container">
          <h2>Classes & Cours</h2>
          <a href="">Filières Académiques</a>
          <a href="">Cours Modernes</a>
          <a href="">Agriculture & IA</a>
          <a href="">Cours d’Été / Club</a>
        
        </div>
        <div class="links-container">
          <h2>Inscription</h2>
          <a href="">Comment s’inscrire ?</a>
          <a href="">Examens d’entrée</a>
          <a href="">Documents requis</a>
          <a href="">Aide financière</a>
        </div>
        <div class="links-container">
          <h2>Contact</h2>
          <div class="links-container-contact"> <h3>Adresse :</h3>
            <a href="">Carrefour, Haïti</a></div>
          <div class="links-container-contact"><h3> Téléphone :</h3>
            <a href="">+509 45 67 89 00</a></div>
          <div class="links-container-contact"><h3>Email :</h3>
            <a href="">info@socratetech.edu.ht</a></div>
          <div class="links-container-contact"> <h3>Heures :</h3>
            <a href="">Lun-Ven, 8h - 16h</a></div>
             
        </div>
      </section>
      <section class="footer-end">
        <p><i class="fa-regular fa-copyright"></i> 2025 SocrateTech Institute. Tous droits réservés.</p>
        <p>Développé avec passion pour propulser la nouvelle génération haïtienne vers l'excellence éducative et technologique.</p>
      </section>
    </footer>
  </section>

  
 


  
       
  <script>
    document.addEventListener("DOMContentLoaded", () => {
  const tabButtons = document.querySelectorAll(".tabs-buttons");
  const tabContents = document.querySelectorAll(".tabs-content");

  if (!tabButtons.length || !tabContents.length) return;

  // reset all
  tabButtons.forEach(btn => btn.classList.remove("btn-active"));
  tabContents.forEach(c => c.classList.remove("tabs-content-active"));

  // activate first tab by default
  tabButtons[0].classList.add("btn-active");
  tabContents[0].classList.add("tabs-content-active");

  // click events
  tabButtons.forEach(button => {
    button.addEventListener("click", () => {
      const currentTab = button.dataset.tab;

      tabButtons.forEach(btn => btn.classList.remove("btn-active"));
      tabContents.forEach(content => content.classList.remove("tabs-content-active"));

      button.classList.add("btn-active");
      const activeContent = document.querySelector(`.tabs-content[data-tab="${currentTab}"]`);
      if (activeContent) activeContent.classList.add("tabs-content-active");
    });
  });
});
  </script>
<script src="js/script.js"></script>
<?php include 'partials/footer.php'?>