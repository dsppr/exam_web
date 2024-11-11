<script setup>
import { defineProps, defineEmits } from "vue";
import { router as $inertia } from "@inertiajs/vue3";

// Mendefinisikan props untuk menerima data proyek
const props = defineProps({
    project: {
        type: Object,
        required: true,
    },
});

// Emit event ke komponen induk (Dashboard.vue)
const emit = defineEmits(["openEditModal", "deleteProject"]);

// Fungsi untuk navigasi ke halaman proyek
const goToProject = (projectId) => {
    if (projectId) {
        $inertia.get(`/projects/${projectId}`);
    }
};

// Emit event untuk membuka modal edit
const openEditModal = () => emit("openEditModal", props.project);

// Emit event untuk menghapus proyek dengan konfirmasi
const deleteProject = () => {
    if (confirm("Are you sure you want to delete this project?")) {
        emit("deleteProject", props.project.id);
    }
};
</script>

<template>
    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
        <!-- Header dengan Ikon dan Judul -->
        <div class="flex justify-between items-center mb-2">
            <div class="flex items-center space-x-2">
                <!-- Ikon Proyek -->
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 512 512"
                >
                    <g fill-rule="evenodd">
                        <path
                            fill="#ffab02"
                            d="M74.968 233.342h280.057v217.867H110.347a35.465 35.465 0 0 1-35.379-35.349z"
                        ></path>
                        <path
                            fill="#3f5163"
                            d="m74.036 67.668 84.716 250.361 199.887-67.639L273.922 0Q173.95 33.834 74.036 67.668z"
                        ></path>
                    </g>
                </svg>
                <h4 class="text-lg font-semibold text-gray-800">
                    {{ project.name }}
                </h4>
            </div>
        </div>

        <!-- Tanggal Update -->
        <p class="text-sm text-gray-500 mb-4">
            Updated: {{ project.updated_at }}
        </p>

        <!-- Label Status -->
        <div class="flex space-x-2 mb-4">
            <span
                v-if="project.status && project.status.deployed"
                class="bg-blue-100 text-blue-600 px-2 py-1 rounded-full text-xs font-medium"
            >
                Deployed
            </span>
            <span
                v-if="project.status && project.status.archived"
                class="bg-purple-100 text-purple-600 px-2 py-1 rounded-full text-xs font-medium"
            >
                Archived
            </span>
            <span
                v-if="project.status && project.status.draft"
                class="bg-gray-100 text-gray-600 px-2 py-1 rounded-full text-xs font-medium"
            >
                Draft
            </span>
        </div>

        <!-- Tombol Aksi -->
        <div class="flex justify-around mt-4 border-t pt-4">
            <!-- Tombol View -->
            <button
                @click="goToProject(project.id)"
                class="text-blue-500 hover:text-blue-700 transition"
            >
                <i class="fas fa-arrow-right"></i>
            </button>

            <!-- Tombol Edit -->
            <button
                @click="openEditModal"
                class="text-gray-500 hover:text-gray-700 transition"
            >
                <i class="fas fa-edit"></i>
            </button>

            <!-- Tombol Delete -->
            <button
                @click="deleteProject"
                class="text-red-500 hover:text-red-700 transition"
            >
                <i class="fas fa-trash-alt"></i>
            </button>
        </div>
    </div>
</template>

<style scoped>
button {
    transition: color 0.3s ease;
}
</style>
