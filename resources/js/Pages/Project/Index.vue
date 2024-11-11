<template>
    <AuthenticatedLayout>
        <!-- Main Content -->
        <template #default>
            <div class="main-content">
                <!-- Header -->
                <Header title="Tag Management" />

                <!-- Breadcrumb -->
                <div class="breadcrumb">
                    <p>Tag Management > Events</p>
                </div>

                <!-- Main Panel -->
                <div class="main-panel">
                    <!-- Sub Navigation -->
                    <div class="sub-nav">
                        <button class="sub-nav-button">
                            Set Up Your Project
                        </button>
                        <button class="sub-nav-button">
                            Choose Ad Tracking & Networks
                        </button>
                        <button class="sub-nav-button">Tags & Triggers</button>
                        <button class="sub-nav-button">Summary</button>
                    </div>

                    <!-- Event Section -->
                    <div class="events-section">
                        <h2>Events</h2>
                        <div class="search-and-new">
                            <input
                                type="text"
                                placeholder="Search and sort all events"
                                class="search-input"
                            />
                            <button class="create-button">
                                + Create New Event
                            </button>
                        </div>

                        <!-- Event List -->
                        <div class="event-list">
                            <EventCard eventTitle="button_click" />
                            <EventCard eventTitle="form_submission" />
                            <EventCard eventTitle="video_play" />
                            <!-- Tambahkan event lainnya sesuai kebutuhan -->
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import EventCard from "@/components/EventCard.vue";

export default {
    components: {
        AuthenticatedLayout,
        Header,
        EventCard,
    },
};
</script>

<style scoped>
.main-content {
    padding: 20px;
}

.breadcrumb {
    font-size: 14px;
    margin: 10px 0;
}

.sub-nav {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}

.sub-nav-button {
    background-color: #007bff;
    color: #fff;
    padding: 10px 20px;
    border-radius: 5px;
    border: none;
    cursor: pointer;
}

.events-section {
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
}

.search-and-new {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}

.search-input {
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 5px;
    width: 70%;
}

.create-button {
    background-color: #007bff;
    color: #fff;
    padding: 10px 20px;
    border-radius: 5px;
    border: none;
    cursor: pointer;
}

.event-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}
</style>
