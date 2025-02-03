<script>
import {Link} from "@inertiajs/vue3";
import Navigation from "@/Components/Navigation.vue";
export default {
    name: "MainLayout",
    components: {
        Link,
        Navigation
    }
}
</script>

<template>
    <div class="w-4/6 mx-auto">
        <navigation></navigation>
        <slot/>
    </div>
</template>

<style scoped>

</style>
