<template>
    <v-row style="width: 70%; height: 70%; border: inset black; margin: 20px auto">
        <cropper
            :src="url ? url : 'images/insertPhoto.png'"
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
                فایل خود را آپلود کنید
            </v-btn>
        </v-row>
    </v-row>
</template>

<script>
import {Cropper} from 'vue-advanced-cropper';

export default {
    name: "CropperImage",
    components: {
        Cropper
    },
    props: {
        value: {
            default: "",
        },
    },
    data() {
        return {
            url: null,
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
                return this.url
            },
            set(value) {
                this.url = value
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
    }
}
</script>

<style scoped>

</style>
