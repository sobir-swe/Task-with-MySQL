<div class="tab-pane fade show active profile-overview" id="profile-overview">
    <h5 class="card-title">About</h5>
    <p class="small fst-italic">{{ auth()->user()->about ?? 'No information available.' }}</p>

    <h5 class="card-title">Profile Details</h5>
    <div class="row">
        <div class="col-lg-3 col-md-4 label">Full Name</div>
        <div class="col-lg-9 col-md-8">{{ auth()->user()->name }}</div>
    </div>

    <div class="row">
        <div class="col-lg-3 col-md-4 label">Company</div>
        <div class="col-lg-9 col-md-8">{{ auth()->user()->company ?? 'N/A' }}</div>
    </div>
</div>
