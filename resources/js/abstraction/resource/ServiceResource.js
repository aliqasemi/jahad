import {SetPagination, SetQueries} from "../../service/SetPagination";

const getJson = (data) => {
    return {
        id: data.id,
        title: data.title,
        address: data.address,
        description: data.description,
        main_image: data.main_image,
        category: data.category,
        user: data.user,
        city: data.city.name,
        county: data.city.county.name,
        province: data.city.county.province.name,
    };
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
        main_image: data.main_image,
        category_id: data.category_id,
        city_id: data.city_id,
        _method: hasUpdate ? "put" : "post",
    };

    let formData = new FormData();
    Object.entries(params).forEach(([key, value]) => {
        formData.append(key, value);
    });

    return formData;
};

export {setData, getArray, getJson, setQuery};
