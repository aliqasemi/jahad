<template>
    <div>
        <v-row class="category ma-0 cols-justified-right cols-pt-pb-1" style="text-align: right; direction: rtl">
            <v-col xl="2" md="3" lg="3" sm="4" xs="12">
                <span>{{ item.name }}</span>
            </v-col>
            <v-col xl="2" md="2" lg="2" sm="4" xs="12" justify="center"
                   style="background-color: #000000;  color:#eeeeee ;border-radius:20px; margin: 0 auto;height: 50%; text-align: center">
                <span>{{ item.children_count }} زیر مجموعه</span>
            </v-col>
            <v-col xl="2" lg="2" sm="3" class="flex-justified-left">
                <v-row justify="center" style="padding: 5px">
                    <router-link :to="{ name: 'EditCategory', params:{category_id: item.id} }">
                    <span>
                        <v-tooltip>
            <template v-slot:activator="{ on }">
                <v-btn
                    slot="activator"
                >
                    <v-icon dark>fa-edit</v-icon>
                </v-btn>
            </template>
            <span>ویرایش</span>
        </v-tooltip>
                    </span>
                    </router-link>
                    <v-dialog
                        v-model="dialog"
                        persistent
                        max-width="290"
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <v-tooltip>
                                <template v-slot:activator="{ on }">
                                    <v-btn
                                        slot="activator"
                                    >
                                        <v-icon dark>fa-trash</v-icon>
                                    </v-btn>
                                </template>
                                <span>حذف</span>
                            </v-tooltip>
                        </template>
                        <v-card>
                            <br>
                            <v-card-text style="direction: rtl">
                                آیا از حذف کردن ایتم خود اطمینان دارید?
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn
                                    color="green darken-1"
                                    text
                                    @click="dialog = false"
                                >
                                    خیر
                                </v-btn>
                                <v-btn
                                    color="green darken-1"
                                    text
                                    @click="deleteCategory(item.id)"
                                >
                                    بله
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </v-row>
            </v-col>
        </v-row>
    </div>
</template>

<script>
import {mapActions} from "vuex";

export default {
    name: 'Item',
    data: () => ({
        dialog: false,
        id: {default: null}
    }),
    props: {
        item: {
            default: () => [],
        },
        subCategoriesCount: {default: 0},
    },
    methods: {
        ...mapActions('category', ['removeCategory']),
        async deleteCategory(id) {
            let response;
            response = await this.removeCategory(id);
            if (!(response instanceof Error)) {
                this.dialog = false;
            }
        }
    }
}
</script>
<style lang="scss">
.category {
    padding: 10px 10px 0px;
    border: 1px solid #eeeeee;
    border-radius: 5px;
    margin-bottom: 5px;
    margin-right: 0px;
    margin-left: 0px;
}
</style>
