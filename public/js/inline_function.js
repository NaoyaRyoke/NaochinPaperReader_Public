document.addEventListener("DOMContentLoaded", function() {
    comments.forEach(function(comment) {
        highlightText(comment.anchor_node, comment.anchor_offset, comment.focus_node, comment.focus_offset, comment.comment, comment.user_id, comment.username, comment.id);
    });
    document.querySelectorAll(".highlight").forEach(element => {
        element.addEventListener("click", function(){
            // ここら辺の宣言ほとんどいらなくなるかも
            // やっぱいる
            var userId = this.getAttribute("comment-user-id");
            var username = this.getAttribute("comment-username");
            var commentId = this.getAttribute("comment-id");

            while(document.getElementById("reply_comment").firstChild){
                document.getElementById("reply_comment").removeChild(document.getElementById("reply_comment").firstChild);
            }

            // var inputvalue = username+":"+this.title+"\n";
            // document.getelementbyid("out_inline").setattribute("user_id", userid);
            // document.getelementbyid("out_inline").setattribute("comment_id", commentid);
            // document.getelementbyid("out_inline").value = inputvalue;

            document.getElementById("reply_comment").setAttribute("user_id", userId);
            document.getElementById("reply_comment").setAttribute("comment_id", commentId);
            var pTag = document.createElement("p");
            var aTag = document.createElement("a");
            aTag.textContent = username;
            aTag.setAttribute("href", "mypage.php?id="+userId);
            pTag.appendChild(aTag);
            var spanTag = document.createElement("span");
            spanTag.textContent += ":"+this.title;
            pTag.appendChild(spanTag);
            document.getElementById("reply_comment").appendChild(pTag);
            
            $.ajax({
                url: "../php/get_reply_comment.php",
                type: "POST",
                data:{
                    paper_id: getQueryVariable("id"),
                    parent_id: commentId
                },
                success: function(response){
                    console.log(response);
                    var result = JSON.parse(response);
                    for(let i = 0; i < result.length; i++){
                        pTag = document.createElement("p");
                        aTag = document.createElement("a");
                        aTag.textContent = result[i]["username"];
                        aTag.setAttribute("href", "mypage.php?id="+result[i]["user_id"]);
                        pTag.appendChild(aTag);
                        spanTag = document.createElement("span");
                        spanTag.textContent += ":"+result[i]["comment"];
                        pTag.appendChild(spanTag);
                        document.getElementById("reply_comment").appendChild(pTag);
                    }
                    
                }
            })
        });
    });
});

function highlightText(anchorNodeText, anchorOffset, focusNodeText, focusOffset, comment, comment_user_id, username, comment_id) {
    var mainContent = document.getElementById("mainContent");
    var innerHTML = mainContent.innerHTML;

    var startIdx = innerHTML.indexOf(anchorNodeText);
    var endIdx = innerHTML.indexOf(focusNodeText, startIdx);

    if (startIdx >= 0 && endIdx >= 0) {
        var beforeHighlight = innerHTML.substring(0, startIdx + anchorOffset);
        var highlightedText = innerHTML.substring(startIdx + anchorOffset, endIdx + focusOffset);
        var afterHighlight = innerHTML.substring(endIdx + focusOffset);

        var newHTML = beforeHighlight +
                    "<span class='highlight' title='" + comment + "' comment-user-id='" + comment_user_id + "' comment-username='" + username + "' comment-id='" + comment_id + "'>" + highlightedText + "</span>" +
                    afterHighlight;

        mainContent.innerHTML = newHTML;
    }
}

document.onselectionchange = function() {
    var cpytxt = document.getSelection();
    if (cpytxt.rangeCount > 0) {
        var range = cpytxt.getRangeAt(0);
        var selectedText = range.toString();
    }
};

document.getElementById("input_inline_comment").addEventListener("click", function(event) {
    event.preventDefault();

    if(document.getElementById("reply_comment").hasAttribute("comment_id")){
        var comment = document.getElementById("inline_comment").value;
        var parent_id = document.getElementById("reply_comment").getAttribute("comment_id");

        $.ajax({
            url: '../php/save_inline_comment.php',
            type: 'POST',
            data: {
                paper_id: getQueryVariable('id'),
                selected_text: "",
                comment: comment,
                anchor_node: "",
                anchor_offset: 1,
                focus_node: "",
                focus_offset: 1,
                parent_id: parent_id
            },
            success: function(response) {
                window.location.href = "../php/content.php?id="+getQueryVariable('id');
            }
        });
    } else {
        var cpytxt = document.getSelection();
        if (cpytxt.rangeCount > 0) {
            var range = cpytxt.getRangeAt(0);
            var selectedText = range.toString();
            var comment = document.getElementById("inline_comment").value;

            $.ajax({
                url: "../php/save_inline_comment.php",
                type: "POST",
                data: {
                    paper_id: getQueryVariable("id"),
                    selected_text: selectedText,
                    comment: comment,
                    anchor_node: range.startContainer.nodeValue,
                    anchor_offset: range.startOffset,
                    focus_node: range.endContainer.nodeValue,
                    focus_offset: range.endOffset,
                    parent_id: -1
                },
                success: function(response) {
                    window.location.href = "../php/content.php?id="+getQueryVariable("id");
                }
            });
        }
    }
});

document.getElementById("delete_inline_comment").addEventListener("click", function(event){
    event.preventDefault();

    document.getElementById("reply_comment").textContent = null;
    document.getElementById("reply_comment").removeAttribute("comment_id");   
});

function getQueryVariable(variable) {
    var query = window.location.search.substring(1);
    var vars = query.split("&");
    for (var i = 0; i < vars.length; i++) {
        var pair = vars[i].split("=");
        if (pair[0] == variable) {
            return pair[1];
        }
    }
    return false;
}
