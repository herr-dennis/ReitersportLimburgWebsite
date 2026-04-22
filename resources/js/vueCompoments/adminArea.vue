<script setup>
import { ref } from 'vue'

const name = ref('')
const description = ref('')
const price = ref(0)
const image = ref([]);



function handleImageUpload(event) {
    image.value = event.target.files[0]
}

</script>

<template>


    <div class="offerSummary">
        <label>Name</label>
        <p>{{name}}</p>
        <label>Description</label>
        <p>{{description}}</p>
         <p>Bild</p>

    </div>


    <h1>Angebote einfügen</h1>
    <form class="offerForm">
        <label>Name</label>
        <input type="text" v-model="name" />
        <label>Email</label>
        <input type="text" v-model="description" />
        <label>Preis</label>
        <input type="number" v-model="price" />
        <input type="file" @change="handleImageUpload" accept="image/*">

    </form>

</template>

<style scoped lang="scss">
 @import "/../resources/css/defaultValues";
 .offerForm,
 .offerSummary {
     display: flex;
     flex-direction: column;
     gap: 0.6rem;
     padding: 1.2rem 1.4rem;
     background-color: white;
     color: $defaultColor;
     border-radius: 10px;
     box-shadow: 0 0 8px rgba(0,0,0,0.08);
     max-width: 450px;
     margin: 1rem auto;
 }

 .offerForm label,
 .offerSummary label {
     font-weight: 600;
     margin-bottom: 0.15rem;
 }

 .offerForm input {
     padding: 0.6rem 0.8rem;
     border: 1px solid lighten($defaultColor, 30%);
     border-radius: 6px;
     background: #fafafa;
     font-size: 1rem;
     transition: 0.2s;
 }

 .offerForm input:focus {
     outline: none;
     border-color: $defaultColor;
     background: white;
     box-shadow: 0 0 0 2px rgba($defaultColor, 0.15);
 }

 .offerSummary p {
     padding: 0.5rem 0.8rem;
     background: #f7f7f7;
     border-radius: 6px;
     border: 1px solid lighten($defaultColor, 35%);
     margin-bottom: 0.6rem;
 }


</style>
