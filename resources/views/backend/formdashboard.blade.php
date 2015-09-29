@extends('backend.master')
@section('title', $title)
@section('page_title', $page_title)
@section('content')
    <div class="btn-controls">
                                <div class="btn-box-row row-fluid">
                                    <a href="{{ url('/art/') }}" class="btn-box big span4"><i class=" icon-book"></i><b>{{ $count_art }}</b>
                                        <p class="text-muted">
                                            Articles</p>
                                    </a><a href="{{ url('/user/') }}" class="btn-box big span4"><i class="icon-user"></i><b>{{ $count_user }}</b>
                                        <p class="text-muted">
                                            Users</p>
                                    </a><a href="{{ url('/gallery/') }}" class="btn-box big span4"><i class="icon-picture"></i><b>{{ $count_gallery }}</b>
                                        <p class="text-muted">
                                            Galleries</p>
                                    </a>
                                </div>
     </div>
@endsection
@section('other')
@endsection