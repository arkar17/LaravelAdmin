@extends('RefereeManagement.layout.app')

@section('title', '2D Manage')

@section('content')
  <!--daily sale book start-->
  <div class="daily-sale-book-parent-container">
    <h1>Daily Sale Book</h1>

    <div class="daily-sale-book-headers-container">
        <div class="daily-sale-book-categories-container">
            <p class="daily-sale-book-category daily-sale-book-categories-active" id="2d_sale_list">2D & Lone Pyine Sale List</p>
            <!-- <p class="daily-sale-book-category" id="lonepyine_sale_list">Lone Pyine List</p> -->
            <p class="daily-sale-book-category" id="3d_sale_list">3D List</p>

        </div>
        <div class="daily-sale-book-search-container">
            <iconify-icon icon="akar-icons:search" class="daily-sale-book-search-icon"></iconify-icon>
            <input type="text" placeholder="Search"/>
        </div>
    </div>

    <div class="daily-sale-book-2d-parent-container">
        <!--2d details start-->
        <div class="daily-sale-book-2dlist-parent-container">
          <h1>2D</h1>
          <div class="daily-sale-book-2dlist-container">
            <div class="daily-sale-book-2dlist-1row"></div>
            <div class="daily-sale-book-2dlist-2row"></div>
            <div class="daily-sale-book-2dlist-3row"></div>
            <div class="daily-sale-book-2dlist-4row"></div>
            <div class="daily-sale-book-2dlist-5row"></div>
            <div class="daily-sale-book-2dlist-6row"></div>
            <div class="daily-sale-book-2dlist-7row"></div>
            <div class="daily-sale-book-2dlist-8row"></div>
            <div class="daily-sale-book-2dlist-9row"></div>
            <div class="daily-sale-book-2dlist-10row"></div>
            <div class="daily-sale-book-2dlist-11row"></div>
            <div class="daily-sale-book-2dlist-12row"></div>
            <div class="daily-sale-book-2dlist-13row"></div>
          </div>
        </div>
        <!--2d details end-->

        <!--lonepyine start-->
        <div class="daily-sale-book-lonepyinelist-parent-container">
          <h1>Lone Pyine</h1>
          <div class="daily-sale-book-lonepyinelist-container">
            <div class="daily-sale-book-lonepyinelist-1row"></div>
            <div class="daily-sale-book-lonepyinelist-2row"></div>
            <div class="daily-sale-book-lonepyinelist-3row"></div>
          </div>

        </div>
        <!--lonepyine end-->

        <!--charts start-->
        <div class="daily-sale-book-charts-container">
          <div class="daily-sale-book-2d-chart-container" >
            <p>2D Most Bet Numbers</p>
            <canvas id="daily-sale-book-2d-chart"></canvas>
          </div>
          <div class="daily-sale-book-lonepyine-chart-container">
            <p>Lone Pyine Most Bet Numbers</p>
            <canvas id="daily-sale-book-lonepyine-chart"></canvas>
          </div>
        </div>
        <!--charts end-->

        <!--accept decline start-->
        <div class="daily-sale-book-labels-container">
            <p>ID</p>
            <p>Date</p>
            <p>Agent Name</p>
            <p>Round</p>
            <p>Type</p>
            <p>Number</p>
            <p>Compensation</p>
            <p>Amount</p>
        </div>
      <div class="daily-sale-book-sale-record-parent-container">
          <h1>2D & Lone Pyine Sale Record</h1>
          <div class="daily-sale-book-sale-record-container">
            <div class="daily-sale-book-sale-record-labels-container">
              <p>ID</p>
              <p>Date</p>
              <p>Agent Name</p>
              <p>Round</p>
              <p>Type</p>
              <p>Number</p>
              <p>Compensation</p>
              <p>Amount</p>
              <p>Status</p>
            </div>
            <div class="daily-sale-book-sale-record-rows-container">
                @foreach($agentList as $agent)
                            <div class="daily-sale-book-sale-record-row">
                                <p>1</p>
                                <p>{{$agent->date}}</p>
                                <p>{{$agent->name}}</p>
                                <p>{{$agent->round}}</p>
                                <p>2D</p>
                                <div class="daily-sale-book-sale-row-numbers">
                                    @foreach($twodList as $twod)
                                        <p>{{$twod->number}}</p>
                                    @endforeach
                                </div>

                                <div class="daily-sale-book-sale-row-compensations">
                                    @foreach($twodList as $twod)
                                        <p>{{$twod->compensation}}</p>
                                    @endforeach
                                </div>
                                <div class="daily-sale-book-sale-row-amounts">
                                    @foreach($twodList as $twod)
                                    <p>{{$twod->sale_amount}}</p>
                                    @endforeach
                                </div>
                                <p>Accepted</p>
                            </div>
                @endforeach






            </div>

          </div>
        </div>
    </div>
    <!-- <div class="daily-sale-book-lonepyine-parent-container">
        <div class="daily-sale-book-labels-container">
            <p>ID</p>
            <p>Date</p>
            <p>Agent Name</p>
            <p>Customer Name</p>
            <p>Number</p>
            <p>Compensation</p>
            <p>Amount</p>
        </div>

        <div class="daily-sale-book-rows-container">
            <div class="daily-sale-book-row">
                <p>1</p>
                <p>24 Aug</p>
                <p>Agent 01</p>
                <p>Customer 01</p>
                <p>7*</p>
                <p>86</p>
                <p>10000ks</p>
                <div class="daily-sale-book-row-btn-container">
                    <button class="daily-sale-book-accept-btn">Accept</button>
                    <button class="daily-sale-book-decline-btn">Decline</button>
                </div>
            </div>
            <div class="daily-sale-book-row">
                <p>1</p>
                <p>24 Aug</p>
                <p>Agent 01</p>
                <p>Customer 01</p>
                <p>*4</p>
                <p>86</p>
                <p>10000ks</p>
                <div class="daily-sale-book-row-btn-container">
                    <button class="daily-sale-book-accept-btn">Accept</button>
                    <button class="daily-sale-book-decline-btn">Decline</button>
                </div>
            </div>
            <div class="daily-sale-book-row">
                <p>1</p>
                <p>24 Aug</p>
                <p>Agent 01</p>
                <p>Customer 01</p>
                <p>*4</p>
                <p>86</p>
                <p>10000ks</p>
                <div class="daily-sale-book-row-btn-container">
                    <button class="daily-sale-book-accept-btn">Accept</button>
                    <button class="daily-sale-book-decline-btn">Decline</button>
                </div>
            </div>
            <div class="daily-sale-book-row">
                <p>1</p>
                <p>24 Aug</p>
                <p>Agent 01</p>
                <p>Customer 01</p>
                <p>7*</p>
                <p>86</p>
                <p>10000ks</p>
                <div class="daily-sale-book-row-btn-container">
                    <button class="daily-sale-book-accept-btn">Accept</button>
                    <button class="daily-sale-book-decline-btn">Decline</button>
                </div>
            </div>
        </div>
    </div> -->
    <div class="daily-sale-book-3d-parent-container">

      <p class="daily-sale-book-3d-current-rate">
          Current Rate : 550
      </p>

      <div class="daily-sale-book-3d-chart-container">
        <p>Most Bet Numbers</p>
        <canvas id="daily-sale-book-3d-chart"></canvas>
      </div>
        <!--accept decline start-->
        <div class="daily-sale-book-labels-container">
          <p>ID</p>
          <p>Date</p>
          <p>Agent Name</p>
          <p>Round</p>
          <p>Type</p>
          <p>Number</p>
          <p>Compensation</p>
          <p>Amount</p>
      </div>

      <div class="daily-sale-book-rows-container">
          <div class="daily-sale-book-row">
              <p>1</p>
              <p>24 Aug</p>
              <p>Agent 01</p>
              <p>Morning</p>
              <p>Lone Pyine</p>
              <div class="daily-sale-book-row-numbers">
                <p>74</p>
                <p>56</p>
                <p>89</p>
              </div>
              <div class="daily-sale-book-row-compensations">
                <p>74</p>
                <p>56</p>
                <p>89</p>
              </div>
              <div class="daily-sale-book-row-amounts">
                <p>1000ks</p>
                <p>400ks</p>
                <p>3000ks</p>
              </div>
              <div class="daily-sale-book-row-btn-container">
                  <button class="daily-sale-book-accept-btn">Accept</button>
                  <button class="daily-sale-book-decline-btn">Decline</button>
              </div>
          </div>
      </div>
      <!--accept decline end-->

      <!--sale record start-->
      <div class="daily-sale-book-sale-record-parent-container">
        <h1>3d sale record list</h1>
        <div class="daily-sale-book-sale-record-container">
          <div class="daily-sale-book-sale-record-labels-container">
            <p>ID</p>
            <p>Date</p>
            <p>Agent Name</p>
            <p>Round</p>
            <p>Type</p>
            <p>Number</p>
            <p>Compensation</p>
            <p>Amount</p>
            <p>Status</p>
          </div>
          <div class="daily-sale-book-sale-record-rows-container">
            <div class="daily-sale-book-sale-record-row">
              <p>1</p>
              <p>24 Aug</p>
              <p>Agent 01</p>
              <p>Morning</p>
              <p>Lone Pyine</p>
              <div class="daily-sale-book-sale-row-numbers">
                <p>74</p>
                <p>56</p>
                <p>89</p>
              </div>
              <div class="daily-sale-book-sale-row-compensations">
                <p>74</p>
                <p>56</p>
                <p>89</p>
              </div>
              <div class="daily-sale-book-sale-row-amounts">
                <p>1000ks</p>
                <p>400ks</p>
                <p>3000ks</p>
              </div>
              <p>Accepted</p>
            </div>
          </div>

        </div>
      </div>
      <!--sale record end-->
    </div>
</div>


            <script src="{{asset('jquery/dailysalebook.js')}}"></script>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
            <script>

            var pusher = new Pusher('{{env("MIX_PUSHER_APP_KEY")}}', {
                cluster: '{{env("PUSHER_APP_CLUSTER")}}',
                encrypted: true
                });

                var channel = pusher.subscribe('betlist-channel.'+2);
                channel.bind('App\\Events\\NewBetList', function(data) {
                    alert(data);
                console.log(data);
                });
            </script>
@endsection


