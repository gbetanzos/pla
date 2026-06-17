<script setup>
import { ref, computed } from 'vue';
import { router, route } from '@inertiajs/vue3';

const bpRecord = ref(null);
const loading = ref(true);

const getStatus = computed(() => {
    if (!bpRecord.value) return '';
    const { systolic, diastolic } = bpRecord.value;
    if (systolic <= 120 && diastolic <= 80) return 'green';
    if (systolic <= 130 && diastolic <= 80) return 'yellow';
    return 'red';
});

await router.get(route('bp.show', bpRecord.value?.id));
bpRecord.value = route('bp.record');
</script>

<template>
    <div
        class="min-h-screen py-12 bg-gray-50"
    >
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div
                class="bg-white shadow-sm sm:rounded-lg overflow-hidden"
            >
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h1 class="text-2xl font-bold text-gray-900">Blood Pressure Reading</h1>
                        <div class="flex space-x-2">
                            <a
                                :href="route('bp.edit', bpRecord.id)"
                                class="text-indigo-600 hover:text-indigo-900 p-2 transition"
                            >
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <a
                                :href="route('bp.index')"
                                class="text-gray-600 hover:text-gray-900 p-2 transition"
                            >
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <div
                        :class="[
                            'rounded-lg p-8 border-4',
                            getStatus === 'green' ? 'border-green-500 bg-green-50' :
                            getStatus === 'yellow' ? 'border-yellow-500 bg-yellow-50' :
                            'border-red-500 bg-red-50',
                        ]"
                    >
                        <div class="text-center">
                            <div class="text-sm text-gray-500 mb-2">Reading from {{ formatDate(bpRecord.created_at) }}</div>
                            <div class="text-7xl font-bold mb-4" :class="{
                                'text-green-600 text-shadow': getStatus === 'green',
                                'text-yellow-600 text-shadow': getStatus === 'yellow',
                                'text-red-600 text-shadow': getStatus === 'red',
                            }">
                                {{ bpRecord.systolic }}<span class="ml-2 text-4xl text-gray-400">/</span>
                                {{ bpRecord.diastolic }}
                            </div>
                            <div class="inline-block px-4 py-2 rounded-full mb-6" :class="getStatus === 'green' ? 'bg-green-100 text-green-800' : getStatus === 'yellow' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800'">
                                {{ getStatus === 'green' ? 'Normal' : getStatus === 'yellow' ? 'Elevated' : 'High' }}
                            </div>

                            <div
                                v-if="bpRecord.notes"
                                class="mt-8 pt-6 border-t"
                            >
                                <div class="text-sm text-gray-500 mb-1">Notes</div>
                                <div class="text-lg text-gray-700">"{{ bpRecord.notes }}"</div>
                            </div>

                            <div class="mt-8 pt-6 border-t text-sm text-gray-500">
                                <div>ID: {{ bpRecord.id }}</div>
                                <div>User: {{ bpRecord.user?.name || 'Unknown' }}</div>
                            </div>
                        </div>
                    </div>

                    <div
                        v-if="bpRecord.history?.length > 0"
                        class="mt-8"
                    >
                        <div class="text-lg font-semibold mb-4">Recent History</div>
                        <div class="space-y-2">
                            <div
                                v-for="history in bpRecord.history.slice(0, 5)"
                                :key="history.id"
                                class="flex justify-between items-center p-3 bg-gray-50 rounded"
                            >
                                <div>
                                    <span :class="`${getStatus} font-bold`">
                                        {{ history.systolic }}
                                    </span>
                                    <span class="text-gray-400">/</span>
                                    <span :class="`${getStatus} font-bold`">
                                        {{ history.diastolic }}
                                    </span>
                                    <span class="text-gray-500 ml-2">
                                        {{ formatDate(history.created_at) }}
                                    </span>
                                </div>
                                <button
                                    @click="deleteHistory(history.id)"
                                    class="text-red-500 hover:text-red-700 p-1"
                                >
                                    ×
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
const formatDate = (date) => new Date(date).toLocaleString('en-US', {
    year: 'numeric', month: 'short', day: 'numeric',
    hour: '2-digit', minute: '2-digit'
});

export default {
    methods: { formatDate },
};
</script>

<style scoped>
.text-shadow {
    text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
}
</style>
