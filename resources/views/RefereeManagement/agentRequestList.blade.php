@extends('RefereeManagement.layout.app')

@section('title', 'Agent Request List')

@section('content')
  <!--agent request list start-->
  <div class="agent-requests-parent-container">
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
                <td>{{$agent->id}}</td>
                <td>{{$agent->name}}</td>
                <td>{{$agent->phone}}</td>
                {{-- <td>{{$agent->referee_id}}</td> --}}
                <td>{{$agent->remark}}</td>
                <a href="{{route('agentAccept',$agent->id)}}"><button class="referee-request-accept-btn">{{__('msg.Accept')}}</button></a>
                <a href="{{route('agentDecline',$agent->id)}}"><button class="referee-request-decline-btn">{{__('msg.Decline')}}</button></a>
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

