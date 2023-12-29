<script setup>
import { useUppy } from "@/Composable/uppy";
import { XMarkIcon } from "@heroicons/vue/24/solid";
import { Dashboard } from "@uppy/vue";
import { reactive } from "vue";
import Modal from "../Shared/Modal.vue";

const props = defineProps({
    isOpen: Boolean,
    getImageUploadResponse: Function,
});

const state = reactive({
    images: [],
})

const uppy =  useUppy({
    csrf_token: '',
    maxFileSize: 5 * 2 ** 20, //5MB
    maxNumberOfFiles: 8,
    minNumberOfFiles: 1,
    allowedFileTypes: ["image/*"],
});

const doneButtonHandler = () => {
    state.images = uppy.getState()
    props.getImageUploadResponse(Object.values(state.images.files))
}

</script>

<template>
    <Modal :show="isOpen" :handle-close="doneButtonHandler" overlay-opacity="99">
        <template #main>
            <div class="relative">
                <XMarkIcon
                    @click="doneButtonHandler"
                    class="w-8 h-8 text-red-500 z-20 absolute top-4 right-4 cursor-pointer"
                />
                <Dashboard
                    :props="{
                        showRemoveButtonAfterComplete: true,
                        proudlyDisplayPoweredByUppy: false,
                        singleFileFullScreen: false,
                        width: '600px',
                        height: '400px',
                        note: '最大 8 つのファイルをアップロードでき、各ファイルは最大 5MB です。',
                        doneButtonHandler
                    }"
                    :uppy="uppy"
                />
            </div>
        </template>
    </Modal>
</template>
