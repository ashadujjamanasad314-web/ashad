```php
<?php
session_start();
require_once __DIR__.'/config/database.php';

if(!empty($_SESSION['admin_id'])){
    header("Location: dashboard.php");
    exit;
}

$error = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $u = trim($_POST['username'] ?? '');
    $p = $_POST['password'] ?? '';

    $s = $pdo->prepare("SELECT * FROM admins WHERE username=?");
    $s->execute([$u]);
    $a = $s->fetch();

    if($a && password_verify($p, $a['password'])){
        session_regenerate_id(true);
        $_SESSION['admin_id'] = $a['id'];
        $_SESSION['admin_username'] = $a['username'];
        $_SESSION['admin_role'] = $a['role'];

        header("Location: dashboard.php");
        exit;
    }

    $error = 'Invalid username or password.';
}
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>AttendPro - Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

<style>

*{
    box-sizing:border-box;
}

body{
    margin:0;
    min-height:100vh;
    font-family:Arial, sans-serif;

    background:
        linear-gradient(135deg, rgba(15,23,42,.92), rgba(37,99,235,.90)),
        url("img/college.jpg.webp");

    background-size:cover;
    background-position:center;

    display:flex;
    align-items:center;
    justify-content:center;

    padding:25px;
}

/* Main Card */

.login-card{
    width:100%;
    max-width:1050px;

    display:grid;
    grid-template-columns:1fr 1fr;

    background:rgba(255,255,255,.96);

    border-radius:25px;

    overflow:hidden;

    box-shadow:
        0 25px 70px rgba(0,0,0,.35);

    animation:cardShow .7s ease;
}

@keyframes cardShow{
    from{
        opacity:0;
        transform:translateY(30px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}

/* Left Side */

.college-side{
    min-height:600px;

    padding:40px;

    color:white;

    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;

    text-align:center;

    background:
        linear-gradient(
            145deg,
            rgba(15,23,42,.92),
            rgba(37,99,235,.88)
        );
}

.college-logo{
    width:125px;
    height:125px;

    object-fit:contain;

    background:white;

    border-radius:50%;

    padding:8px;

    margin-bottom:25px;

    box-shadow:0 10px 30px rgba(0,0,0,.25);

    transition:.3s;
}

.college-logo:hover{
    transform:scale(1.06) rotate(2deg);
}

.college-side h1{
    font-size:30px;
    font-weight:700;

    margin-bottom:10px;
}

.college-side p{
    font-size:16px;
    opacity:.9;

    margin-bottom:25px;
}

.college-photo{
    width:100%;
    max-width:420px;
    height:210px;

    object-fit:cover;

    border-radius:15px;

    border:3px solid rgba(255,255,255,.5);

    box-shadow:0 15px 35px rgba(0,0,0,.25);

    transition:.3s;
}

.college-photo:hover{
    transform:scale(1.02);
}

/* Right Side */

.login-side{
    padding:55px 55px 35px;

    display:flex;
    flex-direction:column;
    justify-content:center;
}

.brand{
    text-align:center;
    margin-bottom:30px;
}

.brand-icon{
    width:70px;
    height:70px;

    margin:auto;

    display:flex;
    align-items:center;
    justify-content:center;

    border-radius:20px;

    background:linear-gradient(
        135deg,
        #2563eb,
        #4f46e5
    );

    color:white;

    font-size:32px;

    box-shadow:0 10px 25px rgba(37,99,235,.3);
}

.brand h2{
    margin-top:15px;
    margin-bottom:5px;

    font-weight:700;

    color:#111827;
}

.brand p{
    color:#64748b;
    margin:0;
}

/* Form */

.form-group{
    margin-bottom:20px;
}

.form-label{
    font-weight:600;
    color:#334155;
}

.input-box{
    position:relative;
}

.input-box > i{
    position:absolute;

    left:15px;
    top:50%;

    transform:translateY(-50%);

    color:#2563eb;

    z-index:2;
}

.form-control{
    height:52px;

    border-radius:12px;

    border:1px solid #dbe2ea;

    padding-left:45px;
    padding-right:45px;

    transition:.25s;

    font-size:15px;
}

.form-control:focus{
    border-color:#2563eb;

    box-shadow:
        0 0 0 4px rgba(37,99,235,.12);

    transform:translateY(-1px);
}

.password-toggle{
    position:absolute;

    right:15px;
    top:50%;

    transform:translateY(-50%);

    border:none;

    background:none;

    color:#64748b;

    cursor:pointer;

    z-index:3;
}

.password-toggle:hover{
    color:#2563eb;
}

/* Login Button */

.login-btn{
    width:100%;

    height:52px;

    border:none;

    border-radius:12px;

    background:linear-gradient(
        135deg,
        #2563eb,
        #4f46e5
    );

    color:white;

    font-weight:600;

    font-size:16px;

    transition:.3s;

    box-shadow:0 8px 20px rgba(37,99,235,.25);
}

.login-btn:hover{
    transform:translateY(-2px);

    box-shadow:0 12px 25px rgba(37,99,235,.35);
}

.login-btn:active{
    transform:translateY(0);
}

/* Error */

.alert{
    border-radius:12px;
}

/* Footer */

.footer{
    text-align:center;

    margin-top:28px;

    font-size:13px;

    color:#94a3b8;
}

/* Mobile */

@media(max-width:800px){

    body{
        padding:15px;
    }

    .login-card{
        grid-template-columns:1fr;

        max-width:500px;
    }

    .college-side{
        min-height:auto;

        padding:30px 25px;
    }

    .college-side h1{
        font-size:24px;
    }

    .college-logo{
        width:95px;
        height:95px;
    }

    .college-photo{
        height:160px;
    }

    .login-side{
        padding:35px 25px 25px;
    }
}

@media(max-width:450px){

    .college-photo{
        height:140px;
    }

    .login-side{
        padding:30px 20px 20px;
    }

    .brand-icon{
        width:60px;
        height:60px;
        font-size:27px;
    }

}

</style>
</head>

<body>

<div class="login-card">

    <!-- College Information -->

    <div class="college-side">

        <img
            src="img/college-logo.jpg.jpg"
            class="college-logo"
            alt="Dinajpur Polytechnic Institute Logo"
        >

        <h1>Dinajpur Polytechnic Institute</h1>

        <p>
            Computer Science & Technology
        </p>

        <img
            src="img/college.jpg.webp"
            class="college-photo"
            alt="Dinajpur Polytechnic Institute"
        >

    </div>


    <!-- Login -->

    <div class="login-side">

        <div class="brand">

            <div class="brand-icon">
                <i class="fa-solid fa-user-check"></i>
            </div>

            <h2>AttendPro</h2>

            <p>Student Attendance Management System</p>

        </div>


        <?php if($error): ?>

            <div class="alert alert-danger">
                <i class="fa-solid fa-circle-exclamation"></i>
                <?=htmlspecialchars($error)?>
            </div>

        <?php endif; ?>


        <form method="post">

            <!-- Username -->

            <div class="form-group">

                <label class="form-label">
                    Username
                </label>

                <div class="input-box">

                    <i class="fa-solid fa-user"></i>

                    <input
                        type="text"
                        name="username"
                        class="form-control"
                        placeholder="Enter username"
                        autocomplete="username"
                        required
                    >

                </div>

            </div>


            <!-- Password -->

            <div class="form-group">

                <label class="form-label">
                    Password
                </label>

                <div class="input-box">

                    <i class="fa-solid fa-lock"></i>

                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="form-control"
                        placeholder="Enter password"
                        autocomplete="current-password"
                        required
                    >

                    <button
                        type="button"
                        class="password-toggle"
                        onclick="togglePassword()"
                        aria-label="Show password"
                    >
                        <i class="fa-solid fa-eye" id="eyeIcon"></i>
                    </button>

                </div>

            </div>


            <!-- Login Button -->

            <button type="submit" class="login-btn">

                <i class="fa-solid fa-right-to-bracket"></i>

                Login

            </button>

        </form>


        <div class="footer">

            © AttendPro · Student Attendance Management System

        </div>

    </div>

</div>


<script>

function togglePassword(){

    const password =
        document.getElementById("password");

    const icon =
        document.getElementById("eyeIcon");

    if(password.type === "password"){

        password.type = "text";

        icon.classList.remove("fa-eye");

        icon.classList.add("fa-eye-slash");

    }else{

        password.type = "password";

        icon.classList.remove("fa-eye-slash");

        icon.classList.add("fa-eye");

    }

}

</script>

</body>
</html>
```