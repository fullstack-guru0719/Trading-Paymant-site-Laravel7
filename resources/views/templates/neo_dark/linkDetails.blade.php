@extends($activeTemplate.'layouts.frontend')

@section('content')

    @include($activeTemplate.'partials.breadcrumb')

    <section class="pt-150 pb-150">
        <div class="container">
            <div class="row mb-none-30">
            	<p>@lang($item->data_values->content)</p>
            </div>
        </div>
    </section>
@endsection
