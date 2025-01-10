<div class="tab-pane fade pt-3" id="profile-change-password">
    <form action="{{ route('profile.password') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row mb-3">
            <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
            <div class="col-md-8 col-lg-9">
                <input name="current_password" type="password" class="form-control" id="currentPassword">
            </div>
        </div>

        <div class="row mb-3">
            <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
            <div class="col-md-8 col-lg-9">
                <input name="password" type="password" class="form-control" id="newPassword">
            </div>
        </div>

        <div class="row mb-3">
            <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
            <div class="col-md-8 col-lg-9">
                <input name="password_confirmation" type="password" class="form-control" id="renewPassword">
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">Change Password</button>
        </div>
    </form>
</div>
