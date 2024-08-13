<div class="">
    <div class="">
        @if ($fileType === PreviewFileTypes::Word)
            <iframe src='https://view.officeapps.live.com/op/embed.aspx?src={{ urlencode($fileUrl) }}' width="100%" class="border rounded"></iframe>
        @elseif ($fileType === PreviewFileTypes::PowerPoint)
            <iframe src="https://view.officeapps.live.com/op/embed.aspx?src={{ urlencode($fileUrl) }}" width="100%" class="border rounded"></iframe>
        @elseif ($fileType === PreviewFileTypes::Video)
            <video controls class="border rounded w-100">
                <source src="{{ $fileUrl }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        @elseif ($fileType === PreviewFileTypes::PDF)
            <iframe src="{{ url($fileUrl) }}" width="100%" style="height: 900px;" class="border rounded"></iframe>
        @elseif ($fileType === PreviewFileTypes::Image)
            <img src="{{ $fileUrl }}" alt="Image Preview" style="max-width: 100%; height: 900px;" class="border rounded">
        @else
            <p>Unable to preview.</p>
        @endif
        <div>
            @if ($fileType !== PreviewFileTypes::NotAFile)
                <a href="{{ $fileUrl }}" download class="btn btn-primary mt-1">
                    Download File
                </a>
            @endif
        </div>
    </div>
</div>