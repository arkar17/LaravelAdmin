   <html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body{
                font-family: Arial, Helvetica, sans-serif;
            }
            th, td {
                    padding: 15px;
                    text-align: left;
                    }
            th{
                    color: #1a1a1d;
            }
            table {
                    width: 100%;
                    border-collapse: collapse;
                    }
            h5{
                font-family:serif;
                }
        </style>
    </head>
    <body>
        <div class="container mt-5">
            <h5 class="text-center mb-3">Customers' Data</h5>
                <table class="table table-bordered mb-5">
                    <thead>
                        <tr class="table-secondary">
                            <th>ID</th>
                            <th>Agent Name</th>
                            <th>Customer Name</th>
                            <th>Customer Phone</th>
                            <th>Sale Amount</th>
                        </tr>
                    </thead>
                    <?php $i=1; ?>
                    @foreach ($results as $result)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$result['name']}}</td>
                            <td>{{$result['customer_name']}}</td>
                            <td>{{$result['customer_phone']}}</td>
                            <td>{{$result['Amount']}}</td>

                        </tr>
                    @endforeach
                </table>
        </div>
    </body>
    <!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
   </html>
