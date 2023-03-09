<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
    <title>404</title>
    <meta name="keywords" content="404">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:500" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Titillium+Web:700,900" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="<?= $configBase ?>assets/404_files/style.css" />
</head>

<body>
    <div class="main-wrapper">
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <div class="error-box">
            <div class="error-body text-center">
                <h1 class="error-title text-danger">404</h1>
                <h3 class="text-uppercase error-subtitle">PAGE NOT FOUND !</h3>
                <p class="text-muted m-t-30 m-b-30">YOU SEEM TO BE TRYING TO FIND THIS WAY HOME</p>
                <a href="<?= $configBase ?>" class="btn btn-danger btn-rounded waves-effect waves-light m-b-40">Back to home</a> </div>
        </div>
    </div>

    <script type="text/javascript" src="<?= $configBase ?>assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?= $configBase ?>assets/bootstrap/bootstrap.js"></script>
    <script type="text/javascript" src="<?= $configBase ?>assets/404_files/popper.js/dist/umd/popper.min.js"></script>
    <script>
        $(".preloader").fadeOut();
    </script>

</body>

</html>