<template>
    <v-dialog
        v-model="state"
        persistent
        transition="dialog-bottom-transition"
        max-width="600"
    >
        <v-card style="text-align: center;">
            <v-form>
                <v-container>
                    <v-row>
                        <v-col
                            cols="12"
                            md="4"
                            style="margin:0 auto "
                        >
                            <v-text-field
                                v-model="form.name"
                                label="نام دسته"
                                required
                            ></v-text-field>
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
                            @click="state = false"
                        >
                            بازگشت
                        </v-btn>
                    </router-link>
                </v-container>
            </v-form>
        </v-card>
    </v-dialog>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

let defaultForm = {
    name: null,
};

export default {
    name: "AddModal",
    props: {
        parent_id: {default: null},
        category_id: {default: null},
        value: {
            type: Boolean,
        },
    },
    data: () => ({
        form: defaultForm,
    }),
    computed: {
        ...mapGetters('category', ['getTreeCategories']),
        state: {
            get() {
                return this.value;
            },
            set(value) {
                this.$emit("input", value);
            },
        },
    },
    methods: {
        ...mapActions('category', ["showCategory", "storeCategory", "updateCategory"]),
        async submit() {
            if (this.category_id) {
                let response;
                response = await this.updateCategory({data: this.form});
                if (!(response instanceof Error)) {
                    this.state = false;
                }
            } else {
                this.form.parent_id = this.parent_id;
                let response;
                response = await this.storeCategory({data: this.form});
                if (!(response instanceof Error)) {
                    this.state = false;
                }
            }
        },
    },
    async created() {
        this.form.name = "";
        if (this.category_id) {
            this.form = await this.showCategory(this.category_id);
        }
    }
}
</script>

<style scoped>

</style>
