<template>
    <v-container>
        <v-row wrap>
            <v-col xs="12" lg="12" md="12" mb-3>
                <recursive-panels
                    :items="getTreeCategories"
                    list-view="tree"
                    parent-id-key="parent_id"
                >
                    <template v-slot:default="{ item, subCategoriesCount, index }">
                        <item
                            :item="item"
                            :sub-categories-count="subCategoriesCount"
                            :index="index"
                        />
                    </template>
                </recursive-panels>
            </v-col>

        </v-row>

        <v-btn @click="plusDialog = true">
            اضافه کردن
        </v-btn>

        <add-modal v-model="plusDialog"/>
    </v-container>
</template>

<script>
import RecursivePanels from "../RecursivePanels/RecursivePanels";
import Item from "./Item";
import {mapGetters, mapActions} from 'vuex'
import AddModal from "./AddModal";

export default {
    name: "Items",
    data: () => ({
        plusDialog: false,
    }),
    components: {
        AddModal,
        RecursivePanels,
        Item,
    },
    computed: {
        ...mapGetters('category', ['getTreeCategories'])
    },
    methods: {
        ...mapActions('category', ['loadCategoryList'])
    },
    async created() {
        await this.loadCategoryList();
    }
}
</script>

<style scoped>
</style>
