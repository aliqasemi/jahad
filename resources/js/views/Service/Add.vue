<template>
    <div>
        <v-form @submit.prevent="registerRequest">
            <div style="width: 90%;margin: 0 auto; direction: rtl">
                <v-row style="direction: rtl;">
                    اضافه کردن خدمت
                </v-row>
                <br>
                <hr style="display: block; width: 75%"/>
                <v-row>
                    <v-col lg="3">
                        <v-text-field style="text-align: right" label="عنوان" v-model="form.title" reverse></v-text-field>
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
    }
}
</script>

<style scoped>
</style>
