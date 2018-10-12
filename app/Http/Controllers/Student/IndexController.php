<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     *  展示学生端主页
     * 	@param 
     *  @return 
     */
    public function index()
    {
    	return view('student.index');
    }
}
