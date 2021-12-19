<template>
    <div style="width: 90%;margin: 0 auto; direction: rtl">
        <v-row style="direction: rtl;">
            اضافه کردن خدمت
        </v-row>
        <br>
        <hr style="display: block; width: 75%"/>
        <v-row>
            <v-col lg="3">
                <v-text-field style="text-align: right" label="عنوان" reverse></v-text-field>
                <v-textarea style="text-align: right" label="توضیحات" reverse></v-textarea>
            </v-col>
            <v-col lg="4">
                <v-text-field style="text-align: right" label="آدرس" reverse></v-text-field>
            </v-col>
            <v-col lg="5">
                <cropper-image
                    :crop_data.sync="form.document.crop_data"
                    v-model="form.document.image"
                    :url.sync="form.document.thumbnail"
                />
            </v-col>
            <v-col lg="12">
                <city-select/>
            </v-col>
        </v-row>
    </div>
</template>

<script>
import CitySelect from "../../components/GeneralComponent/CitySelect";
import 'vue-advanced-cropper/dist/style.css';
import CropperImage from "../../components/GeneralComponent/CropperImage";

var defaultForm = {
    document: {
        crop_data: "",
        image: "",
        thumbnail: "",
    },
};

export default {
    name: "Add",
    props: {
        service_id: {default: null}
    },
    components: {
        CropperImage,
        CitySelect,
    },
    data() {
        return {
            form: {...defaultForm},
        }
    },
    methods: {},
}
</script>

<style scoped>
</style>
