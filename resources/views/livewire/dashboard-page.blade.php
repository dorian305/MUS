<div>
    <livewire:navigation />
    <div class="container mt-5">
        <div class="card mb-4">
            <div class="card-header">
                <h3>User Information</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <td>{{ $user->id }}</td>
                        </tr>
                        <tr>
                            <th>Username</th>
                            <td>{{ $user->username }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h3>Api keys</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                <thead>
                        <tr>
                            <th>ID</th>
                            <th>Key</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user->apikeys as $api_key)
                        <tr>
                            <td>{{ $api_key->id }}</td>
                            <td>{{ $api_key->key }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h3>Uploaded Media</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Size</th>
                            <th>Path</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user->media as $media)
                        <tr>
                            <td>{{ $media->id }}</td>
                            <td>{{ $media->name }}</td>
                            <td>{{ $media->type }}</td>
                            <td>{{ $media->size }}</td>
                            <td><a href="{{ $media->path }}">{{ $media->path }}</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
