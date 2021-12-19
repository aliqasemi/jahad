<template>
    <v-row>
        <v-treeview
            style="direction: ltr;margin: 0 auto"
            selectable
            selection-type="independent"
            :items="items"
            v-model="selectItem"
        ></v-treeview>
    </v-row>
</template>

<script>
import {mapActions} from "vuex";

export default {
    name: "CategorySelect",
    props: {
        value: [],
        selectionType: {default: 'single'}
    },
    data() {
        return {
            items: [],
            selectItem: []
        }
    },
    methods: {
        ...mapActions("category", ['loadCategoryList'])
    },
    async created() {
        this.items = await this.loadCategoryList();
        this.selectItem.push(this.value)
    },
    watch: {
        selectItem: {
            handler() {
                if (this.selectItem.length > 1 && this.selectionType === 'single')
                    this.selectItem.shift()
                this.$emit('value', this.selectItem)
            }
        }
    }
}
</script>

<style scoped>

</style>
