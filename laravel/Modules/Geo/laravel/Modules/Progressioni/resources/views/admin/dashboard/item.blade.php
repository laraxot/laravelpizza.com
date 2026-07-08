class="col-2">
    <div class="card card-header-actions ">
        <div class="card-header">
            <a href="{{ $area->url }}">{{ $area->title }}</a>
        </div>
        <div class="card-body">
            <h4 class="small">
                n schede:
                <span class="float-end fw-bold">{{ $_theme->setModule('progressioni')->call('schedeCount',(int)date('Y')) }}</span>
            </h4>
            {{--
            <div class="progress mb-4">
                <div class="progress-bar bg-danger" role="progressbar" style="width: 20%"
                    aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            --}}
            {{--
            <h4 class="small">
                Sales Tracking
                <span class="float-end fw-bold">40%</span>
            </h4>
            <div class="progress mb-4">
                <div class="progress-bar bg-warning" role="progressbar" style="width: 40%"
                    aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <h4 class="small">
                Customer Database
                <span class="float-end fw-bold">60%</span>
            </h4>
            <div class="progress mb-4">
                <div class="progress-bar" role="progressbar" style="width: 60%" aria-valuenow="60"
                    aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <h4 class="small">
                Payout Details
                <span class="float-end fw-bold">80%</span>
            </h4>
            <div class="progress mb-4">
                <div class="progress-bar bg-info" role="progressbar" style="width: 80%"
                    aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <h4 class="small">
                Account Setup
                <span class="float-end fw-bold">Complete!</span>
            </h4>
            <div class="progress">
                <div class="progress-bar bg-success" role="progressbar" style="width: 100%"
                    aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            --}}
        </div>
        <div class="card-footer position-relative">
            <div class="d-flex align-items-center justify-content-between small text-body">
                <a class="stretched-link text-body" href="{{ $area->url }}">{{ $area->title }}</a>
                <i class="fas fa-angle-right"></i>
            </div>
        </div>
    </div>
</div>