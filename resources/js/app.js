import './bootstrap';

// Extract and store token into local storage.
const storeToken = tokenString => {
    const [id, token] = tokenString.split("|");
    const tokenObject = {
        id: id,
        token: token,
    };

    localStorage.setItem("token", JSON.stringify(tokenObject));

    return tokenObject;
}

// Read token from local storage.
const getToken = () => {
    const tokenObject = localStorage.getItem("token");

    return JSON.parse(tokenObject) ?? null;
}