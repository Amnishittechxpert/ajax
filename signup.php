<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Sign Up</h2>
        <form id="signupForm" method="post" action="">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
                <span class="error" id="nameErr"></span>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
                <span class="error" id="emailErr"></span>
            </div>
            <div class="form-group">
                <label for="gender">Gender:</label>
                <select class="form-control" id="gender" name="gender">
                    <option value="">Select gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
                <span class="error" id="genderErr"></span>
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter phone number">
                <span class="error" id="phoneErr"></span>
            </div>
            <div class="form-group">
                <label for="createdAt">Created At:</label>
                <input type="date" class="form-control" id="createdAt" name="createdAt">
                <span class="error" id="createdAtErr"></span>
            </div>
            <button type="button" class="btn btn-primary" id="signupBtn">Sign Up</button>
            <button type="button" class="btn btn-primary"><a class="text-white" href="http://localhost/phpproject/login.php">Login</a></button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#signupBtn').click(function() {
            var name = $('#name').val();
            var email = $('#email').val();
            var gender = $('#gender').val();
            var phone = $('#phone').val();
            var createdAt = $('#createdAt').val();      

          
            $('.error').text('');

   
            var valid = true;

            if (name === '') {
                $('#nameErr').text('Name is required');
                valid = false;
            }

            if (email === '') {
                $('#emailErr').text('Email is required');
                valid = false;
            } else if (!/^\S+@\S+\.\S+$/.test(email)) {
                $('#emailErr').text('Invalid email format');
                valid = false;
            }

            if (gender === '') {
                $('#genderErr').text('Gender is required');
                valid = false;
            }

            if (phone === '') {
                $('#phoneErr').text('Phone number is required');
                valid = false;
            } else if (!/^\d{10}$/.test(phone)) {
                $('#phoneErr').text('Invalid phone number format (10 digits)');
                valid = false;
            }

            if (createdAt === '') {
                $('#createdAtErr').text('Created At date is required');
                valid = false;
            }

            if (!valid) {
                return; 
            }

            // Send data to server using Ajax
            $.ajax({
                type: 'POST',
                url: 'process_signup.php', 
                data: {
                    name: name,
                    email: email,
                    gender: gender,
                    phone: phone,
                    createdAt: createdAt,
                    signup: true
                },
                success: function(response) {
                    alert('New record created successfully');
                    window.location.href = 'login.php';
                },
                error: function(xhr, status, error) {
                    alert('Error: ' + xhr.responseText);
                }
            });
        });
    });
    </script>
</body>
</html>
