<template>
    <v-row class="item">
        <v-col lg="2">
            {{ index + 1 }}
        </v-col>
        <v-col lg="3">
            {{ item.title }}
        </v-col>
        <v-col lg="2">
            {{ item.user.firstname + ' ' + item.user.lastname }}
        </v-col>
        <v-col lg="5" style="text-align: left">
            <router-link :to="{name:'AttachByRequirement',  params: { requirement_id: item.id },}">
                <v-tooltip>
                    <template v-slot:activator="{ on }">
                        <v-btn
                            slot="activator"
                        >
                            <v-icon dark>fa-paperclip</v-icon>
                        </v-btn>

                    </template>
                    <span>ویرایش</span>
                </v-tooltip>
            </router-link>
            <router-link :to="{name:'EditRequirement',  params: { requirement_id: item.id },}">
                <v-tooltip>

                    <template v-slot:activator="{ on }">

                        <v-btn
                            slot="activator"
                        >
                            <v-icon dark>fa-edit</v-icon>
                        </v-btn>

                    </template>
                    <span>ویرایش</span>
                </v-tooltip>
            </router-link>
            <v-tooltip>
                <template v-slot:activator="{ on }">
                    <v-btn
                        slot="activator"
                        @click.native="deleteDialog = true"
                    >
                        <v-icon dark>fa-trash</v-icon>
                    </v-btn>
                </template>
                <span>حذف</span>
            </v-tooltip>
            <delete-modal v-model="deleteDialog" @action="deleteRequirement(item.id)"/>
        </v-col>
    </v-row>
</template>

<script>
import DeleteModal from "../GeneralComponent/deleteModal";
import {mapActions} from "vuex";

export default {
    name: "Item",
    props: {
        item: {default: null},
        index: {default: 0},
    },
    components: {
        DeleteModal
    },
    data() {
        return {
            deleteDialog: false
        }
    },
    methods: {
        ...mapActions("requirement", ['removeRequirement']),
        async deleteRequirement(id) {
            let response;
            response = await this.removeRequirement(id);
            if (!(response instanceof Error)) {
                this.deleteDialog = false;
            }
        },
    }
}
</script>

<style scoped>
.item {
    border: 2px inset darkseagreen;
    border-radius: 5px;
    margin: 5px;
}

.item:hover {
    background-color: azure;
    transition: 100ms;
    border: 2px inset black;
}
</style>
