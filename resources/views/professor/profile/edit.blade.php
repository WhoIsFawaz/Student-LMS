<x-layout>
    <livewire:professor.sidebar :currentPage=ProfessorSidebarLink::ModuleMeetings>
    <div class="viewport-container container-fluid p-0">
        @livewire('professor.module-header', ['currentPage' => 'Profile'])

        <div class="p-4">
            <div class="d-flex">
                <div class="me-auto">
                    <ul class="nav nav-pills flex-scroll-x gap-2 p-1 small bg-body-secondary rounded-5 mb-3 me-3" id="profile-tab"
                        role="tablist">
                        <li class="nav-item d-inline-block" role="presentation">
                            <a id="tab-profile" class="nav-link rounded-5 active" data-bs-toggle="tab"
                                href="#folder-profile" role="tab" aria-controls="folder-profile"
                                aria-selected="true">Profile</a>
                        </li>
                        <li class="nav-item d-inline-block" role="presentation">
                            <a id="tab-password" class="nav-link rounded-5" data-bs-toggle="tab"
                                href="#folder-password" role="tab" aria-controls="folder-password"
                                aria-selected="false">Password</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-content" id="folderTab">
                <div class="tab-pane fade show active" id="folder-profile"
                    role="tabpanel" aria-labelledby="tab-profile">
                    @include('professor.profile.partials.update-profile-information-form')
                </div>
                <div class="tab-pane fade" id="folder-password"
                    role="tabpanel" aria-labelledby="tab-password">
                    @include('professor.profile.partials.update-password-form')
                </div>
            </div>
        </div>
    </div>
</x-layout>
