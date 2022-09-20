@extends('RefereeManagement.layout.app')

@section('title', 'Agent Request List')

@section('content')
  <!--agent request list start-->
  <div class="agent-requests-parent-container">
    <h1>{{__('msg.Request List - Agent')}}</h1>

    <div class="agent-request-container">
      <div class="agent-requests-labels-container">
        <h2>{{__('msg.ID')}}</h2>
        <h2>{{__('msg.Name')}}</h2>
        <h2>{{__('msg.Phone Number')}}</h2>
        {{-- <h2>Refree ID </h2> --}}
        <h2>{{__('msg.Remark')}}</h2>

      </div>
      <div class="agent-request-rows-container">
        @foreach ($agentrequests as $agent )
            <div class="agent-request-row">
                <p>{{$agent->id}}</p>
                <p>{{$agent->name}}</p>
                <p>{{$agent->phone}}</p>
                {{-- <p>{{$agent->referee_id}}</p> --}}
                <p>{{$agent->remark}}</p>
                    <a href="{{route('agentAccept',$agent->id)}}"><button class="referee-request-accept-btn">{{__('msg.Accept')}}</button></a>
                    <a href="{{route('agentDecline',$agent->id)}}"><button class="referee-request-decline-btn">{{__('msg.Decline')}}</button></a>
            </div>
        @endforeach
    </div>
    </div>
  </div>
<!--agent request list end-->

@endsection

@push('script')
    <script>

    </script>
@endpush

