<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
   <link rel="stylesheet" href="../css/main.css">
</head>

<body data-barba="wrapper">
   <?php $current_page = 'About'; ?>
   <?php include './loading.php'; ?>
   <main class="main" id="about" data-barba="container" data-barba-namespace="about">
      <div class="main-wrap" data-scroll-container>

         <?php include './header.php'; ?>



         <header class="section default-header about-header" data-scroll-section>
            <?php include './nav.php'; ?>
            <div class="container medium once-in">
               <div class="row">
                  <div class="flex-col">
                     <h1><span>Helping brands thrive </span><span>in the digital world</span></h1>
                  </div>
               </div>
            </div>
         </header>

         <section class="section no-padding line-globe once-in" data-scroll-section>
            <div class="container medium">
               <div class="row">
                  <div class="flex-col">
                     <div class="stripe"></div>
                     <div class="digital-ball">
                        <div class="overlay"></div>
                        <div class="globe">
                           <div class="globe-wrap">
                              <div class="circle"></div>
                              <div class="circle"></div>
                              <div class="circle"></div>
                              <div class="circle-hor"></div>
                              <div class="circle-hor-middle"></div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>

         <section class="section about-image once-in" data-scroll-section>
            <div class="bottom-lightgray"></div>
            <div class="container">
               <div class="row">
                  <div class="flex-col">
                     <div class="arrow">
                        <svg width="14px" height="14px" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg">
                           <g stroke="#FFFFFF" stroke-width="1.5">
                              <g transform="rotate(90 7 7)">
                                 <polyline points="2.769 0 12 0 12 9.231"></polyline>
                                 <line x1="12" y1="0" x2="0" y2="12"></line>
                              </g>
                           </g>
                        </svg>
                     </div>
                     <p data-scroll data-scroll-speed="-1" data-scroll-position="top" data-scroll-offset="0%, -50%">
                        I help companies from all over the world with tailor-made solutions. With each project, I push
                        my work to new horizons, always putting quality first.
                     </p>
                     <p data-scroll data-scroll-speed="-1" data-scroll-position="top" data-scroll-offset="0%, -50%">
                        <span style="opacity: .5; display: block; padding-top: .5em;">Always exploring<span
                              class="animate-dot">.</span><span class="animate-dot">.</span><span
                              class="animate-dot">.</span></span>
                     </p>
                  </div>
                  <div class="flex-col">
                     <div class="single-about-image">
                        <div class="overlay overlay-image" data-scroll data-scroll-speed="-2"
                           data-scroll-position="top"></div>
                        <div class="overlay"></div>
                     </div>
                  </div>
               </div>
            </div>
         </section>

         <section class="section about-services" data-scroll-section>
            <div class="container">
               <div class="row">
                  <div class="flex-col">
                     <h2>I can help you with <span class="animate-dot">.</span><span class="animate-dot">.</span><span
                           class="animate-dot">.</span></h2>
                  </div>
               </div>
               <div class="row">
                  <div class="flex-col">
                     <h5>01</h5>
                     <div class="stripe"></div>
                     <h4>Design</h4>
                     <p>With a solid track record in designing websites, I deliver strong and user-friendly digital
                        designs. (Since 2024 only in combination with development)</p>
                  </div>
                  <div class="flex-col">
                     <h5>02</h5>
                     <div class="stripe"></div>
                     <h4>Development</h4>
                     <p>I build scalable websites from scratch that fit seamlessly with design. My focus is on micro
                        animations, transitions and interaction. Building with Webflow (or Kirby CMS).</p>
                  </div>
                  <div class="flex-col">
                     <h5>03</h5>
                     <div class="stripe"></div>
                     <h4>The full package</h4>
                     <p>A complete website from concept to implementation, that's what makes me stand out. My great
                        sense for design and my development skills enable me to create kick-ass projects.</p>
                  </div>
               </div>
            </div>
         </section>

         <section class="section about-awwwards" data-scroll-section>
            <div class="container">
               <div class="row">
                  <div class="flex-col">
                     <div class="single-image">
                        <div class="overlay" data-scroll data-scroll-speed="-1"></div>
                        <div class="overlay"></div>
                     </div>
                  </div>
                  <div class="flex-col">
                     <h2>Eng - Ammar Ahmed</h2>
                     <p>
                        I’m a 21-year-old Egyptian Full-Stack Web Developer, currently pursuing my degree at the Faculty
                        of Computers and Artificial Intelligence. I specialize in both front-end and back-end
                        development, with a strong passion for building modern, responsive, and user-friendly web
                        applications. I'm constantly learning and staying updated with the latest technologies to
                        deliver high-quality digital solutions.
                     </p>
                     <div class="news-widget-categories">
                        <ul id="audio-list" class="list-unstyled"></ul>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <?php include './footer.php'; ?>
      </div>
   </main>
   <script src="../js/audio-script.js"></script>
   <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/2.2.0/js.cookie.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/ScrollTrigger.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/@barba/core@2.10.3"></script>
   <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.6.1/dist/lazyload.min.js"></script>
   <script src="https://dennissnellenberg.com/assets/js/locomotive-scroll.min.js"></script>
   <script defer src="https://dennissnellenberg.com/assets/js/index-new.js"></script>
</body>

</html>