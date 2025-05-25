<?php
include 'db.php';

$ip = $_SERVER['REMOTE_ADDR'];
if ($ip === '127.0.0.1' || $ip === '::1') {
    $ip = '8.8.8.8';
}

$country = 'Unknown';
$response = @file_get_contents("http://ip-api.com/json/{$ip}?fields=country");
if ($response !== false) {
    $data = json_decode($response, true);
    if (isset($data['country'])) {
        $country = $data['country'];
    }
}

$stmt = $conn->prepare("INSERT INTO visitors (ip_address, country) VALUES (?, ?)");
if ($stmt) {
    $stmt->bind_param("ss", $ip, $country);
    $stmt->execute();
    $stmt->close();
}

$sql = "SELECT * FROM cards ORDER BY id DESC";
$result = $conn->query($sql);

$cards = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $cards[] = $row;
    }
}

$card = null;
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id > 0) {
    $stmt = $conn->prepare("SELECT * FROM cards WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $card = $result->fetch_assoc();
        } else {
            exit("Card not found.");
        }
        $stmt->close();
    } else {
        exit("Database error: " . $conn->error);
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
            <link href="../css/normalize.css" rel="stylesheet">
    <link href="../css/locomotive-scroll.css" rel="stylesheet">
    <link href="../css/styleguide.css" rel="stylesheet">
    <link href="../css/components.css" rel="stylesheet">
    <link href="../css/style-new.css" rel="stylesheet">
</head>
    <body data-barba="wrapper">
        <div class="no-scroll-overlay"></div>
        <div class="loading-container">
            <div class="loading-screen">
                <div class="rounded-div-wrap top">
                    <div class="rounded-div"></div>
                </div>
                <div class="loading-words">
                    <h2 class="home-active home-active-first">Hello<div class="dot"></div></h2>
                    <h2 class="home-active">Bonjour<div class="dot"></div></h2>
                    <h2 class="home-active">स्वागत हे<div class="dot"></div></h2>
                    <h2 class="home-active">Ciao<div class="dot"></div></h2>
                    <h2 class="home-active">Olá<div class="dot"></div></h2>
                    <h2 class="home-active jap">おい<div class="dot"></div></h2>
                    <h2 class="home-active">Hallå<div class="dot"></div></h2>
                    <h2 class="home-active">Guten tag<div class="dot"></div></h2>
                    <h2 class="home-active-last">Hallo<div class="dot"></div></h2>
                                        <h2>Home<div class="dot"></div></h2>
                                        <h2>Work<div class="dot"></div></h2>
                                        <h2>TWICE<div class="dot"></div></h2>
                                        <h2>The Damai<div class="dot"></div></h2>
                                        <h2>FABRIC&trade;<div class="dot"></div></h2>
                                        <h2>Aanstekelijk<div class="dot"></div></h2>
                                        <h2>Base Create<div class="dot"></div></h2>
                                        <h2>AVVR<div class="dot"></div></h2>
                                        <h2>GraphicHunters<div class="dot"></div></h2>
                                        <h2>Future Goals<div class="dot"></div></h2>
                                        <h2 class="active"><?php echo htmlspecialchars($card['title']); ?><div class="dot"></div></h2>
                                        <h2>One:Nil<div class="dot"></div></h2>
                                        <h2>Andy Hardy<div class="dot"></div></h2>
                                        <h2>About<div class="dot"></div></h2>
                                        <h2>Contact<div class="dot"></div></h2>
                                        <h2>Success<div class="dot"></div></h2>
                                        <h2>Archive<div class="dot"></div></h2>
                                        <h2>Error<div class="dot"></div></h2>
                                        <h2>Styleguide<div class="dot"></div></h2>
                                    </div>
                <div class="rounded-div-wrap bottom">
                    <div class="rounded-div"></div>
                </div>
            </div>
        </div>
        <main class="main" id="work-single" data-barba="container" data-barba-namespace="work-single" >
                                                        <div class="mouse-pos-list-image no-select"></div>
            <div class="mouse-pos-list-btn no-select"></div>
            <div class="mouse-pos-list-span no-select"><p>Next case</p></div>
                        <div class="btn btn-hamburger">
                <div class="btn-click magnetic" data-strength="50" data-strength-text="25">
                    <div class="btn-fill"></div>
                    <div class="btn-text">
                        <div class="btn-bars"></div>
                        <span class="btn-text-inner">Menu</span>
                    </div>
                </div>
            </div>
            <div class="overlay fixed-nav-back"></div>
            <div class="fixed-nav theme-dark">
                <div class="fixed-nav-rounded-div">
                    <div class="rounded-div-wrap">
                        <div class="rounded-div"></div>
                    </div>
                </div>
                <div class="fixed-nav-inner">
                    <div class="row nav-row">
                        <h5>Navigation</h5>
                        <div class="stripe"></div>
                        <ul class="links-wrap">
                            <li class="btn btn-link">
                                <a href="https://dennissnellenberg.com" class="btn-click magnetic" data-strength="24" data-strength-text="12">
                                <span class="btn-text">
                                    <span class="btn-text-inner">Home</span>
                                </span>
                                </a>
                            </li>
                            <li class="btn btn-link active">
                                <a href="https://dennissnellenberg.com/work" class="btn-click magnetic" data-strength="24" data-strength-text="12">
                                <span class="btn-text">
                                    <span class="btn-text-inner">Work</span>
                                </span>
                                </a>
                            </li>
                            <li class="btn btn-link">
                                <a href="https://dennissnellenberg.com/about" class="btn-click magnetic" data-strength="24" data-strength-text="12">
                                <span class="btn-text">
                                    <span class="btn-text-inner">About</span>
                                </span>
                                </a>
                            </li>
                            <li class="btn btn-link">
                                <a href="https://dennissnellenberg.com/contact" class="btn-click magnetic" data-strength="24" data-strength-text="12">
                                <span class="btn-text">
                                    <span class="btn-text-inner">Contact</span>
                                </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="row social-row">
                        <div class="stripe"></div>
                        <div class="socials">
                            <h5>Socials</h5>
                            <ul>
                                <li class="btn btn-link btn-link-external">
                                    <a href="https://www.awwwards.com/dennissnellenberg/" target="_blank" class="btn-click magnetic" data-strength="20" data-strength-text="10">
                                        <span class="btn-text">
                                            <span class="btn-text-inner">Awwwards</span>
                                        </span>
                                    </a>
                                </li>
                                <li class="btn btn-link btn-link-external">
                                    <a href="https://www.instagram.com/codebydennis/" target="_blank" class="btn-click magnetic" data-strength="20" data-strength-text="10">
                                        <span class="btn-text">
                                            <span class="btn-text-inner">Instagram</span>
                                        </span>
                                    </a>
                                </li>
                                <li class="btn btn-link btn-link-external">
                                    <a href="https://twitter.com/codebydennis" target="_blank" class="btn-click magnetic" data-strength="20" data-strength-text="10">
                                        <span class="btn-text">
                                            <span class="btn-text-inner">Twitter</span>
                                        </span>
                                    </a>
                                </li>
                                <li class="btn btn-link btn-link-external">
                                    <a href="https://www.linkedin.com/in/dennissnellenberg/" target="_blank" class="btn-click magnetic" data-strength="20" data-strength-text="10">
                                        <span class="btn-text">
                                            <span class="btn-text-inner">LinkedIn</span>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-wrap" data-scroll-container><section class="section case-top-wrap " >
<header class="section default-header case-header" data-scroll-section>
   <div class="nav-bar">
    <div class="credits-top">
        <div class="btn btn-link btn-left-top">
            <a href="https://dennissnellenberg.com" class="btn-click magnetic" data-strength="20" data-strength-text="10">
            <span class="btn-text">
                <div class="credit"><span>©</span></div><div class="cbd"><span class="code-by">Code by </span><span class="dennis"><span class="dennis-span">Dennis</span> <span class="snellenberg">Snellenberg</span></span></span></div>
            </span>
            </a>
        </div>
    </div>
    <ul class="links-wrap">
        <li class="btn btn-link active">
            <a href="https://dennissnellenberg.com/work" class="btn-click magnetic" data-strength="20" data-strength-text="10">
            <span class="btn-text">
                <span class="btn-text-inner">Work</span>
            </span>
            </a>
        </li>
        <li class="btn btn-link">
            <a href="https://dennissnellenberg.com/about" class="btn-click magnetic" data-strength="20" data-strength-text="10">
            <span class="btn-text">
                <span class="btn-text-inner">About</span>
            </span>
            </a>
        </li>
        <li class="btn btn-link">
            <a href="https://dennissnellenberg.com/contact" class="btn-click magnetic" data-strength="20" data-strength-text="10">
            <span class="btn-text">
                <span class="btn-text-inner">Contact</span>
            </span>
            </a>
        </li>
        <li class="btn btn-link btn-menu">
            <div class="btn-click magnetic" data-strength="20" data-strength-text="10">
                <div class="btn-text">
                    <span class="btn-text-inner">Menu</span>
                </div>
            </div>
        </li>
    </ul>
</div>   <div class="container medium once-in">
      <div class="row">
         <div class="flex-col">
            <h1><?php echo htmlspecialchars($card['title']); ?></h1>
         </div>
      </div>
   </div>
</header>
<section class="section case-intro once-in" data-scroll-section>
   <div class="container medium">
      <div class="row">
         <div class="flex-col">
            <h5>Role / Services</h5>
            <div class="stripe"></div>
            <li><p><?php echo htmlspecialchars($card['role']); ?> & Development</p></li>
         </div>
         <div class="flex-col">
            <h5>Credits</h5>            <div class="stripe"></div>
            <li><p>Design: Robyn Cambruzzi</p></li>         </div>
         <div class="flex-col">
            <h5>Location & year</h5>            <div class="stripe"></div>
            <li><p><?php echo htmlspecialchars($card['location']); ?> ©</p></li>            <li><p><?php echo htmlspecialchars($card['year']); ?></p></li>
         </div>
      </div>
   </div>
</section>

<section class="section case-intro-image once-in block-padding-bottom "  data-scroll-section>
   <div class="container">
      <div class="row">
         <div class="flex-col">
            <div class="btn-wrap theme-dark">
               <div class="btn btn-round" data-scroll data-scroll-speed="2"  data-scroll-position="top">
                  <a href="<?php echo htmlspecialchars($card['link']); ?>" target="_blank" class="btn-click magnetic " data-strength="100" data-strength-text="50">
                     <div class="btn-fill"></div>
                     <span class="btn-text">
                        <span class="btn-text-inner">Live site <div class="arrow"><?xml version="1.0" encoding="UTF-8"?>
<svg width="14px" height="14px" viewBox="0 0 14 14" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
    <title>arrow-up-right</title>
    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <g id="Artboard" transform="translate(-1019.000000, -279.000000)" stroke="#FFFFFF" stroke-width="1.5">
            <g id="arrow-up-right" transform="translate(1026.000000, 286.000000) rotate(90.000000) translate(-1026.000000, -286.000000) translate(1020.000000, 280.000000)">
                <polyline id="Path" points="2.76923077 0 12 0 12 9.23076923"></polyline>
                <line x1="12" y1="0" x2="0" y2="12" id="Path"></line>
            </g>
        </g>
    </g>
</svg></div></span>
                     </span>
                  </a>
               </div>
            </div>
            <div class="single-image">
               <img class="overlay lazy" data-scroll data-scroll-speed="-1" src="https://dennissnellenberg.com/media/pages/work/atypikal/e0f19f8847-1646837280/atypikal-case-header-540x.jpg" data-src="https://dennissnellenberg.com/media/pages/work/atypikal/e0f19f8847-1646837280/atypikal-case-header.jpg" />               <img class="overlay overlay-image-top lazy" data-src="https://dennissnellenberg.com/media/pages/work/atypikal/fd65568bd5-1646837277/atypikal-case-header-overlay.svg" />            </div>
         </div>
      </div>
   </div>
</section>
</section>
<section class="section single-block block-device block_0 block-padding-bottom " style="background-color: #d8d5cc;" data-scroll-section>
   <div class="container">
      <div class="row device-macprohigher">
         <div class="flex-col">
            <div class="device">
               <div class="single-image">
               
               <img src="uploads/<?php echo htmlspecialchars($card['image1']); ?>"  alt="">

                  <div class="overlay overlay-image playpauze"><video muted playsinline></video></div>                                     
                   
               </div>
                  
               <div class="overlay-device-image"><div class="overlay overlay-device" style="background: url('https://dennissnellenberg.com/assets/img/device-macpro-higher.png') center center no-repeat; background-size: cover;"></div></div>
                           </div>
         </div>
      </div>
   </div>
</section><section class="section single-block block-mobile-devices block_1" data-scroll-section >
   <div class="container no-padding block-padding-sides amount-3">
      <div class="row device-iphone13nonotch">
         <div class="flex-col block-padding-bottom" >
            <div class="device" data-scroll data-scroll-target=".block_1" data-scroll-speed="-1">
               <div class="single-image">
                     
                  <div class="overlay overlay-image playpauze"><video class="overlay" src="https://dennissnellenberg.com/media/pages/work/atypikal/52f224ca12-1646837279/atypikal-screen-mobile-load.mp4" loop muted playsinline></video></div>                                 </div>  
                              <div class="overlay-device-image"><div class="overlay overlay-device" style="background: url('https://dennissnellenberg.com/assets/img/device-iphone13-nonotch.png') center center no-repeat; background-size: cover;"></div></div>
                           </div>
         </div>
                  <div class="flex-col block-padding-bottom" >
            <div class="device">
               <div class="single-image">
                     
                  <img class="overlay overlay-image lazy" src="https://dennissnellenberg.com/media/pages/work/atypikal/6d95789446-1646837279/atypikal-mobile-2-540x.jpg" data-src="https://dennissnellenberg.com/media/pages/work/atypikal/6d95789446-1646837279/atypikal-mobile-2.jpg" width="540" height="1170" /> 
                                 </div>  
                              <div class="overlay-device-image"><div class="overlay overlay-device" style="background: url('https://dennissnellenberg.com/assets/img/device-iphone13-nonotch.png') center center no-repeat; background-size: cover;"></div></div>
                           </div>
         </div>
                           <div class="flex-col block-padding-bottom" >
            <div class="device" data-scroll data-scroll-target=".block_1" data-scroll-speed="1">
               <div class="single-image">
                     
                  <div class="overlay overlay-image playpauze"><video class="overlay" src="https://dennissnellenberg.com/media/pages/work/atypikal/71c55005ad-1646837277/atypikal-mobile-footer.mp4" loop muted playsinline></video></div>                                 </div>  
                              <div class="overlay-device-image"><div class="overlay overlay-device" style="background: url('https://dennissnellenberg.com/assets/img/device-iphone13-nonotch.png') center center no-repeat; background-size: cover;"></div></div>
                           </div>
         </div>
               </div>
   </div>
</section>

<section class="section single-block block-device block_2 block-padding-bottom " style="background-color: #d8d5cc;" data-scroll-section>
   <div class="container">
      <div class="row device-ipadpro">
         <div class="flex-col">
            <div class="device">
               <div class="single-image">
                     
                  <div class="overlay overlay-image playpauze"><video class="overlay" src="https://dennissnellenberg.com/media/pages/work/atypikal/06caeb881e-1646837280/atypikal-screen-footer.mp4" loop muted playsinline></video></div>                                     
                   
               </div>
                  
               <div class="overlay-device-image"><div class="overlay overlay-device" style="background: url('https://dennissnellenberg.com/assets/img/device-ipad-pro-lower.png') center center no-repeat; background-size: cover;"></div><img class="overlay overlay-pencil lazy"  data-scroll data-scroll-speed="1.5" data-src="https://dennissnellenberg.com/assets/img/device-apple-pencil.png" /></div>
                           </div>
         </div>
      </div>
   </div>
</section><div class="footer-rounded-div" data-scroll-section>
   <div class="rounded-div-wrap">
      <div class="rounded-div" style="background-color: #d8d5cc;"></div>
   </div>
</div>
<div class="footer-wrap footer-case-wrap theme-dark" data-scroll-section>
   <section class="section footer" data-scroll data-scroll-speed="-4" data-scroll-position="bottom" data-scroll-offset="-25%, 0%">
      <div class="container medium">
         <a href="https://dennissnellenberg.com/work/one-nil" class="row next-case-btn">
            <div class="flex-col">
               <p>Next case</p>
               <h2>One:Nil</h2>
            </div>
            <div class="tile-image-wrap">
               <div class="tile-image">
                                    <div class="overlay overlay-image lazy" data-scroll data-scroll-speed="2.5" data-scroll-position="bottom" style="background-color:var(--color-lightgray); background-position: center center; background-repeat: no-repeat; background-size: cover;" data-bg="https://dennissnellenberg.com/media/pages/work/one-nil/288460827e-1646837272/thumbnail-onenil-v3.jpg"></div>                                 </div>
            </div>
         </a>
         <div class="row">
            <div class="flex-col">
               <div class="stripe"></div>
            </div>
         </div>
         <div class="row">
            <div class="flex-col">
               <div class="btn btn-normal">
                  <a href="https://dennissnellenberg.com/work" class="btn-click magnetic" data-strength="25" data-strength-text="15">
                     <div class="btn-fill"></div>
                     <span class="btn-text">
                        <span class="btn-text-inner change">All work<div class="count-nr">11</div></span>
                     </span>
                  </a>
               </div>
            </div>
         </div>
      </div>
      <div class="container no-padding">
         <div class="row bottom-footer">
            <div class="flex-col">
               <div class="credits">
                     <h5>Version</h5>
                     <p>2022 © Edition</p>
               </div>
               <div class="time">
                     <h5>Local time</h5>
                     <p><span id="timeSpan">09:41 PM CET</span></p>
               </div>
            </div>
            <div class="flex-col">
               <div class="socials">
                     <h5>Socials</h5>
                     <ul>
                        <li class="btn btn-link btn-link-external">
                           <a href="https://www.awwwards.com/dennissnellenberg/" target="_blank" class="btn-click magnetic" data-strength="20" data-strength-text="10">
                                 <span class="btn-text">
                                    <span class="btn-text-inner">Awwwards</span>
                                 </span>
                           </a>
                        </li>
                        <li class="btn btn-link btn-link-external">
                           <a href="https://www.instagram.com/codebydennis/" target="_blank" class="btn-click magnetic" data-strength="20" data-strength-text="10">
                                 <span class="btn-text">
                                    <span class="btn-text-inner">Instagram</span>
                                 </span>
                           </a>
                        </li>
                        <li class="btn btn-link btn-link-external">
                           <a href="https://dribbble.com/dennissnellenberg" target="_blank" class="btn-click magnetic" data-strength="20" data-strength-text="10">
                                 <span class="btn-text">
                                    <span class="btn-text-inner">Dribbble</span>
                                 </span>
                           </a>
                        </li>
                        <li class="btn btn-link btn-link-external">
                           <a href="https://www.linkedin.com/in/dennissnellenberg/" target="_blank" class="btn-click magnetic" data-strength="20" data-strength-text="10">
                                 <span class="btn-text">
                                    <span class="btn-text-inner">LinkedIn</span>
                                 </span>
                           </a>
                        </li>
                     </ul>
                     <div class="stripe"></div>
               </div>
            </div>
         </div>
      </div>
   </section>
   <div class="overlay overlay-gradient"></div>
</div>
<style>.block-fullwidth {background: #000;}</style>             
                               </div>
        </main>




<div class="card-details">

    <a href="products.php" class="back-link">&larr; العودة إلى المنتجات</a>

 

    <div class="card-section">
        <strong>الوصف:</strong> <?php echo nl2br(htmlspecialchars($card['description'])); ?>
    </div>



    <div class="card-section">
        <strong>الدور:</strong> 
    </div>

    <div class="card-section">
        <strong>الخدمات:</strong> <?php echo nl2br(htmlspecialchars($card['services'])); ?>
    </div>

    <div class="card-section">
        <strong>الاعتمادات:</strong> <?php echo nl2br(htmlspecialchars($card['credits'])); ?>
    </div>


    <div class="card-section">
        <strong>نص إضافي:</strong> <?php echo nl2br(htmlspecialchars($card['extra_text'])); ?>
    </div>

    <div class="card-section">
        <strong>تاريخ الإنشاء:</strong> <?php echo htmlspecialchars($card['created_at']); ?>
    </div>

    
    <div class="card-images">
    <?php if (!empty($card['image1'])): ?>
        <img src="uploads/<?php echo htmlspecialchars($card['image1']); ?>" alt="صورة 1" style="max-width: 100%; border-radius:8px; margin-bottom: 15px;">
    <?php endif; ?>

    <?php if (!empty($card['image2'])): ?>
        <img src="uploads/<?php echo htmlspecialchars($card['image2']); ?>" alt="صورة 2" style="max-width: 100%; border-radius:8px; margin-bottom: 15px;">
    <?php endif; ?>

    <?php if (!empty($card['image3'])): ?>
        <img src="uploads/<?php echo htmlspecialchars($card['image3']); ?>" alt="صورة 3" style="max-width: 100%; border-radius:8px; margin-bottom: 15px;">
    <?php endif; ?>

    <?php if (!empty($card['image4'])): ?>
        <img src="uploads/<?php echo htmlspecialchars($card['image4']); ?>" alt="صورة 4" style="max-width: 100%; border-radius:8px; margin-bottom: 15px;">
    <?php endif; ?>

    <?php if (!empty($card['image5'])): ?>
        <img src="uploads/<?php echo htmlspecialchars($card['image5']); ?>" alt="صورة 5" style="max-width: 100%; border-radius:8px; margin-bottom: 15px;">
    <?php endif; ?>

    <?php if (!empty($card['image6'])): ?>
        <img src="uploads/<?php echo htmlspecialchars($card['image6']); ?>" alt="صورة 6" style="max-width: 100%; border-radius:8px; margin-bottom: 15px;">
    <?php endif; ?>
</div>

</div>



     
                 <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/2.2.0/js.cookie.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/ScrollTrigger.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@barba/core@2.10.3"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.6.1/dist/lazyload.min.js"></script>
    <script src="../js/locomotive-scroll.min.js"></script>
    <script defer src="../js/index-new.js"></script>  
        
        </body>
</html>
