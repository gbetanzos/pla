<script setup>
import { ref } from 'vue';
import { router, route } from '@inertiajs/vue3';

const isSubmitting = ref(false);
const record = ref(null);

await router.get(route('bp.edit', record.value?.id));
record.value = route('bp.record');

const submit = (e) => {
    e.preventDefault();
    e.stopPropagation();

    const form = e.target;
    const formData = new FormData(form);

    isSubmitting.value = true;

    router.put(route('bp.update', record.value.id), {
        systolic: formData.get('systolic'),
        diastolic: formData.get('diastolic'),
        notes: formData.get('notes'),
    }).then(() => {
        router.replace(route('bp.show', record.value.id));
    }).finally(() => {
        isSubmitting.value = false;
    });
};
</script>

<template>
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">Edit Reading</h1>
                    <p class="text-gray-500">Update blood pressure record (ID: {{ record.id }})</p>
                </div>

                <form @submit="submit">
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Systolic (Top number)
                            </label>
                            <input
                                type="number"
                                name="systolic"
                                v-model="record.systolic"
                                required
                                min="50"
                                max="250"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            />
                            <p class="text-xs text-gray-500 mt-1">Normal: 90-120 mmHg</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Diastolic (Bottom number)
                            </label>
                            <input
                                type="number"
                                name="diastolic"
                                v-model="record.diastolic"
                                required
                                min="40"
                                max="140"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            />
                            <p class="text-xs text-gray-500 mt-1">Normal: 60-80 mmHg</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Notes
                            </label>
                            <textarea
                                name="notes"
                                v-model="record.notes"
                                rows="3"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            />
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t">
                            <router-link
                                :href="route('bp.show', record.id)"
                                class="text-indigo-600 hover:text-indigo-900"
                            >
                                Cancel
                            </router-link>
                            <button
                                type="submit"
                                :disabled="isSubmitting"
                                class="bg-indigo-600 text-white px-6 py-2 rounded-md font-medium hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                {{ isSubmitting ? 'Saving...' : 'Save Changes' }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
