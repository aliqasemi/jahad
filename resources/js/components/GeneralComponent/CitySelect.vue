<template>
    <v-row>
        <v-col lg="4">
            <v-autocomplete
                style="direction: ltr"
                v-model="province_id"
                :items="provinces"
                item-text="name"
                item-value="id"
                dense
                reverse
                filled
                label="استان"
            ></v-autocomplete>
        </v-col>
        <v-col lg="4">
            <v-autocomplete
                style="direction: ltr"
                v-model="county_id"
                :items="counties"
                item-text="name"
                item-value="id"
                dense
                reverse
                filled
                label="شهر"
            ></v-autocomplete>
        </v-col>

        <v-col lg="4">
            <v-autocomplete
                style="direction: ltr"
                v-model="city_id"
                :items="cities"
                item-text="name"
                item-value="id"
                dense
                reverse
                filled
                label="شهرستان"
            ></v-autocomplete>
        </v-col>

    </v-row>
</template>

<script>
import CityRepository from "../../abstraction/repository/CityRepository";

let repository = new CityRepository();

export default {
    name: "CitySelect",
    data() {
        return {
            countyStatus: false,
            cityStatus: false,
            provinces: [],
            counties: [],
            cities: [],
            province_id: null,
            county_id: null,
            city_id: null
        }
    },
    async created() {
        this.provinces = await repository.indexProvinces();
    },
    watch: {
        province_id: {
            async handler() {
                this.counties = await repository.indexCounties(this.province_id);
                this.cities = [];
            }
        },
        county_id: {
            async handler() {
                this.cities = await repository.indexCities(this.county_id);
            }
        }
    }
}
</script>

<style scoped>

</style>
