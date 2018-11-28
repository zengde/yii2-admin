/**
 * Created by zeng on 2017/1/10.
 */
//ajax提交modal表单
function ajaxform(formobj, callback) {
    str = formobj.serialize();
    url = formobj.attr('action');
    $.post(url, str, function (json) {
        if (callback && callback != '') {
            dispatchfunc(callback, json);
        }
    });
    return true;

}
//ajax提交modal表单带file ie10+
function ajaxform_file(formobj, callback) {
    str = '';
    fmele = formobj;
    var formData = new FormData(fmele[0]);//用form 表单直接 构造formData 对象; 就不需要下面的append 方法来为表单进行赋值了。

    var url = fmele.attr('action');
    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        /**
         * 必须false才会避开jQuery对 formdata 的默认处理
         * XMLHttpRequest会对 formdata 进行正确的处理
         */
        processData: false,
        /**
         *必须false才会自动加上正确的Content-Type
         */
        contentType: false,
        success: function (json) {
            if (callback && callback != '') {
                dispatchfunc(callback, json);
            }
        },
        error: function (responseStr) {

        },
        complete: function (msg) {

        }
    });

}

/**
 * 动态调用函数
 * @param fn string
 * @param args mixed
 * @returns {*}
 */
function dispatchfunc(fn, args) {
    args = (typeof args == 'string' || typeof args == 'object') ? [args] : args;
    fn = (typeof fn == "function") ? fn : window[fn];  // Allow fn to be a function object or the name of a global function
    return fn.apply(null, args || []);  // args is optional, use an empty array by default
}