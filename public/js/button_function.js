$(function() {
    $('button#add_authers').click(function(){
        var tr_form='<td><input type="text" id="keyword" name="keyword[]" required></td>';
        $(tr_form).appendTo($('table#authers>tbody>tr'));
    });
    $('button#write_user_memo').click(function(){
        target = document.getElementById('user_memo');
        // これ罠ね（大文字小文字）
        target.readOnly = false;
    });
});