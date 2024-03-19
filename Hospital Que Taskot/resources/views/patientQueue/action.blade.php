
<!-- aksi Data antrian -->

<a href="{{route('patientQueue.showDetail',['id'=>$id])}}" data-id="{{ $id }}" data-toggle="tooltip" data-original-title="Edit" class="detail btn btn-primary">
    Detail
    </a>
<a href="{{route('exportDetail.pdf',['id'=>$id])}}" data-id="{{ $id }}" data-toggle="tooltip" data-original-title="Edit" class="detail btn btn-primary">
        Export
    </a>