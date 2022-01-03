<template>
    <div style="width: 90%;margin: 0 auto; direction: rtl">
        <v-row style="direction: rtl;">
            نیازمندی
        </v-row>
        <br>
        <hr style="display: block; width: 75%"/>
        <v-container>
            <v-row>
                <v-col
                    cols="12"
                    md="4"
                >
                    <v-card-text>
                        عنوان:
                    </v-card-text>
                    <v-card-text>
                        {{ service.title }}
                    </v-card-text>
                </v-col>

                <v-col
                    cols="12"
                    md="4"
                >
                    <v-card-text>
                        توضیحات:
                    </v-card-text>
                    <v-card-text>
                        {{ service.description }}
                    </v-card-text>
                </v-col>

                <v-col
                    cols="12"
                    md="4"
                >
                    <v-card-text>
                        آدرس:
                    </v-card-text>
                    <v-card-text>
                        {{ service.address }}
                    </v-card-text>
                </v-col>

                <v-col
                    cols="12"
                    md="4"
                >
                    <v-card-text>
                        دسته بندی:
                    </v-card-text>
                    <v-card-text>
                        {{ service.category ? service.category.name : '' }}
                    </v-card-text>
                </v-col>

                <v-col
                >
                    <v-card-text>
                        مستندات:
                    </v-card-text>
                    <v-img :src="service.thumbnail" width="700px" height="300px" alt="مستندات"/>
                </v-col>

                <v-col
                    cols="12"
                    md="4"
                >
                    <v-card-text>
                        استان:
                    </v-card-text>
                    <v-card-text>
                        {{ service.province }}
                    </v-card-text>
                </v-col>

                <v-col
                    cols="12"
                    md="4"
                >
                    <v-card-text>
                        شهر:
                    </v-card-text>
                    <v-card-text>
                        {{ service.county }}
                    </v-card-text>
                </v-col>

                <v-col
                    cols="12"
                    md="4"
                >
                    <v-card-text>
                        مرکز:
                    </v-card-text>
                    <v-card-text>
                        {{ service.city }}
                    </v-card-text>
                </v-col>
                <v-col cols="12" md="4" v-if="service.available_province">
                    <v-card-text>
                        شهر های در دسترس:
                    </v-card-text>
                    <div v-for="(available,key) in service.available_province">
                        <v-card-text>
                            {{ key + 1 }}: {{ available.name }}
                        </v-card-text>
                    </div>
                </v-col>
            </v-row>
        </v-container>

        <v-row v-if="attachment" style="direction: rtl;">
             نیازمندی پیشنهاد شده
        </v-row>
        <br>
        <hr v-if="attachment" style="display: block; width: 75%"/>
        <Items v-if="attachment" :service_id="service_id"/>
    </div>
</template>

<script>
import {mapActions} from "vuex";
import Items from "../../components/AttachServiceRequirement/AttachByService/Items";

export default {
    name: "AttachByService",
    components: {Items},
    props: {
        service_id: null,
        attachment: {default: true},
    },
    data() {
        return {
            service: {default: null}
        }
    },
    methods: {
        ...mapActions('service', ['showService'])
    },
    async created() {
        this.service = await this.showService(this.service_id);
    }
}
</script>

<style scoped>

</style>
