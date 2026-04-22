<script setup>

import {onMounted} from "vue";



onMounted(()=>{
       proofCookies();
});

function toggleBanner(){
    const banner = document.getElementsByClassName("consentContainer")[0];
    const backdrop = document.querySelector('.consentContainer--backdrop');
    backdrop.classList.toggle('is-hidden');
    banner.classList.contains("active") ? banner.classList.remove("active") : banner.classList.add("active");

}

function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
    return null;
}


function setTechnicalCookies(){
    document.cookie = "cookiesAccepted=technical; path=/; max-age=" + 60*60*24*365;
    console.log("TechnicalCookies allowed")
    toggleBanner();
}
function setAllCookies(){
    document.cookie = "cookiesAccepted=all; path=/; max-age=" + 60*60*24*365;
    console.log("Alle Cookies erlaubt")
    toggleBanner();
}
function setNoCookies(){
   console.log("Keine Cookies gesetzt")
    toggleBanner();
    document.cookie = "cookiesAccepted=; path=/; max-age=0";
}

function proofCookies(){
    const cookieValue = getCookie("cookiesAccepted");
    const banner = document.querySelector(".consentContainer");
    const backdrop = document.querySelector('.consentContainer--backdrop');

    if(cookieValue === "all" || cookieValue === "technical") {
        console.log("Cookie consent:", cookieValue);
        banner.classList.add("active");
        backdrop.classList.add("is-hidden");
    } else {
        backdrop.classList.remove("is-hidden");
        banner.classList.remove("active");
    }
}



</script>

<template>

    <teleport to="body">
    <div class="consentContainer--backdrop">
    <div class="consentContainer">
        <p class="consentContainer__p">
            Diese Website verwendet Cookies, die für den technischen Betrieb erforderlich sind.
        </p>

        <button @click="setTechnicalCookies" class="consentContainer__btn">
            Nur notwendige Cookies
        </button>

        <p>
            Wenn Sie keine Cookies zulassen, kann die Website nur eingeschränkt genutzt werden.
        </p>

        <button @click="setNoCookies" class="consentContainer__btn">
            Keine Cookies
        </button>

        <p class="consentContainer__p">
            Zusätzlich können Sie der Nutzung aller Cookies zustimmen, um die bestmögliche Funktionalität zu erhalten.
        </p>

        <button @click="setAllCookies" class="consentContainer__btn">
            Alle Cookies akzeptieren
        </button>

        <p class="consentContainer__p">
            Weitere Informationen finden Sie in unserer
            <a href="/datenschutz">Datenschutzerklärung</a>.
        </p>
    </div>
    </div>
    </teleport>


</template>

<style scoped lang="scss">
$defaultColor: rgb(111, 66, 193);
.consentContainer--backdrop {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.5);
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px); /* Safari */
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9998;

    opacity: 1;
    pointer-events: auto;
    transition: opacity .2s ease;
}

.consentContainer--backdrop.is-hidden {
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
}
.consentContainer {
    display: block;
    position: relative;            /* NICHT fixed */
    color: #fff;
    background: #444;
    padding: 2rem 3rem;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    max-width: 500px;
    width: 90%;
    text-align: center;
    z-index: 9999;

    &__btn{
        width: 70%;
        background:$defaultColor;
        color: #fff;
        border-radius: 15px;
        border: none;
        cursor: pointer;
        padding: 1.3rem;

    }

    &__p{
        color: #fff;
    }
    &__p a{
        color: #fff;               /* weiße Schrift */
        text-decoration: underline; /* klassisch verlinkt */
        font-weight: 500;          /* leicht hervorgehoben */
        transition: color 0.2s ease;
    }
    &__p a:hover{
        color:#ddd;
        text-decoration: none;
    }

}

.consentContainer.active {
    display: none;
}




</style>
