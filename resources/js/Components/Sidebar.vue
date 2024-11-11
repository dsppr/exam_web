<script setup>
import { defineProps } from "vue";
import { Link } from "@inertiajs/vue3";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";

const props = defineProps({
    activeLink: {
        type: String,
        default: "/dashboard",
    },
});

const links = [
    { name: "Dashboard", href: "/dashboard", icon: "fas fa-home" },
    { name: "Projects", href: "/projects", icon: "fas fa-folder" },
    { name: "Tasks", href: "/tasks", icon: "fas fa-tasks" },
    { name: "Milestones", href: "/milestones", icon: "fas fa-flag-checkered" },
    { name: "Reports", href: "/reports", icon: "fas fa-chart-line" },
];
</script>

<template>
    <aside class="w-64 bg-white p-6 shadow-lg fixed h-full">
        <div class="mb-8">
            <ApplicationLogo class="block h-9 w-auto mx-auto" />
        </div>
        <nav class="space-y-6">
            <Link
                v-for="link in links"
                :key="link.name"
                :href="link.href"
                :class="[
                    'flex items-center p-2 rounded transition-all duration-200',
                    link.href === activeLink
                        ? 'bg-blue-100 text-blue-600'
                        : 'text-gray-700 hover:text-blue-500',
                ]"
            >
                <i :class="link.icon + ' mr-3'"></i> {{ link.name }}
            </Link>
        </nav>

        <!-- Logout link positioned at the bottom with alignment and style similar to other links -->
        <div class="absolute bottom-6 w-full">
            <Link
                href="/logout"
                method="post"
                as="button"
                class="w-full flex items-center justify-center p-2 rounded text-red-600 transition-all duration-200 hover:bg-red-100"
            >
                <i class="fas fa-sign-out-alt mr-3"></i> Log Out
            </Link>
        </div>
    </aside>
</template>
