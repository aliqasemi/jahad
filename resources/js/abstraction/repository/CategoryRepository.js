import {
    setData,
    getJson,
    getArray,
} from "../resource/CategoryResource";
import axios from "axios"

export default class CategoryRepository {
    async index() {
        try {
            let response = await axios.get('http://127.0.0.1:8000/api/jahad/categories');

            if (response && response.status === 200) {
                return getArray(response.data.data);
            }
        } catch (e) {
            return e;
        }
    }

    async show(id) {
        let response = await axios.put("http://127.0.0.1:8000/api/jahad/categories/" + id);
        if (response && response.status === 200) {
            return getJson(response.data.data);
        }
    }

    async store(data) {
        try {
            const params = setData(data);
            let response = await axios.post("http://127.0.0.1:8000/api/jahad/categories", params);

            if (response && response.status === 201) {
                return getJson(response.data.data);
            }
        } catch (e) {
            return e;
        }
    }

    async update(data) {
        const params = setData(data, true);

        let response = await axios.post(
            "http://127.0.0.1:8000/api/jahad/categories/" + data.id,
            params
        );

        if (response && response.status === 200) {
            return getJson(response.data.data);
        }
    }

    async destroy(id) {
        try {
            let response = await axios.delete(
                "http://127.0.0.1:8000/api/jahad/categories/" + id
            );
            if (response && response.status === 200) {
                return true;
            }
        } catch (e) {
            return e;
        }

    }
}
