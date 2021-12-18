<template>
    <div style="width: 90%;margin: 0 auto; direction: rtl">
        <v-row style="direction: rtl;">
            لیست خدمت ها
        </v-row>
        <br>
        <hr style="display: block; width: 75%"/>
        <items/>

        <router-link :to="{name:'AddService'}">
            <v-btn>اضافه کردن حدمت جدید</v-btn>
        </router-link>
    </div>
</template>

<script>
import Items from "../../components/Service/Items";

export default {
    name: "Services",
    components: {Items}
}
</script>

<style scoped>

</style>
