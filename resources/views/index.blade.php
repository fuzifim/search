@extends('layout')
@section('title', 'Xu hướng tìm kiếm')
@section('header')
    @include('header')
@endsection
@section('content')
    <div class="container">
        <div class="row mt-2">
            <div class="col-md-8">
                <div class="form-group mt-2">
                    <div class="alert alert-info p-2">
                        <strong>Cung Cấp đến mọi người ⭐ ⭐ ⭐ ⭐ ⭐</strong>
                        <p>Đăng tin lên Cung Cấp để cung cấp sản phẩm, dịch vụ kinh doanh đến mọi người hoàn toàn miễn phí! </p>
                    </div>
                    <div class="btn-group d-flex" role="group"><a class="btn btn-success w-100" href="https://cungcap.net" target="_blank"><h4>Đăng tin miễn phí</h4></a></div>
                </div>
                @if(count($listKeywords)>0)
                    <ul class="list-group">
                        <?php $i=0; ?>
                        @foreach($listKeywords as $item)
                            <?php
                            $article = DB::table('article')
                                    ->join('article_join_keyword','article_join_keyword.article_id','=','article.id')
                                    ->where('article_join_keyword.keyword_id',$item->id)
                                    ->limit(5)->get();
                            ?>
                            <?php $i++;?>
                            @if($i==3 || $i==9)
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
                                <h3><a href="{!! route('view.keyword',array($item->id,$item->slug)) !!}">{!! $item->keyword !!}</a></h3>
                                <strong>Trên: {!! $item->traffic !!}.000 lượt tìm kiếm </strong><small>Ngày: {!! \Carbon\Carbon::parse($item->updated_at)->format('d-m-Y') !!} - Quốc gia: {!! $item->region !!}</small>
                                @foreach($article as $itemArticle)
                                    <p>
                                        {!! $itemArticle->title !!}<br>
                                        <small>{!! $itemArticle->author !!}</small>
                                    </p>
                                @endforeach
                            </li>
                        @endforeach
                    </ul>
                    <div class="form-group mt-2">
                        {{ $listKeywords->links() }}
                    </div>
                @endif
            </div>
            <div class="col-md-4">
                @if(count($getNewKeywordNew))
                    <div class="form-group mt-2">
                        <h4>Từ khóa mới cập nhật </h4>
                        <ul class="list-group">
                            @foreach($getNewKeywordNew as $keyword)
                                <li class="list-group-item">
                                    <a href="{!! route('view.keyword',array($keyword->id,$keyword->slug)) !!}">{!! $keyword->keyword !!}</a>
                                    <small>{!! $keyword->updated_at !!}</small>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="form-group mt-2">
                    <div class="form-group">
                        <ins class="adsbygoogle"
                             style="display:block"
                             data-ad-client="ca-pub-6739685874678212"
                             data-ad-slot="7536384219"
                             data-ad-format="auto"></ins>
                        <script>
                            (adsbygoogle = window.adsbygoogle || []).push({});
                        </script>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('css')
@endsection
@section('script')
@endsection