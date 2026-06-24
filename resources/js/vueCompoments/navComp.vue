
<script setup>
import {onMounted, ref} from 'vue';
import logo from '../../images/logo_lang.png'

//Hier werden Routen gesetzt, für mehrsprachig Website
const routes = {
    nl: {
        "1": 'contact',
      "2": 'paarden',
     "3":'ruiters',
      "4" :'diervoeder',
       "5" :'colofon',
     "6": 'privacybeleid',
      "7": 'winkel',
        "8": 'tuin'
    },
    de : {
      "1" :'kontakt',
      "2":'pferdebedarf',
      "3":'reiterbedarf',
        "4": 'tierfutter',
     "5": 'impressum',
      "6":'datenschutz',
       "7":'geschaeft',
        "8" :'garten'
    }
}
const lang = document.documentElement.lang;
let currentRoutes = null;
currentRoutes = getRoutes(lang);

onMounted(() => {
    const body    = document.body;
    const nav     = document.querySelector('.nav');
    const burger  = document.querySelector('.nav__burger');
    const layer   = document.getElementById('nav-layer');
    if (!nav || !burger || !layer) return;

    const backdrop = layer.querySelector('.nav-layer__backdrop');
    const closeBtn = layer.querySelector('#closeBtn');

    // Desktop- & Drawer-Items aktiv schalten
    const navItems       = document.querySelectorAll('.nav__li');
    const navItemDrawer  = document.querySelectorAll('.nav-layer__li');


    function highlightedNav() {
        const page = document.querySelector('#page');

        if (!page || !page.dataset.page) {
            return;
        }

        const currentPage = page.dataset.page;
        const navItems = document.querySelectorAll('.nav__li');

        navItems.forEach(item => {
            item.classList.toggle(
                'active',
                item.dataset.nav === currentPage
            );
        });
    }



    /**
     *
     *     navItems.forEach(item => {
     *         item.addEventListener('click', () => {
     *             navItems.forEach(i => i.classList.remove('active'));
     *             item.classList.add('active');
     *         });
     *     });
     */

    navItemDrawer.forEach(item => {
        item.addEventListener('click', () => {
            navItemDrawer.forEach(i => i.classList.remove('active'));
            item.classList.add('active');
            closeNav(); // Drawer nach Auswahl schließen (üblich auf Mobile)
        });
    });

    // ARIA initial
    burger.setAttribute('aria-expanded', 'false');
    layer.setAttribute('aria-hidden', 'true');


    function preparePathname(){
        let url_ = window.location.pathname || "/";
        url_ = url_.toLowerCase();
        url_ = url_.replace("/","");
        console.log(url_);
        return url_;
    }

    function openNav() {
        body.classList.add('no-scroll');
        layer.classList.add('is-open');
        nav.classList.add('is-open');            // <-- für Burger-Animation
        layer.setAttribute('aria-hidden', 'false');
        burger.setAttribute('aria-expanded', 'true');
    }

    function closeNav() {
        body.classList.remove('no-scroll');
        layer.classList.remove('is-open');
        nav.classList.remove('is-open');         // <-- zurücksetzen
        layer.setAttribute('aria-hidden', 'true');
        burger.setAttribute('aria-expanded', 'false');
    }


    function toggleNav() {
        layer.classList.contains('is-open') ? closeNav() : openNav();
    }

    burger.addEventListener('click', toggleNav);
    backdrop?.addEventListener('click', closeNav);
    closeBtn?.addEventListener('click', closeNav);

   highlightedNav();
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && layer.classList.contains('is-open')) closeNav();
    });
});
function getRoutes(lang){
    if(lang === 'de'){
        return routes.de;
    }
    return routes.nl;
}

function changeLang(){
    if(lang === 'de'){
        window.location.href="/locale/nl";
        return;
    }
    if(lang === 'nl'){
        window.location.href="/locale/de";
       return;
    }
    //Fallback
    window.location.href="locale/nl";
}

function directionTo(path){
    if(!path || path == ''){
        window.location.href="/";
        return;
    }
    window.location.href="/"+path;
}
</script>

<template>
    <nav class="nav">
        <div class="nav__brand">
            <img :src="logo" alt="Logo">
        </div>

        <!-- Desktop-Nav -->
        <ul class="nav__ul">
            <li data-nav="home" @click="directionTo()" class="nav__li active">Home</li>
            <li  data-nav="horse"  @click="directionTo(currentRoutes[2])" class="nav__li">{{ currentRoutes[2] }}</li>
            <li  data-nav="rider" @click="directionTo(currentRoutes[3])" class="nav__li">{{ currentRoutes[3] }}</li>
            <li  data-nav="feed" @click="directionTo(currentRoutes[4])" class="nav__li">{{ currentRoutes[4] }}</li>
            <li data-nav="garden" @click="directionTo(currentRoutes[8])" class="nav__li">  {{currentRoutes[8]}}</li>
            <li  data-nav="shop" @click="directionTo(currentRoutes[7])" class="nav__li" >{{ currentRoutes[7] }}</li>
            <li data-nav="contact" @click="directionTo(currentRoutes[1])" class="nav__li">  {{currentRoutes[1]}}</li>

        </ul>
        <div class="nav__lang">
            <button @click="changeLang()">
                <svg class="icon-globe" viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
                    <path d="M2 12h20" stroke="currentColor" stroke-width="2"/>
                    <path d="M12 2a15 15 0 0 1 0 20a15 15 0 0 1 0-20" stroke="currentColor" stroke-width="2" fill="none"/>
                </svg>
                {{ lang }}
            </button>
        </div>

        <!-- Hamburger (nur mobile sichtbar) -->
        <button class="nav__burger" aria-label="Menü öffnen/schließen">
            <span></span>
        </button>
    </nav>

    <!-- Drawer-Ebene -->
    <!-- Drawer-Ebene via Teleport außerhalb des <header> -->
    <teleport to="body">
        <div id="nav-layer" class="nav-layer" aria-hidden="true">
            <div class="nav-layer__backdrop"></div>
            <aside class="nav-layer__drawer" role="dialog" aria-modal="true">
                <ul class="nav-layer__ul">
                    <li data-nav="home" @click="directionTo()" class="nav__li active">Home</li>
                    <li  data-nav="horse" @click="directionTo(currentRoutes[2])" class="nav__li">{{ currentRoutes[2] }}</li>
                    <li data-nav="rider"  @click="directionTo(currentRoutes[3])" class="nav__li">{{ currentRoutes[3] }}</li>
                    <li  data-nav="feed" @click="directionTo(currentRoutes[4])" class="nav__li">{{ currentRoutes[4] }}</li>
                    <li data-nav="garden" @click="directionTo(currentRoutes[8])" class="nav__li">  {{currentRoutes[8]}}</li>
                    <li  data-nav="shop"   @click="directionTo(currentRoutes[7])" class="nav__li" >{{ currentRoutes[7] }}</li>
                    <li data-nav="contact" @click="directionTo(currentRoutes[1])" class="nav__li">  {{currentRoutes[1]}}</li>

                </ul>

                <button class="nav_btn" id="closeBtn" aria-label="Menü schließen">&#10005;</button>
                <img @click="directionTo()" class="nav-layer__img" :src="logo" alt="Logo" />

                <div class="nav-layer__social">
                    <a href="https://www.instagram.com" target="_blank" aria-label="Instagram" class="social-link instagram">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                            <path d="M7 2C4.243 2 2 4.243 2 7v10c0 2.757 2.243 5 5 5h10c2.757 0 5-2.243
        5-5V7c0-2.757-2.243-5-5-5H7zm0-2h10c3.866 0 7 3.134 7 7v10c0 3.866-3.134
        7-7 7H7c-3.866 0-7-3.134-7-7V7c0-3.866 3.134-7 7-7zm5 7a5 5 0 100 10 5
        5 0 000-10zm0 2a3 3 0 110 6 3 3 0 010-6zm6.5-3a1.5 1.5 0 100 3 1.5 1.5
        0 000-3z"/>
                        </svg>
                    </a>
                    <a href="https://www.facebook.com" target="_blank" aria-label="Facebook" class="social-link facebook">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                            <path d="M22 12c0-5.523-4.477-10-10-10S2
        6.477 2 12c0 4.991 3.657 9.128 8.438
        9.878v-6.987h-2.54V12h2.54V9.797c0-2.507
        1.492-3.89 3.777-3.89 1.094 0 2.238.195
        2.238.195v2.46h-1.26c-1.242 0-1.63.771-1.63
        1.562V12h2.773l-.443 2.891h-2.33v6.987C18.343
        21.128 22 16.991 22 12z"/>
                        </svg>
                    </a>
                </div>
            </aside>
        </div>
    </teleport>


</template>

<style scoped lang="scss">
$defaultColor: rgb(111, 66, 193);
$breakpoint: 768px;
$drawer-width: 280px;
$backdrop-color: rgba(43, 40, 40, 0.45);

/* Desktop-Nav */
.nav {
    width: 100%;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: space-between;   // sorgt für links <-> rechts

    &__ul {
        list-style: none;
        display: flex;
        gap: 8px;
        margin-right: auto;
    }

    &__li {
        font-size: 1.3rem;        // etwas größer (≈ 18px)
        font-weight: 1500;         // halbfett für bessere Lesbarkeit
        letter-spacing: 0.5px;    // mehr Luft zwischen Buchstaben
        line-height: 1.6;         // angenehmer Zeilenabstand
        padding: 12px 20px;       // mehr Klickfläche
        cursor: pointer;
        color: #111;              // Textfarbe (auf hellem BG)
        border-radius: 6px;
        transition: background-color .2s ease, color .2s ease;
        &:hover { background-color:  lighten($defaultColor, 10%); }
        &.active { background-color: darken($defaultColor, 10%);color: white; border-radius: 6px; }
    }

    &__li::first-letter {
        text-transform: capitalize;
    }

    &__burger{
        width: 42px; height: 42px;
        border: none; background: transparent;
        position: relative; cursor: pointer; padding: 0;
        display: none;
    }


}

.nav__lang {

    margin-left: 20px;                // kleiner Abstand zum Menü
}

.nav__lang button {
    background: rgb(255,255,255,0.2);
    color: #fff;
    padding: 6px 12px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;          // Abstand Icon <-> Text
    font-size: 15px;
    transition: background .2s ease;
}
.icon-globe {
    width: 18px;
    height: 18px;
}
.nav__lang button:hover {
    background: #444;
}


/* ========== Mobile: Hamburger + Drawer ========== */
/* Gemeinsamer Layer über der Seite */
.nav-layer {
    position: fixed;
    inset: 0;
    pointer-events: none;   // Standard: nichts klickbar
    z-index: 9990;          // EIN gemeinsamer Kontext
}

/* Backdrop unter Drawer */
.nav-layer__backdrop {
    position: fixed;
    inset: 0;
    background: $backdrop-color;
    opacity: 0;
    visibility: hidden;
    transition: opacity .2s ease, visibility .2s ease;
    z-index: 1;
    pointer-events: auto;   // klickbar, wenn sichtbar
}

/* Drawer über Backdrop */
.nav-layer__drawer {
    position: fixed;
    top: 0; right: 0;
    width: $drawer-width; max-width: 85vw;
    height: 100dvh;
    background: rgba(255, 255, 255);
    box-shadow: -12px 0 24px rgb(23, 22, 22);
    transform: translateX(100%);
    transition: transform .3s ease;
    z-index: 2;
    padding: 20px;
    pointer-events: auto;
}

/* Liste im Drawer */
.nav-layer__ul {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;   // vertikal stapeln
    align-items: flex-start;  // nach links ausrichten
    gap: 12px;                // moderner Abstand zwischen den Punkten
}

/* Einzelne Menü-Punkte */
.nav-layer__ul li {
    cursor: pointer;
    color: $defaultColor;
    font-size: 1.25rem;       // größer als Standard (≈ 20px)
    font-weight: 500;         // etwas kräftiger
    letter-spacing: 0.5px;    // leicht luftiger
    padding: 10px 0;          // mehr Klickfläche
    width: 100%;              // ganze Breite für besseren Touch-Hit
    transition: color .2s ease, transform .2s ease;
}

/* Hover-/Tap-Effekt
.nav-layer .nav-layer__ul li:hover {
    color: lighten($defaultColor, 15%);
    transform: translateX(4px);
    border-radius: 5px;
    padding: 2px;
}*/

.nav-layer .nav-layer__li.active {
    color: #090909;           // oder deine Akzentfarbe
    font-weight: 600;
    transform: translateX(4px);
    background: rgba(255,255,255,.08);
    border-radius: 8px;
}


.nav_btn{
    color: $defaultColor;
    border: none;
    background: none;
    cursor: pointer;
    font-size: 1.2rem;       // größer als Standard (≈ 20px)
    font-weight: 500;         // etwas kräftiger
    letter-spacing: 0.5px;    // leicht luftiger
    padding: 10px 0;
    width: 100%;              // ganze Breite für besseren Touch-Hit
    transition: color .2s ease, transform .2s ease;
}

/* Offen-Zustand – setze Klasse auf <body> ODER #nav-layer */
.is-open .nav-layer__drawer { transform: translateX(0); }
.is-open .nav-layer__backdrop { opacity: 1; visibility: visible; }

// Mobile
@media (max-width: $breakpoint) {
    .nav {
        &__ul { display: none; }    // Desktop-Liste ausblenden
        &__burger { display: block;margin-left: auto;} // Burger zeigen

    }
}

// Desktop
@media (min-width: $breakpoint) {
    .nav-layer { display: none; }
}

.no-scroll { overflow: hidden; height: 100dvh; }


$burger-size: 42px;
$burger-line-width: 24px;
$burger-line-height: 2px;
$burger-color: $defaultColor;

.nav__burger {
    width: $burger-size;
    height: $burger-size;
    border: none;
    background: transparent;
    position: relative;
    cursor: pointer;
    padding: 0;

    // drei Linien
    &::before,
    &::after,
    span {
        content: "";
        display: block;
        position: absolute;
        left: calc(($burger-size - $burger-line-width) / 2); // zentrieren
        width: $burger-line-width;
        height: $burger-line-height;
        background: $burger-color;
        border-radius: 2px;
        transition: transform .3s ease, opacity .3s ease;
    }

    span { top: 50%; transform: translateY(-50%); }
    &::before { top: 30%; }
    &::after  { top: 70%; }

}

.nav-layer__img{
    height: 133px;
    width: auto;
    justify-self: end;
}
.nav-layer__social {
    margin-top: auto;
    padding: 20px 0;
    display: flex;
    justify-content: center;
    gap: 20px;
}
/* Instgramm / Facebock  */
.social-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: rgba(255,255,255,0.1);
    color: #fff;               // Icon-Farbe
    text-decoration: none;
    transition: background .3s ease, transform .2s ease;

    &:hover {
        background: rgba(255,255,255,0.25);
        transform: scale(1.1);
    }

    svg {
        width: 22px;
        height: 22px;
    }
}

// Farben individuell für Branding
.social-link.instagram { background: #E1306C; }
.social-link.facebook  { background: #1877F2; }

</style>

