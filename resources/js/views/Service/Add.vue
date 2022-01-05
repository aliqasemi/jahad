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
                    اضافه کردن خدمت
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
                    <v-col lg="6" md="12" style="direction: ltr">
                        <v-select
                            v-model="form.available_province_ids"
                            :items="provinces"
                            item-text="name"
                            item-value="id"
                            label="انتخاب نمایید"
                            multiple
                            chips
                            hint="در صورتی که تنها در استان خاصی قادر به فعالیت هستید آن استان خاص را انتخاب نمایید"
                            persistent-hint
                        ></v-select>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col>
                        <v-btn v-if="service_id" type="submit">
                            ویرایش خدمت
                        </v-btn>
                        <v-btn v-else type="submit">
                            اضافه کردن خدمت
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
import CityRepository from "../../abstraction/repository/CityRepository";

let repository = new CityRepository();
var defaultForm = {
    title: null,
    description: null,
    city_id: null,
    address: null,
    category_id: [],
    available_province_ids: [],
    crop_data: "",
    image: "",
    thumbnail: "",
};

export default {
    name: "Add",
    props: {
        service_id: {default: null}
    },
    components: {
        CitySelect,
        CropperImage,
        CategorySelect
    },
    data() {
        return {
            form: {...defaultForm},
            provinces: [],
            items: [
                {
                    text: 'صفحه اصلی',
                    disabled: false,
                    routeName: "Main",
                    icon: "fa fa-home"
                },
                {
                    text: 'خدمت ها',
                    disabled: false,
                    routeName: "ListServices",
                    icon: "fa fa-wrench"
                },
                {
                    text: 'خدمت',
                    disabled: true,
                    routeName: "AddService",
                    icon: "fa fa-wrench"
                },
            ],
        }
    },
    methods: {
        ...mapActions("service", ['storeService', 'showService', 'updateService']),
        async registerRequest() {
            if (this.service_id) {
                let response = await this.updateService({data: this.form});
                if (!(response instanceof Error)) {
                    await this.$router.replace("/services");
                }
            } else {
                let response = await this.storeService({data: this.form});
                if (!(response instanceof Error)) {
                    await this.$router.replace("/services");
                }
            }
        }
    },
    async created() {
        if (this.service_id) {
            this.form = await this.showService(this.service_id)
        }
        this.provinces = await repository.indexProvinces();
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
