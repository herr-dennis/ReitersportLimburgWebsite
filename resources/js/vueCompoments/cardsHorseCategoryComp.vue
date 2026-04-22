<script setup>
import acceessImg from '../../images/default.jpg';
import {onMounted} from "vue";

const lang = document.documentElement.lang.startsWith('nl') ? 'nl' : 'de';

const props = defineProps({
    translations: {
        type: Array,
        default: () => []
    }
});
</script>

<template>
    <div class="cardContainer">
        <div class="card" v-for="(item, index) in props.translations" :key="index">
            <div class="card-item">
                <img :src="item.image" alt="">

                <section>{{ item.title[lang] }}</section>

                <p class="card-item__beschreibung">
                    {{ lang === 'de' ? 'Beschreibung:' : 'Beschrijving:' }}
                </p>

                <p class="card-item__text">
                    {{ item.description[lang] }}
                </p>

                <h3>{{ lang === 'de' ? 'Marken:' : 'Merken:' }}</h3>

                <p class="card-item__marken">
                    {{ item.brands }}
                </p>


            </div>
        </div>
    </div>
</template>

<style scoped lang="scss">
$defaultColor: rgb(111, 66, 193);
$backdrop-color: rgb(255, 255, 255,0.7);



.cardContainer {
    display: flex;
    flex-wrap: wrap;          /* 👉 erlaubt Umbruch in mehrere Zeilen */
    justify-content: center;  /* zentriert Karten auch in der letzten Zeile */
    align-items: flex-start;   /* Karten alle oben ausrichten */
    gap: 20px;                /* moderner Ersatz für margin */
    padding: 20px;
}

.card {
    position: relative;
    width: clamp(260px, 30vw, 360px);
    background-color: $backdrop-color;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);

}

.card-item section{
    position: relative;
    top: -14px;               /* „liegt“ am Bildrand */
    margin: 0 10px -6px;      /* zieht die Karte optisch zusammen */
    padding: 8px 14px;
    text-align: center;
    font-size: 22px;
    color: $defaultColor;
    background: rgba(255,255,255,0.75);
    backdrop-filter: blur(6px);
    border-radius: 12px;
    border: 1px solid rgba(111,66,193,0.15);
    box-shadow: 0 2px 8px rgba(0,0,0,0.12);
}
.card-item {
    width: 100%;
}

    .card-item img {
        width: 100%;
        height: 200px;
        object-fit: cover; /* optional: füllt den Container */
    }

    .card-item__marken {
        width: 100%;
        height: 50px;}

.card-item__beschreibung {
    font-weight: 600;
    margin: 8px 0 10px;
    position: relative;
    display: inline-block;
}

.card-item__beschreibung::after {
    content: "";
    display: block;
    height: 2px;
    width: 48px;                 /* Länge der Linie */
    background: linear-gradient(90deg, $defaultColor, transparent);
    margin-top: 4px;
    border-radius: 2px;
}
.card-item__text {
    line-height: 1.5;
    max-width: 62ch;   /* angenehme Lesebreite */
}

.card h3 {
    margin: 14px 0 6px;
}
@media (max-width: 768px) {
    .card {
        width: min(100%, 420px);
    }
}
@media (min-width: 769px) {
    .card{
        height: 600px;
    }

}


</style>
