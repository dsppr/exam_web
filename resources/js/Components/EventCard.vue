<template>
    <div class="event-card">
        <div class="event-header">
            <span class="event-icon">📌</span>
            <span class="event-title">{{ eventTitle }}</span>
            <button class="add-button">Add To All Pages</button>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        eventTitle: {
            type: String,
            required: true,
        },
    },
};
</script>

<style scoped>
.event-card {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background-color: #ffffff;
    border: 1px solid #ddd;
    padding: 10px 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.event-header {
    display: flex;
    align-items: center;
    gap: 10px;
}

.event-icon {
    font-size: 18px;
}

.event-title {
    font-size: 16px;
    font-weight: 600;
}

.add-button {
    background-color: #007bff;
    color: #fff;
    padding: 5px 10px;
    border-radius: 5px;
    border: none;
    cursor: pointer;
    font-size: 14px;
}

.add-button:hover {
    background-color: #0056b3;
}
</style>
