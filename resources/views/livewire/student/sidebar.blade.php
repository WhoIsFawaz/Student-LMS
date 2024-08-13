<div class="viewport-container sidebar offcanvas-lg offcanvas-start bg-body-secondary border-end d-flex flex-column" tabindex="-1"
    id="sidebar" aria-labelledby="sidebarLabel" style="min-height: 100vh">
    <div class="border-bottom">
        <a href="/" class="d-flex align-items-center py-4 px-4 link-dark text-decoration-none">
            <img id="logo-light" class="d-none" src="{{ $logoLightUrl }}" alt="Logo" height="45">
            <img id="logo-dark" class="d-none" src="{{ $logoDarkUrl }}" alt="Logo" height="45">
            <div class="d-flex align-items-center">
                <span class="h5 ms-3 mb-0 text-body">
                    {{ $universityName }}
                </span>
            </div>
        </a>
    </div>
    <div class="flex-grow-1 offcanvas-body">
        <ul class="list-unstyled flex-column overflow-auto mb-auto mt-4 px-3">
            <li class="mb-1">
                <a href="{{ route('student.dashboard') }}"
                    class="btn btn-lg btn-sidebar fw-medium {{ $currentPage === StudentSidebarLink::Dashboard ? 'sidebar-active' : '' }} d-flex text-start">
                    <i class="bi bi-house-door me-2"></i>
                    Dashboard
                </a>
            </li>
            <li class="mx-3 mt-3 mb-1">
                <span class="text-body-secondary">Modules</span>
            </li>

            @forelse($modules as $module)
                <li class="mb-1 heading">
                    <button
                        class="btn btn-lg btn-toggle btn-sidebar fw-medium {{ $currentModule == $module->module_id ? '' : 'collapsed' }} d-flex text-start"
                        data-bs-toggle="collapse" data-bs-target="#collapse-{{ $loop->index }}"
                        aria-expanded="{{ $currentModule == $module->module_id ? 'true' : 'false' }}">
                        <i class="bi bi-chevron-down me-2"></i>
                        {{ $module->module_name }}
                    </button>
                    <div class="{{ $currentModule == $module->module_id ? 'collapse show' : 'collapse' }}"
                        id="collapse-{{ $loop->index }}">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li>
                                <a href="{{ route('modules.student.content.index', ['module_id' => $module->module_id]) }}"
                                    class="{{ $currentPage === StudentSidebarLink::ModuleContent && $currentModule == $module->module_id ? 'sidebar-active' : '' }} text-body rounded btn-sidebar">
                                    Content
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('modules.student.assignments.index', ['module_id' => $module->module_id]) }}"
                                    class="{{ $currentPage === StudentSidebarLink::ModuleAssignment && $currentModule == $module->module_id ? 'sidebar-active' : '' }} text-body rounded btn-sidebar">
                                    Assignments
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('modules.student.news.index', ['module_id' => $module->module_id]) }}"
                                    class="{{ $currentPage === StudentSidebarLink::ModuleNews && $currentModule == $module->module_id ? 'sidebar-active' : '' }} text-body rounded btn-sidebar">
                                    News
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('modules.student.quizzes.index', ['module_id' => $module->module_id]) }}"
                                    class="{{ $currentPage === StudentSidebarLink::ModuleQuiz && $currentModule == $module->module_id ? 'sidebar-active' : '' }} text-body rounded btn-sidebar">
                                    Quizzes
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('modules.student.meetings.index', ['module_id' => $module->module_id]) }}"
                                    class="{{ $currentPage === StudentSidebarLink::ModuleMeetings && $currentModule == $module->module_id ? 'sidebar-active' : '' }} text-body rounded btn-sidebar">
                                    Meetings
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @empty
                <p class="p-3">No modules pinned.</p>
            @endforelse
        </ul>
    </div>
    <div class="">
        <div class="dropdown border-top p-4 mt-4 w-100">
            <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle"
                id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ $userProfileUrl }}" alt="" width="32" height="32"
                    class="rounded-circle me-2">
                <span class="text-body">{{ $userName }}</span>
            </a>
            <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                <li><a class="dropdown-item" href="{{ route('student.profile.edit') }}">Settings</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="dropdown-item" type="submit">Sign out</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>

<script>
    const logoLight = document.getElementById('logo-light');
    const logoDark = document.getElementById('logo-dark');

    updateTheme = function() {
        const theme = getTheme();
        if (theme === 'dark') {
            logoLight?.classList.add('d-none');
            logoDark?.classList.remove('d-none');
        } else {
            logoLight?.classList.remove('d-none');
            logoDark?.classList.add('d-none');
        }
    }
</script>
