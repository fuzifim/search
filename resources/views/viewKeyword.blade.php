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
                    <?php $i=0; ?>
                    @foreach($listArticle as $article)
                        <?php $i++;?>
                        @if($i==3 || $i==8)
                            <div class="form-group mt-2">
                                <ins class="adsbygoogle"
                                     style="display:block"
                                     data-ad-client="ca-pub-6739685874678212"
                                     data-ad-slot="7536384219"
                                     data-ad-format="auto"></ins>
                                <script>
                                    (adsbygoogle = window.adsbygoogle || []).push({});
                                </script>
                            </div>
                        @endif
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
                <div class="form-group">
                    <h4>Các từ khóa khác tại {!! $keyword->region !!} </h4>
                    @if(count($listKeywordRegion))
                        <ul class="list-group">
                            @foreach($listKeywordRegion as $keyword)
                                <li class="list-group-item"><a href="{!! route('view.keyword',array($keyword->id,$keyword->slug)) !!}">{!! $keyword->keyword !!}</a></li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="form-group mt-2">
                    <ins class="adsbygoogle"
                         style="display:block"
                         data-ad-client="ca-pub-6739685874678212"
                         data-ad-slot="7536384219"
                         data-ad-format="auto"></ins>
                    <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </div>
                @if(count($getNewKeywordNew))
                    <div class="form-group mt-2">
                        <h4>Từ khóa mới cập nhật </h4>
                        <ul class="list-group">
                            @foreach($getNewKeywordNew as $keyword)
                                <li class="list-group-item"><a href="{!! route('view.keyword',array($keyword->id,$keyword->slug)) !!}">{!! $keyword->keyword !!}</a></li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('css')
@endsection
@section('script')
@endsection