@if( $article->getStartPage() > 0 )
    - С. {{{ $article->getStartPage()}}}@if( $article->getEndPage() > 0 )-{{{ $article->getEndPage() }}}@endif.
@endif