<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar" data-sidebarbg="skin6">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="sidebar-item @if ( Session::get('page') === 'dashboard' ) selected @endif"> 
                    <a class="sidebar-link sidebar-link @if ( Session::get('page') === 'dashboard' ) active @endif"
                        href="{{ route('dashboard') }}" aria-expanded="false">
                        <i data-feather="home" class="feather-icon"></i>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <li class="list-divider"></li>
                <li class="nav-small-cap">
                    <span class="hide-menu">Management</span>
                </li>
                <li class="sidebar-item @if ( Session::get('page') === 'forms' ) selected @endif"> 
                    <a class="sidebar-link has-arrow" href="javascript:void(0)"
                        aria-expanded="false">
                        <i data-feather="file-text" class="feather-icon"></i>
                        <span class="hide-menu">Forms </span>
                    </a>
                    <ul aria-expanded="false" class="collapse  first-level base-level-line">
                        <li class="sidebar-item @if ( Session::get('sub_page') === 'list' ) active @endif">
                            <a href="{{ route('formsets') }}" class="sidebar-link">
                                <span
                                    class="hide-menu"> All Forms
                                </span>
                            </a>
                        </li>
                        <li class="sidebar-item @if ( Session::get('sub_page') === 'add' ) active @endif">
                            <a href="{{ route('formset-add') }}" class="sidebar-link">
                                <span
                                    class="hide-menu"> Add New +
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                        aria-expanded="false"><i data-feather="users" class="feather-icon"></i><span
                            class="hide-menu">Accounts </span></a>
                    <ul aria-expanded="false" class="collapse  first-level base-level-line">
                        <li class="sidebar-item"><a href="#" class="sidebar-link"><span
                                    class="hide-menu"> All Accounts
                                </span></a>
                        </li>
                        <li class="sidebar-item"><a href="#" class="sidebar-link"><span
                                    class="hide-menu"> Managers
                                </span></a>
                        </li>
                        <li class="sidebar-item"><a href="#" class="sidebar-link"><span
                                    class="hide-menu">
                                    Supervisors
                                </span></a>
                        </li>
                        <li class="sidebar-item"><a href="table-layout-coloured.html" class="sidebar-link"><span
                                    class="hide-menu">
                                    Operators
                                </span></a>
                        </li>
                    </ul>
                </li>
                <li class="list-divider"></li>
                <li class="sidebar-item"> 
                    <a class="sidebar-link sidebar-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <i data-feather="log-out" class="feather-icon"></i>
                        <span class="hide-menu">Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>