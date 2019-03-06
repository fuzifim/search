<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Input;
use Session;
use Auth;
use Cache;
use File;
use Validator;
use Carbon\Carbon;
use DB;
use Route;
class IndexController extends Controller
{
    public $_parame;
    public $_date;
    public function __construct()
    {

    }
    public function index(Request $request)
    {
        $dt=Carbon::now();
        $dt->subDays(1)->diffForHumans();
        $this->_date=$dt->format('m/d/Y');
        $getNewKeywordNew = Cache::store('memcached')->remember('getNewKeywordNew',1, function()
        {
            return DB::table('keywords')
                ->orderBy('updated_at','desc')
                ->take(20)->get();
        });
        $getArticle = Cache::store('memcached')->remember('list_home_date_'.$this->_date,1, function()
        {
            return DB::table('article')
                ->join('article_join_keyword','article_join_keyword.article_id','=','article.id')
                ->join('keywords','keywords.id','=','article_join_keyword.keyword_id')
                ->where(DB::raw("(DATE_FORMAT(keywords.updated_at,'%m/%d/%Y'))"),'>=',$this->_date)
                ->select('article.id',DB::raw('keywords.id as keyword_id'),DB::raw('keywords.slug as keyword_slug'),DB::raw('keywords.region as keyword_region'),
                    'article.title','article.description','article.img_xs','article.author','article.source',
                    'article.region','article.created_at','article.updated_at','keywords.keyword','keywords.traffic','keywords.ads')
                ->limit(500)->get();
        });
        $group = array();
        foreach ( $getArticle as $value ) {
            $group[$value->keyword]['keyword_id'] = $value->keyword_id;
            $group[$value->keyword]['keyword_slug'] = $value->keyword_slug;
            $group[$value->keyword]['keyword_region'] = $value->keyword_region;
            $group[$value->keyword]['created_at'] = $value->created_at;
            $group[$value->keyword]['traffic'] = $value->traffic;
            $group[$value->keyword]['article'][] = $value;
        }
        arsort($group);
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        // Create a new Laravel collection from the array data
        $itemCollection = collect($group);
        $perPage = 10;
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
        $paginatedItems->setPath($request->url());
        return view('index',array(
            'listArticle'=>$paginatedItems,
            'getNewKeywordNew'=>$getNewKeywordNew
        ));
    }
    public function viewKeyword(Request $request){
        $dt=Carbon::now();
        $dt->subDays(1)->diffForHumans();
        $this->_date=$dt->format('m/d/Y');
        $id = $request->route('id');
        $slug = $request->route('slug');
        if(!empty($id) && !empty($slug)){
            $keyword = Cache::store('memcached')->remember('company_mst_'.$id,1, function() use ($id,$slug)
            {
                return DB::table('keywords')->where('id',$id)->where('slug',$slug)->first();
            });
            if(!empty($keyword->keyword)){
                $getArticle = Cache::store('memcached')->remember('getArticle_keyword_'.$keyword->id,1, function() use ($keyword)
                {
                    return DB::table('article')
                        ->join('article_join_keyword','article_join_keyword.article_id','=','article.id')
                        ->where('article_join_keyword.keyword_id',$keyword->id)
                        ->groupBy('article.id')
                        ->get();
                });
                $getNewKeywordRegion = Cache::store('memcached')->remember('getNewKeywordRegion_'.$keyword->id.'_'.$keyword->region.'_'.$this->_date,1, function() use ($keyword)
                {
                    return DB::table('keywords')
                        ->where('id','!=',$keyword->id)
                        ->where('region',$keyword->region)
                        ->where(DB::raw("(DATE_FORMAT(keywords.updated_at,'%m/%d/%Y'))"),'>=',$this->_date)
                        ->get();
                });
                $getNewKeywordNew = Cache::store('memcached')->remember('getNewKeywordNew',1, function()
                {
                    return DB::table('keywords')
                        ->orderBy('updated_at','desc')
                        ->take(20)->get();
                });
                return view('viewKeyword',array(
                    'keyword'=>$keyword,
                    'listArticle'=>$getArticle,
                    'listKeywordRegion'=>$getNewKeywordRegion,
                    'getNewKeywordNew'=>$getNewKeywordNew
                ));
            }
        }
    }
    public function getTrends(Request $request)
    {
        $region='VN';
        $lang='vi';
        $array=array(
            '1'=>array(
                'region'=>'VN',
                'lang'=>'vi'
            ),
            '2'=>array(
                'region'=>'SA',
                'lang'=>'vi'
            ),
            '3'=>array(
                'region'=>'EG',
                'lang'=>'vi'
            ),
            '4'=>array(
                'region'=>'AT',
                'lang'=>'vi'
            ),
            '5'=>array(
                'region'=>'AR',
                'lang'=>'vi'
            ),
            '6'=>array(
                'region'=>'AU',
                'lang'=>'vi'
            ),
            '7'=>array(
                'region'=>'IN',
                'lang'=>'vi'
            ),
            '8'=>array(
                'region'=>'PL',
                'lang'=>'vi'
            ),
            '9'=>array(
                'region'=>'BE',
                'lang'=>'vi'
            ),
            '10'=>array(
                'region'=>'PT',
                'lang'=>'vi'
            ),
            '11'=>array(
                'region'=>'BR',
                'lang'=>'vi'
            ),
            '12'=>array(
                'region'=>'CA',
                'lang'=>'vi'
            ),
            '2'=>array(
                'region'=>'CL',
                'lang'=>'vi'
            ),
            '13'=>array(
                'region'=>'CO',
                'lang'=>'vi'
            ),
            '14'=>array(
                'region'=>'TW',
                'lang'=>'vi'
            ),
            '15'=>array(
                'region'=>'DK',
                'lang'=>'vi'
            ),
            '16'=>array(
                'region'=>'DE',
                'lang'=>'vi'
            ),
            '17'=>array(
                'region'=>'NL',
                'lang'=>'vi'
            ),
            '18'=>array(
                'region'=>'KR',
                'lang'=>'vi'
            ),
            '19'=>array(
                'region'=>'US',
                'lang'=>'vi'
            ),
            '20'=>array(
                'region'=>'HU',
                'lang'=>'vi'
            ),
            '21'=>array(
                'region'=>'HK',
                'lang'=>'vi'
            ),
            '22'=>array(
                'region'=>'GR',
                'lang'=>'vi'
            ),
            '23'=>array(
                'region'=>'ID',
                'lang'=>'vi'
            ),
            '24'=>array(
                'region'=>'IE',
                'lang'=>'vi'
            ),
            '25'=>array(
                'region'=>'IL',
                'lang'=>'vi'
            ),
            '26'=>array(
                'region'=>'IT',
                'lang'=>'vi'
            ),
            '27'=>array(
                'region'=>'KE',
                'lang'=>'vi'
            ),
            '28'=>array(
                'region'=>'MY',
                'lang'=>'vi'
            ),
            '29'=>array(
                'region'=>'KE',
                'lang'=>'vi'
            ),
            '30'=>array(
                'region'=>'MX',
                'lang'=>'vi'
            ),
            '31'=>array(
                'region'=>'NO',
                'lang'=>'vi'
            ),
            '32'=>array(
                'region'=>'ZA',
                'lang'=>'vi'
            ),
            '33'=>array(
                'region'=>'NZ',
                'lang'=>'vi'
            ),
            '34'=>array(
                'region'=>'RU',
                'lang'=>'vi'
            ),
            '35'=>array(
                'region'=>'JP',
                'lang'=>'vi'
            ),
            '36'=>array(
                'region'=>'NG',
                'lang'=>'vi'
            ),
            '37'=>array(
                'region'=>'FR',
                'lang'=>'vi'
            ),
            '38'=>array(
                'region'=>'FI',
                'lang'=>'vi'
            ),
            '39'=>array(
                'region'=>'PH',
                'lang'=>'vi'
            ),
            '40'=>array(
                'region'=>'RO',
                'lang'=>'vi'
            ),
            '41'=>array(
                'region'=>'CZ',
                'lang'=>'vi'
            ),
            '42'=>array(
                'region'=>'SG',
                'lang'=>'vi'
            ),
            '43'=>array(
                'region'=>'TH',
                'lang'=>'vi'
            ),
            '44'=>array(
                'region'=>'TR',
                'lang'=>'vi'
            ),
            '45'=>array(
                'region'=>'SE',
                'lang'=>'vi'
            ),
            '46'=>array(
                'region'=>'CH',
                'lang'=>'vi'
            ),
            '47'=>array(
                'region'=>'UA',
                'lang'=>'vi'
            ),
            '48'=>array(
                'region'=>'GB',
                'lang'=>'vi'
            )
        );
        foreach($array as $arr){
            $this->_date=Carbon::now()->format('m/d/Y');
            $file=@file_get_contents('https://trends.google.com.vn/trends/api/dailytrends?hl='.$lang.'&tz=-420&geo='.$arr['region'].'&ns=15');
            $file=str_replace(")]}',","",$file);
            $arrayTrends=json_decode($file);
            foreach($arrayTrends as $trends){
                foreach($trends->trendingSearchesDays as $element){
                    foreach($element->trendingSearches as $item){
                        echo $item->title->query.'<p>';
                        $checkKeyword=DB::table('keywords')->where('base_64',base64_encode($item->title->query))->first();
                        if(empty($checkKeyword->keyword)){
                            $traffic = (int) filter_var($item->formattedTraffic, FILTER_SANITIZE_NUMBER_INT);
                            $keyword_id=DB::table('keywords')->insertGetId(
                                [
                                    'type'=>'trends',
                                    'keyword' => $item->title->query,
                                    'base_64' => base64_encode($item->title->query),
                                    'slug'=>str_slug($item->title->query),
                                    'ads'=>'pending',
                                    'status'=>'active',
                                    'region'=>$arr['region'],
                                    'traffic'=>$traffic,
                                    'created_at'=>Carbon::now()->format('Y-m-d H:i:s'),
                                    'updated_at'=>Carbon::now()->format('Y-m-d H:i:s')
                                ]
                            );
                        }else{
                            $keyword_id=$checkKeyword->id;
                            DB::table('keywords')
                                ->where('id', $checkKeyword->id)
                                ->update(['updated_at' => Carbon::now()->format('Y-m-d H:i:s')]);
                        }
                        $checkTrendsDate=DB::table('keyword_trends_date')
                            ->where('keyword_id',$keyword_id)
                            ->where(DB::raw("(DATE_FORMAT(created_at,'%m/%d/%Y'))"),$this->_date)
                            ->first();
                        if(empty($checkTrendsDate->keyword_id)){
                            DB::table('keyword_trends_date')->insert(
                                [
                                    'keyword_id' => $keyword_id,
                                    'created_at'=>Carbon::now()->format('Y-m-d H:i:s'),
                                    'updated_at'=>Carbon::now()->format('Y-m-d H:i:s')
                                ]
                            );
                        }
                        foreach($item->articles as $article){
                            $checkArticle=DB::table('article')
                                ->where('base_64',base64_encode(strip_tags($article->title,'')))
                                ->first();
                            if(empty($checkArticle->title)){
                                if(!empty($article->image->imageUrl)){
                                    $img=$article->image->imageUrl;
                                }else{
                                    $img='';
                                }
                                $article_id=DB::table('article')->insertGetId(
                                    [
                                        'title'=>strip_tags($article->title,''),
                                        'base_64'=> base64_encode(strip_tags($article->title,'')),
                                        'description'=>strip_tags($article->snippet,''),
                                        'img_xs'=>$img,
                                        'author'=>$article->source,
                                        'source'=>$article->url,
                                        'region'=>$arr['region'],
                                        'created_at'=>Carbon::now()->format('Y-m-d H:i:s'),
                                        'updated_at'=>Carbon::now()->format('Y-m-d H:i:s')
                                    ]
                                );
                            }else{
                                $article_id=$checkArticle->id;
                            }
                            DB::table('article_join_keyword')->insert(
                                [
                                    'keyword_id'=> $keyword_id,
                                    'article_id'=>$article_id
                                ]
                            );
                        }
                    }
                }
            }
        }
    }
}
