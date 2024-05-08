<div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center">
    <div class="p-5 shadow-lg rounded" id="component-inner">
        <h1 class="text-center mb-4">Register</h1>
        
        <form>
            <div class="mb-3 d-flex align-items-start">
                <input type="text" name="username" class="form-control border-secondary flex-grow-1" id="username" placeholder="Username">
                <span class="text-danger fs-4 ms-2 mt-1">*</span>
            </div>
            <div class="mb-3 d-flex align-items-start">
                <input type="email" name="email" class="form-control border-secondary flex-grow-1" id="email" placeholder="Email">
                <span class="text-danger fs-4 ms-2 mt-1">*</span>
            </div>
            <div class="mb-3 d-flex align-items-start">
                <input type="password" name="passwrd" class="form-control border-secondary flex-grow-1" id="passwrd" placeholder="Password">
                <span class="text-danger fs-4 ms-2 mt-1">*</span>
            </div>
            <div class="mb-3 d-flex align-items-start">
                <input type="password" name="passwrd_confirmation" class="form-control border-secondary flex-grow-1" id="passwrd_confirmation" placeholder="Confirm password">
                <span class="text-danger fs-4 ms-2 mt-1">*</span>
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

        const requestData = {
            username: document.querySelector("#username").value,
            email: document.querySelector("#email").value,
            passwrd: document.querySelector("#passwrd").value,
            passwrd_confirmation: document.querySelector("#passwrd_confirmation").value,
        };

        if (incompleteFormData(requestData)){
            Swal.fire({
                title: "Oops",
                text: "Looks like you have left out some information while filling the form.",
                icon: "error",
                confirmButtonText: "Give me another chance",
            })
            .then(res => {
                toggleClass(componentInner, "opacity-25");
                formReadOnly(false);
            });

            return;
        }

        try {
            const response = await axios.post("/api/user-register", requestData);

            // Registration success
            window.location.href = "/login";


        } catch (res) {
            const data = res.response.data;
            console.log(data);

            if (data.errors){
                Swal.fire({
                    title: "Encountered errors",
                    html: generateDescriptionList(data.errors),
                    icon: "error",
                    confirmButtonText: "Let me correct that",
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