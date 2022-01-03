<template>
    <div>
        <v-overlay :value="overlay">
            <v-progress-circular
                indeterminate
                size="64"
            ></v-progress-circular>
        </v-overlay>
        <div v-if="attachments" v-for="(attachment , key) in attachments">
            <item :item="attachment" :index="key" :maxPoint="maxPoint"/>
        </div>
    </div>
</template>

<script>
import Item from "./Item";
import AttachmentRepository from "../../../abstraction/repository/AttachmentRepository";

let repository = new AttachmentRepository;
export default {
    name: "Items",
    components: {Item},
    props: {
        service_id: '',
    },
    data() {
        return {
            overlay: false,
            attachments: null,
        }
    },
    computed: {
        maxPoint() {
            if (this.attachments)
                return this.attachments[0].point
        }
    },
    async created() {
        this.overlay = true;
        this.attachments = await repository.indexAttachmentByService(this.service_id);
        this.overlay = false;
    }
}
</script>

<style scoped>

</style>
