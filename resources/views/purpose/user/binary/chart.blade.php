<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crypto Streaming App</title>
    <script src="https://unpkg.com/lightweight-charts/dist/lightweight-charts.standalone.production.js"></script>
</head>
<body>

    <div id="tvchart" style="width: 800px; height: 600px;"></div>

    <script src="{{ asset('js/app.js') }}"></script>

    <script>
        const chart = LightweightCharts.createChart(document.getElementById('tvchart'), {
            width: 800,
            height: 600,
        });

        const candleSeries = chart.addCandlestickSeries();

        const socket = new WebSocket('wss://ot5.test/stream');
        socket.onmessage = function (event) {
            const data = JSON.parse(event.data);
            candleSeries.setData(data);

            console.log(data);
        };
    </script>
</body>
</html>