import axios from "axios";

class Auth {
    constructor() {
        this.token = null;
        this.uesr = null;
    }

    login(token, user) {
        window.localStorage.setItem("token", token);
        window.localStorage.setItem("user", JSON.stringify(user));

        axios.defaults.headers.common["Authorization"] = "Bearer " + token;

        this.token = token;
        this.user = user;

        Event.$emit("UserLoggedIn");
    }

    check() {
        return !!this.token;
    }
}

export default new Auth();
