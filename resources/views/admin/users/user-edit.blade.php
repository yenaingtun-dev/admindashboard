@extends('layouts.app') @section('content')
<div class="col">
    <div class="container px-5">
        <h1>Edit User</h1>
        <div class="container">
            <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name" name="name"
                        value="{{ old('name', $user->name) }}" />
                    @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email" name="email"
                        value="{{ old('email', $user->email) }}" />
                    @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" id="password" name="password"
                        value="{{ old('password', $user->password) }}" />
                    @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                @if ($roles)
                    <div class="mb-3">
                        @foreach ($roles as $role)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}" id="{{ $role->title }}"
                                @if (\App\Helpers\helper\helper::hasRole($role->id, $user->roles)) checked @endif>
                                <label class="form-check-label" for="{{ $role->title }}">
                                        {{ $role->title }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                @endif
                <div class="form-group mb-3">
                    <div class="needsclick dropzone {{ $errors->has('profile_image_path') ? 'is-invalid' : '' }}" id="profileImagesPathDropzone"></div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection @section('scripts')
<script>
    // profile image image
    profileImageDocumentMap = [];
    var profileImagesPathDropzone = new Dropzone("#profileImagesPathDropzone", {
        url: "{{ route('users.store_media') }}",
        maxFilesize: 2,
        maxFiles: 1,
        addRemoveLinks: true,
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        success: function (file, response) {
            $(file.previewElement).find('.dz-error-message').text('You cannot upload any more files');
            for (let i = 0; i < profileImagesPathDropzone.files.length; i++) {
                const file = profileImagesPathDropzone.files[i];
                if (i >= 1) {
                    file.previewElement.classList.add('dz-error');
                }
            }
            $('form').append('<input type="hidden" name="profile_image_path" value="' + response.name + '">')
            profileImageDocumentMap[file.name] = response.name
        },
        removedfile: function (file) {
            var allPreviews = document.querySelectorAll(".dz-preview");
            allPreviews.forEach(function (previewElement) {
                previewElement.classList.remove("dz-error");
            });
            $(file.previewElement).find('.dz-error-message').text('You cannot upload any more files');
            for (let i = 0; i < profileImagesPathDropzone.files.length; i++) {
                const file = profileImagesPathDropzone.files[i];
                if (i >= 1) {
                    file.previewElement.classList.add('dz-error');
                }
            }
            swal({
                title: "Are you sure you want to remove this image?",
                text: "If you remove this, it will be delete from data.",
                icon: "warning",
                type: "warning",
                buttons: ["Cancel", "Remove!"],
                confirmButtonColor: '#FF0000',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((willDelete) => {
                if (willDelete) {
                    file.previewElement.remove()
                    var name = ''
                    if (typeof file.file_name !== 'undefined') {
                        name = file.file_name
                    } else {
                        name = profileImageDocumentMap[file.name]
                    }
                    $('form').find('input[name="profile_image_path"][value="' + name + '"]').remove()
                    removeMedia(file.name, 'profile_image_path')
                }
            });
        },
        init: function () { }
    });
    // Loop through imagePaths and add images to Dropzone
    var imagePath = {!! json_encode($user->profile_image_path) !!};
    if (imagePath) {
        var mockFile = {
            name: imagePath,
            size: 5,
            accepted: true
        };
        profileImagesPathDropzone.emit("addedfile", mockFile);
        profileImagesPathDropzone.emit("thumbnail", mockFile, imagePath);
        profileImagesPathDropzone.emit("complete", mockFile);
        profileImagesPathDropzone.files.push(mockFile);
    }
    // remove media
    function removeMedia(file_name, type) {
            $.ajax({
                type: 'POST',
                url: "{{ route('users.remove_media') }}",
                data: {
                    'file_name': file_name,
                    'type': type,
                    'model_id': {!! $user->id !!},
                },
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(data) {
                    console.log('success');
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }
</script>
@endsection