<div class="comments heading">
    <h3>Comments</h3>
    <form id="komentform">
    @foreach($comments as $comment)
        <div class="media">
            <div class="media-body">
                <table class="table">
                    <tr>
                        <td>
                <h4 class="media-heading">	{{ $comment->korisnicko_ime }}</h4>
                <h6><label>{{ date("F j, Y", strtotime($comment->created_at)) }}</label></h6>
                <span id="comment{{$comment->id}}">
                    <span id="kom{{$comment->id}}">{{ $comment->content }}</span></br>
                    @if(session('user'))
                        @if(session()->get('user')[0]->id == $comment->user_id || session()->get('user')[0]->naziv == 'admin')
                            <a href="{{ route("deleteComment", ['commentId' => $comment->id]) }}"><i class="fa fa-trash">Obrisi</i></a>
                        @endif
                        @if(session()->get('user')[0]->id == $comment->user_id)
                                 <a href="#comment{{$comment->id}}"><i class="fa fa-edit" onclick="editComment({{ $comment->id }},{{ $singlePost->postId}})">Izmeni</i></a>
                        @endif
                    @endif
                    <span id="#comments"></span>
                </span>
                        </td>
                </tr>
                </table>
            </div>
            <div class="media-right">

            </div>
        </div>
    @endforeach
    </form>
</div>
