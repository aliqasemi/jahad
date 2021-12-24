<template>
    <div>
        <v-progress-linear
            v-if="getRequirementLoading"
            color="black accent-4"
            indeterminate
            rounded
            height="10"
            style="margin: 10px"
        ></v-progress-linear>
        <div v-else v-for="(requirement , key) in getListRequirement">
            <item :item="requirement" :index="key"/>
        </div>
        <div class="text-center" style="direction: ltr">
            <v-pagination
                v-model="page"
                :length="pageNumber"
                :total-visible="7"
            ></v-pagination>
        </div>
    </div>
</template>

<script>
import Item from "../Requirement/Item";
import {mapActions, mapGetters, mapMutations} from "vuex";

export default {
    name: "items",
    components: {Item},
    data() {
        return {
            page: 1,
            itemsPerPage: 10,
            pageNumber: 1,
        }
    },
    computed: {
        ...mapGetters("requirement", ['getListRequirement', 'getRequirementLoading'])
    },
    methods: {
        ...mapActions("requirement", ['loadRequirementList']),
        ...mapMutations("requirement", ['SET_REQUIREMENT_PAGINATION'])
    },
    watch: {
        page: {
            deep: true,
            immediate: true,
            async handler() {
                this.SET_REQUIREMENT_PAGINATION({page: this.page, itemsPerPage: this.itemsPerPage})
                await this.loadRequirementList()
            },
        },
    },
    async created() {
        let response = await this.loadRequirementList();
        this.pageNumber = response.pagination.pageCount
    }
}
</script>

<style scoped>

</style>
