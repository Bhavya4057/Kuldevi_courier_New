<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuldevi Courier</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            /* Centers horizontally */
            align-items: center;
            /* Centers vertically */
            height: 100vh;
            /* Full viewport height */
            margin: 0;
            /* Remove default margin */
        }

        .cards {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .cards .red {
            background-color: #f43f5e;
        }

        .cards .blue {
            background-color: #3b82f6;
        }

        .cards .green {
            background-color: #22c55e;
        }

        .cards .card {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
            height: 100px;
            width: 250px;
            border-radius: 10px;
            color: white;
            cursor: pointer;
            transition: 900ms;
        }

        .cards .card p.tip {
            font-size: 45px;
            font-weight: 700;
        }

        .cards .card:hover {
            transform: scale(1.1, 1.1);
        }

        .cards:hover>.card:not(:hover) {
            filter: blur(10px);
            transform: scale(0.9, 0.9);
        }
        a{
            text-decoration: none;
            transition: all 0.9s ease;
            color:darkmagenta;
        }
        a:hover{
            text-decoration: underline;
        }
    </style>
</head>

<body>
        
        <div class="cards">
            <div class="card red">
                <p class="tip"><a href="Delhievery\display.php">Delhievery</a></p>
            </div>
            <div class="card blue">
                <p class="tip"><a href="Tirupati\display.php">Tirupati</a></p>
            </div>
    </div>
</body>

</html>