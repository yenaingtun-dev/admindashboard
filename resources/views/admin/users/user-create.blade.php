@extends('layouts.app')
@section('content')
<div class="col">
      <div class="container px-5">
            <h1>Create User</h1>
            <div class="container">
                  <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                              <label for="name" class="form-label">Name</label>
                              <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="mb-3">
                              <label for="email" class="form-label">Email</label>
                              <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="mb-3">
                              <label for="password" class="form-label">Password</label>
                              <input type="password" class="form-control" id="password" name="password">
                        </div>
                        @if ($roles)
                              @foreach ($roles as $role)
                                    <div class="mb-3">
                                          <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}" id="{{ $role->title }}">
                                                <label class="form-check-label" for="{{ $role->title }}">
                                                      {{ $role->title }}
                                                </label>
                                          </div>
                                    </div>
                              @endforeach
                        @endif
                        <div class="form-group mb-3">
                              <div class="needsclick dropzone" id="profileImagesPathDropzone">
                              </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
                  </form>
            </div>
      </div>
</div>
@endsection

@section('scripts')
<script>
      // profile image image
      profileImageDocumentMap = [];
      var profileImagesPathDropzone = new Dropzone("#profileImagesPathDropzone", {
            url: "{{ route('users.store_media') }}",
            maxFilesize: 2, // MB
            addRemoveLinks: true,
            headers: {
                  'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function(file, response) {
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
            removedfile: function(file) {
                  var allPreviews = document.querySelectorAll(".dz-preview");
                  allPreviews.forEach(function(previewElement) {
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
            init: function() {}
      });
       // remove media
    function removeMedia(file_name, type) {
            $.ajax({
                type: 'POST',
                url: "{{ route('users.remove_media') }}",
                data: {
                    'file_name': file_name,
                    'type': type,
                    'model_id': {!! auth()->user()->id !!},
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