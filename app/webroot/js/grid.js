//<![CDATA[
$(function(){
    //setup
    var vg = $("#grid-content").vgrid({
        easing: "easeOutQuint",
        useLoadImageEvent: true,
        useFontSizeListener: true,
        time: 400,
        delay: 20,
        wait: 500,
        fadeIn: {
            time: 500,
            delay: 50
        },
        onStart: function(){
            $("#message1")
            .stop()
            .css("visibility", "visible")
            .fadeOut("slow",function(){
                $(this).show().css("visibility", "hidden");
            });
        },
        onFinish: function(){
            $("#message2")
            .stop()
            .css("visibility", "visible")
            .fadeOut("slow",function(){
                $(this).show().css("visibility", "hidden");
            });
        }
    });
    $(window).load(function(e){
        vg.vgrefresh();
    });

    //show
    $("#grid-addlist").on('click', 'li', function(e){
        var self = $(this);
        var key = self.attr("id").split("-")[1];
        self.hide();
        $("#grid-"+key).stop().show().fadeTo(300, 1);
        vg.vgrefresh();
    });

    //hide
    $("#grid-content").on('click', 'a', function(e){
        var self = $(this).parent().parent();
        var key = self.attr("id").split("-")[1];
        self.stop().fadeOut(200, function(){
            vg.vgrefresh();
        });
        $("#list-"+key).show();
        return false;
    });

    //add new item
    $("#additem").click(function(e){
        var height = Math.max(30, Math.min(300, Math.round(Math.random()*300)));
        var key = $.now();
        var list = $('<li>Add "'+ key +'"</li>').attr("id", "list-"+key).hide();
        var item = $('<div>\
<h3>'+key+'</h3>\
<p><img src="http://dummyimage.com/150x'+ height +'" alt="dummy" /></p>\
<p><a href="#">DELETE</a></p>\
</div>')
        .attr("id", "grid-"+key)
        .stop()
        .fadeTo(0, 0);
        $("#grid-addlist").prepend(list);
        $("#grid-content").prepend(item);
        vg.vgrefresh(null, null, null, function(){
            item.stop().fadeTo(300, 1);
        });
    });
});
//]]>
