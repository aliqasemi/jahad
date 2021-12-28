<template>
    <v-row style="padding: 20px">
        <tree-select
            style="direction: ltr;text-align:right;margin: 0 auto"
            search-nested
            v-model="selectItem"
            :value="selectItem"
            :multiple="true"
            :options="getTreeCategories"
            placeholder="نوع خدمت خود را انتخاب کنید"
        />
    </v-row>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import TreeSelect from '@riophae/vue-treeselect'
import '@riophae/vue-treeselect/dist/vue-treeselect.css'

export default {
    name: "CategorySelect",
    props: {
        value: {
            default: null,
        },
        selectionType: {default: 'single'}
    },
    components: {
        TreeSelect
    },
    data() {
        return {
            selectItem: []
        }
    },
    computed: {
        ...mapGetters("category", ['getTreeCategories']),
    },
    methods: {
        ...mapActions("category", ['loadCategoryList'])
    },
    async created() {
        await this.loadCategoryList();
        if (this.selectionType === 'single') {
            this.selectItem = [this.value];
        } else {
            this.selectItem = this.value;
        }
    },
    watch: {
        selectItem: {
            handler() {
                if (this.selectItem.length > 1 && this.selectionType === 'single')
                    this.selectItem.shift()
                this.$emit('input', this.selectItem)
            }
        }
    }
}
</script>

<style scoped>

</style>
