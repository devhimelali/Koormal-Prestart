<div class="navbar-header">
    <div class="d-flex">
        <!-- LOGO -->
        <div class="navbar-brand-box horizontal-logo">
            <a href="{{ route('redirect') }}" class="logo logo-dark">
                <span class="logo-sm">
                    <img src="{{ asset('assets/logos/4emus-logo.png') }}" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="{{ asset('assets/logos/4emus-logo.png') }}" alt="" height="22">
                </span>
            </a>

            <a href="{{ route('redirect') }}" class="logo logo-light">
                <span class="logo-sm">
                    <img src="{{ asset('assets/logos/4emus-logo.png') }}" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="{{ asset('assets/logos/4emus-logo.png') }}" alt="" height="22">
                </span>
            </a>
        </div>

        <button type="button" class="px-3 shadow-none btn btn-sm fs-16 header-item vertical-menu-btn topnav-hamburger"
                id="topnav-hamburger-icon">
            <span class="hamburger-icon">
                <span></span>
                <span></span>
                <span></span>
            </span>
        </button>
    </div>

    <div class="d-flex align-items-center">
        <div class="ms-1 header-item d-none d-sm-flex">
            <button type="button" class="btn btn-icon btn-topbar btn-ghost-dark rounded-circle"
                    data-toggle="fullscreen">
                <i class='bi bi-arrows-fullscreen fs-lg'></i>
            </button>
        </div>

        <div class="dropdown topbar-head-dropdown ms-1 header-item">
            <button type="button" class="btn btn-icon btn-topbar btn-ghost-dark rounded-circle mode-layout"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="align-middle bi bi-sun fs-3xl"></i>
            </button>
            <div class="p-2 dropdown-menu dropdown-menu-end" id="light-dark-mode">
                <a href="#!" class="dropdown-item" data-mode="light"><i class="align-middle bi bi-sun me-2"></i>
                    Default (light mode)</a>
                <a href="#!" class="dropdown-item" data-mode="dark"><i class="align-middle bi bi-moon me-2"></i>
                    Dark</a>
                <a href="#!" class="dropdown-item" data-mode="auto"><i
                        class="align-middle bi bi-moon-stars me-2"></i> Auto (system default)</a>
            </div>
        </div>

        <div class="dropdown ms-sm-3 header-item topbar-user">
            <button type="button" class="shadow-none btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                <span class="d-flex align-items-center">
                    <img class="rounded-circle header-profile-user" src="{{ asset('assets/images/avatar-icon.png') }}"
                         alt="Header Avatar">
                    <span class="text-start ms-xl-2">
                        <span
                            class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ auth()->user()->name }}</span>
                        <span
                            class="d-none d-xl-block ms-1 fs-sm user-name-sub-text">{{ ucfirst(auth()->user()->roles->pluck('name')->first()) }}</span>
                    </span>
                </span>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <!-- item-->
                <h6 class="dropdown-header">Welcome {{ auth()->user()->name }}!</h6>
                <a class="dropdown-item"
                   href="{{ route('profile.show', auth()->user()->roles->pluck('name')->first()) }}"><i
                        class="align-middle mdi mdi-account-circle text-muted fs-lg me-1"></i> <span
                        class="align-middle">Profile</span></a>
                <form action="{{ route('logout') }}" method="post" class="dropdown-item" id="logoutForm">
                    @csrf
                    <i class="align-middle mdi mdi-logout text-muted fs-lg me-1"></i>
                    <button type="submit" class="logoutBtn">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    .logoutBtn {
        background: transparent;
        border: none;
        margin-left: -6px;
    }
</style>
<script>
    $(document).ready(function () {
        $('#logoutForm').on('submit', function (e) {
            e.preventDefault();
            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('logout') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    notify('success', 'Logged out successfully');
                    setTimeout(() => {
                        window.location.href = "{{ route('login') }}";
                    }, 1000);
                },
                error: function (xhr, status, error) {
                    notify('error', error);
                }
            });
        });
    });
</script>
