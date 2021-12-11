import axios from "axios";

export const setAuthToken = (token) => {
    if (token) {
        localStorage.setItem("token", token);
        axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
    } else {
        localStorage.removeItem("token");
        delete axios.defaults.headers.common["Authorization"];
    }
};

export const setAuthUser = (user) => {
    if (user) {
        localStorage.setItem("user", JSON.stringify(user));
    } else {
        localStorage.removeItem("user");
    }
};

export const checkAuth = () => {
    if (localStorage.getItem("token")) {
        return true;
    } else {
        return false;
    }
};
