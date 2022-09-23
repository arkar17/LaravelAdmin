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
            <h2>2D Declined Lists</h2>
            <div>
                <center>
                <table>
                    <th>ID</th>
                    <th>Agent Name</th>
                    <th>Number</th>
                    <th>Max Amount</th>
                    <th>Sale Amount</th>
                    <?php $i=1; ?>
                @foreach ($Declined_twoDList as $result)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{$result->name}}</td>
                        <td>{{$result->number}}</td>
                        <td>{{$result->max_amount}}</td>
                        <td>{{$result->sales}}</td>

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
