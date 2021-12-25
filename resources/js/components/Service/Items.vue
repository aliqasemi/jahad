<template>
    <div>
        <v-progress-linear
            v-if="getServiceLoading"
            color="black accent-4"
            indeterminate
            rounded
            height="10"
            style="margin: 10px"
        ></v-progress-linear>
        <div v-else v-for="(service , key) in getListService">
            <item :item="service" :index="key"/>
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
import Item from "../Service/Item";
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
        ...mapGetters("service", ['getListService', 'getServiceLoading'])
    },
    methods: {
        ...mapActions("service", ['loadServiceList']),
        ...mapMutations("service", ['SET_SERVICE_PAGINATION'])
    },
    watch: {
        page: {
            deep: true,
            immediate: true,
            async handler() {
                this.SET_SERVICE_PAGINATION({page: this.page, itemsPerPage: this.itemsPerPage})
                await this.loadServiceList()
            },
        },
    },
    async created() {
        let response = await this.loadServiceList();
        console.log(response.pagination)
        this.pageNumber = response.pagination.pageCount
    }
}
</script>

<style scoped>

</style>
