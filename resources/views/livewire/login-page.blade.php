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
    document.querySelector("#submit").onclick = async e => {
        toggleClass(componentInner, "opacity-25");

        // Change form elements to read-only
        formReadOnly(true);

        try {
            const response = await axios.post("/api/user-login", {
                identifier: document.querySelector("#identifier").value,
                password: document.querySelector("#password").value,
            });

            // Login success
            storeToken(response.data.token.token);
            window.location.href = `/dashboard/${response.data.user.username}`;

        } catch (error) {
            // If response was not successful or other error occurs
            const { response } = error; // Extract response from error object
            if (response && response.data.errors) {
                Swal.fire({
                    title: "Errors encountered",
                    html: generateDescriptionList(response.data.errors),
                    icon: "error",
                    confirmButtonText: "My bad",
                })
                .then(res => {
                    toggleClass(componentInner, "opacity-25");
                    formReadOnly(false);
                });

                return;
            }
            // Handle other types of errors (e.g., network errors) here if needed
            toggleClass(componentInner, "opacity-25");
            formReadOnly(false);
        }
    }

</script>