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
                        {{ requirement.title }}
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
                        {{ requirement.description }}
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
                        {{ requirement.address }}
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
                        {{ requirement.category ? requirement.category.name : '' }}
                    </v-card-text>
                </v-col>

                <v-col
                >
                    <v-card-text>
                        مستندات:
                    </v-card-text>
                    <v-img :src="requirement.thumbnail" width="700px" height="300px" alt="مستندات"/>
                </v-col>

                <v-col
                    cols="12"
                    md="4"
                >
                    <v-card-text>
                        استان:
                    </v-card-text>
                    <v-card-text>
                        {{ requirement.province }}
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
                        {{ requirement.county }}
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
                        {{ requirement.city }}
                    </v-card-text>
                </v-col>
            </v-row>
        </v-container>

        <v-row v-if="attachment" style="direction: rtl;">
            خدمت پیشنهاد شده
        </v-row>
        <br>
        <hr v-if="attachment" style="display: block; width: 75%"/>
        <Items v-if="attachment" :requirement_id="requirement_id"/>
    </div>
</template>

<script>
import {mapActions} from "vuex";
import Items from "../../components/AttachServiceRequirement/AttachByRequirement/Items";

export default {
    name: "AttachByRequirement",
    components: {Items},
    props: {
        requirement_id: null,
        attachment: {default: true},
    },
    data() {
        return {
            requirement: {default: null}
        }
    },
    methods: {
        ...mapActions('requirement', ['showRequirement'])
    },
    async created() {
        this.requirement = await this.showRequirement(this.requirement_id);
    }
}
</script>

<style scoped>

</style>
