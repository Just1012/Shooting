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
                        class="nav-link {{ Request::routeIs('dashboard') ? 'active' : '' }}" data-key="t-nft-landing">
                        <i class='bx bxs-dashboard'></i>
                        <span data-key="t-landing">Dashboard</span>
                    </a>
                </li>
                {{-- End Dashboard Page  --}}

                {{-- Start Home Page  --}}
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarDashboards" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class='bx bx-home'></i> <span data-key="t-dashboards">Home Page</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarDashboards">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('slider.index') }}" class="nav-link" data-key="t-one-page">Slider
                                    Section</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('editHomeSection') }}" class="nav-link" data-key="t-one-page">Home
                                    Section</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('journeyImage.index') }}" class="nav-link" data-key="t-one-page">journey Section Image</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- end Home Page -->

                {{-- Start  Pages  --}}
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#pages" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="pages">
                        <i class='bx bxs-info-circle'></i> <span data-key="t-dashboards">Pages</span>
                    </a>
                    <div class="collapse menu-dropdown" id="pages">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('editAbout') }}" class="nav-link" data-key="t-one-page">About Page</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('editService') }}" class="nav-link" data-key="t-one-page">Our Services
                                    Page</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('editIndustry') }}" class="nav-link" data-key="t-one-page">Industry
                                    Page</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('userHiring.editHiringPage') }}" class="nav-link"
                                    data-key="t-one-page">User Hiring Page</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- End Pages -->

                {{-- Start Category Page  --}}
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#category" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="category">
                        <i class='bx bx-category-alt'></i> <span data-key="t-dashboards">Category</span>
                    </a>
                    <div class="collapse menu-dropdown" id="category">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('category.index') }}" class="nav-link"
                                    data-key="t-one-page">Category
                                    List</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- end Category Page -->

                {{-- Start Brand Page  --}}
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#brand" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="brand">
                        <i class='bx bx-money-withdraw'></i> <span data-key="t-dashboards">Brand</span>
                    </a>
                    <div class="collapse menu-dropdown" id="brand">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('brand.index') }}" class="nav-link" data-key="t-one-page">Brand
                                    List</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- end Brand Page -->

                {{-- Start Partner Page  --}}
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#partner" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="partner">
                        <i class='bx bxs-user-badge'></i> <span data-key="t-dashboards">Partners</span>
                    </a>
                    <div class="collapse menu-dropdown" id="partner">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('partner.index') }}" class="nav-link"
                                    data-key="t-one-page">Partners
                                    List</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- end Partner Page -->

                {{-- Start Blog Page  --}}
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#blog" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="blog">
                        <i class='bx bx-news'></i> <span data-key="t-dashboards">Blog</span>
                    </a>
                    <div class="collapse menu-dropdown" id="blog">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('blog.index') }}" class="nav-link" data-key="t-one-page">Blog
                                    List</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- end Blog Page -->

                {{-- Start User Page  --}}
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#users" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="users">
                        <i class='bx bx-user'></i> <span data-key="t-dashboards">Users</span>
                    </a>
                    <div class="collapse menu-dropdown" id="users">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('userRegister.index') }}" class="nav-link"
                                    data-key="t-one-page">User Register List</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('userHiring.index') }}" class="nav-link"
                                    data-key="t-one-page">User Hiring & Training List</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- end User Page -->

                {{-- Start System Settings  --}}
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#systemSetting" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="systemSetting">
                        <i class='bx bx-cog'></i> <span data-key="t-dashboards">System Settings</span>
                    </a>
                    <div class="collapse menu-dropdown" id="systemSetting">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('editSystemSetup') }}" class="nav-link"
                                    data-key="t-one-page">System SetUp</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('editSystemInfo') }}" class="nav-link"
                                    data-key="t-one-page">System Info</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- end System Settings -->

            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
