<template>
    <v-form>
        <v-container>
            <v-row>
                <v-col
                    cols="12"
                    md="4"
                >
                    <v-text-field
                        v-model="form.name"
                        label="نام دسته"
                        required
                    ></v-text-field>
                </v-col>
                <v-col
                    cols="12"
                    md="4"
                >
                    <v-treeview
                        selectable
                        shaped
                        hoverable
                        activatable
                        selection-type="independent"
                        v-model="form.parent_id"
                        :items="getTreeCategories"
                    ></v-treeview>
                </v-col>
            </v-row>
            <v-btn
                class="mr-4"
                @click="submit"
            >
                ذخیره
            </v-btn>
            <router-link :to="{name:'ListCategories'}">
                <v-btn
                    class="mr-4"
                >
                    بازگشت
                </v-btn>
            </router-link>
        </v-container>
    </v-form>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

let defaultForm = {
    name: null,
    parent_id: [0],
};

export default {
    name: "Add",
    props: {
        category_id: {default: null}
    },
    data: () => ({
        form: defaultForm,
    }),
    computed: {
        ...mapGetters('category', ['getTreeCategories'])
    },
    methods: {
        ...mapActions('category', ["showCategory", "storeCategory", "updateCategory"]),
        async submit() {
            if (this.category_id) {
                let response;
                response = await this.updateCategory({data: this.form});
                if (!(response instanceof Error)) {
                    await this.$router.push({name: 'ListCategories'})
                }
            } else {
                let response;
                response = await this.storeCategory({data: this.form});
                if (!(response instanceof Error)) {
                    await this.$router.push({name: 'ListCategories'})
                }
            }
        }
    },
    async created() {
        if (this.category_id) {
            this.form = await this.showCategory(this.category_id);
            this.form.parent_id = [this.form.parent_id];
        }
    }
}
</script>

<style scoped>
</style>
