<script setup>
import PlantRing from '@/Components/PlantRing.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import dayjs from 'dayjs';
import { reactive, ref } from 'vue';

defineProps({
    gardens: Array,
    summary: Object,
    plants: Array,
});

const plantForm = reactive({
    garden_id: null,
    plant_id: null,
    planting_date: dayjs(),
});

const showPlantModal = ref(false);

function openPlantModal(gardenId) {
    plantForm.garden_id = gardenId;
    showPlantModal.value = true;
}

function submitPlantForm() {
    router.post('/gardenplants', plantForm, {
        onSuccess: () => {
            showPlantModal.value = false;
            // Reset form
            plantForm.garden_id = null;
            plantForm.plant_id = null;
            plantForm.planting_date = new Date().toISOString().substr(0, 10);
        },
    });
}

const gardenForm = reactive({
    user_id: null,
    name: null,
    description: null,
});

const showGardenModal = ref(false);

function openGardenModal(userID) {
    gardenForm.user_id = userID;
    showGardenModal.value = true;
}

function submitGardenForm() {
    router.post('/garden', gardenForm, {
        onSuccess: () => {
            showGardenModal.value = false;
            // Reset form
            gardenForm.user_id = null;
            gardenForm.name = null;
            gardenForm.description = null;
        },
    });
}

// Delete gardens
function deleteGarden(gardenId) {
    if (confirm('Are you sure you want to remove this garden?')) {
        router.delete(`/garden/${gardenId}`);
    }
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-white">
                    My Gardens
                </h2>
                <div class="text-xl font-semibold leading-tight text-white">
                    You have {{ summary.total_gardens }} gardens and
                    {{ summary.total_plants }} plants on the go.
                </div>
                <div class="relative ring-1 ring-green-300">
                    <button
                        class="bg-gray-800 px-3 py-2 font-bold uppercase text-green-300 ring-1 ring-green-300 transition hover:-translate-x-1 hover:-translate-y-1 focus:outline-none focus-visible:ring-2"
                        @click="openGardenModal($page.props.auth.user.id)"
                    >
                        Add Garden +
                    </button>
                </div>
            </div>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    v-if="gardens.length === 0"
                    class="overflow-hidden bg-gray-800 p-6 shadow-sm sm:rounded-lg"
                >
                    <p class="text-green-300">
                        You haven't created any gardens yet.
                    </p>
                </div>

                <div v-else class="space-y-6">
                    <div
                        v-for="garden in gardens"
                        :key="garden.id"
                        class="overflow-hidden bg-gray-800 shadow-sm sm:rounded-lg"
                    >
                        <div class="p-6">
                            <div class="mb-4 flex items-center gap-4">
                                <h3
                                    class="text-lg font-semibold text-green-300"
                                >
                                    {{ garden.name }}
                                </h3>
                                <p class="text-sm text-green-300">
                                    {{ garden.plants.length }}
                                    {{
                                        garden.plants.length === 1
                                            ? 'plant'
                                            : 'plants'
                                    }}
                                </p>
                                <div class="relative ring-1 ring-green-300">
                                    <button
                                        @click="deleteGarden(garden.id)"
                                        class="bg-gray-800 px-3 py-2 font-bold uppercase text-green-300 ring-1 ring-green-300 transition hover:-translate-x-1 hover:-translate-y-1 hover:text-red-200 hover:ring-red-200 focus:outline-none focus-visible:ring-2"
                                    >
                                        Delete Garden
                                    </button>
                                </div>
                                <div
                                    class="relative ml-auto ring-1 ring-green-300"
                                >
                                    <button
                                        class="bg-gray-800 px-3 py-2 font-bold uppercase text-green-300 ring-1 ring-green-300 transition hover:-translate-x-1 hover:-translate-y-1 focus:outline-none focus-visible:ring-2"
                                        @click="openPlantModal(garden.id)"
                                    >
                                        Plant something new +
                                    </button>
                                </div>
                            </div>

                            <p class="mb-4 text-green-300">
                                {{ garden.description }}
                            </p>

                            <div
                                v-if="garden.plants.length"
                                class="flex flex-wrap gap-20 overflow-hidden rounded-lg border p-10"
                            >
                                <PlantRing
                                    v-for="plant in garden.plants"
                                    :key="plant.id"
                                    :plant="plant"
                                    :size="300"
                                    :strokeWidth="8"
                                />
                            </div>

                            <div v-else class="mt-4 text-sm text-green-300">
                                No plants in this garden yet.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
    <div
        v-if="showPlantModal"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50"
    >
        <div class="w-96 rounded-lg bg-gray-800 p-6">
            <h3 class="mb-4 text-xl font-semibold text-green-300">
                Add New Plant
            </h3>

            <form @submit.prevent="submitPlantForm">
                <div class="mb-4">
                    <label class="mb-2 block text-green-300"
                        >Select Plant</label
                    >
                    <select
                        v-model="plantForm.plant_id"
                        class="w-full rounded bg-gray-700 p-2 text-green-300"
                        required
                    >
                        <option value="">Select a plant</option>
                        <option
                            v-for="plant in plants"
                            :key="plant.id"
                            :value="plant.id"
                        >
                            {{ plant.name }}
                        </option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="mb-2 block text-green-300"
                        >Planting Date</label
                    >
                    <input
                        type="date"
                        v-model="plantForm.planting_date"
                        class="w-full rounded bg-gray-700 p-2 text-green-300"
                        required
                    />
                </div>

                <div class="flex justify-end gap-2">
                    <button
                        type="button"
                        @click="showPlantModal = false"
                        class="bg-gray-800 px-3 py-2 font-bold uppercase text-green-300 ring-1 ring-green-300 transition hover:-translate-x-1 hover:-translate-y-1 focus:outline-none focus-visible:ring-2"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="bg-gray-800 px-3 py-2 font-bold uppercase text-green-300 ring-1 ring-green-300 transition hover:-translate-x-1 hover:-translate-y-1 focus:outline-none focus-visible:ring-2"
                    >
                        Add Plant
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div
        v-if="showGardenModal"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50"
    >
        <div class="w-96 rounded-lg bg-gray-800 p-6">
            <h3 class="mb-4 text-xl font-semibold text-green-300">
                Add New Garden
            </h3>

            <form @submit.prevent="submitGardenForm">
                <div class="mb-4">
                    <label class="mb-2 block text-green-300">Garden Name</label>
                    <input
                        type="text"
                        v-model="gardenForm.name"
                        class="w-full rounded bg-gray-700 p-2 text-green-300"
                        required
                    />
                </div>

                <div class="mb-4">
                    <label class="mb-2 block text-green-300"
                        >Garden Description</label
                    >
                    <input
                        type="text"
                        v-model="gardenForm.description"
                        class="w-full rounded bg-gray-700 p-2 text-green-300"
                        required
                    />
                </div>

                <div class="flex justify-end gap-2">
                    <button
                        type="button"
                        @click="showGardenModal = false"
                        class="bg-gray-800 px-3 py-2 font-bold uppercase text-green-300 ring-1 ring-green-300 transition hover:-translate-x-1 hover:-translate-y-1 focus:outline-none focus-visible:ring-2"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="bg-gray-800 px-3 py-2 font-bold uppercase text-green-300 ring-1 ring-green-300 transition hover:-translate-x-1 hover:-translate-y-1 focus:outline-none focus-visible:ring-2"
                    >
                        Add Garden
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
