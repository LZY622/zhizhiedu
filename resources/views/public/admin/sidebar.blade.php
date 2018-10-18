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
                    <a href="/admin/setuser" class="tpl-user-panel-action-link"> <span class="am-icon-pencil"></span> 账号设置</a>
                </div>
            </div>


            <!-- 菜单 -->
            <ul class="sidebar-nav">
                <li class="sidebar-nav-link">
                    <a href="/admin">
                        <i class="am-icon-home sidebar-nav-link-logo"></i> 首页
                    </a>
                </li>
                <li class="sidebar-nav-heading"> <span class="sidebar-nav-heading-info">课程管理</span></li>
                <li class="sidebar-nav-link">
                    <a href="/admin/stu_sclass/create">
                        <i class="am-icon-home sidebar-nav-link-logo"></i> 
                        查看口语课程预约列表
                    </a>
                </li>
                <li class="sidebar-nav-link">
                    <a href="/admin/tea_sclass">
                        <i class="am-icon-home sidebar-nav-link-logo"></i> 
                        查看空闲口语课程列表
                    </a>
                </li>
                <li class="sidebar-nav-link">
                    <a href="/admin/stu_wcorrect/create">
                        <i class="am-icon-home sidebar-nav-link-logo"></i> 
                        查看作文批改预约列表
                    </a>
                </li>
                <li class="sidebar-nav-link">
                    <a href="/admin/tea_wcorrect">
                        <i class="am-icon-home sidebar-nav-link-logo"></i> 
                        查看未预约作文批改篇数列表
                    </a>
                </li>
                <li class="sidebar-nav-link">
                    <a href="/admin/classcate">
                        <i class="am-icon-home sidebar-nav-link-logo"></i> 
                        课程分类
                    </a>
                </li>
                <li class="sidebar-nav-heading"> <span class="sidebar-nav-heading-info">学生管理</span></li>
                <li class="sidebar-nav-link">
                    <a href="/admin/stuuser">
                        <i class="am-icon-home sidebar-nav-link-logo"></i> 
                        查看学生列表
                    </a>
                </li>
                    
                <li class="sidebar-nav-heading"> <span class="sidebar-nav-heading-info">老师管理</span></li>
                <li class="sidebar-nav-link">
                    <a href="/admin/teauser">
                        <i class="am-icon-home sidebar-nav-link-logo"></i> 
                        查看老师列表
                    </a>
                </li>
                <li class="sidebar-nav-link">
                    <a href="/admin/tea_sclass/create">
                        <i class="am-icon-home sidebar-nav-link-logo"></i> 
                        查看口语老师课时统计
                    </a>
                </li>
                <li class="sidebar-nav-link">
                    <a href="/admin/tea_wcorrect/create">
                        <i class="am-icon-home sidebar-nav-link-logo"></i> 
                        查看作文批改老师篇数统计
                    </a>
                </li>
                <li class="sidebar-nav-heading"> <span class="sidebar-nav-heading-info">助教管理</span></li>
                <li class="sidebar-nav-link">
                    <a href="/admin/adminuser">
                        <i class="am-icon-home sidebar-nav-link-logo"></i> 
                        查看助教列表
                    </a>
                </li>
               <li class="sidebar-nav-link">
                <!-- 课时数模块包含在用户模块里面 -->
                    <a href="/admin/stuuser/select_all">
                        <i class="am-icon-home sidebar-nav-link-logo"></i> 
                        查看助教添加课程记录
                    </a>
                </li>

                <li class="sidebar-nav-heading"> <span class="sidebar-nav-heading-info">角色权限管理</span></li>
                <li class="sidebar-nav-link">
                    <a href="/rp/role">
                        <i class="am-icon-home sidebar-nav-link-logo"></i> 
                        查看角色权限列表
                    </a>
                </li>
                <li class="sidebar-nav-heading"> <span class="sidebar-nav-heading-info">主页内容管理</span></li>
                <li class="sidebar-nav-link">
                    <a href="/admin/guanwang/seo">
                        <i class="am-icon-home sidebar-nav-link-logo"></i> 
                        SEO优化
                    </a>
                </li>
                <li class="sidebar-nav-link">
                    <a href="/admin/guanwang/banner">
                        <i class="am-icon-home sidebar-nav-link-logo"></i> 
                        主页banner图设置
                    </a>
                </li>
                <li class="sidebar-nav-link">
                    <a href="/admin/guanwang/lunbo">
                        <i class="am-icon-home sidebar-nav-link-logo"></i> 
                        学生主页轮播图设置
                    </a>
                </li>
                <li class="sidebar-nav-link">
                    <a href="/admin/guanwang/notice">
                        <i class="am-icon-home sidebar-nav-link-logo"></i> 
                        学生预约页面通知设置
                    </a>
                </li>


                <li class="sidebar-nav-heading"> <span class="sidebar-nav-heading-info">备用模板</span></li>
                <li class="sidebar-nav-link">
                    <a href="javascript:;" class="sidebar-nav-sub-title">
                        <i class="am-icon-table sidebar-nav-link-logo"></i> 
                        备用模板
                        <span class="am-icon-chevron-down am-fr am-margin-right-sm sidebar-nav-sub-ico"></span>
                    </a>
                    <ul class="sidebar-nav sidebar-nav-sub">
                        <li class="sidebar-nav-link">
                            <a href="/admin/adminuser">
                                <span class="am-icon-angle-right sidebar-nav-link-logo"></span> 备用模板
                            </a>
                        </li>
                    </ul>
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