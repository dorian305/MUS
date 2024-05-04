<div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center">
    <div class="p-5 shadow-lg rounded" id="component-inner">
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
    const componentInner = document.querySelector("#component-inner");

    document.querySelector("#submit").onclick = async e => {
        componentInner.classList.toggle("opacity-25");

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
            const data = await response.json();
            console.log(data);
            componentInner.classList.toggle("opacity-25");
        }
    }
</script>