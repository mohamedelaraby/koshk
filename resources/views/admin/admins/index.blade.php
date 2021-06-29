@extends('index')



@section('content')

 <!-- Main content -->
 <section class="content">
    <div class="row">
	<div class="col-xl-12">
		@include('admin.layouts.message')
		<div class="card mg-b-20">
            <div class="card-header">
                <div class="card-title">
                    <!-- breadcrumb -->
                    <div class="breadcrumb-header justify-content-between">
                        <div class="my-auto">
                            <div class="d-flex">
                                <h4 class="content-title mb-0 my-auto">
    </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">
                                    {{$title}}</span>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
			<div class="card-body">

                <div class="table-responsive">
                    <table class="table text-md-nowrap" id="example1">

                        {!!$dataTable->table([
                            'class' => 'datatable table table-bordered table-striped'
                            ],true)!!}
                        </table>
                        </div>

			</div>
        </div>
    </div>
					<!--/div-->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->


{{--   End Datatable --}}
@endsection

@push('scripts')
{!! $dataTable->scripts() !!}
@endpush


