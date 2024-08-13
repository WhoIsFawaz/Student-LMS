<div class="d-flex align-items-center justify-content-center w-100 bg-body" style="height: 100vh;">
    <div class="d-none d-md-block">  
        <div class="align-items-center p-5 shadow-lg rounded-5 border" style="max-width: 600px;">
            <div class="m-4">
                {{ $slot }}
            </div>
            
        </div>
    </div>
    <div class="d-md-none w-100">
        <div class="align-items-center p-5">
            {{ $slot }}
        </div>
    </div>
</div>