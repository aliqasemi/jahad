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
                <category-select/>
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
                <v-text-field style="text-align: right; width: 60%" label="آدرس" reverse></v-text-field>
            </v-col>
        </v-row>
    </div>
</template>

<script>
import CitySelect from "../../components/GeneralComponent/CitySelect";
import CropperImage from "../../components/GeneralComponent/CropperImage";
import CategorySelect from "../../components/GeneralComponent/CategorySelect";

var defaultForm = {
    document: {
        crop_data: "",
        image: "",
        thumbnail: "",
    },
    components: {
        CitySelect,
        CropperImage,
        CategorySelect
    }
};

export default {
    name: "Add",
    props: {
        service_id: {default: null}
    },
    components: {
        CategorySelect,
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
