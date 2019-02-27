@extends('layout')
@section('title', 'Xu hướng tìm kiếm')
@section('header')
    @include('header')
@endsection
@section('content')
    <div class="container">
        <div class="row mt-2">
            <div class="col-md-4">
                <div class="form-group mt-2">
                    <div class="alert alert-info p-2">
                        <strong>Cung Cấp đến mọi người ⭐ ⭐ ⭐ ⭐ ⭐</strong>
                        <p>Đăng tin lên Cung Cấp để cung cấp sản phẩm, dịch vụ kinh doanh đến mọi người hoàn toàn miễn phí! </p>
                    </div>
                    <div class="btn-group d-flex" role="group"><a class="btn btn-success w-100" href="https://cungcap.net" target="_blank"><h4>Đăng tin miễn phí</h4></a></div>
                </div>
            </div>
            <div class="col-md-8">
                @if(count($listArticle)>0)
                    <ul class="list-group">
                        <?php $i=0; ?>
                        @foreach($listArticle as $key => $item)
                            <?php
                                $filtered = array_filter($item['article'], function($item) {
                                    static $counts = array();
                                    if(isset($counts[$item->id])) {
                                        return false;
                                    }
                                    $counts[$item->id] = true;
                                    return true;
                                });
                            ?>
                            <li class="list-group-item">
                                <h3><a href="{!! route('view.keyword',array($item['keyword_id'],$item['keyword_slug'])) !!}">{!! $key !!}</a></h3>
                                <strong>Trên: {!! $item['traffic'] !!}.000 lượt tìm kiếm </strong><small>Ngày: {!! \Carbon\Carbon::parse($item['created_at'])->format('d-m-Y') !!} - Quốc gia: {!! $item['keyword_region'] !!}</small>
                                @foreach($filtered as $article)
                                    <p>
                                        {!! $article->title !!}<br>
                                        <small>{!! $article->author !!}</small>
                                    </p>
                                @endforeach
                            </li>
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