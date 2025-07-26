<!doctype html>
<html lang="en" data-layout="vertical" data-sidebar="dark" data-sidebar-size="lg" data-preloader="disable"
    data-theme="default" data-topbar="light" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <title>@yield('title') - {{ env('APP_NAME') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ env('APP_DESCRIPTION') }}" name="description">
    <meta content="{{ env('APP_NAME') }}" name="author">
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- Fonts css load -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link id="fontsLink"
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet">

    <!-- Layout config Js -->
    <script src="{{ asset('assets/js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/libs/toastr/toastr.min.css') }}">
    @yield('vendor-css')
    @yield('page-css')
</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <!-- ========== App Menu ========== -->
        <div class="app-menu navbar-menu">
            <!-- LOGO -->
            <div class="navbar-brand-box">
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
                <button type="button" class="p-0 btn btn-sm fs-3xl header-item float-end btn-vertical-sm-hover"
                    id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>

            <div id="scrollbar">
                @hasrole('admin')
                    @include('admin.partials.sidebar')
                @endhasrole
                @hasrole('user')
                    @include('user.partials.sidebar')
                @endhasrole
                <!-- Sidebar -->
            </div>

            <div class="sidebar-background"></div>
        </div>
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>
        <header id="page-topbar">
            <div class="layout-width">
                @include('layouts.partials.topbar')
            </div>
        </header>
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div><!--end row-->
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        @include('layouts.partials.footer')
    </div>
    <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->
    <!--start back-to-top-->
    <button class="btn btn-dark btn-icon" id="back-to-top">
        <i class="bi bi-caret-up fs-3xl"></i>
    </button>
    <!--end back-to-top-->

    <!--preloader-->
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <div id="loader"
        style="display: none; position: fixed; top: 50%; left: 50%;
    transform: translate(-50%, -50%); z-index: 1051; background-color: rgba(208,208,208,0.3); width: 100% ; height: 100%;">
        <div class="d-flex justify-content-center align-items-center h-100">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    {{-- <div class="customizer-setting d-none d-md-block">
    <div class="p-2 shadow-lg btn btn-info text-uppercase rounded-end-0" data-bs-toggle="offcanvas"
         data-bs-target="#theme-settings-offcanvas" aria-controls="theme-settings-offcanvas">
        <i class="mb-1 bi bi-gear"></i> Customizer
    </div>
</div> --}}

    <!-- Theme Settings -->
    @include('layouts.partials.theme-setting')

    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/toastr/toastr.min.js') }}"></script>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                notify('error', "{{ $error }}");
            </script>
        @endforeach
    @endif
    @stack('scripts')
    <script>

        let lightboxInstance;

        function initGlightbox() {
            if (lightboxInstance && typeof lightboxInstance.destroy === 'function') {
                lightboxInstance.destroy();
            }

            lightboxInstance = GLightbox({
                selector: '.glightbox'
            });
        }

        document.addEventListener('DOMContentLoaded', initGlightbox);

        @if (Session::has('success'))
            notify('success', "{{ session('success') }}");
        @elseif (Session::has('error'))
            notify('error', "{{ Session::get('error') }}");
        @elseif (Session::has('warning'))
            notify('warning', "{{ Session::get('warning') }}");
        @elseif (Session::has('info'))
            notify('info', "{{ Session::get('info') }}");
        @endif

        @foreach (session('toasts', collect())->toArray() as $toast)
            const options = {
                title: '{{ $toast['title'] ?? '' }}',
                message: '{{ $toast['message'] ?? 'No message provided' }}',
                position: '{{ $toast['position'] ?? 'topRight' }}',
            };
            show('{{ $toast['type'] ?? 'info' }}', options);
        @endforeach

        function notify(type, msg, position = 'toast-bottom-right') {
            if (['success', 'info', 'warning', 'error'].includes(type)) {
                toastr.options = {
                    closeButton: true,
                    positionClass: position,
                    progressBar: true
                };
                toastr[type](msg);
            } else {
                console.error(`Invalid toastr type: ${type}`);
            }
        }

        function show(type, options) {
            if (['info', 'success', 'warning', 'error'].includes(type)) {
                toastr[type](options);
            } else {
                toastr.show(options);
            }
        }

        function resetCkEditors() {
            if (window.editors) {
                Object.values(window.editors).forEach(editor => {
                    editor.setData('');
                });
            }
        }

        function ajaxBeforeSend(formSelector, buttonSelector) {
            $(formSelector).find('.is-invalid').removeClass('is-invalid');
            $(buttonSelector).prop('disabled', true);
            $(buttonSelector).html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...'
            );
        }

        function handleAjaxErrors(xhr, status, error) {
            switch (xhr.status) {
                case 400:
                    notify('error',
                        xhr.responseJSON.message ||
                        'The request could not be processed due to invalid input. Please review your data and try again.'
                    );
                    break;
                case 401:
                    notify('error', 'Your session has expired or you are not logged in. Please log in to continue.');
                    break;
                case 403:
                    notify('error',
                        'You do not have permission to perform this action. Please contact your administrator if you believe this is an error.'
                    );
                    break;
                case 404:
                    notify('error', );
                    message = 'The requested resource could not be found. It may have been moved or deleted.';
                    break;
                case 422:
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        notify('error', value);
                        let input = $('[name="' + key + '"]');
                        input.addClass('is-invalid');
                        if (input.closest('.auth-pass-inputgroup').length) {
                            input.closest('.auth-pass-inputgroup').find('.invalid-feedback').text(value);
                        } else {
                            input.next('.invalid-feedback').text(value);
                        }
                    });
                    break;
                case 429:
                    notify('error', 'Too many requests. Please try again later.');
                    break;
                case 500:
                    notify('error',
                        'An unexpected server error occurred. Please try again later or contact support if the issue persists.'
                    );
                    break;
                case 0:
                    notify('error',
                        'Network connection lost or server is unreachable. Please check your internet connection and try again.'
                    );
                    break;
                default:
                    notify('error', 'An unknown error occurred. Please try again or contact support.');
                    break;
            }
        }

        function ajaxComplete(buttonSelector, defaultText = 'Save') {
            $(buttonSelector).prop('disabled', false);
            $(buttonSelector).html(defaultText);
        }

        function openDynamicFormModal({
            title,
            action,
            method = 'POST',
            fields = [],
            modalId = 'addOrEditShiftModal',
            formId = 'shiftAddForm'
        }) {
            // Set modal title and form config
            $(`#${modalId} .modal-title`).text(title);
            $(`#${formId}`).attr('action', action);
            $(`#${formId} #method`).val(method);

            const container = $(`#${modalId} #formFieldsContainer`);
            container.empty();

            // Loop through fields and generate HTML
            fields.forEach(field => {
                const {
                    type = 'text',
                        label = '',
                        name,
                        value = '',
                        required = false,
                        placeholder = '',
                        options = [],
                        checked = false,
                        multiple = false,
                        data = {}
                } = field;

                const requiredAttr = required ? 'required' : '';
                const requiredStar = required ? '<span class="text-danger">*</span>' : '';
                const dataAttrs = Object.entries(data)
                    .map(([key, val]) => `data-${key}="${val}"`)
                    .join(' ');

                let inputHtml = '';

                switch (type) {
                    case 'textarea':
                        inputHtml = `
                    <div class="mb-2">
                        <label for="${name}" class="form-label">${label} ${requiredStar}</label>
                        <textarea name="${name}" id="${name}" class="form-control" placeholder="${placeholder}" ${requiredAttr} ${dataAttrs}>${value}</textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                `;
                        break;

                    case 'select':
                        let optionHtml = options.map(opt => {
                            const {
                                value: optValue,
                                label: optLabel,
                                data: optData = {}
                            } = opt;

                            const isSelected = optValue == value ? 'selected' : '';
                            const optionDataAttrs = Object.entries(optData)
                                .map(([k, v]) => `data-${k}="${v}"`)
                                .join(' ');

                            return `<option value="${optValue}" ${isSelected} ${optionDataAttrs}>${optLabel}</option>`;
                        }).join('');

                        inputHtml = `
                    <div class="mb-2">
                        <label for="${name}" class="form-label">${label} ${requiredStar}</label>
                        <select name="${name}" id="${name}" class="form-select" ${multiple ? 'multiple' : ''} ${requiredAttr} ${dataAttrs}>
                            ${optionHtml}
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                `;
                        break;

                    case 'checkbox':
                    case 'radio':
                        inputHtml = `
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="${type}" name="${name}" id="${name}" ${checked ? 'checked' : ''} ${requiredAttr} ${dataAttrs}>
                        <label class="form-check-label" for="${name}">
                            ${label} ${requiredStar}
                        </label>
                        <div class="invalid-feedback"></div>
                    </div>
                `;
                        break;

                    default:
                        inputHtml = `
                    <div class="mb-2">
                        <label for="${name}" class="form-label">${label} ${requiredStar}</label>
                        <input type="${type}" name="${name}" id="${name}" class="form-control"
                            value="${value}" placeholder="${placeholder}"
                            ${multiple && type === 'file' ? 'multiple' : ''}
                            ${requiredAttr} ${dataAttrs}>
                        <div class="invalid-feedback"></div>
                    </div>
                `;
                        break;
                }

                container.append(inputHtml);
            });

            // Ensure wrapper exists inside container
            if ($(`#${modalId} .dynamic-wrapper`).length === 0) {
                const wrapper = `<div class="mb-2 dynamic-wrapper"></div>`;
                container.append(wrapper);
            }

            // Show modal
            $(`#${modalId}`).modal('show');
        }
    </script>
    <!-- App js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
    @yield('vendor-script')
    @yield('page-script')

</body>

</html>
