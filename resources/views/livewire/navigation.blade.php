<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">MyLogo</a>
        <div class="d-flex align-items-center ms-auto">
            <!-- Logout Button -->
            <a href="#" id="logout-button" class="btn btn-danger ms-3">Logout pls</a>
        </div>
    </div>
</nav>

<script>
    document.querySelector("#logout-button").onclick = async e => {
        try {
            const response = axios.post("/api/user-logout", { 
                headers: {
                'Authorization': 'Bearer ' + getToken(),
                } 
            });

            if (!response.ok){
                Swal.fire({
                    title: "Error",
                    text: "Failed to logout: " + response.error,
                    icon: "error",
                    confirmButtonText: "???",
                })

                return;
            }
            
            localStorage.clear();
            window.location.href = "/login";
        }

        catch (error) {

        }
    }
</script>