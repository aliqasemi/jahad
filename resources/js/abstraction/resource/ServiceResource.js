import {SetPagination, SetQueries} from "../../service/SetPagination";
import {serialize} from 'object-to-formdata';

const getJson = (data) => {
    let result = {
        id: data.id,
        title: data.title,
        address: data.address,
        description: data.description,
        thumbnail: data.main_image ? data.main_image.image : null,
        url: data.main_image ? data.main_image.image : null,
        category_id: data.category ? data.category.id : null,
        category: data.category ? data.category : null,
        user: data.user,
        city: data.city.name,
        city_id: data.city.id,
        county: data.city.county.name,
        province: data.city.county.province.name,
        available_province: data.available_province,
    };
    if (data.available_province) {
        result.available_province_ids = data.available_province.map((e) => {
            return e.id;
        });
    }

    return result;
};

const getArray = ({data, meta}) => {
    const pagination = SetPagination(meta);
    data = data.map((Item) => getJson(Item));
    return {data, pagination};
};

const setQuery = (data) => {
    return SetQueries(data);
};

const setData = (data, hasUpdate = false) => {
    let params = {
        title: data.title,
        address: data.address,
        description: data.description,
        available_province_ids: data.available_province_ids,
        crop_data: data.crop_data,
        main_image: data.image,
        category_id: data.category_id[0],
        city_id: data.city_id,
        _method: hasUpdate ? "put" : "post",
    };

    return serialize(
        params,
    );
};

export {setData, getArray, getJson, setQuery};
