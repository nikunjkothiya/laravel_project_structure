<div class="d-flex justify-content-start">
    <a href="{{ route($routeName.'.show', $id) }}" class="btn btn-secondary icon" title="View">
        <i class="bi bi-eye"></i>
    </a>
    <a href="javascript:{}" class="btn btn-danger icon action-delete" data-route="{{ $routeName }}" entry-id="{{$id}}" title="Delete">
        <i class="bi bi-trash"></i>
    </a>
    <a href="{{route('pdfdownload',$id)}}" class="btn btn-danger icon" title="Download">
        <i class="bi bi-download"></i>
    </a>
    <a href="javascript:" data-id="{{$id}}" class="btn btn-primary icon" id="staff-report" title="Report">
        <img src="{{ asset('public/assets/img/clipboard.png') }}" alt="">
    </a>
</div>