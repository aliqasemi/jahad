<template>
    <v-row class="item">
        <v-col lg="1">
            {{ index + 1 }}
        </v-col>
        <v-col lg="3">
            {{ item.title }}
        </v-col>
        <v-col lg="2">
            {{ item.user.firstname + ' ' + item.user.lastname }}
        </v-col>
        <v-col lg="1">
            {{ item.point }} / {{ maxPoint }}
        </v-col>
        <v-col lg="1">
            {{ item.city.name }}
        </v-col>
        <v-col lg="1">
            {{ item.category.name }}
        </v-col>
        <v-col lg="2">
            <router-link :to="{name:'AttachByService',  params: { service_id: item.id , attachment: false}}" style="text-decoration: none">
                <v-tooltip top>
                    <template v-slot:activator="{ on ,attrs}">
                        <v-btn
                            slot="activator"
                            v-bind="attrs"
                            v-on="on"
                        >
                            <v-icon dark>fa-info-circle</v-icon>
                        </v-btn>
                    </template>
                    <span>جزییات</span>
                </v-tooltip>
            </router-link>
        </v-col>
    </v-row>
</template>

<script>
export default {
    name: "Item",
    props: {
        item: {default: null},
        index: {default: 0},
        maxPoint: {default: 0}
    },
}
</script>

<style scoped>
.item {
    border: 2px inset darkseagreen;
    border-radius: 5px;
    margin: 5px;
}

.item:hover {
    background-color: azure;
    transition: 100ms;
    border: 2px inset black;
}
</style>
