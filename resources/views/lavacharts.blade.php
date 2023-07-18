<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Geo Chart</title>
</head>
<body style="text-align: center"> <br>
    <div><a href="{{ url('/dashboard') }}"  style="text-decoration:none;color:#2c2d7c;">Back To Dashboard</a> </div><br>
    <div id="pop-div" style="width:100%;border:1px solid #EEE;height:100vh;"></div> <br>
    <div id="geo"></div>
     <?= $lava->render('GeoChart', 'Users', 'pop-div') ?>
</body>
<script src="https://cdn.zoomcharts-cloud.com/1/latest/zoomcharts.js"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
</html>