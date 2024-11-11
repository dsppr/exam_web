<script setup>
import { usePage } from "@inertiajs/vue3";
import NotificationBell from "@/Components/NotificationBell.vue";

const { user } = usePage().props;
</script>

<template>
    <header class="bg-white p-4 shadow flex items-center justify-between">
        <!-- Bagian Kiri: Judul -->
        <h1 class="text-xl font-bold">Dashboard</h1>

        <!-- Bagian Kanan: Notifikasi dan Profil -->
        <div class="flex items-center space-x-6">
            <button
                @click="$inertia.visit(route('projects.create'))"
                class="bg-white text-blue-600 px-4 py-2 rounded font-semibold shadow-lg hover:bg-gray-200 transition-colors duration-300"
            >
                + Create Project
            </button>
            <!-- Notification bell -->
            <NotificationBell :hasNewNotifications="true" />

            <!-- Profile section -->
            <div class="flex items-center space-x-2">
                <img
                    v-if="user?.profile_photo_url"
                    :src="user.profile_photo_url"
                    alt="Profile"
                    class="w-8 h-8 rounded-full border-2 border-gray-200"
                />
                <div class="text-left">
                    <span class="text-gray-900 font-medium block">{{
                        user?.name
                    }}</span>
                    <span class="text-gray-500 text-sm">{{ user?.email }}</span>
                </div>
            </div>
        </div>
    </header>
</template>
