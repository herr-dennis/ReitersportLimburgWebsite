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

                <!-- TEXT mit Absätzen -->
                <p
                    class="card-item__text"
                    v-html="item.description[lang].replace(/\n/g, '<br>')"
                ></p>

                <!-- BULLETS -->
                <ul
                    v-if="item.bullets && item.bullets[lang] && item.bullets[lang].length"
                    class="card-item__bullets"
                >
                    <li v-for="(point, i) in item.bullets[lang]" :key="i">
                        {{ point }}
                    </li>
                </ul>

                <!-- MARKEN nur anzeigen wenn vorhanden -->
                <div v-if="item.brands">
                    <h3>{{ lang === 'de' ? 'Marken:' : 'Merken:' }}</h3>
                    <p class="card-item__marken">
                        {{ item.brands }}
                    </p>
                </div>

            </div>
        </div>
    </div>
</template>

<style scoped lang="scss">
$defaultColor: rgb(111, 66, 193);
$backdrop-color: rgba(255, 255, 255, 0.7);

.cardContainer {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: stretch;
    gap: 20px;
    padding: 20px;
}

.card {
    position: relative;
    width: clamp(260px, 30vw, 360px);
    background-color: $backdrop-color;
    display: flex;
    flex-direction: column;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    min-height: 600px;
    height: auto;
}

.card-item {
    width: 100%;
    display: flex;
    flex-direction: column;
    height: 100%;
}

.card-item img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 8px;
    flex-shrink: 0;
}

.card-item section {
    position: relative;
    top: -14px;
    margin: 0 10px -6px;
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
    width: 48px;
    background: linear-gradient(90deg, $defaultColor, transparent);
    margin-top: 4px;
    border-radius: 2px;
}

.card-item__text {
    line-height: 1.55;
    max-width: 62ch;
    margin: 0 0 12px;
    overflow-wrap: break-word;
}

.card-item__bullets {
    margin: 10px 0 0;
    padding-left: 22px;

}

.card-item__bullets li {
    margin-bottom: 6px;
    line-height: 1.45;
}
.card-item__bullets li::marker {
    color: $defaultColor;
}
.card h3 {
    margin: 14px 0 6px;
}

.card-item__marken {
    width: 100%;
    min-height: 50px;
    margin: 0;
}

@media (max-width: 768px) {
    .card {
        width: min(100%, 420px);
        min-height: unset;
    }
}

@media (min-width: 769px) {
    .card {
        min-height: 600px;
        height: auto;
    }
}


</style>
