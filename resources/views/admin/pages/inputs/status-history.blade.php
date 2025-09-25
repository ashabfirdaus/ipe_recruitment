<style>
    thead>tr>th {
        background-color: #c5bd78;
        color: white;
        padding: 5px !important;
    }

    tbody>tr>td {
        padding: 5px !important;
    }

    .timeline-icon {
        top: 0px;
    }
</style>

<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4>
                <i class="icon-history position-left"></i>
                <span class="text-semibold">Riwayat Pelamar</span>
            </h4>
        </div>
    </div>
</div>
<div class="content">
    <h5>{{ $data->full_name }} - {{ $data->position }}</h5>
    <div class="pull-right">
        <a href="{{ route('applicant-entry', $data->id) }}" class="btn btn-default me"> <i
                class="icon-undo2 position-left"></i> Kembali</a>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="timeline timeline-left">
                <div class="timeline-container">
                    @foreach ($data->histories as $h)
                        <div class="timeline-row">
                            <div class="timeline-icon">
                                <a href="#">
                                    <img src="{{ asset('img/placeholder.jpg') }}" alt="">
                                </a>
                            </div>
                            <div class="panel panel-flat timeline-content">
                                <div class="panel-body">
                                    <div class="pull-right">
                                        {{ date('d/m/Y H:i:s', strtotime($h->time)) }}
                                    </div>
                                    {{ $h->desc }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</div>
