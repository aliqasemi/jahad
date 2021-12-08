const {checkAuth} = require("../service/AuthService");

export const isGuest = (to, from, next) => {
    const userIsAuthenticated = checkAuth();
    if (userIsAuthenticated) {
        next('/home');
        return;
    }
    next();
};

export const isAuthenticated = (to, from, next) => {
    const userIsAuthenticated = checkAuth();
    if (!userIsAuthenticated) {
        next('/login');
        return;
    }
    next();
};

export default {isAuthenticated, isGuest};
