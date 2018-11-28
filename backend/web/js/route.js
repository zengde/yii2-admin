!function($) {
    var animateIcon = '<i class="fa fa-refresh fa-spin"></i>';

    function updateRoutes(r) {
        _opts.routes.avaliable = r.avaliable;
        _opts.routes.assigned = r.assigned;
        search('avaliable');
        search('assigned');
    }

    $('#btn-new').click(function () {
        var $this = $(this);
        var html = $this.html();
        var route = $('#inp-route').val().trim();
        if (route != '') {
            $this.addClass('layui-btn-disabled').html(animateIcon);
            $.post($this.attr('href'), {route: route}, function (r) {
                $('#inp-route').val('').focus();
                updateRoutes(r.data);
            }).always(function () {
                $this.removeClass('layui-btn-disabled').html(html);
            });
        }
        return false;
    });

    $('.btn-assign').click(function () {
        var $this = $(this);
        var html = $this.html();
        var target = $this.data('target');
        var routes = $('select.list[data-target="' + target + '"]').val();
        if (routes && routes.length) {
            $this.addClass('layui-btn-disabled').html(animateIcon);
            $.post($this.attr('href'), {routes: routes}, function (r) {
                updateRoutes(r.data);
            }).always(function () {
                $this.removeClass('layui-btn-disabled').html(html);
            });
        }
        return false;
    });

    $('#btn-refresh').click(function () {
        var $icon = $(this).children('i.fa');
        $icon.addClass('fa-spin');
        $.post($(this).attr('href'), function (r) {
            updateRoutes(r.data);
        }).always(function () {
            $icon.removeClass('fa-spin');
        });
        return false;
    });

    $('.search[data-target]').keyup(function () {
        search($(this).data('target'));
    });
    $('select.list[data-target="avaliable"]').click(function(e){
        $('#inp-route').val($(this).val()+'-').focus();
    });
    function search(target) {
        var $list = $('select.list[data-target="' + target + '"]');
        $list.html('');
        var q = $('.search[data-target="' + target + '"]').val();
        $.each(_opts.routes[target], function () {
            var r = this;
            if (r.indexOf(q) >= 0) {
                $('<option>').text(r).val(r).appendTo($list);
            }
        });
    }

    // initial
    search('avaliable');
    search('assigned');
}(jQuery);