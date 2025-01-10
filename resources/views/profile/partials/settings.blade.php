<div class="tab-pane fade pt-3" id="profile-settings">
    <form action="{{ route('profile.settings') }}" method="POST">
        @csrf
        <div class="row mb-3">
            <label class="col-md-4 col-lg-3 col-form-label">Email Notifications</label>
            <div class="col-md-8 col-lg-9">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="notify_changes"
                           id="changesMade" {{ auth()->user()->notify_changes ? 'checked' : '' }}>
                    <label class="form-check-label" for="changesMade">
                        Changes made to your account
                    </label>
                </div>
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
    </form>
</div>
