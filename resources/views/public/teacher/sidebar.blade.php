<style type="text/css" media="screen">
   .sidebar-nav-heading-info{
        font-weight: 900;
        color: #3599D6;
   } 
   .sidebar-nav-heading{
    padding: 5px 17px;
   }
</style>
<div class="left-sidebar">
            <!-- 用户信息 -->
            <div class="tpl-sidebar-user-panel">
                <div class="tpl-user-panel-slide-toggleable">
                    <div class="tpl-user-panel-profile-picture">
                        <img src="{{$rs->img}}" alt="">
                    </div>
                    <span class="user-panel-logged-in-text">
                        <i class="am-icon-circle-o am-text-success tpl-user-panel-status-icon"></i>
                        {{$rs->username}}
                    </span>
                    <a href="/teacher/setuser" class="tpl-user-panel-action-link"> <span class="am-icon-pencil"></span> 账号设置</a>
                </div>
            </div>


            <!-- 菜单 -->
            <ul class="sidebar-nav">
                <li class="sidebar-nav-link">
                    <a href="/teacher">
                        <i class="am-icon-home sidebar-nav-link-logo"></i> 首页
                    </a>
                </li>
                <li class="sidebar-nav-heading"> <span class="sidebar-nav-heading-info">课程管理</span></li>
                <li class="sidebar-nav-link">
                    <a href="/teacher/stu_sclass/create">
                        <i class="am-icon-clock-o sidebar-nav-link-logo"></i> 
                        查看口语课程预约列表
                    </a>
                </li>
                <li class="sidebar-nav-link">
                    <a href="/teacher/tea_sclass/{{session('user')->id}}/edit">
                        <i class="am-icon-lock sidebar-nav-link-logo"></i> 
                        口语课程开关
                    </a>
                </li>
                
                <li class="sidebar-nav-link">
                    <a href="/teacher/stu_wcorrect/create">
                        <i class="am-icon-clock-o sidebar-nav-link-logo"></i> 
                        查看作文批改预约列表
                    </a>
                </li>
                <li class="sidebar-nav-link">
                    <a href="/teacher/tea_wcorrect/{{session('user')->id}}">
                        <i class="am-icon-lock sidebar-nav-link-logo"></i> 
                        篇数开放
                    </a>
                </li>
                
                
                
            </ul>
        </div>
        <script>
            $(function(){
                var path = window.location.pathname;
                // console.log(path);
                $('.sidebar-nav-link>a[href="'+path+'"]').addClass('active');
                $('.sidebar-nav-sub a[href="'+path+'"]').addClass('sub-active');
                
            });
        </script>