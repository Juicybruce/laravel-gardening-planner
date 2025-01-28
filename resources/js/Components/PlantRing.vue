<script setup>
import { router } from '@inertiajs/vue3';
import dayjs from 'dayjs';
const props = defineProps({
    plant: Object,
    size: Number,
    strokeWidth: Number,
});

const circumference = (2 * Math.PI * props.size) / 2;

const progressPercent =
    (dayjs().diff(props.plant.pivot.planting_date, 'day') /
        props.plant.days_to_harvest) *
    100;

function deletePlant() {
    if (confirm('Are you sure you want to remove this plant?')) {
        router.delete(`/gardenplants/${props.plant.pivot.id}`);
    }
}
</script>
<template>
    <div class="relative flex flex-col items-center gap-4">
        <div class="mb-5 text-center text-green-200">
            {{ plant.name }}
        </div>
        <div
            :class="[
                `flex items-center justify-center w-[${size}px] h-[${size}px]`,
            ]"
        >
            <div
                class="absolute flex flex-col gap-4 text-center text-green-200"
            >
                <div class="text-lg font-semibold">
                    {{
                        plant.days_to_harvest -
                        dayjs().diff(plant.pivot.planting_date, 'day')
                    }}
                    days til harvest
                </div>
                <div class="text-lg font-semibold">
                    {{ parseInt(progressPercent) }}% ripened!
                </div>
            </div>
            <svg class="progress-ring" :width="size" :height="size">
                <circle
                    class="progress-ring__circle"
                    stroke="green"
                    :stroke-width="strokeWidth"
                    fill="transparent"
                    :r="size / 2 - strokeWidth * 2"
                    :cx="size / 2"
                    :cy="size / 2"
                    :style="[
                        `stroke-dashoffset: ${
                            circumference -
                            (progressPercent / 100) * circumference
                        }`,
                        `stroke-dasharray: ${circumference} ${circumference}`,
                    ]"
                />
            </svg>
        </div>
        <div class="relative ring-1 ring-green-300">
            <button
                @click="deletePlant"
                class="bg-gray-800 px-3 py-2 font-bold uppercase text-green-300 ring-1 ring-green-300 transition hover:-translate-x-1 hover:-translate-y-1 hover:text-red-200 hover:ring-red-200 focus:outline-none focus-visible:ring-2"
            >
                Delete
            </button>
        </div>
    </div>
</template>

<style>
.progress-ring__circle {
    transition: 0.35s stroke-dashoffset;
    transform: rotate(-90deg);
    transform-origin: 50% 50%;
}
</style>
