<template>
    <div style="width: 90%;margin: 0 auto; direction: rtl">
        <v-row style="direction: rtl;">
            لیست نیازمندی ها
        </v-row>
        <br>
        <hr style="display: block; width: 75%"/>
        <items/>

        <router-link :to="{name:'AddRequirement'}">
            <v-btn>اضافه کردن نیازمندی جدید</v-btn>
        </router-link>
    </div>
</template>

<script>
import Items from "../../components/Requirement/Items";

export default {
    name: "Requirement",
    components: {Items}
}
</script>

<style scoped>

</style>
