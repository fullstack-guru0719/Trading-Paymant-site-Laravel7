@php
    $howWorks = getContent('how_work.element','','',true);
    $howWorkContent = getContent('how_work.content',true);
@endphp
<section class="work-section pt-150 pb-150">
        <div class="container">
            <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section-header text-center">
                    <h2 class="section__title">@lang(@$howWorkContent->data_values->heading)</h2>
                    <p>@lang(@$howWorkContent->data_values->sub_heading)</p>
                </div>
            </div>
        </div>
            <div class="row justify-content-center">
                @foreach($howWorks as $howWork)
                <div class="col-lg-4 col-md-6 col-sm-8 mb-30">
                    <div class="work-item text-center">
                        <div class="work-icon">
                            @php echo $howWork->data_values->icon @endphp
                        </div>
                        <div class="work-content">
                            <h4 class="title">@lang($howWork->data_values->title)</h4>
                            <span class="sub-title">@lang('Step '.$loop->iteration)</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>