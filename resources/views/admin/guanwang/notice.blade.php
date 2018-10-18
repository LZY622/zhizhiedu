@extends('layouts.admin.admins')
@section('title','吱吱英语后台管理')
@section('content')
<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
    <div class="widget am-cf">
        <div class="widget-head am-cf">
            <div class="widget-title am-fl">学生预约页面提示信息设置</div>
        </div>
        <div id="xinxi">
            @if(session('success'))  
            <div class="alert alert-success" role="alert">
                {{session('success')}}  

            </div>
            @endif
            @if (count($errors) > 0)
                <div class="alert alert-warning" role="alert">
                    <ul>
                        @if(is_object($errors))
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        @else
                            <li>{{ $errors }}</li>
                        @endif
                    </ul>
                </div>
            @endif
        </div>
        <div class="widget-body am-fr">
            <form class="am-form tpl-form-border-form tpl-form-border-br" action="/admin/guanwang/notice_upd" method="post">
                {{csrf_field()}}
                

                <div class="am-form-group">
                    <label for="user-weibo" class="am-u-sm-3 am-form-label">
                        口语页面提示信息
                        <span class="tpl-form-line-small-title">speak</span>
                    </label>
                    <div class="am-u-sm-9">
                        <div class="am-form-group am-form-file">
                            <!-- 配置文件 -->
                            <script type="text/javascript" src="/ueditor/ueditor.config.js"></script>
                            <!-- 编辑器源码文件 -->
                            <script type="text/javascript" src="/ueditor/ueditor.all.js"></script>
                            <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
                            <script type="text/javascript" charset="utf-8" src="/ueditor/lang/zh-cn/zh-cn.js"></script>
                            <script id="speak_container" name="speak_content" type="text/plain" style=""></script>
                            <input type="hidden" name="speak" value="{{$res[1]->content}}">
                        </div>
                    </div>
                    <label for="user-weibo" class="am-u-sm-3 am-form-label">
                        作文批改页面提示信息
                        <span class="tpl-form-line-small-title">write</span>
                    </label>
                    <div class="am-u-sm-9">
                        <div class="am-form-group am-form-file">
                            <!-- 配置文件 -->
                            <script type="text/javascript" src="/ueditor/ueditor.config.js"></script>
                            <!-- 编辑器源码文件 -->
                            <script type="text/javascript" src="/ueditor/ueditor.all.js"></script>
                            <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
                            <script type="text/javascript" charset="utf-8" src="/ueditor/lang/zh-cn/zh-cn.js"></script>
                            <script id="write_container" name="write_content" type="text/plain" style=""></script>   
                            <input type="hidden" name="write" value="{{$res[0]->content}}">

                        </div>
                    </div>
                    <button class="am-btn am-btn-default am-btn-success" type="submit">提交</button>
                </div>
                
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $('.alert-success').delay(2000).fadeOut(1000);
    $('.alert-warning').delay(2000).fadeOut(1000);
    var ue = UE.getEditor('speak_container');
    ue.ready(function(){
        ue.setContent($('input[name=speak]').val())
    });
    var uee = UE.getEditor('write_container');
    uee.ready(function(){
        uee.setContent($('input[name=write]').val())
    });
</script>

@stop