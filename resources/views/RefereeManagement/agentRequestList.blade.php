@extends('system_admin.layouts.app')

@section('title', 'Agent Request List')

@section('content')

  <!--agent request list start-->
  <div class="agent-requests-parent-container">
    @if (Session::has('success'))
            <div id="hide">
                <h4 class="main-cash-alert"> {{ Session::get('success') }} &nbsp;&nbsp;&nbsp;<span class="closeBtn">x</span> </h4>
            </div>
        @endif
    <h1>{{__('msg.Request List - Agent')}}</h1>

    <table class="agent-request-container">
        <thead>
      <tr class="agent-requests-labels-container">
        <th>{{__('msg.ID')}}</th>
        <th>{{__('msg.Name')}}</th>
        <th>{{__('msg.Phone Number')}}</th>
        {{-- <th>Refree ID </th> --}}
        <th>{{__('msg.Remark')}}</th>
        <th></th>
        <th></th>

      </tr>
        </thead>
      <tbody class="agent-request-rows-container">
        @foreach ($agentrequests as $agent )
            <tr class="agent-request-row">
                <?php $i = 1 ?>
                <td>{{$i++}}</td>
                <td>{{$agent->name}}</td>
                <td>{{$agent->phone}}</td>
                    <td href="{{route('agentAccept',$agent->id)}}"><button class="referee-request-accept-btn">{{__('msg.Accept')}}</button></td>
                    <td href="{{route('agentDecline',$agent->id)}}"><button class="referee-request-decline-btn">{{__('msg.Decline')}}</button></td>
            </tr>
        @endforeach
      </tbody>
    </table>
  </div>
<!--agent request list end-->

@endsection

@push('script')
    <script>

    </script>
@endpush

