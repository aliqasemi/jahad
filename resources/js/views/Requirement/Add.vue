<template>
    <div style="width: 90%;margin: 0 auto; direction: rtl">
        <div style="direction: rtl; background-color: aliceblue;border-radius: 10px">
            <v-breadcrumbs :items="items">
                <template v-slot:divider>
                    <v-icon>fa fa-chevron-left</v-icon>
                </template>
                <template v-slot:item="{ item }">
                    <v-breadcrumbs-item
                        :disabled="item.disabled"
                    >
                        <router-link :to="{name:item.routeName}" style="text-decoration: none;color:black;padding: 5px"
                                     class="bredRoute">
                           <span>
                                <v-icon>{{ item.icon }}</v-icon>  {{ item.text.toUpperCase() }}
                           </span>
                        </router-link>
                    </v-breadcrumbs-item>
                </template>
            </v-breadcrumbs>
        </div>
        <v-form @submit.prevent="registerRequest" style="margin-top: 20px">
            <div style="margin: 0 auto; direction: rtl">
                <v-row style="direction: rtl;">
                    اضافه کردن نیازمندی
                </v-row>
                <br>
                <hr style="display: block; width: 75%"/>
                <v-row>
                    <v-col lg="3">
                        <v-text-field style="text-align: right" label="عنوان" v-model="form.title"
                                      reverse></v-text-field>
                        <v-textarea style="text-align: right" label="توضیحات" v-model="form.description"
                                    reverse></v-textarea>
                    </v-col>
                    <v-col lg="4">
                        <category-select v-model="form.category_id"/>
                    </v-col>
                    <v-col lg="5">
                        <cropper-image
                            :crop_data.sync="form.crop_data"
                            v-model="form.image"
                            :url.sync="form.thumbnail"
                            :url="form.url"
                        />
                    </v-col>
                    <v-col lg="12">
                        <city-select v-model="form.city_id"/>
                        <v-text-field style="text-align: right; width: 60%" label="آدرس" v-model="form.address"
                                      reverse></v-text-field>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col>
                        <v-btn v-if="requirement_id" type="submit">
                            ویرایش نیازمندی
                        </v-btn>
                        <v-btn v-else type="submit">
                            اضافه کردن نیازمندی
                        </v-btn>
                    </v-col>
                </v-row>
            </div>
        </v-form>
    </div>
</template>

<script>
import CitySelect from "../../components/GeneralComponent/CitySelect";
import CropperImage from "../../components/GeneralComponent/CropperImage";
import CategorySelect from "../../components/GeneralComponent/CategorySelect";
import {mapActions} from "vuex";

var defaultForm = {
    title: null,
    description: null,
    city_id: null,
    address: null,
    category_id: [],
    crop_data: "",
    image: "",
    thumbnail: "",
};

export default {
    name: "Add",
    props: {
        requirement_id: {default: null}
    },
    components: {
        CitySelect,
        CropperImage,
        CategorySelect
    },
    data() {
        return {
            form: {...defaultForm},
            items: [
                {
                    text: 'صفحه اصلی',
                    disabled: false,
                    routeName: "Main",
                    icon: "fa fa-home"
                },
                {
                    text: 'نیازمندی ها',
                    disabled: false,
                    routeName: "ListRequirements",
                    icon: "fa fa-asterisk"
                },
                {
                    text: 'نیازمندی',
                    disabled: true,
                    routeName: "AddRequirement",
                    icon: "fa fa-asterisk"
                },
            ],
        }
    },
    methods: {
        ...mapActions("requirement", ['storeRequirement', 'showRequirement', 'updateRequirement']),
        async registerRequest() {
            if (this.requirement_id) {
                let response = await this.updateRequirement({data: this.form});
                if (!(response instanceof Error)) {
                    await this.$router.replace("/requirements");
                }
            } else {
                let response = await this.storeRequirement({data: this.form});
                if (!(response instanceof Error)) {
                    await this.$router.replace("/requirements");
                }
            }
        }
    },
    async created() {
        if (this.requirement_id) {
            this.form = await this.showRequirement(this.requirement_id)
        }
    }
}
</script>

<style scoped>
.bredRoute:hover {
    background-color: cadetblue;
    color: white;
    border-radius: 10px;
    transition: 1s;
}
</style>
