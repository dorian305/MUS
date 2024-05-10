<div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="display-4">Dashboard - {{ $user->username }}</h1>
            <a href="#" class="btn btn-danger">Logout</a>
        </div>

        <!-- User Information -->
        <div class="card mb-4">
            <div class="card-body">
                <h2 class="card-title">Information</h2>
                <div class="row">
                    <div class="col-md-6">
                        <p class="card-text">Email: <strong>{{ $user->email }}</strong></p>
                    </div>
                    <div class="col-md-6">
                        <p class="card-text">API Keys: <strong>{{ $user->apikeys }}</strong></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Uploaded Media Files -->
        <div class="card">
            <div class="card-body">
                <h2 class="card-title">Uploaded Media Files</h2>
                <div class="row">
                    <div class="col">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">File 1</h5>
                                <p class="card-text">Type: <strong>Image</strong></p>
                                <p class="card-text">Size: <strong>1.5 MB</strong></p>
                                <!-- You can display more information or add download/delete options -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>