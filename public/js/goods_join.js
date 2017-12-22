layui.use('flow', function(){
    var flow = layui.flow;
    layui.use('flow', function(){
        var $ = layui.jquery; //不用额外加载jQuery，flow模块本身是有依赖jQuery的，直接用即可。
        var flow = layui.flow;

        flow.load({
            elem: '#content_rl' //指定列表容器
            ,done: function(page, next){ //到达临界点（默认滚动触发），触发下一页
                var lis = [];
                $.get('/goods_join_list/'+page, function(res){
                    //假设你的列表返回在data集合中
                        layui.each(res.data, function(index, item){
                            var str = '';
                            str += '<li>';
                            str +=     '<a href="/goods_details/' + item.id + '">';
                            str +=         '<div class="">';
                            str +=             '<div class="img"><img src="' + item.preview + '"></div>';
                            str +=             '<p class="bt overflow_clear">' + item.name + '</p>';
                            str +=             '<p>';
                            str +=                  item.summary;
                            str +=             '</p>';
                            str +=             '<p><span class="price">';
                            if(item.wholesale_price){ 
                                str += '￥'; 
                            }  
                            str += '<b>' + item.wholesale_price + '</b></span><span class="sell_num">已售: ' + item.wholesale_num + ' 件</span></p>';
                            str +=         '</div>';
                            str +=     '</a>';
                            str += '</li>';
                            lis.push(str);
                        }); 
                    
                    //执行下一页渲染，第二参数为：满足“加载更多”的条件，即后面仍有分页
                    //pages为Ajax返回的总页数，只有当前页小于总页数的情况下，才会继续出现加载更多
                    next(lis.join(''), page < res.pages);    
                });
            }
        });
    });
});
