<template>
    <v-row>
        <v-treeview
            style="direction: ltr;margin: 0 auto"
            selectable
            selection-type="independent"
            :items="getTreeCategories"
            v-model="selectItem"
        ></v-treeview>
    </v-row>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: "CategorySelect",
    props: {
        value: {
            default: [],
            type: Array
        },
        selectionType: {default: 'single'}
    },
    data() {
        return {
            selectItem: []
        }
    },
    computed: {
        ...mapGetters("category", ['getTreeCategories'])
    },
    methods: {
        ...mapActions("category", ['loadCategoryList'])
    },
    async created() {
        await this.loadCategoryList();
        this.selectItem.push(this.value)
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
