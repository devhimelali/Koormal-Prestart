<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="{{ route('admin.dashboard') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('assets/logos/4emus-logo.png') }}" alt="logo" height="36">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/logos/4emus-logo.png') }}" alt="" height="36">
            </span>
        </a>
        <a href="{{ route('admin.dashboard') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('assets/logos/4emus-logo.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/logos/4emus-logo.png') }}" alt="" height="22">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-3xl header-item float-end btn-vertical-sm-hover"
                id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">

                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                       class="nav-link menu-link @if (Route::current()->getName() == 'admin.dashboard') active @endif"
                       aria-expanded="false">
                        <i class="ph-gauge"></i>
                        <span data-key="t-dashboard">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('shifts.index') }}"
                       class="nav-link menu-link @if (Route::current()->getName() == 'shifts.index') active @endif"
                       aria-expanded="false">
                        <i class="ph ph-calendar"></i>
                        <span data-key="t-shifts">Shifts</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('shift-rotations.edit') }}"
                       class="nav-link menu-link @if (Route::current()->getName() == 'shift-rotations.edit') active @endif"
                       aria-expanded="false">
                        <i class="ph ph-arrows-clockwise"></i>
                        <span data-key="t-shift-rotations">Shift Rotations</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('rosters.index') }}"
                       class="nav-link menu-link @if (Route::current()->getName() == 'rosters.index') active @endif"
                       aria-expanded="false">
                        <i class="ph ph-clipboard-text"></i>
                        <span data-key="t-roster-list">Roster List</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('cross-criteria.index') }}"
                       class="nav-link menu-link @if (Route::current()->getName() == 'cross-criteria.index') active @endif"
                       aria-expanded="false">
                        <i class="ph ph-x"></i>
                        <span data-key="t-cross-criteria">Cross Criteria</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('fatality-risk-controls.index') }}"
                       class="nav-link menu-link @if (Route::current()->getName() == 'fatality-risk-controls.index') active @endif"
                       aria-expanded="false">
                        <i class="ph ph-warning"></i>
                        <span data-key="t-fatality-risk-controls">Fatality Risk Controls</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)"
                       id="siteCommunicationBtn"
                       class="nav-link menu-link @if (Route::current()->getName() == 'site-communications.index') active @endif"
                       aria-expanded="false">
                        <i class="ph ph-chat-circle-dots"></i>
                        <span data-key="t-site-communications">Site Communications</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>

<script>
    $(document).ready(function () {
        $('#siteCommunicationBtn').on('click', function () {
            Swal.fire({
                title: 'Select Shift Type',
                icon: 'question',
                html: `
                    <button class="swal2-confirm btn-option btn btn-sm btn-primary" data-value="day_shift">Day Shift</button>
                    <button class="swal2-confirm btn-option btn btn-sm btn-secondary" data-value="night_shift">Night Shift</button>
                  `,
                showConfirmButton: false,
                didOpen: () => {
                    document.querySelectorAll('.btn-option').forEach(button => {
                        button.addEventListener('click', () => {
                            const selected = button.getAttribute('data-value');
                            Swal.close();

                            if (selected === 'day_shift') {
                                window.location.href = "{{ route('site-communications.index', ['shift_type' => 'day_shift']) }}";
                            } else if (selected === 'night_shift') {
                                window.location.href = "{{ route('site-communications.index', ['shift_type' => 'night_shift']) }}";
                            }
                        });
                    });
                }
            });
        });
    });
</script>


