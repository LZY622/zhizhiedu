<header>
    <style>
        .kuaijie {
            color: grey;
            text-decoration: none;
        }
        .kuaijie:hover{
            color: #2E6EA5;
            text-decoration: none;
        }
    </style>
            <!-- logo -->
    <div class="am-fl tpl-header-logo">
        <a href="javascript:;"><img src="/assets/img/logo.png" alt=""></a>
    </div>
    <!-- 右侧内容 -->
    <div class="tpl-header-fluid">
        <!-- 侧边切换 -->
        <div class="am-fl tpl-header-switch-button am-icon-list">
            <span>

            </span>
        </div>
        <!-- 搜索 -->

        <div class="am-fl tpl-header-switch-button" style="margin-left: -8px;">
           <a style=""  href="javascript:;" id="all_back" class='kuaijie am-icon-arrow-left'><span></span></a>
        </div>
        <div class="am-fl tpl-header-switch-button" style="margin-left: -8px;">
           <a style=""  href="/admin/stuuser"  class='am-icon-bookmark kuaijie'><span> 学生管理</span></a>
        </div>
        <div class="am-fl tpl-header-switch-button" style="margin-left: -8px;">
           <a href="/admin/tea_sclass"  class='am-icon-bookmark kuaijie'><span> 口语空课表</span></a>
        </div>
        <div class="am-fl tpl-header-switch-button" style="margin-left: -8px;">
           <a href="/admin/stu_wcorrect/create"  class='am-icon-bookmark kuaijie'><span> 作文预约表</span></a>
        </div>
        <!-- 其它功能-->
        <div class="am-fr tpl-header-navbar">
            <ul>
                <!-- 欢迎语 -->
                <li class="am-text-sm tpl-header-navbar-welcome">
                    <a href="/admin/setuser">欢迎你, <span>{{$rs->username}}</span> </a>
                </li>

                <!-- 新邮件 -->
                <li class="am-dropdown tpl-dropdown" data-am-dropdown>
                    <a href="/admin/message" >
                        <i class="am-icon-envelope"></i>
                        <span class="am-badge am-badge-success am-round item-feed-badge" id="changenum">0</span>
                    </a>
                </li>

                

                <!-- 退出 -->
                <li class="am-text-sm">
                    <a href="/admin/loginout">
                        <span class="am-icon-sign-out"></span> 退出
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <!-- <script src="https://cdn.socket.io/socket.io-1.3.4.js"></script> -->
    <script src="/socket.io/socket.io.js"></script>
    <script>
        $('#all_back').click(function(){
            window.history.back(-1);
        });
    //建立一个socket链接
      var socket = io.connect('http://dt.diantingedu.com:3389/');
        //往服务器发送消息
        socket.emit('howmany', { num: $('#changenum').html()});
        //监听服务端发送的消息 news参数与服务端emit第一个参数相同
        socket.on('new_num', function (data) {
            console.log(data);
            $('#changenum').html(data.new_num.length);
            socket.emit('howmany', { num: $('#changenum').html()});
        });
    </script>

</header>
