<?php
$loading_labels = [
    'Home',
    'Work',
    'TWICE',
    'The Damai',
    'FABRIC',
    'Aanstekelijk',
    'Base Create',
    'AVVR',
    'GraphicHunters',
    'Future Goals',
    'Atypikal',
    'One:Nil',
    'Andy Hardy',
    'About',
    'Contact',
    'Success',
    'Archive',
    'Error',
    'Styleguide',
    'Skills'
];
?>

<div class="no-scroll-overlay"></div>
<div class="loading-container">
    <div class="loading-screen">
        <div class="rounded-div-wrap top">
            <div class="rounded-div"></div>
        </div>
        <div class="loading-words">
            <h2 class="home-active home-active-first">Hello<div class="dot"></div>
            </h2>
            <h2 class="home-active">Bonjour<div class="dot"></div>
            </h2>
            <h2 class="home-active">स्वागत हे<div class="dot"></div>
            </h2>
            <h2 class="home-active">Ciao<div class="dot"></div>
            </h2>
            <h2 class="home-active">Olá<div class="dot"></div>
            </h2>
            <h2 class="home-active jap">おい<div class="dot"></div>
            </h2>
            <h2 class="home-active">Hallå<div class="dot"></div>
            </h2>
            <h2 class="home-active">Guten tag<div class="dot"></div>
            </h2>
            <h2 class="home-active-last">Hallo<div class="dot"></div>
            </h2>

            <?php foreach ($loading_labels as $label): ?>
                <h2 class="<?= ($current_page == $label) ? 'active' : '' ?>">
                    <?= htmlspecialchars($label) ?>
                    <div class="dot"></div>
                </h2>
            <?php endforeach; ?>
        </div>
        <div class="rounded-div-wrap bottom">
            <div class="rounded-div"></div>
        </div>
    </div>
</div>