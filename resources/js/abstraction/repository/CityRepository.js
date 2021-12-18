import {
    getArray
} from "../resource/CItyresource";
import axios from "axios"

export default class CityRepository {
    async indexProvinces() {
        try {
            let response = await axios.get('http://127.0.0.1:8000/api/jahad/provinces');
            if (response && response.status === 200) {
                return getArray(response.data.data);
            }
        } catch (e) {
            return e;
        }
    }

    async indexCounties(province_id) {
        try {
            let response = await axios.get('http://127.0.0.1:8000/api/jahad/counties/' + province_id);
            if (response && response.status === 200) {
                return getArray(response.data.data);
            }
        } catch (e) {
            return e;
        }
    }

    async indexCities(county_id) {
        try {
            let response = await axios.get('http://127.0.0.1:8000/api/jahad/cities/' + county_id);
            if (response && response.status === 200) {
                return getArray(response.data.data);
            }
        } catch (e) {
            return e;
        }
    }
}
