<div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center">
    <div class="p-5 shadow-lg rounded" id="component-inner">
        <h1 class="text-center mb-4">Register</h1>
        
        <form>
            <div class="mb-3">
                <input type="text" name="username" class="form-control border-secondary" id="username" placeholder="Username">
            </div>
            <div class="mb-3">
                <input type="email" name="email" class="form-control border-secondary" id="email" placeholder="Email">
            </div>
            <div class="mb-3">
                <input type="password" name="passwrd" class="form-control border-secondary" id="passwrd" placeholder="Password">
            </div>
            <div class="mb-3">
                <input type="password" name="passwrd_confirmation" class="form-control border-secondary" id="passwrd_confirmation" placeholder="Confirm password">
            </div>
            <button type="button" id="submit" class="btn btn-primary btn-block">Register</button>
        </form>
        <p class="mt-3">Already have an account? <a href="/login">Login</a></p>
    </div>
</div>

<script>
    const btn = document.querySelector("#submit");

    document.querySelector("#submit").onclick = async e => {
        toggleClass(componentInner, "opacity-25");

        // Change form elements to read only
        formReadOnly(true);

        try {
            const response = await axios.post("/api/user-login", {
                username: document.querySelector("#username").value,
                email: document.querySelector("#email").value,
                passwrd: document.querySelector("#passwrd").value,
                passwrd_confirmation: document.querySelector("#passwrd_confirmation").value,
            });

            // Registration success, redirect to dashboard
            window.location.href = "/dashboard";

            
        } catch (res) {
            const data = res.response.data;
            console.log(data);

            // Username or email is already taken
            if (data.errors){
                Swal.fire({
                    title: "Oops",
                    text: "It seems like the username or email you want to use is already taken.",
                    icon: "error",
                    confirmButtonText: "I'll try another",
                })
                .then(res => {
                    toggleClass(componentInner, "opacity-25");
                    formReadOnly(false);
                });

                return;
            }
        }
    }
</script>