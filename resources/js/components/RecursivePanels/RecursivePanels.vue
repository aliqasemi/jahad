<template>
    <v-expansion-panels flat>
        <v-expansion-panel v-for="(item, i) in filtered" :key="i">
            <v-expansion-panel-header expand-icon="WMi-down-open">
                <slot :item="item" :subCategoriesCount="getSubCategoriesCount(item)" :index="i"></slot>
            </v-expansion-panel-header>
            <v-expansion-panel-content v-if="listView === 'tree'">
                <recursive-panels :parentId="item.id" :list-view="listView" :items="items">
                    <template v-slot:default="{ item, subCategoriesCount, index }">
                        <slot :item="item" :subCategoriesCount="subCategoriesCount" :index="index"></slot>
                    </template>
                </recursive-panels>
            </v-expansion-panel-content>
        </v-expansion-panel>
    </v-expansion-panels>
</template>
<script>
export default {
    name: "recursivePanels",
    computed: {
        filtered() {
            let list = [];
            for (let item of this.items) {
                if (item[this.parentIdKey] === this.parentId) {
                    list.push(item);
                }
            }
            return list;
        },
    },
    props: {
        parentId: {
            default: null,
        },
        parentIdKey: {
            type: String,
            default: "parent_id",
        },
        items: {
            default: () => [],
        },
        listView: {
            default: "tree",
        },
    },
    methods: {
        getSubCategoriesCount(item) {
            return this.items.filter((x) => x.parent_id === item.id).length;
        },
    },
};
</script>
<style lang="scss">
.v-expansion-panel-header {
    margin-top: 12px !important;
    border: 1px solid #eeeeee;
    border-radius: 5px;
    transition: 0.2s;
}
.v-expansion-panel-header:hover {
    border: 1px solid #000;
    background-color: #f5f5f5;
}
</style>
