const getJson = (data) => {
    return {
        id: data.id,
        name: data.name,
        created_at: data.created_at,
        parent_id: data.parent_id,
        children_count: data.children_count,
        children: data.children,
    };
};

const getArray = (data) => {
    return data.map((Item) => getJson(Item));
};

const setData = (data, hasUpdate = false) => {
    return {
        name: data.name,
        parent_id: data.parent_id !== 0 ? data.parent_id : null,
        _method: hasUpdate ? "put" : "post",
    };
};

export {setData, getArray, getJson};
