<header class="app-header navbar">
    <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
        <img class="navbar-brand-full" src="{{asset('storage/logos/'.config('logo_b_image'))}}" height="25" alt="Square Logo">
        <img class="navbar-brand-minimized" src="{{asset('storage/logos/'.config('logo_popup'))}}" height="30" alt="Square Logo">
    </a>
    <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
        <span class="navbar-toggler-icon"></span>
    </button>

    <ul class="nav navbar-nav d-md-down-none">

        <!-- <li class="nav-item px-3">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
        </li> -->

        <li class="nav-item px-3">
            <a class="nav-link" href="{{ route('frontend.index') }}"><i class="icon-home"></i> Home</a>
        </li>
        <li class="nav-item px-3">
            <a class="nav-link" href="{{asset('courses')}}" target="_blank">Courses</a>
        </li>
        <li class="nav-item px-3">
            <a class="nav-link" href="{{asset('contact')}}" target="_blank">Contact</a>
        </li>
        <li class="nav-item px-3">
            <a class="nav-link" href="{{asset('about-us')}}" target="_blank">About Us</a>
        </li>

        <li class="nav-item px-3 dropdown">

            <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <span class="d-md-down-none"> Online Resources </span>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{asset('faqs')}}" target="_blank">FAQS</a>
                <a class="dropdown-item" href="{{asset('blog')}}" target="_blank">Reference Materials</a>
            </div>
        </li>
        <li class="nav-item px-3 dropdown">
            <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <span class="d-md-down-none"> Directory of Expertise </span>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{asset('teachers')}}" target="_blank">Subject Matter Experts / Instructional Designers</a>
                <a class="dropdown-item" href="{{asset('expertise?type=0')}}" target="_blank">Core Group of Specialist (CGS)</a>
                <a class="dropdown-item" href="{{asset('expertise?type=1')}}" target="_blank">Social Welfare and Development Learning Network (SWDLNet)</a>
            </div>
        </li>
        <li class="nav-item px-3">
            <a class="nav-link" href="{{asset('events')}}" target="_blank">Events</a>
        </li>

    </ul>

    <ul class="nav navbar-nav ml-auto mr-4">
        <li class="nav-item d-md-down-none">
            <a class="nav-link" data-toggle="dropdown" href="#" r ole="button" aria-haspopup="true" aria-expanded="false">
                <i class="icon-bell"></i>
                <span class="badge badge-pill d-none badge-success unreadNotificationCounter"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" width="100px">
                <div class="dropdown-header text-center">
                    <strong>Notification</strong>
                </div>
                <div id="readNotification" class="unreadMessages">
                    <p class="mb-0 text-center py-2">No Notification</p>
                </div>
            </div>
        </li>
        <li class="nav-item d-md-down-none">
            <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="icon-envelope"></i>
                <span class="badge badge-pill d-none badge-success unreadMessageCounter" id="countNotif"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-header text-center">
                    <strong>@lang('navs.general.messages')</strong>
                </div>
                <div class="unreadMessages">
                    <p class="mb-0 text-center py-2">@lang('navs.general.no_messages')</p>
                </div>
            </div>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <img src="{{ $logged_in_user->picture }}" class="img-avatar" alt="{{ $logged_in_user->email }}">
                <span style="right: 0;left: inherit" class="badge d-md-none d-lg-none d-none mob-notification badge-success">!</span>
                <span class="d-md-down-none">{{ $logged_in_user->full_name }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-header text-center">
                    <strong>@lang('navs.general.account')</strong>
                </div>

                <a class="dropdown-item" href="{{route('admin.messages')}}">
                    <i class="fa fa-envelope"></i> @lang('navs.general.messages')
                    <span class="badge unreadMessageCounter d-none badge-success">5</span>
                </a>

                <a class="dropdown-item" href="{{ route('admin.account') }}">
                    <i class="fa fa-user"></i> @lang('navs.general.profile')
                </a>

                <div class="divider"></div>
                <a class="dropdown-item" href="{{ route('frontend.auth.logout') }}">
                    <i class="fas fa-lock"></i> @lang('navs.general.logout')
                </a>
            </div>
        </li>
    </ul>

    {{--<button class="navbar-toggler aside-menu-toggler d-md-down-none" type="button" data-toggle="aside-menu-lg-show">--}}
    {{--<span class="navbar-toggler-icon"></span>--}}
    {{--</button>--}}
    {{--<button class="navbar-toggler aside-menu-toggler d-lg-none" type="button" data-toggle="aside-menu-show">--}}
    {{--<span class="navbar-toggler-icon"></span>--}}
    {{--</button>--}}
</header>




@push('after-scripts')
<script>
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            var notification_count = 0;
            const NOTIFICATION_TYPES = {
                enroll_course: 'App\\Notifications\\EnrollNotification'
            };
            $.ajax({
                type: "GET",
                url: "{{route('admin.messages.notification')}}",
                success: function(response) {
                    showNotifications(response, "#readNotification")
                },
            });

            function showNotifications(notifications, target) {

                if (notifications.length) {
                    var htmlElements = notifications.map(function(notification) {
                        if (notification.read_at == null) {
                            notification_count += 1;
                        }
                        return makeNotification(notification);
                    });
                    if (notification_count > 0) {
                        $('.unreadNotificationCounter').html(notification_count);
                        $('.unreadNotificationCounter').removeClass('d-none');
                    } else {
                        $('.unreadNotificationCounter').addClass('d-none');
                    }
                    $(target).html(htmlElements.join(''));
                    $(target).addClass('has-notifications')
                } else {
                    $(target).html('<li class="dropdown-header">No notifications</li>');
                    $(target).removeClass('has-notifications');
                }
            }

            function makeNotification(notification) {
                var to = routeNotification(notification);
                var notificationText = makeNotificationText(notification);
                return `<a class = "dropdown-item"  href = "${to}" >
                <i class = "icon-info" > </i>
                ${notificationText}</a>`;
            }

            // get the notification route based on it's type
            function routeNotification(notification) {
                var to = '?read=' + notification.id;
                if (notification.type === NOTIFICATION_TYPES.enroll_course) {
                    to = 'user/notification' + to;
                }
                return '/' + to;
            }

            // get the notification text based on it's type
            function makeNotificationText(notification) {
                var text = '';
                if (notification.type === NOTIFICATION_TYPES.enroll_course) {
                    var name = notification.data.data.title;
                    var body = notification.data.data.body;
                    // text += `<a class = "dropdown-item"  href = "#" >`
                    text += name
                }
                return text;
            }
        });
    });
</script>
@endpush