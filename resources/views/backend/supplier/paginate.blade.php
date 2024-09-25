@if ($paginator->hasPages())
   
       
        @if ($paginator->onFirstPage())
            <a class="disabled"> < </a>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"> < </a>
        @endif


      
        @foreach ($elements as $element)
           
            @if (is_string($element))
                <a class="disabled"><span>{{ $element }}</span></a>
            @endif


           
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <a href="#" class="active">{{ $page }}</a>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach


        
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"> > </a>
        @else
            <a class="disabled"> > </a>
        @endif
    
@endif 