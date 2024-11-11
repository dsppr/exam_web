<script setup>
import { ref, defineProps } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Header from "@/Components/Header.vue";
import Sidebar from "@/Components/Sidebar.vue";

const props = defineProps({
    activeLink: {
        type: String,
        default: "/dashboard",
    },
});
</script>

<template>
    <div class="flex min-h-screen bg-gray-100">
        <!-- Sidebar -->
        <Sidebar :activeLink="activeLink" />

        <!-- Main Content -->
        <div class="flex-1 ml-64">
            <!-- Header Component -->
            <Header @createProject="onCreateProject" />

            <!-- Page Content Slot -->
            <main class="p-6">
                <slot />
            </main>
        </div>
    </div>
</template>

<script>
function onCreateProject() {
    // Implementasi logic saat membuat proyek baru
    console.log("Create New Project clicked");
}
</script>

<style scoped>
/* Custom styling for icons and links */
aside nav a {
    transition: color 0.3s;
}
aside nav a:hover {
    color: #1d4ed8;
}
</style>
