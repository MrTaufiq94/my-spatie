@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @can('posts.index')
                        <h3>Post Index</h3>
                        <p>Isi ini hanya boleh di baca oleh user yang mempunyai permision <span><b>posts.index</b></span> sahaja</p>
                    @endcan
                    <hr>
                    @can('posts.create')
                        <h3>Post Create</h3>
                        <p>Isi ini hanya boleh di baca oleh user yang mempunyai permision <span><b>posts.create</b></span> sahaja</p>
                    @endcan
                    <hr>
                    @can('posts.edit')
                        <h3>Post Edit</h3>
                        <p>Isi ini hanya boleh di baca oleh user yang mempunyai permision <span><b>posts.edit</b></span> sahaja</p>
                    @endcan
                    <hr>
                    @can('posts.delete')
                        <h3>Post Delete</h3>
                        <p>Isi ini hanya boleh di baca oleh user yang mempunyai permision <span><b>posts.delete</b></span> sahaja</p>
                    @endcan


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
