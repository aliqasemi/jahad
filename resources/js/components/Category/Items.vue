<template>
    <v-container>
        <v-row wrap>
            <v-progress-linear
                v-if="getCategoryLoading"
                color="black accent-4"
                indeterminate
                rounded
                height="10"
                style="margin: 10px;background: linear-gradient(30deg, #AED6D1, azure);border-radius: 10px"
            ></v-progress-linear>
            <v-col v-else xs="12" lg="12" md="12" mb-3>
                <recursive-panels
                    :items="getTreeCategories"
                    list-view="tree"
                    parent-id-key="parent_id"
                    style="background: linear-gradient(30deg, cadetblue, #b1b1b1);"
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

        <v-tooltip bottom>
            <template v-slot:activator="{ on, attrs }">
                <v-btn icon @click="plusDialog = true"
                       class="add"
                       v-bind="attrs"
                       v-on="on"
                >
                    <v-icon>fa fa-plus</v-icon>
                </v-btn>
            </template>
            <span>اضافه کردن دسته بندی</span>
        </v-tooltip>

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
        ...mapGetters('category', ['getTreeCategories', 'getCategoryLoading'])
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
.add {
    display: flex;
    position: fixed;
    border-radius: 50%;
    padding: 10px;
    margin: 10px;
    bottom: 25px;
    right: 25px;
    width: 75px;
    height: 75px;
    background-color: cadetblue;
}
</style>
