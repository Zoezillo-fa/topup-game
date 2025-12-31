@extends('layouts.main')

@section('title', $title)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card bg-dark border-secondary shadow mb-5">
                <div class="card-body p-4 text-white">
                    <h3 class="fw-bold text-warning mb-4 border-bottom border-secondary pb-3">{{ $title }}</h3>
                    
                    <div class="content-body" style="line-height: 1.8; color: #d1d5db;">
                        {!! $content !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection