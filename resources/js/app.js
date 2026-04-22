
import { createApp } from 'vue';
import NavComp from './vueCompoments/navComp.vue';
import NewsFeed from './vueCompoments/NewsFeedComp.vue';
import Brands from './vueCompoments/brandsComp.vue';
import HorseCategory from './vueCompoments/cardsHorseCategoryComp.vue';
import Administrator from './vueCompoments/adminArea.vue';
import GardenCards from './vueCompoments/cardsHorseCategoryComp.vue';
import FeedCards from './vueCompoments/cardsHorseCategoryComp.vue';
import translateHorseCategory from './translate/horseCategoryTranslate.js';
import gardenCategories from "./translate/gardenTranslate.js";
import categories_feed from "./translate/feedTranslate.js";
import RiderCards from './vueCompoments/cardsHorseCategoryComp.vue';
import categories_rider from "./translate/riderTranslate.js";

createApp(NavComp).mount('#nav');

const registry = {
    NewsFeed,
    Brands,
    HorseCategory,
    Administrator,
    GardenCards,
    FeedCards,
    RiderCards,

};

const translationRegistry = {
    HorseCategory: translateHorseCategory,
    GardenCards: gardenCategories,
    FeedCards: categories_feed,
    RiderCards: categories_rider
};

for (const el of document.querySelectorAll('.vue-mount')) {
    const { component, ...raw } = el.dataset;
    const Comp = registry[component];

    if (!Comp) continue;

    const props = {
        ...raw,
        perPage: raw.perPage ? Number(raw.perPage) : undefined,
        translations: translationRegistry[component],
    };

    createApp(Comp, props).mount(el);
}

