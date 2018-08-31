/*
 * @Author: https://github.com/WangEn
 * @Author: https://gitee.com/lovetime/
 * @Date:   2018-03-27
 * @lastModify 2018-3-28
 * +----------------------------------------------------------------------
 * | WeAdmin 表格table中多个删除等操作公用js
 * | 有改用时直接复制到对应页面也不影响使用
 * +----------------------------------------------------------------------
 */
/*layui.extend({
	admin: '{/}../../static/js/admin'
});*/
layui.use(['laydate', 'jquery', 'admin'], function() {
	var laydate = layui.laydate,
		$ = layui.jquery,
		admin = layui.admin;
	//执行一个laydate实例
	laydate.render({
		elem: '#start' //指定元素
	});
	//执行一个laydate实例
	laydate.render({
		elem: '#end' //指定元素
	});
	/*用户-停用*/
	window.member_stop = function (obj, id,url,name,values) {
        var content = $(obj).parents("tr").find(".td-status").find('span').html();
        if(content == '已启用'){
            var confirmTitle = '确认要停用吗？';
        } else {
            var confirmTitle = '确认要启用吗？';
        }
		layer.confirm(confirmTitle, function(index) {
            var postId = $(obj).parents("tr").find(".layui-form-checkbox").attr('data-id');
            //发异步把用户状态进行更改
            $.ajax({
                type: 'POST',
                url: url,
                data: {'name':name,'id':postId,'_csrf-backend':csrfBackend,'value':values},
                dataType: 'json',
                success: function (data) {
                    if(data.status == 1){
                        if($(obj).attr('title') == '启用') {

                            $(obj).attr('title', '停用')
                            $(obj).find('i').html('&#xe62f;');

                            $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
                            layer.msg('已停用!', {
                                icon: 5,
                                time: 1000
                            });

                        } else {
                            $(obj).attr('title', '启用')
                            $(obj).find('i').html('&#xe601;');

                            $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
                            layer.msg('已启用!', {
                                icon: 6,
                                time: 1000
                            });
                        }
                        $(obj).attr('data-status',data.msg[name]);
                    }else{
                        layer.msg(data.msg);
                    }
                },
                error: function (err) {
                    layer.msg('服务器异常');
                }
            });
		});
	}

	/*用户-删除*/
	window.member_del = function (obj, url) {
		layer.confirm('确认要删除吗？', function(index) {
            var postId = $(obj).parents("tr").find(".layui-form-checkbox").attr('data-id');
			//发异步删除数据
            $.ajax({
                type: 'POST',
                url: url,
                data: {'id':postId,'_csrf-backend':csrfBackend},
                dataType: 'json',
                success: function (data) {
                    if(data.status == 1){
                        $(obj).parents("tr").remove();
                        layer.msg('已删除!', {
                            icon: 1,
                            time: 1000
                        });
                    }else{
                        layer.msg(data.msg);
                    }
                },
                error: function (err) {
                    layer.msg('服务器异常');
                }
            });
		});
	}

	window.delAll = function (argument) {
		var data = tableCheck.getData();
		if(data == ''){
            layer.msg('未选择任何数据');
            return false;
        }
		layer.confirm('确认要删除吗？', function(index) {
			//捉到所有被选中的，发异步进行删除
            $.ajax({
                type: 'POST',
                url: argument,
                data: {'id':data,'_csrf-backend':csrfBackend},
                dataType: 'json',
                success: function (data) {
                    if(data.status == 1){
                        layer.msg('删除成功', {
                            icon: 1
                        });
                        $(".layui-form-checked").not('.header').parents('tr').remove();
                    }else{
                        layer.msg(data.msg);
                    }
                },
                error: function (err) {
                    layer.msg('服务器异常');
                }
            });
		});
	}
});