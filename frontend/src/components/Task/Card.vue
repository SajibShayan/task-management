<script setup>
import { TrashIcon,PencilIcon } from '@heroicons/vue/24/outline';
import Modal from "@/components/Shared/Modal.vue";
import TaskForm from './TaskForm.vue';
import { reactive } from 'vue';
import { errorNotification,successNotification } from '@/Composable/notification'
import axios from "@/Services/axios.js"

const props = defineProps({
  task: Object,
  getAllTask: Function,
})
const state = reactive({
  isOpen: false,
  deleteModal: false,
  loading: false,
})



const handleDelete = async() => {
  state.loading = true;

  try {
    const response = await axios.delete("/task/" + props.task?.slug);
    successNotification('Successfully deleted the task');
    state.loading = false;
    state.deleteModal = false;
    props.getAllTask();

  } catch (error) {
    errorNotification('Something bad happend')
  }


}

</script>

<template>
  <div class="max-w-[304px] p-6 bg-white border border-gray-200 rounded-lg shadow">
    <div class="flex  justify-between">
      <h5 class="mb-2 text-lg font-semibold tracking-tight text-gray-900">
      {{ task.title }}
    </h5>
     <div class="flex gap-1">
      <PencilIcon 
      @click="state.isOpen = true"
      class="h-5 w-5 text-[#3D3D3D] cursor-pointer"/>
      <TrashIcon
      @click="state.deleteModal = true"
      class="h-5 w-5 text-[#3D3D3D] cursor-pointer" />
     </div>
    </div>
    <p class="mb-3 font-normal text-gray-500">
      {{ task.description }}
    </p>
  </div>


  <Modal 
    :show="state.isOpen" 
    :handle-close=" () => (state.isOpen = false)" 
    overlay-opacity="99">
    <TaskForm
       :handle-close="() => (state.isOpen = false)" 
       :get-all-task="props.getAllTask"  
       :data="task"          
      />
      <template #footer>{{}}</template>
    </Modal>

    <Modal 
    :show="state.deleteModal" 
    :handle-close=" () => (state.deleteModal = false)" 
    overlay-opacity="99">
    <div class="mb-4 flex justify-center items-center gap-4 flex-col">
      <div class=""> Do you want to delete this task? </div>
          <div class="flex gap-4 mt-6">
            <button
                @click="state.deleteModal = false"
                type="button"
                class="bg-yellow-500 text-white rounded-md px-4 py-2"
            >
                Cancel
            </button>
            <button
                @click="handleDelete"
                type="submit"
                class="bg-indigo-500 text-white rounded-md px-4 py-2 min-w-[80px] flex justify-center"
                :class="state.loading ? 'cursor-not-allowed' : ''"
                :disabled="state.loading ? true :false"
                >
                <span
                    v-if="state.loading"
                    class=" w-6 h-6 rounded-full border-2 border-white border-t-transparent animate-spin block"
                ></span>
                <span v-else>Delete</span>
            </button>
          </div>
        </div>
      <template #footer>{{}}</template>
    </Modal>
</template>
