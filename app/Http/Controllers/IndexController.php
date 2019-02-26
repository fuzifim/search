<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
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
    public function __construct()
    {

    }
    public function index(Request $request)
    {

    }
    public function getTrends(Request $request)
    {
        $file=@file_get_contents('https://trends.google.com.vn/trends/api/dailytrends?hl=vi&tz=-420&geo=VN&ns=15');
        $file=str_replace(")]}',","",$file);
        $arrayTrends=json_decode($file);
        foreach($arrayTrends as $trends){
            foreach($trends->trendingSearchesDays as $element){
                foreach($element->trendingSearches as $item){
                    echo $item->title->query.'<p>';
                }
            }
        }
    }
}
