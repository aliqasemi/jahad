export const SetQueries = ({pagination}) => {
    let Query = {};
    if (typeof pagination === 'object') {
        pagination = {
            per_page: pagination.itemsPerPage,
            page: pagination.page
        };
        Query = {...Query, ...pagination};
    }
    return Query;
}

export const SetPagination = (paginate) => {
    return {
        page: paginate.current_page,
        pageStop: paginate.to,
        pageStart: paginate.from,
        pageCount: paginate.last_page,
        itemsLength: paginate.total,
        itemsPerPage: paginate.per_page,
    }
};
