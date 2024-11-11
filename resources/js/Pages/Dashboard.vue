<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center space-x-4">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Dashboard
                </h2>
                <!-- Notification Bell and Profile Display -->
                <div
                    class="relative cursor-pointer p-2 rounded-lg border border-gray-300 hover:bg-gray-100 transition duration-300"
                    @click="handleClick"
                >
                    <i class="fas fa-bell text-gray-800 text-xl"></i>
                    <span
                        v-if="localHasNewNotifications"
                        class="absolute top-0 right-0 w-2 h-2 bg-red-600 rounded-full animate-ping"
                    ></span>
                </div>
                <div class="flex items-center space-x-2">
                    <img
                        :src="user?.profile_photo_url || '/default-avatar.png'"
                        alt="User Profile"
                        class="w-8 h-8 rounded-full object-cover"
                    />
                    <div class="text-gray-700 text-sm">
                        <p>{{ user?.name }}</p>
                        <p class="text-gray-500">{{ user?.email }}</p>
                    </div>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Greeting Section -->
                <div
                    v-if="showGreeting"
                    class="bg-gradient-to-r from-blue-500 to-purple-600 text-white p-4 rounded-lg mb-4 relative"
                >
                    <button
                        @click="closeGreeting"
                        class="absolute top-2 right-2 text-white"
                    >
                        &times;
                    </button>
                    <h2 class="text-2xl font-semibold">
                        Welcome, {{ user?.name }} 👋
                    </h2>
                    <p>
                        Start to manage your team members and their account
                        permissions here.
                    </p>
                </div>

                <!-- Proyek yang Dikelola -->
                <h3 class="text-lg font-bold mb-4">Your Projects</h3>
                <div v-if="managedProjects && managedProjects.length > 0">
                    <div
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4"
                    >
                        <ProjectCard
                            v-for="project in managedProjects"
                            :key="project.id"
                            :project="project"
                            @openEditModal="openEditModal"
                            @deleteProject="deleteProject"
                        />
                    </div>
                </div>
                <div v-else class="text-center text-gray-500">
                    Anda belum mempunyai proyek yang dikelola.
                </div>

                <!-- Modal Edit Proyek -->
                <Modal v-if="showEditModal" @close="showEditModal = false">
                    <form @submit.prevent="updateProject">
                        <h3>Edit Project</h3>
                        <input
                            v-model="editProjectData.name"
                            placeholder="Project Name"
                            class="border p-2 w-full mb-4"
                        />
                        <textarea
                            v-model="editProjectData.description"
                            placeholder="Description"
                            class="border p-2 w-full mb-4"
                        ></textarea>
                        <button
                            type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded"
                        >
                            Save
                        </button>
                    </form>
                </Modal>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref } from "vue";
import { usePage, router as $inertia } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import ProjectCard from "@/Components/ProjectCard.vue";
import Modal from "@/Components/Modal.vue";

const { user, managedProjects } = usePage().props;
const showEditModal = ref(false);
const editProjectData = ref({});

// Function to show greeting message
const showGreeting = ref(true);
function closeGreeting() {
    showGreeting.value = false;
}

// Open edit modal and populate data
function openEditModal(project) {
    editProjectData.value = { ...project };
    showEditModal.value = true;
}

// Update project information
function updateProject() {
    $inertia.put(
        `/projects/${editProjectData.value.id}`,
        editProjectData.value,
        {
            onSuccess: () => {
                showEditModal.value = false;
                // Tambahkan notifikasi atau update data proyek jika diperlukan
            },
        }
    );
}

// Delete project by ID
function deleteProject(projectId) {
    $inertia.delete(`/projects/${projectId}`, {
        onSuccess: () => {
            // Tambahkan notifikasi atau aksi setelah berhasil menghapus proyek
        },
    });
}
</script>
