@if ($paginator->hasPages())
    <ul class="pagination">
        <!-- Previous Page Link -->
        @if ($paginator->onFirstPage())
            <li class="disabled"><span><i class="fa fa-chevron-left"></i> Anterior</span></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="fa fa-chevron-left"></i> Anterior</a></li>
        @endif

        <!-- Next Page Link -->
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">Siquiente  <i class="fa fa-chevron-right"></i></a></li>
        @else
            <li class="disabled"><span>Siguiente <i class="fa fa-chevron-right"></i></span></li>
        @endif
    </ul>
@endif
