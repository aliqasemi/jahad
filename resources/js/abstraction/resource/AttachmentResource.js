let result = [];
const getJson = (data) => {
    for (let key in data) {
        if (key !== 'point') {
            result.push(
                {
                    id: data[key].id,
                    point: data['point'],
                    city: data[key].city,
                    title: data[key].title,
                    user: data[key].user,
                    address: data[key].address,
                    description: data[key].description,
                    category: data[key].category,
                    available_province: data[key].available_province,
                }
            )
        }
    }
};

const getArray = (data) => {
    result = [];
    data.map((Item) => getJson(Item));
    return result;
};

export {getArray, getJson};
