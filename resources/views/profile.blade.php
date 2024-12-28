
<form method="POST" enctype="multipart/form-data" >
    <div>
        <label class="label">
            <span class="text-base label-text">Name</span>
        </label>
        <input name="name" type="text" value="{{ auth()->user()->name }}" class="w-full input input-bordered" /><br>
    </div>
    <div>
        <label class="label">
            <span class="text-base label-text">Email</span>
        </label>
        <input name="email" type="text" value="{{ auth()->user()->email }}" class="w-full input input-bordered" />
    </div>
    <div class="mt-6">
        <button type="submit" class="btn btn-block">Save Profile</button>
    </div>
</form>
