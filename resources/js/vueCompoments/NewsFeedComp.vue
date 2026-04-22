<script setup>
import {ref, onMounted, computed} from 'vue'



/*
Lang Logik
 */
const lang = document.documentElement.lang;

const translate ={
    nl:{
        contact:"Aarzel niet om contact met ons op te nemen!"
    },
    de:{
        contact:"Zögere nicht uns zu kontaktieren!"
    }
}

function getRoutes(lang){
    if(lang === 'de'){
        return routes.de;
    }
    return routes.nl;
}
const contactText = ref(translate.nl.contact);

const props = defineProps({
    endpoint: { type: String, required: true },
    perPage: { type: Number, default: 10 },
})

// Zustand / State
const items = ref([])      // hier landen die News
const loading = ref(true)
const error = ref(null)
const index = ref(0);
const itemLen = ref(0);

// News holen
async function loadNews() {
    try {
        const url = new URL(props.endpoint)
        url.searchParams.set('per_page', props.perPage)
        const res = await fetch(url)
        if (!res.ok) throw new Error(`HTTP ${res.status}`)
        const data = await res.json()

        // Wenn Laravel paginator nutzt → data.data
        items.value = data.data ?? data
    } catch (err) {
        error.value = err.message
    } finally {
        loading.value = false
    }


}
function rotateContainer(){
    const newsContainer= document.querySelectorAll(".news-feed__li")
    newsContainer.forEach(item=>{
        item.classList.add('is-hidden');
    });
    newsContainer[index.value].classList.add("active");

}
function clickRight(){
    const newsContainer= document.querySelectorAll(".news-feed__li")
    let currentIndex = index.value;
    index.value = (index.value +1) % itemLen.value;
    console.log( index.value)
    newsContainer[currentIndex].classList.remove("active")
    newsContainer[ index.value].classList.add("active");
}
function clickLeft(){
    const newsContainer= document.querySelectorAll(".news-feed__li")
    let currentIndex = index.value;
    index.value = (index.value - 1 + itemLen.value) % itemLen.value;

    console.log( index.value)
    newsContainer[currentIndex].classList.remove("active")
    newsContainer[ index.value].classList.add("active");
}
onMounted(()=>{
    loadNews().then(()=>{
        itemLen.value=items.value.length;
        rotateContainer();
        console.log("GELADEN"+itemLen.value)

    });

    if(lang==="de"){
        contactText.value = translate.de.contact;
    }


})

</script>

<template>

    <div class="divider"></div>

    <div class="news-feed">
        <button class="btnLeft" @click="clickLeft"></button>
        <button class="btnRight" @click="clickRight"></button>

        <h2>News Feed</h2>

        <p v-if="loading">Lade News …</p>
        <p v-if="error" class="error">Fehler: {{ error }}</p>

        <ul class="news-feed__ul" v-else>
            <li class="news-feed__li" v-for="(item, i) in items" :key="i" :class="{active: i === index}">
                <h3>{{ item.name }}</h3>
                <p>{{ item.description }}</p>
                <strong>{{ item.price }} €</strong>
                <p>{{contactText}}</p>

            </li>
        </ul>
        <a>  </a>

    </div>
    <div class="divider"></div>
</template>

<style scoped lang="scss">


$defaultColor: rgb(111, 66, 193);
$defaultColorDark: rgba(111, 66, 193, .85);
$defaultColorLight: rgba(111, 66, 193, .12);
$ink: #0f1222;
$muted: #6b7280;
$bg: #f7f7fb;

/* --- Layout & Bühne --- */
.news-feed {
    position: relative;
    padding: 1.25rem 1.25rem 2.75rem;
    border-radius: 16px;
    background:
        radial-gradient(1200px 400px at 20% -20%, $defaultColorLight, transparent 40%),
        linear-gradient(180deg, #fff, #fafafe 60%, #f8f8ff);
    box-shadow:
        0 10px 30px rgba(18, 16, 52, .06),
        inset 0 1px 0 rgba(255,255,255,.6);
    border: 1px solid rgba(17, 24, 39, .06);
    overflow: hidden;
}

.news-feed h2 {
    margin: 0 0 .9rem;
    font-size: clamp(1.1rem, 1vw + .8rem, 1.4rem);
    font-weight: 700;
    color: $ink;
    letter-spacing: .2px;
    display: inline-flex;
    align-items: center;
    gap: .6rem;

    &::after {
        content: "• Sale";
        font-weight: 600;
        color: $defaultColorDark;
        background: rgba(111, 66, 193, .1);
        padding: .15rem .5rem;
        border-radius: 999px;
        font-size: .8rem;
    }
}

.status, .error {
    margin: .35rem 0 .75rem;
    font-size: .95rem;
}

.error {
    color: #b91c1c;
}

/* --- Slider-Viewport: genau eine Karte sichtbar --- */
.news-feed__ul {
    position: relative;
    list-style: none;
    padding: 0;
    margin: 0;

    /* Höhe an Karten anpassen, verhindert „Springen“ beim Wechsel */
    min-height: 180px; /* nach Bedarf: abhängig von Content */
    display: grid;
}

/* Grundzustand: verstecken, nur .active sichtbar */
.news-feed__li {
    display: none;
}

.news-feed__li.is-hidden {
    display: none;
}

.news-feed__li.active {
    display: block;
    animation: card-fade-in .35s ease-out both;
}

/* --- Karte / Produkt --- */
.news-feed__li > * {
    /* damit h3, p, strong innerhalb der Karte hübsch aussehen */
}

.news-feed__li .card {
    /* falls du eine innere .card nutzen willst */
}

.news-feed__li.active {
    background: #fff;
    border: 1px solid rgba(17, 24, 39, .06);
    border-radius: 14px;
    padding: 1rem 1.1rem 1.1rem;
    box-shadow:
        0 8px 30px rgba(17, 24, 39, .06),
        0 2px 6px rgba(17, 24, 39, .04);
}

/* Typo innerhalb der Karte */
.news-feed__li h3 {
    margin: 0 0 .3rem;
    font-size: 1.05rem;
    line-height: 1.2;
    color: $ink;
    font-weight: 700;
}

.news-feed__li p {
    margin: 0 0 .65rem;
    color: $muted;
    line-height: 1.45;
    font-size: .95rem;
}

.news-feed__li strong {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    font-weight: 800;
    color: #0b1120;
    font-size: 1.05rem;
    padding: .35rem .6rem;
    border-radius: 10px;
    background:
        linear-gradient(180deg, rgba(111,66,193,.12), rgba(111,66,193,.08));
    border: 1px solid rgba(111,66,193,.18);
    box-shadow: inset 0 1px 0 rgba(255,255,255,.6);
}

.news-feed__li strong::before {
    content: "SALE";
    font-size: .72rem;
    letter-spacing: .6px;
    color: #fff;
    background: $defaultColor;
    padding: .2rem .45rem;
    border-radius: 6px;
    line-height: 1;
}

/* --- Navigationspfeile --- */
.btnLeft,
.btnRight {
    --size: 44px;
    position: absolute;
    z-index: 2;
    top: calc(62px + .2rem); /* unter der Überschrift; bei Bedarf anpassen */
    transform: translateY(-50%);
    width: var(--size);
    height: var(--size);
    border-radius: 999px;
    border: 1px solid rgba(17, 24, 39, .08);
    background: #fff;
    box-shadow:
        0 8px 20px rgba(17, 24, 39, .08),
        inset 0 1px 0 rgba(255,255,255,.7);
    display: grid;
    place-items: center;
    cursor: pointer;
    transition: transform .12s ease, box-shadow .12s ease, border-color .12s ease;

    &:hover {
        transform: translateY(-50%) scale(1.04);
        box-shadow: 0 10px 26px rgba(17, 24, 39, .12);
        border-color: rgba(111, 66, 193, .25);
    }

    &:active {
        transform: translateY(-50%) scale(.98);
    }

    /* Icon */
    &::before {
        content: "";
        display: block;
        width: 12px;
        height: 12px;
        border-right: 2px solid $defaultColor;
        border-bottom: 2px solid $defaultColor;
        transform: rotate(-45deg);
    }
}

.btnLeft { left: .6rem; }
.btnRight { right: .6rem; }
.btnLeft::before { transform: rotate(135deg); } /* Pfeil nach links */

/* Mobile: Pfeile näher ran */
@media (max-width: 640px) {
    .btnLeft, .btnRight {
        --size: 40px;
        top: calc(58px + .2rem);
    }
}

/* --- dezenter „Glanz“ oben --- */
.news-feed::before {
    content: "";
    position: absolute;
    inset: 0 0 auto 0;
    height: 70px;
    background: linear-gradient(180deg, rgba(255,255,255,.7), rgba(255,255,255,0));
    pointer-events: none;
}

/* --- Animationen --- */
@keyframes card-fade-in {
    from { opacity: 0; transform: translateY(6px) scale(.995); }
    to   { opacity: 1; transform: translateY(0) scale(1); }
}
</style>
