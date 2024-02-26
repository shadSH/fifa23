<div >

    <div class="mb-3">
        <label class="form-label">File Name</label>
        <input type="text" class="form-control" value="{{ $file->file_name ?? "" }}" disabled>
    </div>
    <div class="mb-3">
        <label class="form-label">File Type</label>
		<input type="text" class="form-control" value="{{ $file->type ?? ""}}" disabled>
	</div>
    <div class="mb-3">
        <label class="form-label">File Size</label>
		<input type="text" class="form-control" value="{{ formatBytes($file->file_size)  }}" disabled>
	</div>
    <div class="mb-3">
        <label class="form-label">Updated By</label>
		<input type="text" class="form-control" value="{{ $file->User->name ?? ""}}" disabled>
	</div>
    <div class="mb-3">
        <label class="form-label">Updated At</label>
		<input type="text" class="form-control" value="{{ $file->created_at ?? ""}}" disabled>
	</div>

    <div class="mb-3 text-center">
        @php
            if($file->file_original_name == null){
                $file_name = ('Unknown');
            }else{
                $file_name = $file->file_original_name;
            }
        @endphp
        <a class="btn btn-secondary" href="{{ my_asset($file->file_name) }}" target="_blank" download="{{ $file_name }}.{{ $file->extension }}">{{ ('Download') }}</a>
    </div>
</div>
