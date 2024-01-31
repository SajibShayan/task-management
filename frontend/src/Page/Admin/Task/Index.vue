<script setup>
import { PlusIcon } from "@heroicons/vue/24/outline";
import AdminLayout from "../../../Layouts/AdminLayout.vue";
import Card from "../../../components/Task/Card.vue";
import Modal from "@/components/Shared/Modal.vue";
import TaskForm from "../../../components/Task/TaskForm.vue";
import { errorNotification,successNotification } from '@/Composable/notification'
import axios from "@/Services/axios.js"
import FilterDropdown from "@/components/Shared/FilterDropdown.vue";

import { onMounted, onUpdated, reactive, ref, watch } from "vue";

const state = reactive({
  isOpen: false,
  status: "All",
  searchTerm: "",
})
const allTask = ref([]);
const incompleteTasks = ref([]);
const completeTasks = ref([]);
let page = 1;

const allStatus = [{ name: "All" }, { name: "Incomplete" }, { name: "Complete" }];
const defaultType = allStatus.findIndex((i) => i.name === state.status);

const getTaskStatus = (type) => (state.status = type);

const separateTasksByStatus = () => {
 
  allTask.value.forEach(task => {
    if (task.status === 'incomplete' && !incompleteTasks.value.find(t => t.id === task.id)) {
      incompleteTasks.value.push(task);
    } else if (task.status === 'complete' && !completeTasks.value.find(t => t.id === task.id)) {
      completeTasks.value.push(task);
    }
  });
};

const getAllTask = async() => {
  try {

    state.searchTerm = state.status;
    state.searchTerm = state.searchTerm.toLowerCase();
    const response = await axios.get(`/task?status=${state.searchTerm}&page=${page}`);

    incompleteTasks.value = [];
    completeTasks.value = [];

    allTask.value = response?.data?.data?.data || [];
    
    separateTasksByStatus();

  } catch (error) {
    errorNotification('something bad happend!')
  }
}
const handleScroll = () => {
  const bottomOfWindow = document.documentElement.scrollTop + window.innerHeight === document.documentElement.offsetHeight;
  if (bottomOfWindow) {
    page++;
    getAllTask();
  }
};

onMounted(() => {
  getAllTask();
  window.addEventListener('scroll', handleScroll);

})

watch(
  () => state.status,
  (newValue, oldValue) => {
      page = 1;
      allTask.value = [];
      incompleteTasks.value = [];
      completeTasks.value = [];
      getAllTask();
  },
  {immediate: true}
);
</script>



<template>
  <AdminLayout>
    <template #main>
      <div class="flex justify-between items-center">
        <div class="">Tasks</div>
        <div class="min-w-[328px]">
          <FilterDropdown
                    class="text-sm"
                    :drop-down-data="allStatus"
                    :default="defaultType >= 0 ? defaultType : 0"
                    @getFilterData="getTaskStatus"
                />
        </div>
        <div class="flex">
          <button 
           @click="state.isOpen = true"
          class="btn-primary bg-[#2563DC]"> New task 
            <PlusIcon  class="h-4 w-4 text-[#FFFFFF]"/></button>
          
        </div>
      </div>
      <div class="flex gap-3 pt-4">
      <div class="max-w-[328px] bg-[#EEF2FC] border rounded-xl min-h-screen flex flex-col items-center gap-3 pt-4 px-2">
        <h5 class="text-[#14367B]">Incomplete</h5>
        <div v-for="task in incompleteTasks" :key="task.id">

          <Card :task="task" :get-all-task="getAllTask"  />
        </div> 
      </div>

      <div class="max-w-[328px] bg-[#FFE4C2] border rounded-xl min-h-screen flex flex-col items-center gap-3 pt-4 px-2">
        <h5 class="text-[#14367B]">Complete</h5>
        <div v-for="task in completeTasks" :key="task.id">

        <Card :task="task" :get-all-task="getAllTask"/>
         </div>
      </div>

    </div>

    <Modal 
    :show="state.isOpen" 
    :handle-close=" () => (state.isOpen = false)" 
    overlay-opacity="99">
    <TaskForm
       :handle-close="() => (state.isOpen = false)" 
       :get-all-task="getAllTask"  
      />
      <template #footer>{{}}</template>
    </Modal>

    </template>
  </AdminLayout>
</template>
