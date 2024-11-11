<script setup>
import { ref, defineProps, watch } from "vue";

// Menggunakan prop untuk menerima status notifikasi dari induk
const props = defineProps({
    hasNewNotifications: {
        type: Boolean,
        default: false,
    },
});

// Ref untuk mengatur status notifikasi secara lokal
const localHasNewNotifications = ref(props.hasNewNotifications);

// Watch untuk sinkronisasi prop dengan local state
watch(
    () => props.hasNewNotifications,
    (newVal) => {
        localHasNewNotifications.value = newVal;
    }
);

// Fungsi untuk mengatur status notifikasi saat ikon diklik
const handleClick = () => {
    localHasNewNotifications.value = false;
    // Emit event ke induk jika perlu
    // emit("notificationRead");
};
</script>

<template>
    <div
        class="relative cursor-pointer p-2 rounded-md border border-gray-300 hover:bg-gray-100 transition duration-300 flex items-center justify-center w-10 h-10"
        @click="handleClick"
    >
        <img
            src="https://cdn-icons-png.flaticon.com/512/3602/3602145.png"
            alt="Notification Bell"
        />
        <span
            v-if="localHasNewNotifications"
            class="absolute top-1 right-1 inline-block w-2 h-2 bg-red-600 rounded-full animate-ping"
        ></span>
    </div>
</template>

<style scoped>
.relative {
    position: relative;
}

/* Animasi smooth untuk titik merah */
@keyframes ping {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.5);
    }
    100% {
        transform: scale(1);
    }
}
.animate-ping {
    animation: ping 0.6s ease-in-out infinite;
}
</style>
