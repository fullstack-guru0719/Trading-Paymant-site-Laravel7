@php
    $counter = getContent('counter.element');
@endphp
<!-- overview-section start -->
<div class="overview-section pb-150 pt-150">
    <div class="container">
        <div class="row mb-none-30">
            @foreach($counter as  $k =>$data)
            <div class="col-lg-3 col-sm-6 mb-30">
                <div class="overview-item">
                    <span>{{trim(@$data->data_values->counter_digit)}}</span>
                    <p>{{@$data->data_values->title}}</p>
                </div><!-- overview-item end -->
            </div>
            @endforeach
        </div>
    </div>
</div>
<!-- overview-section end -->
