const addIndexTreeToList = list => {
    function recursiveFunctionIndexToTree(list, parent_id = null) {
        var indexTree = 1;
        for (const item of list) {
            if (item.parent_id === parent_id) {
                item['indexTree'] = indexTree;
                indexTree++;
                recursiveFunctionIndexToTree(list, item.id);
            }
        }
        return list;
    }

    return recursiveFunctionIndexToTree(list);
};

const convertListToTree = list => {

    function recursiveFunctionToTree(list, parent_id = null) {
        let object = [];
        for (const item of list) {
            item.label = item.label ? item.label : item.name;
            if (item.id) {
                if (item.parent_id === parent_id) {
                    let children = recursiveFunctionToTree(list, item.id);
                    if (children.length) {
                        item['children'] = children;
                    }
                    object.push(item);
                }
            }
        }
        return object;
    }

    return recursiveFunctionToTree(list);
};
export {
    addIndexTreeToList,
    convertListToTree
};
