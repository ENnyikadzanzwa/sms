<div class="row mb-3">
    <div class="col-md-4">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Total Schools</h5>
                <p class="card-text">{{ $metrics['totalSchools'] }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Active Schools</h5>
                <p class="card-text">{{ $metrics['activeSchools'] }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-danger">
            <div class="card-body">
                <h5 class="card-title">Inactive Schools</h5>
                <p class="card-text">{{ $metrics['inactiveSchools'] }}</p>
            </div>
        </div>
    </div>
</div>
