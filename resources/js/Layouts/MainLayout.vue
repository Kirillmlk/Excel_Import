<script>
import {Link} from "@inertiajs/vue3";
export default {
    name: "MainLayout",
    components: {
        Link
    }
}
</script>

<template>
    <div class="w-96 mx-auto">
        <h1>My App</h1>
        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
            <Link :href="route('dashboard')">
                Dashboard
            </Link>

            <Link :href="route('project.index')">
                Projects
            </Link>

            <Link :href="route('project.import')">
                Import
            </Link>

            <Link :href="route('task.index')">
                Tasks
            </Link>
        </div>
        <slot>

        </slot>
    </div>
</template>

<style scoped>

</style>
