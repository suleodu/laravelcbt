<?php

namespace App\Http\Middleware;

use Closure;
use App\Test;
class ImageCapture
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $tid = NULL)
    {
        if($tid != NULL){
            $test_ppt = Test::where('tid', $tid)->first();
            dd($test_ppt);
            //dd($request);
            return view('student.image_capture', $data); 
        }
        
        
        //return $next($request);
    }
}
