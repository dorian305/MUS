// Extract and store token into local storage.
const storeToken = tokenString => {
    localStorage.setItem("token", tokenString);

    return tokenObject;
}

// Read token from local storage.
const getToken = () => {
    const token = localStorage.getItem("token");

    return token ?? null;
}