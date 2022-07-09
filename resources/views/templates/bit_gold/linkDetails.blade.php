@extends($activeTemplate.'layouts.frontend')
@section('content')
    @include($activeTemplate.'partials.breadcrumb')

    <section class="pt-120 pb-120">
    	<div class="container">
    		<div class="row">
    			<div class="col-md-12">
    				<p>@lang($item->data_values->content)</p>
    			</div>
    		</div>
    	</div>
    </section>
@endsection
