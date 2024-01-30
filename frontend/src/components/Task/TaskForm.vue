<script setup>
import { reactive } from "vue";
import FilterDropdown from "@/components/Shared/FilterDropdown.vue";
import { errorNotification,successNotification } from '@/Composable/notification'
import axios from "@/Services/axios.js"


const props = defineProps({
    data: Object || {},
    handleClose: Function,
    getAllTask: Function,
});
const allType = [{ name: "Incomplete" }, { name: "Complete" }];

const state = reactive({
    loading: false,
    title: props.data?.title || "",
    description: props.data?.description || "",
    status: props.data?.status || "",
    errors: '',
});

const defaultType = allType.findIndex((i) => i.name.toLowerCase() === state.status);
const getAccountType = (type) => (state.status = type);

const handleSubmit = () => {

    const data = {...state}
    data.status = data.status.toLowerCase();
    state.loading = true;
    if (props.data?.id) handleUpdate(data);
    else handleCreate(data);
};

const handleCreate = async(data) => {
    try {
    const response = await axios.post("/task", data);
    successNotification('Successfully created the task');
    state.loading = false;
    props.handleClose();
    props.getAllTask();

  } catch (error) {
    state.errors = error.response?.data?.errors;
    errorNotification('Something bad happend')
  }
};

const handleUpdate = async(newData) => {
    try {
    const response = await axios.put("/task/" + props.data?.slug, newData);
    successNotification('Successfully updated the task');
    state.loading = false;
    props.handleClose();
    props.getAllTask();

  } catch (error) {
    state.errors = error.response?.data?.errors;
    errorNotification('Something bad happend')
  }
};
</script>

<template>
        <div class="grid grid-cols-2 gap-x-5">
            <div class="mb-2 col-span-2">
                <label for="account_holder_name" class="block mb-2"
                    >Title</label
                >
                <input
                    type="text"
                    name="title"
                    id="title"
                    class="w-full border border-gray-300 rounded-md p-2 text-sm"
                    placeholder="Enter the title"
                    v-model="state.title"
                    required
                />
                <span
                    v-if="state.errors?.title"
                    class="text-sm text-red-500"
                    >{{ state.errors?.title[0] }}</span
                >
            </div>
            <div class="mb-2 col-span-2">
                <label for="account_type" class="block mb-2"
                    >Task Status</label
                >
                <FilterDropdown
                    class="text-sm"
                    :drop-down-data="allType"
                    :default="defaultType >= 0 ? defaultType : 0"
                    @getFilterData="getAccountType"
                />
                <span
                    v-if="state.errors?.status"
                    class="text-sm text-red-500"
                    >{{ state.errors?.status[0] }}</span
                >
            </div>
            <div class="mb-2 col-span-2">
                <label for="account_number" class="block mb-2"
                    >Description</label
                >
                <textarea
                    name="description"
                    id="description"
                    class="w-full border border-gray-300 rounded-md p-2 text-sm"
                    placeholder="Enter task description here..."
                    v-model="state.description"
                    required
                >
                </textarea>
                <span
                    v-if="state.errors?.description"
                    class="text-sm text-red-500"
                    >{{ state.errors?.description[0] }}</span
                >
            </div>
           
        </div>

        <div class="mb-4 flex justify-center items-center gap-4">
            <button
                @click="handleClose"
                type="button"
                class="bg-yellow-500 text-white rounded-md px-4 py-2"
            >
                Cancel
            </button>
            <button
                @click="handleSubmit"
                type="submit"
                class="bg-indigo-500 text-white rounded-md px-4 py-2 min-w-[80px] flex justify-center"
                :class="state.title == '' || state.description == '' ? 'cursor-not-allowed' : ''"
                :disabled="state.title == '' || state.description == '' || state.loading ? true :false"
                >
                <span
                    v-if="state.loading"
                    class="w-6 h-6 rounded-full border-2 border-white border-t-transparent animate-spin block"
                ></span>
                <span v-else>Save</span>
            </button>
        </div>
</template>
