<script setup>
import {onMounted, ref, computed} from 'vue'

const props = defineProps({
    endpoint: {type: String, default: '/api/marken'}, // liefert [{id,name,url}] oder [{name,url}]
    speed: {type: Number, default: 190},            // Sekunden pro Loop (größer = langsamer)
    direction: {type: String, default: 'ltr'},         // 'ltr' = von links nach rechts, 'rtl' = von rechts nach links
    pauseOnHover: {type: Boolean, default: true}
})

const brands = ref([])
const loading = ref(true)
const error = ref(null)

onMounted(async () => {
    try {
        const res = await fetch(props.endpoint)
        if (!res.ok) throw new Error(`HTTP ${res.status}`)
        const data = await res.json()
        // vereinheitlichen: id fallback
        brands.value = (Array.isArray(data) ? data : []).map((b, i) => ({
            id: b.id ?? i,
            name: b.name ?? `Brand ${i + 1}`,
            url: b.logo_url ?? b.url ?? b.src ?? ''
        })).filter(b => b.url)
    } catch (e) {
        error.value = e.message
    } finally {
        loading.value = false
    }
})

const marqueeClass = computed(() => ({
    'dir-ltr': props.direction === 'ltr',
    'dir-rtl': props.direction !== 'ltr',
    'pause-on-hover': props.pauseOnHover
}))
</script>

<template>

    <div class="brand-marquee" :style="{'--speed': `${speed}s`}">
        <div v-if="loading" class="status">Lade Marken…</div>
        <div v-else-if="error" class="status">Fehler: {{ error }}</div>
        <div v-else class="brand-viewport" :class="marqueeClass">
            <!-- Track enthält 2 identische Listen für nahtlosen Loop -->
            <div class="brand-track">
                <ul class="brand-list">
                    <li v-for="b in brands" :key="`a-${b.id}`" class="brand-item">
                        <img :src="b.url" :alt="b.name" loading="lazy"/>
                    </li>
                </ul>
                <ul class="brand-list" aria-hidden="true">
                    <li v-for="b in brands" :key="`b-${b.id}`" class="brand-item">
                        <img :src="b.url" :alt="b.name" loading="lazy"/>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<style scoped lang="scss"> /* Wrapper: volle Breite des Eltern-Containers */
.brand-marquee {
    width: 100%;
}

h2{
    color: white;
}

$defaultColor: rgb(111, 66, 193); /* Status */
.status {
    padding: 8px 0;
    text-align: center;
}

/* Viewport: eine Zeile, nichts bricht um, verdeckt Overflow */
.brand-viewport {
    position: relative;
    overflow: hidden;
    width: 100%;
    user-select: none;
    -webkit-mask-image: linear-gradient(to right, transparent 0, black 5%, black 95%, transparent 100%);
    mask-image: linear-gradient(to right, transparent 0, black 5%, black 95%, transparent 100%);
}

/* Track bewegt sich horizontal */
.brand-track {
    display: flex;
    flex-wrap: nowrap;
    width: max-content; /* Geschwindigkeit über CSS-Variable --speed. Standard 40s */
    animation-duration: var(--speed, 40s);
    animation-timing-function: linear;
    animation-iteration-count: infinite;
}

/* Richtung: von links nach rechts (gewünscht) */
.dir-ltr .brand-track {
    animation-name: scroll-ltr;
}

/* Alternative Richtung: von rechts nach links */
.dir-rtl .brand-track {
    animation-name: scroll-rtl;
}

/* Hover to pause */
.pause-on-hover:hover .brand-track {
    animation-play-state: paused;
}

/* Eine Liste = ein Segment; zwei Segmente hintereinander -> nahtlos */
.brand-list {
    display: flex;
    flex-wrap: nowrap;
    gap: 24px;
    align-items: center;
    margin: 0;
    padding: 8px 0;
    list-style: none;
}

/* Einzelnes Logo */
.brand-item {
    border: 1px solid $defaultColor;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 8px 14px;
    background: #fff;
    box-shadow: 0 1px 3px rgba(0, 0, 0, .06);
}

.brand-item img {
    max-height: 48px; /* deine gewünschte Höhe */
    max-width: 160px;
    object-fit: contain;
    opacity: .9;
    transition: opacity .2s ease;
}

.brand-item:hover img {
    opacity: 1;
}

/* Keyframes: - Wir setzen zwei identische Listen nebeneinander (gesamt = 200% einer Liste) - LTR: Start bei -50% (linke Hälfte offscreen), Endwert 0 (nach rechts, Items „kommen“ von links) - RTL: Start bei 0, Endwert -50% (nach links, Items „kommen“ von rechts) */
@keyframes scroll-ltr {
    from {
        transform: translateX(-50%);
    }
    to {
        transform: translateX(0);
    }
}

@keyframes scroll-rtl {
    from {
        transform: translateX(0);
    }
    to {
        transform: translateX(-50%);
    }
}

/* Barrierefreiheit: Nutzerwunsch reduzierte Bewegung respektieren */
@media (prefers-reduced-motion: reduce) {
    .brand-track {
        animation: none;
        transform: translateX(0) !important;
    }
} </style>
