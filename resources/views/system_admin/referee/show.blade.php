   <html>
    <head>
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
                    color: #0b0bbb;
                    font-size: 1em;
            }
            table {
                    width: 100%;
                    border-collapse: collapse;
                    }
        </style>
    </head>
    <body>
        <div class="role-view-detail-parent-container">
            <h2>Customers' Data</h2>
            <div>
                <center>
                <table>
                    <th>ID</th>
                    <th>Agent Name</th>
                    <th>Customer Name</th>
                    <th>Customer Phone</th>
                    <th>Sale Amount</th>
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
                </center>
            </div>
        </div>
    </body>
    <!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
   </html>
