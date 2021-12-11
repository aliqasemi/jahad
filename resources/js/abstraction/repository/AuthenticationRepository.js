import {setAuthToken, setAuthUser} from "../../service/AuthService";

export default class AuthenticationRepository {
    async logIn(body) {
        try {
            let response = await axios.post("http://127.0.0.1:8000/api/jahad/login", body);
            setAuthToken(response.data.token);
            setAuthUser(response.data.user);
            if (response && response.status === 200) {
                return response.data;
            }
        } catch (e) {
            return e;
        }
    }

    async logOut() {
        try {
            let response = await axios.get("http://127.0.0.1:8000/api/jahad/logout");
            setAuthToken();
            setAuthUser();
            if (response && response.status === 200) {
                return response.data;
            }
        } catch (e) {
            return e;
        }
    }

    async register(formData) {
        try {
            let response = await axios.post("http://127.0.0.1:8000/api/jahad/register", formData);
            if (response && response.status === 201) {
                return response.data;
            }
        } catch (e) {
            return e;
        }
    }
}
