<table>
    <thead>
    <tr>
        <th style="font-weight: bold">Game Type</th>
        <th style="font-weight: bold">Customer Name</th>
        <th style="font-weight: bold">Customer Phone </th>
        <th style="font-weight: bold">Sales Amount</th>
    </tr>
    </thead>
    <tbody>
    @foreach($twod_salelists as $twod_salelist)
        <tr>
            <td>2D Pieces</td>
            <td>{{$twod_salelist->customer_name}}</td>
            <td>{{$twod_salelist->customer_phone}}</td>
            <td>{{$twod_salelist->sale_amount}}</td>
        </tr>
    @endforeach
    @foreach($lonepyine_salelists as $twod_salelist)
    <tr>
        <td>Lone Pyine Pieces</td>
        <td>{{$twod_salelist->customer_name}}</td>
        <td>{{$twod_salelist->customer_phone}}</td>
        <td>{{$twod_salelist->sale_amount}}</td>
    </tr>
@endforeach
    @foreach($threed_salelists as $threed_salelist)
    <tr>
        <td>3D Pieces</td>
        <td>{{$threed_salelist->customer_name}}</td>
        <td>{{$threed_salelist->customer_phone}}</td>
        <td>{{$threed_salelist->sale_amount}}</td>
    </tr>
@endforeach

{{-- @foreach ($results as $result)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{$result['name']}}</td>
                        <td>{{$result['customer_name']}}</td>
                        <td>{{$result['customer_phone']}}</td>
                        <td>{{$result['Amount']}}</td>

                    </tr>
                @endforeach --}}
    </tbody>
</table>

