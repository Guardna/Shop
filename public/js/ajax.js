function editComment(id,pid) {
        var content=$('#kom'+id).text();
        document.getElementById("txta").value=content;
        var url=document.getElementById("pform").action;
        var res = url.replace(pid, id);
        var form = document.getElementById('pform');
        form.action=res;
        $.ajax({
            method : "get",
            processData: false, contentType: false,
            data: {
                'id' : id,
                'content' : content,
            },
            type : 'json',
            success : function(data) {
                showComment(id,content,form);
            },
            error : function(error)
            {
                console.log("Something went wrong....");
            }
        });
}

function showComment(id,content,form) {
    var url="/editComment/" + id + "/edit";
    var editForm = form;
    $("#comment"+id).html(editForm);
}

function updateComment(id) {
    var editedData = $("#commentContent").val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        "url" :"/comments/" + id + "/edit",
        method : "post",
        data : {
            'content' : editedData,
            '_method' : "post",
            'csrf-token' : X-CSRF-TOKEN
        },
        type : 'json',
        success : function(data) {
            hideAndReset(id, editedData);
        },
        error : function(error)
        {
            console.log("Something went wrong....");
        }
    });
}

function hideAndReset(id, editedData)
{
    console.log(editedData);
    $("#comment" + id).html(editedData);
    $("#comments").html("<div class='alert alert-info'>Comment successfully edited!</div>");
}

$(".trazi").click(function(event){
    event.preventDefault();
    var keyword = $('#search').val();
    _token: $('meta[name="csrf-token"]').attr('content'),

    $.ajax({
        url: "/searchjs",
        type:"GET",
        dataType: "json",
        data:{
            'keyword':keyword
        },
        success:function(data){
            $("#rezultati").html(data);
            console.log(data);
        },
        error: function(error) {
            console.log(error);
        }
    });
});

function salji(sid){
    event.preventDefault();
    var keyword = $('#psalji').val();
    _token: $('meta[name="csrf-token"]').attr('content'),

        $.ajax({
            url: "/commentsjs/" + sid+"/"+keyword,
            type:"GET",
            dataType: "json",
            data:{
                'keyword':keyword,
                'sid':sid
            },
            success:function(data){
                $("#rezultati").html(data);
                console.log(data);
            },
            error: function(error) {
                console.log(error);
            }
        });
};

function showpost(id) {
    event.preventDefault();
        $.ajax({
            url: "/postjs/" + id,
            type:"GET",
            dataType: "json",
            data:{
                'id':id
            },
            success:function(data){
                $("#rezultati").html(data);
                console.log(data);
            },
            error: function(error) {
                console.log(error);
            }
    });
}
