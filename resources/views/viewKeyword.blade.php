@extends('layout')
@section('title', $keyword->keyword)
@section('description', '')
@section('header')
    @include('header')
@endsection
@section('content')
    <div class="container">
        <div class="row mt-2">
            <div class="col-md-8">
                <h1>{!! $keyword->keyword !!}</h1>
                <div class="form-group mt-2">
                    <div class="alert alert-info p-2">
                        <strong>Cung Cấp đến mọi người ⭐ ⭐ ⭐ ⭐ ⭐</strong>
                        <p>Đăng tin lên Cung Cấp để cung cấp sản phẩm, dịch vụ kinh doanh đến mọi người hoàn toàn miễn phí! </p>
                    </div>
                    <div class="btn-group d-flex" role="group"><a class="btn btn-success w-100" href="https://cungcap.net" target="_blank"><h4>Đăng tin miễn phí</h4></a></div>
                </div>
                <h5 class="card-title">Từ khóa: {!! $keyword->keyword !!}</h5>
                <p><strong>Trên: {!! $keyword->traffic !!}.000 lượt tìm kiếm </strong><small>Ngày: {!! \Carbon\Carbon::parse($keyword->created_at)->format('d-m-Y') !!}</small></p>
                <p>Quốc gia: {!! $keyword->region !!}</p>
                @if(count($listArticle))
                    @foreach($listArticle as $article)
                        <li class="list-group-item">
                            @if(!empty($article->img_xs))
                                <img src="{!! $article->img_xs !!}" alt="{!! $article->title !!}">
                            @endif
                            <strong>{!! $article->title !!}</strong>
                            <small>{!! $article->author !!}</small>
                            <p>{!! $article->description !!}</p>
                        </li>
                    @endforeach
                    </ul>
                @endif
            </div>
            <div class="col-md-4">
                <h4>Các từ khóa khác tại {!! $keyword->region !!} </h4>
                @if(count($listKeywordRegion))
                    <ul class="list-group">
                        @foreach($listKeywordRegion as $keyword)
                            <li class="list-group-item"><a href="{!! route('view.keyword',array($keyword->id,$keyword->slug)) !!}">{!! $keyword->keyword !!}</a></li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('css')
@endsection
@section('script')
@endsection