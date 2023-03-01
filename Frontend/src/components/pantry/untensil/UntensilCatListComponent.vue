<script lang="ts">
import type { UntensilCat } from "@/model/CatagoryModel";
import UntensilCatComponent from "@/components/pantry/untensil/UntensilCatComponent.vue";
export default {
    name: "UntensilCatListComponent",
    props: {
        untensilcats: Array<UntensilCat>,
    },
    components: {
        UntensilCatComponent,
    }
};
</script>
<template>
            <UntensilCatComponent @delete-untensilcat="(id) => $emit('delete-untensilcat', id)" v-for="untensilcat in untensilcats" :key="untensilcat.id"
            :untensilcat="untensilcat" />

</template>
