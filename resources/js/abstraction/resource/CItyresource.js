const getJson = (data) => {
    return {
        id: data.id,
        title: data.title,
        name: data.name,
    };
};

const getArray = (data) => {
    data = data.map((Item) => getJson(Item));
    return data;
};


export {getArray};
