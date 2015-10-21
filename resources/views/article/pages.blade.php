@if( $article->start_page > 0 )
    - С. {{{ $article->start_page}}}@if( $article->end_page > 0 )-{{{ $article->end_page }}}@endif.
@endif