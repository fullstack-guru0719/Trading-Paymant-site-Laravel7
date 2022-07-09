@php
    $team = getContent('team.element');
    $teamContent = getContent('team.content',true);
@endphp

<!--=======Team-Section Starts Here=======-->
<section class="team-section pt-150 pb-150">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section-header text-center">
                    <h2 class="section__title">@lang(@$teamContent->data_values->heading)</h2>
                    <p>@lang(@$teamContent->data_values->sub_heading)</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            @foreach($team as $data)
            <div class="col-lg-4 col-md-6 col-sm-8">
                <div class="team-card">
                    <div class="card-body">
                        <div class="card-thumb pb-0 mb-0">
                            <img src="{{getImage('assets/images/frontend/team/'.$data->data_values->image)}}" alt="team">
                        </div>
                    </div>
                    <div class="card-footer">
                        <h5 class="title">
                            <a href="javascript:void(0)">{{__(@$data->data_values->name)}}</a>
                        </h5>
                        <span class="info">{{__(@$data->data_values->designation)}}</span>
                    </div>
                </div>
            </div>
            @endforeach



        </div>
    </div>
</section>
<!--=======Team-Section Ends Here=======-->


