@extends('layouts.app')

@section('style')
    <style>
        .post-comments {
            padding-bottom: 9px;
            margin: 5px 0 5px;
        }

        .comments-nav {
            border-bottom: 1px solid #eee;
            margin-bottom: 5px;
        }

        .post-comments .comment-meta {
            border-bottom: 1px solid #eee;
            margin-bottom: 5px;
        }

        .post-comments .media {
            border-left: 1px dotted #000;
            border-bottom: 1px dotted #000;
            margin-bottom: 5px;
            padding-left: 10px;
        }

        .post-comments .media-heading {
            font-size: 12px;
            color: grey;
        }

        .post-comments .comment-meta a {
            font-size: 12px;
            color: grey;
            font-weight: bolder;
            margin-right: 5px;
        }
    </style>
@endsection


@section('content')
    <div class="container">

        <h1>Add a question</h1>

        <form action="/questions/add" method="post">
            <div class="form-group">
                <label>Question</label>
                {!! csrf_field() !!}
                <input type="text" name="question" class="form-control" placeholder="Question">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <br>

        <div class="post-comments">
            @foreach($questions as $question)

                <div class="form-group">
                    <h2>{{ $question->question  }}</h2>
                </div>

                <form action="/answers/add" method="post">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <input type="hidden" name="question_id" value="{{$question->id}}" />
                        <input type="text" name="answer" class="form-control" placeholder="Your answer">
                    </div>
                </form>

                <div class="row">
                    @foreach($question->answers as $answer)
                        @if($answer->parent_id == 0)
                            <div class="media">
                                <div class="media-heading">
                                    <button class="btn btn-default btn-xs" type="button" data-toggle="collapse" data-target="#collapseOne-{{$answer->id}}" aria-expanded="false" aria-controls="collapseExample">
                                        <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                                    </button>
                                    <span class="label label-info">ananymous</span> {{ $answer->updated_at->diffForHumans() }}
                                </div>

                                <div class="panel-collapse collapse in" id="collapseOne-{{$answer->id}}">
                                    <div class="media-body">
                                        <p>{{ $answer->answer }}</p>

                                        <div class="comment-meta">
                                            <span><a href="#">delete</a></span>
                                            <span><a href="#">report</a></span>
                                            <span><a href="#">hide</a></span>
                                            <span><a class="" role="button" data-toggle="collapse" href="#replyCommentT-{{$answer->id}}" aria-expanded="false" aria-controls="collapseExample">reply</a></span>
                                            <div class="collapse" id="replyCommentT-{{$answer->id}}">
                                                <form action="/answers/add" method="post">
                                                    {!! csrf_field() !!}
                                                    <div class="form-group">
                                                        <input type="hidden" name="question_id" value="{{$question->id}}" />
                                                        <input type="hidden" name="parent_id" value="{{ $answer->id }}" />
                                                        <input type="text" name="answer" class="form-control" placeholder="Your answer">
                                                    </div>
                                                </form>
                                            </div>


                                            @foreach($answer->answers as $reply)
                                                <div class="media">
                                                    <div class="media-heading">
                                                        <button class="btn btn-default btn-xs" type="button" data-toggle="collapse" data-target="#collapseOne-{{$reply->id}}" aria-expanded="false" aria-controls="collapseExample">
                                                            <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                                                        </button>
                                                        <span class="label label-info">ananymous</span> {{ $reply->updated_at->diffForHumans() }}
                                                    </div>
                                                    <div class="panel-collapse collapse in" id="collapseOne-{{$reply->id}}">
                                                        <div class="media-body">
                                                            <p>{{ $reply->answer }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
@endsection


@section('js')
    <script>
        $('[data-toggle="collapse"]').on('click', function() {
            var $this = $(this),
                $parent = typeof $this.data('parent')!== 'undefined' ? $($this.data('parent')) : undefined;
            if($parent === undefined) { /* Just toggle my  */
                $this.find('.glyphicon').toggleClass('glyphicon-plus glyphicon-minus');
                return true;
            }

            /* Open element will be close if parent !== undefined */
            var currentIcon = $this.find('.glyphicon');
            currentIcon.toggleClass('glyphicon-plus glyphicon-minus');
            $parent.find('.glyphicon').not(currentIcon).removeClass('glyphicon-minus').addClass('glyphicon-plus');

        });
    </script>
@endsection