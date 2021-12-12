<template>
    <v-container>
        <v-row wrap>
            <v-col xs="12" lg="12" md="12" mb-3>
                <recursive-panels
                    :items="getListCategory"
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

        <router-link :to="{ name: 'AddCategory' }" replace>
            <v-btn>
                اضافه کردن
            </v-btn>
        </router-link>
    </v-container>
</template>

<script>
import RecursivePanels from "../RecursivePanels/RecursivePanels";
import Item from "./Item";
import {mapGetters, mapActions} from 'vuex'

export default {
    name: "Items",
    components: {
        RecursivePanels,
        Item,
    },
    computed: {
        ...mapGetters('category', ['getListCategory'])
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
