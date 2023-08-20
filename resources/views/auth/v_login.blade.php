<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">{{ __('Login') }}</div>

                    <div class="card-body">
                        <form id="loginForm" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="role">Login As:</label>
                                <select class="form-control" id="role" name="role">
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#loginForm').submit(function(event) {
                event.preventDefault();
                var formData = $(this).serialize();
                var role = $('#role').val();
                var url = role === 'admin' ? '/api/admin/verify' : '/api/user/verify';

                $.post(url, formData)
                    .done(function(data) {
                        if (role === 'admin' || role === 'user') {
                            localStorage.setItem('token', data.token);
                            window.location.href = '/products';
                        }
                        // Handle API response if needed
                    })
                    .fail(function(error) {
                        alert('Login failed. Please check your credentials.');
                    });
            });
        });
    </script>

</body>

</html>
