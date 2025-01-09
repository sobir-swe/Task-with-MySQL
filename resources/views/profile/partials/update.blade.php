<div class="tab-pane fade profile-edit pt-3" id="profile-edit">
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row mb-3">
            <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
            <div class="col-md-8 col-lg-9">
                <img src="{{ asset('assets/img/profile-img.jpg') }}" alt="Profile">
                <div class="pt-2">
                    <input type="file" name="profile_image" class="d-none" id="profile_image">
                    <a href="#" class="btn btn-primary btn-sm" title="Upload new profile image"
                       onclick="document.getElementById('profile_image').click()">
                        <i class="bi bi-upload"></i>
                    </a>
                    <a href="#" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
            <div class="col-md-8 col-lg-9">
                <input name="name" type="text" class="form-control" id="fullName"
                       value="{{ auth()->user()->name }}">
            </div>
        </div>

        <!-- Add more form fields -->

        <div class="text-center">
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
    </form>
</div>
