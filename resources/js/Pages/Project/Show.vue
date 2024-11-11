<template>
    <AuthenticatedLayout :activeLink="'/projects'">
        <!-- Bagian Detail Proyek -->
        <div class="p-6 bg-white rounded-lg shadow-md max-w-4xl mx-auto">
            <h1 class="text-3xl font-semibold text-gray-800 mb-4">
                {{ project.name }}
            </h1>

            <!-- Form Membuat Tugas Baru -->
            <form
                @submit.prevent="createTask"
                class="bg-gray-50 p-4 rounded-md mb-6"
            >
                <h2 class="text-lg font-medium text-gray-700 mb-2">
                    Create New Task
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700"
                            >Task Title</label
                        >
                        <input
                            v-model="newTask.title"
                            type="text"
                            class="mt-1 w-full border rounded-md p-2"
                            required
                        />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700"
                            >Task Description</label
                        >
                        <textarea
                            v-model="newTask.description"
                            class="mt-1 w-full border rounded-md p-2"
                        ></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700"
                            >Due Date</label
                        >
                        <input
                            v-model="newTask.due_date"
                            type="date"
                            class="mt-1 w-full border rounded-md p-2"
                            required
                        />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700"
                            >Assign to</label
                        >
                        <select
                            v-model="newTask.assigned_user"
                            class="mt-1 w-full border rounded-md p-2"
                            required
                        >
                            <option
                                v-for="member in teamMembers"
                                :key="member.id"
                                :value="member.id"
                            >
                                {{ member.name }}
                            </option>
                        </select>
                    </div>
                </div>
                <button
                    type="submit"
                    class="mt-4 bg-blue-600 text-white rounded px-4 py-2"
                >
                    Create Task
                </button>
            </form>

            <!-- Daftar Tugas -->
            <h2 class="text-lg font-medium text-gray-700 mb-4">Tasks</h2>
            <ul class="space-y-4">
                <li
                    v-for="task in tasks"
                    :key="task.id"
                    class="flex justify-between items-center p-4 bg-gray-100 rounded-md"
                >
                    <span class="text-gray-700"
                        >{{ task.title }} - {{ task.assignedUser.name }} ({{
                            task.due_date
                        }})</span
                    >
                    <div class="space-x-2">
                        <button
                            @click="editTask(task)"
                            class="text-blue-600 hover:underline"
                        >
                            Edit
                        </button>
                        <button
                            @click="deleteTask(task.id)"
                            class="text-red-600 hover:underline"
                        >
                            Delete
                        </button>
                    </div>
                </li>
            </ul>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref } from "vue";
import { usePage, router as $inertia } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InviteMemberModal from "@/Components/InviteMemberModal.vue";

// Ambil props dari halaman untuk data proyek dan anggota tim
const { project, tasks, teamMembers } = usePage().props;

// Variabel reaktif untuk form tugas baru
const newTask = ref({
    title: "",
    description: "",
    due_date: "",
    assigned_user: "",
});

// Variabel untuk kontrol modal undangan
const showInviteModal = ref(false);

// Fungsi untuk membuat tugas baru
function createTask() {
    $inertia
        .post(`/projects/${project.id}/tasks`, {
            title: newTask.value.title,
            description: newTask.value.description,
            due_date: newTask.value.due_date,
            assigned_user: newTask.value.assigned_user,
            project_id: project.id,
        })
        .then(() => {
            newTask.value = {
                title: "",
                description: "",
                due_date: "",
                assigned_user: "",
            };
        });
}

// Fungsi untuk mengedit tugas
function editTask(task) {
    newTask.value = { ...task };
    // Logika tambahan untuk membuka modal atau memperbarui tampilan jika diperlukan
}

// Fungsi untuk menghapus tugas
function deleteTask(taskId) {
    if (confirm("Are you sure you want to delete this task?")) {
        $inertia.delete(`/tasks/${taskId}`).then(() => {
            // Penanganan tambahan setelah penghapusan berhasil
        });
    }
}

// Fungsi untuk menutup modal undangan
function closeInviteModal() {
    showInviteModal.value = false;
}

// Fungsi untuk membuka modal undangan
function openInviteModal() {
    showInviteModal.value = true;
}
</script>
