<?php
require_once "autoloader.php";
$lighting = new lighting();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            background-color: lightcyan;
        }

        .center {
            margin: auto;
            width: 60%;
            padding: 10px;
            background-color: lightgreen;
        }

        .element {
            display: inline-block;
            width: 100px;
            height: 120px;
            font-size: .6em;
            text-align: center;
            margin: 10px;
        }

        .element,
        .center {
            -moz-box-shadow: 3px 3px 5px 6px rgb(87, 137, 87);
            -webkit-box-shadow: 3px 3px 5px 6px rgb(87, 137, 87);
            box-shadow: 3px 3px 5px 6px rgb(87, 137, 87);
            border-radius: 10px;
      
            -moz-border-radius: 10px;
            -webkit-border-radius: 10px;
            border: 3px solid navy;
        }

        .element img {
            width: 3em;
            vertical-align: middle;
        }

        .on {
            background-color: lightyellow;
        }

        .off {
            background-color: lightslategray;
        }

        h1 {
            font-size: 1.5em;
            text-align: center;
            background-color: black;
            color: azure;
        }

        form {
            text-align: center;
        }
    </style>
</head>

<body>


<?php

$totalFondoNorte = 0;
$totalFondoSur = 0;
$totalGradaOeste = 0;
$totalGradaEste = 0;

foreach ($FondoNorte as $fila) {
    foreach ($fila as $elemento) {
        echo $elemento;
    }
    echo "<br>";
}

foreach ($FondoNorte as $fila) {
    foreach ($fila as $elemento) {
        if ($elemento === '1') {
            $totalFondoNorte ++
        }
    }
}


foreach ($FondoSur as $fila) {
    foreach ($fila as $elemento) {
        echo $elemento;
    }
    echo "<br>";
}

foreach ($FondoSur as $fila) {
    foreach ($fila as $elemento) {
        if ($elemento === '1') {
            $totalFondoSur ++
        }
    }
}


foreach ($GradaEste as $fila) {
    foreach ($fila as $elemento) {
        echo $elemento;
    }
    echo "<br>";
}

foreach ($GradaEste as $fila) {
    foreach ($fila as $elemento) {
        if ($elemento === '1') {
            $totalGradaEste ++
        }
    }
}

foreach ($GradaOeste as $fila) {
    foreach ($fila as $elemento) {
        echo $elemento;
    }
    echo "<br>";
}

foreach ($GradaOeste as $fila) {
    foreach ($fila as $elemento) {
        if ($elemento === '1') {
            $totalGradaOeste++
        }
    }
}


?>

    <div class="center">
        <h1>BIG STADIUM - LIGHTING CONTROL PANEL</h1>

        <div class="texto">
<? echo "Total de potencia de Fondo norte: " . $totalFondoNorte;
echo "Total de potencia de Fondo sur: " . $totalFondoSur;
echo "Total de potencia de Grada este: " . $totalGradaEste;
echo "Total de potencia de Grada oeste: " . $totalGradaOeste;
?>
</div>
        <form action="" method="post">
            <select name="filter">
                <?= $lighting->drawZonesOptions() ?>
            </select>
            <input type="submit" value="Filter by zone">
        </form>
        <?= $lighting->drawLampsList() ?>
    </div>
</body>

</html>