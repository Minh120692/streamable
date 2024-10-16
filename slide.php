<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    body {
        background-color: #2E3537;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .wrapper {
        background-color: #E1E2E2;
        height: 130px;
        overflow: hidden;
        position: relative;
        width: 100%;
        display: flex;
        align-items: center;
        padding: 0 20px;
    }

    .wrapper:before,
    .wrapper:after {
        content: "";
        position: absolute;
        height: 130px;
        width: 150px;
        z-index: 2;
    }

    .wrapper:after {
        right: 0;
        top: 0;
        transform: rotateZ(180deg);
    }

    .wrapper:before {
        left: 0;
        top: 0;
    }

    .wrapper .track {
        display: flex;
        width: calc(150px * 10);
        animation: scroll 15s 0.5s linear infinite;
    }

    .wrapper .logo {
        width: 150px;
    }

    .wrapper .logo img {
        height: 90px;
    }

    @keyframes scroll {
        from {
            transform: translateX(0);
        }

        to {
            transform: translateX(calc(-150px * 5));
        }
    }
</style>

<body>
    <div class="wrapper">
        <div class="track">
            <div class="logo">
                <img src="./img/logo.JPG" />
            </div>
            <div class="logo">
                <img src="./img/logo.JPG" />
            </div>
            <div class="logo">
                <img src="./img/logo.JPG" />
            </div>
            <div class="logo">
                <img src="./img/logo.JPG" />
            </div>
            <div class="logo">
                <img src="./img/logo.JPG" />
            </div>
            <div class="logo">
                <img src="./img/logo.JPG" />
            </div>
            <div class="logo">
                <img src="./img/logo.JPG" />
            </div>
            <div class="logo">
                <img src="./img/logo.JPG" />
            </div>
            <div class="logo">
                <img src="./img/logo.JPG" />
            </div>
            <div class="logo">
                <img src="./img/logo.JPG" />
            </div>
        </div>
    </div>

</body>

</html>