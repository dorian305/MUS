<div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center">
    <div class="p-5 shadow-lg rounded" id="registration-element">
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
    const registrationElem = document.querySelector("#registration-element");
    const btn = document.querySelector("#submit");

    btn.onclick = async e => {
        registrationElem.classList.toggle("opacity-25");

        const username = document.querySelector("#username").value;
        const email = document.querySelector("#email").value;
        const passwrd = document.querySelector("#passwrd").value;
        const passwrd_confirmation = document.querySelector("#passwrd_confirmation").value;

        const data = {
            username: username,
            email: email,
            passwrd: passwrd,
            passwrd_confirmation: passwrd_confirmation,
        };

        const response = await fetch("/api/user-register", {
            method: "POST",
            headers: {
                'Content-Type': "application/json",
            },
            body: JSON.stringify(data),
        });

        if (response.ok){
            alert("Registration successfull");
        }

        else {
            registrationElem.classList.toggle("opacity-25");
        }
    }
</script>