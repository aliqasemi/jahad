<template>
    <div>
        <v-row class="category ma-0 cols-justified-right cols-pt-pb-1" style="text-align: right; direction: rtl">
            <v-col xl="2" md="3" lg="3" sm="4" xs="12">
                <span>{{ item.name }}</span>
            </v-col>
            <v-col xl="2" md="2" lg="2" sm="4" xs="12" justify="center"
                   style="background-color: #000000;  color:#eeeeee ;border-radius:20px; margin: 0 auto;height: 50%; text-align: center">
                <span>{{ item.children_count }} زیر مجموعه</span>
            </v-col>
            <v-col xl="4" lg="4" sm="4" class="flex-justified-left">
                <v-row justify="center" style="padding: 5px; margin: 0 auto">
                    <v-tooltip top>
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn
                                slot="activator"
                                @click="editDialog = true"
                                v-bind="attrs"
                                v-on="on"
                            >
                                <v-icon dark>fa-edit</v-icon>
                            </v-btn>
                        </template>
                        <span>ویرایش</span>
                    </v-tooltip>
                    <v-tooltip top>
                        <template v-slot:activator="{ on,attrs }">
                            <v-btn
                                slot="activator"
                                v-bind="attrs"
                                v-on="on"
                                @click.native="deleteDialog = true"
                            >
                                <v-icon dark>fa-trash</v-icon>
                            </v-btn>
                        </template>
                        <span>حذف</span>
                    </v-tooltip>
                    <v-tooltip top>
                        <template v-slot:activator="{ on, attrs}">
                            <v-btn
                                slot="activator"
                                v-bind="attrs"
                                v-on="on"
                                @click.native="plusDialog = true"
                            >
                                <v-icon dark>fa-plus</v-icon>
                            </v-btn>
                        </template>
                        <span>اضافه کردن زیر مجموعه</span>
                    </v-tooltip>
                    <delete-modal v-model="deleteDialog" @action="deleteCategory(item.id)"/>
                    <add-modal v-model="plusDialog" :parent_id="item.id"/>
                    <add-modal v-model="editDialog" :category_id="item.id"/>
                </v-row>
            </v-col>
        </v-row>
    </div>
</template>

<script>
import {mapActions} from "vuex";
import DeleteModal from "../GeneralComponent/deleteModal";
import AddModal from "./AddModal";

export default {
    name: 'Item',
    components: {AddModal, DeleteModal},
    data: () => ({
        deleteDialog: false,
        plusDialog: false,
        editDialog: false,
        id: {default: null}
    }),
    props: {
        item: {
            default: () => [],
        },
        subCategoriesCount: {default: 0},
    },
    methods: {
        ...mapActions('category', ['removeCategory', 'loadCategoryList']),
        async deleteCategory(id) {
            let response;
            response = await this.removeCategory(id);
            await this.loadCategoryList();
            if (!(response instanceof Error)) {
                this.dialog = false;
            }
        },
    }
}
</script>
<style lang="scss">
.category {
    padding: 10px 10px 0px;
    border: 1px solid #eeeeee;
    border-radius: 5px;
    margin-bottom: 5px;
    margin-right: 0px;
    margin-left: 0px;
}
</style>
