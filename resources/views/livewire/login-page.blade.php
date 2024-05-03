<div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center">
    <div class="p-5 shadow-lg rounded" id="login-element">
        <h1 class="text-center mb-4">Login</h1>
        
        <form>
            <div class="mb-3">
                <input type="text" name="identifier" class="form-control border-secondary" id="identifier" placeholder="Email address or username...">
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control border-secondary" id="password" placeholder="Password">
            </div>
            <button type="button" id="submit" class="btn btn-primary btn-block">Login</button>
        </form>

        <p class="mt-3">Don't have an account? <a href="/register">Create one</a></p>
    </div>
</div>

<script>
    const loginElem = document.querySelector("#login-element");
    const btn = document.querySelector("#submit");

    btn.onclick = async e => {
        loginElem.classList.toggle("opacity-25");

        const identifier = document.querySelector("#identifier").value;
        const password = document.querySelector("#password").value;

        const data = {
            identifier: identifier,
            password: password,
        };

        const response = await fetch("/api/user-login", {
            method: "POST",
            headers: {
                'Content-Type': "application/json",
            },
            body: JSON.stringify(data),
        });

        if (response.ok){
            alert("login successfull");
        }
        
        else {
            loginElem.classList.toggle("opacity-25");
        }
    }
</script>