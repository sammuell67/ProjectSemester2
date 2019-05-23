<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Ajax</title>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <style>
        td, tr, table {
            border-collapse: collapse;
            border: solid black 1px;
        }

        tr, td {
            min-width: 60px;
            min-height: 20px;
            height:20px;
        }
    </style>
</head>

<body>

<table>
    <tbody>
        <?php
            for ($i = 0; $i < 10; $i++) {
                echo '<tr>';
                for ($j = 0; $j < 20; $j++){
                    echo '<td></td>';
                }
                echo '</tr>';
            }
        ?>
    </tbody>
</table>

<div id="content"></div>

<script type="application/javascript">
    var content = document.getElementById('content');
    var socket = new WebSocket('ws://147.175.121.210:4461');

    socket.onmessage = function (message) {
        var data = JSON.parse(JSON.parse(message.data).utf8Data);
        console.log(data);
        $( "table tr:nth-child("+(data.row+1)+") td:nth-child("+(data.col+1)+")" ).css("background-color", "blue");
    };

    socket.onerror = function (error) {
        console.log('WebSocket error: ' + error);
    };

    $('td').click(function() {
        $(this).css('backgroundColor', 'red');

        var col = this.cellIndex;
        var tr = $(this).closest('tr');
        var row = tr.index();

        console.log(row + " " + col);
        var data = {"row": row, "col": col};
        socket.send(JSON.stringify(data));
    });

</script>
</body>
</html>