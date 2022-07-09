@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
        	<div class="card">
        		<div class="card-body">
        			@php echo $email->message @endphp
        		</div>
        	</div>
        </div>
    </div>
@endsection