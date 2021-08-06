<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                    <div class="card-header">Piezas faltantes</div>
                        <div class="card-body">
                        <h5 class="h1 card-title"><span id "idpiezaFaltante">30</h5>
                        <p class="card-text">Cantidad de paradas debido a falta de piezas.</p>
                    </div>
                </div>
                </div>
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                    <div class="card-header">Pieza fallida</div>
                        <div class="card-body">
                        <h5 class="h1 card-title"><span id "idpiezaFallida">26</h5>
                        <p class="card-text">Cantidad de paradas debido a fallas en piezas.</p>
                    </div>
                </div>    
                </div>
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                    <div class="card-header">Falta de tiempo</div>
                    <div class="card-body">
                        <h5 class="h1 card-title"><span id "idfaltaTiempo">30</h5>
                        <p class="card-text">Cantidad de paradas debido a falta de tiempo en montaje.</p>
                    </div>
                </div>
        </div>
        <div class="row my-3">
            <div class="col-md-12 text-center">
                <h2>Título de gráfico</h2>
                <canvas id="idGrafica" class="grafica"></canvas>
            </div>
        </div>
        <div class="row my-3">
            <div class="col-md-12 text-center">
                <div id="idContTabla"></div>
            </div>
        </div>
    </div>
    <script src="js/query.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script src="js/index.js"></script>
</body>
</html>