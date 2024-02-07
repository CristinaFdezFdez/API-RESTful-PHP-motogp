<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="shortcut icon" href="./imagenes/Moto_Gp_logo.svg.png">
    <title>MotoGP</title>

    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, html {
            margin: 0;
            padding: 0;
        }
        header{
            font-size: 2em;
        }

        #demo {
            padding: 10px;
            height: auto;
            margin: auto;
            position: relative;
            width: 100%;
            background-color: black;
            font-size: 2rem;
            color: beige;
            text-align: center;
            top: 450px;
        }

        #parallax1, #parallax2, #parallax3 {
            height: 650px;
            background-position: center;
            background-size: cover;
            margin: 0;
            padding: 0;
            background-attachment: fixed;
            width: 100%;
        }

        #parallax1 {
            background-image: url(imagenes/uno.jpg);
            top: 0;
            margin: 0;
            padding: 0;
            margin-top: -70px;
        }

        #parallax2 {
            background-image: url(imagenes/dos.jpg);
        }

        #parallax3 {
            background-image: url(imagenes/tres.jpg);
        }

        #texto, #texto2 {
            padding: 50px;
            height: 250px;
            background-color: black;
            font-size: 2rem;
            color: beige;
            text-align: center;
            margin: 0;
        }
        
    </style>
</head>

<body>
    <header>
        <nav>
            <img id="logo" src="./imagenes/logo.png" alt="Logo">
            <ul>
                <li><a href="./pilotos/pilotos.php">Pilotos</a></li>
                <li><a href="./equipos/equipos.php">Equipos</a></li>
                <li><a href="./motos/motos.php">Motos</a></li>
            </ul>
        </nav>
    </header>

    <div id="demo">MOTOGP</div>

    <div id="parallax1"></div>

    <div id="texto">
        <h2>Bienvenido a MotoGP</h2>
        <p>Encuentra, modifica, inserta y elimina información sobre pilotos, equipos y motos.</p>
    </div>

    <div id="parallax2"></div>

    <div id="texto2">Se trata de la categoría "reina" del campeonato, pues en ella compiten las motos de mayor cilindrada.</div>

    <div id="parallax3"></div>


</body>

</html>
<footer class="principal">
        <p>&copy; MotoGP</p>
</footer>