<div class="conrainer">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-9">
                    <h4 style="margin:0;">
                        <a href={{{route('journal.details', $journal->prefix)}}}>
                            <span class="glyphicon glyphicon-book" aria-hidden="true" style="font-size:18px; margin-right:10px;"></span>
                            {{{ $journal->name }}}
                        </a>
                    </h4>
                </div>
                <div class="col-md-3 text-right">
                    <small style="font-weight:bold; text-transform:uppercase;">{{{ $journal->type }}}</small>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-3 top10 bottom10" style="width: 240px">
                    <a href={{{route('journal.details', $journal->prefix)}}}><img class="img-thumbnail" src={{{ url('/public/data/'.$journal->prefix.'/'.$journal->default_edition_picture) }}} /> </a>
                </div>
                <div class="col-md-9 top10 bottom10">
                    <div>
                        @foreach($journal->chapters as $chapterIndex => $chapter)
                            <div class="row top5">
                                <div class="col-md-1" style="width: 25px" >{{{$chapterIndex + 1}}}.</div>
                                <div class="col-md-11"><a href="{{{route('chapter.details', array($chapter->chapter_id))}}}">{{{$chapter->name}}}</a></div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
