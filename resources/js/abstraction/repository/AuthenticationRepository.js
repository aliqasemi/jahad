import {setAuthToken} from "../../service/AuthService";

export default class AuthenticationRepository {
    async logIn(body) {
        try {
            let response = await axios.post("http://127.0.0.1:8000/api/jahad/login", body);
            const token = response.data.token;
            setAuthToken(token);
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
            if (response && response.status === 200) {
                return response.data;
            }
        } catch (e) {
            return e;
        }
    }
}
