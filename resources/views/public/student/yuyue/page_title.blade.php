<section id="page-title">
    <div class="container clearfix">
        <div class="col-md-6">
    		<h1>@yield('page_title')</h1>
			<div class="line" style="margin: 5px 0 10px 0"></div>
	    	<div class="" style="color: #e74c3c; ">
	    		<div class="col-md-4">
					<h5>@yield('num_name1')</h5>
					<span data-from="100" data-to="@yield('s_num')" data-speed="2500" id="s_num">@yield('num1')</span>
				</div>
				<div class="col-md-4">
					<h5>@yield('num_name2')</h5>
					<span data-from="100" data-to="@yield('m_num')" data-speed="2500" id="m_num">@yield('num2')</span>
				</div>
				<div class="col-md-4">
		            <button href="#" class="btn btn-success btn-sm" >购买课程</button>
	            </div>
			</div>
    	</div>
    	<div class="col-md-6">
    		<ol class="breadcrumb">
	            <li><a href="/students">学生主页</a></li>
	            <li class="active">@yield('page_title')</li>
       		</ol>	
        </div>
		<!-- <div class="line" style="margin:20 0 20 0"></div> -->


                    
    <!--              -->
	</div>
</section>