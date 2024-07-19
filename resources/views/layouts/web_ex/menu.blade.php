<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="#" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('web/assets/images/logo-light.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img style="scale: 5.5 !important;" src="{{ asset('web/assets/images/logo-light.png') }}" alt=""
                    height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="#" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('web/assets/images/logo-light.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img style="scale: 5.5 !important;" src="{{ asset('web/assets/images/logo-light.png') }}" alt=""
                    height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
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

                {{-- Start Dashboard Page  --}}
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ Request::routeIs('dashboard') ? 'active' : '' }}"
                        data-key="t-nft-landing">
                        <i class='bx bxs-dashboard'></i>
                        <span data-key="t-landing">Dashboard</span>
                    </a>
                </li>
                {{-- End Dashboard Page  --}}

                {{-- Start Meals  --}}
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarDashboards" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class='bx bx-dish'></i> <span data-key="t-dashboards">Meals</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarDashboards">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="" class="nav-link" data-key="t-one-page">List</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- end Meals -->




            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
