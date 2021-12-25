<template>
    <v-row style="width: 70%; height: 70%; border: inset black; margin: 20px auto">
        <cropper
            :src="imageUrl ? imageUrl : 'images/insertPhoto.png'"
            @change="change"
        />
        <v-row>
            <v-btn
                large
                @click.native="$refs['image'].click()"
                color="withe"
                dark
                style="margin: 0 auto;text-align: center"
            >
                <input
                    type="file"
                    v-show="false"
                    ref="image"
                    name="image"
                    @change="uploadImage($event)"
                />
                <v-icon dark>fa fa-edit
                </v-icon
                >
                عکس خود را آپلود کنید
            </v-btn>
        </v-row>
    </v-row>
</template>

<script>
import {Cropper} from 'vue-advanced-cropper';
import 'vue-advanced-cropper/dist/style.css';

export default {
    name: "CropperImage",
    components: {
        Cropper
    },
    props: {
        value: {
            default: "",
        },
        url: null,
    },
    data() {
        return {
            imageUrl: {default: null},
        }
    },
    methods: {
        async uploadImage(event) {
            let input = event.target;
            if (input.files && input.files[0]) {
                this.file = input.files[0];
                let reader = new FileReader();
                reader.onload = (e) => {
                    this.image = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        },
        change({coordinates}) {
            this.$emit("update:crop_data", coordinates);
        },
    },
    computed: {
        image: {
            get() {
                return this.imageUrl;
            },
            set(value) {
                this.imageUrl = value;
                this.$emit("update:url", value);
            },
        },
        file: {
            get() {
                return this.value;
            },
            set(value) {
                this.$emit("input", value);
            },
        },
    },
    watch: {
        url: {
            deep: true,
            immediate: true,
            async handler() {
                this.imageUrl = this.url;
            },
        },
    },
}
</script>

<style scoped>

</style>
