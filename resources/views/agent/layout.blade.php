<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Agent Dashboard') - iWander</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f9fafb; color: #111827; }
        .dashboard-container { display: flex; min-height: 100vh; }
        .sidebar { width: 280px; background: white; border-right: 1px solid #e5e7eb; position: fixed; left: 0; top: 0; height: 100vh; overflow-y: auto; z-index: 40; transition: transform 0.3s; }
        .sidebar.mobile-open { transform: translateX(0); }
        @media (max-width: 1024px) { .sidebar { transform: translateX(-100%); } }
        .sidebar-header { padding: 24px; border-bottom: 1px solid #e5e7eb; }
        .sidebar-logo { display: flex; align-items: center; gap: 12px; }
        .sidebar-logo svg { width: 32px; height: 32px; color: #237f87; }
        .sidebar-logo-text { font-size: 24px; font-weight: 700; color: #237f87; }
        .sidebar-nav { padding: 16px; }
        .nav-item { display: flex; align-items: center; gap: 12px; padding: 12px 16px; margin-bottom: 4px; border-radius: 8px; color: #6b7280; text-decoration: none; cursor: pointer; transition: all 0.2s; border: 0; background: transparent; width: 100%; text-align: left; }
        .nav-item:hover { background: #f3f4f6; color: #237f87; }
        .nav-item.active { background: #237f87; color: white; }
        .nav-item svg { width: 20px; height: 20px; }
        .nav-item-text { font-size: 14px; font-weight: 500; }
        .main-content { flex: 1; margin-left: 280px; transition: margin-left 0.3s; }
        @media (max-width: 1024px) { .main-content { margin-left: 0; } }
        .header { background: white; border-bottom: 1px solid #e5e7eb; padding: 16px 24px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 30; }
        .header-left { display: flex; align-items: center; gap: 16px; }
        .hamburger { display: none; background: none; border: none; cursor: pointer; padding: 8px; }
        @media (max-width: 1024px) { .hamburger { display: block; } }
        .header-title { font-size: 24px; font-weight: 700; color: #111827; }
        .header-right { display: flex; align-items: center; gap: 16px; }
        .search-container { position: relative; }
        .search-input { width: 300px; height: 40px; padding-left: 40px; padding-right: 16px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px; }
        .search-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #9ca3af; }
        .icon-button { position: relative; background: none; border: none; padding: 8px; border-radius: 8px; cursor: pointer; color: #6b7280; transition: all 0.2s; }
        .icon-button:hover { background: #f3f4f6; color: #237f87; }
        .notification-badge { position: absolute; top: 4px; right: 4px; width: 8px; height: 8px; background: #ef4444; border-radius: 50%; }
        .user-avatar { width: 40px; height: 40px; border-radius: 50%; background: #237f87; color: white; display: flex; align-items: center; justify-content: center; font-weight: 600; cursor: pointer; }
        .content { padding: 24px; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 24px; margin-bottom: 24px; }
        .stat-card, .quick-actions, .table-container, .pending-requests, .panel { background: white; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); }
        .stat-card:hover { box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); }
        .stat-card-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; }
        .stat-icon { width: 48px; height: 48px; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; }
        .stat-change { display: flex; align-items: center; gap: 4px; padding: 4px 8px; border-radius: 16px; font-size: 11px; font-weight: 600; }
        .stat-change.up { background: #dcfce7; color: #16a34a; }
        .stat-title { font-size: 13px; color: #6b7280; margin-bottom: 4px; }
        .stat-value { font-size: 28px; font-weight: 700; color: #111827; text-align: right; }
        .quick-actions-title, .table-title, .pending-requests-title { font-size: 18px; font-weight: 700; margin-bottom: 16px; }
        .actions-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 16px; }
        .action-button { display: flex; flex-direction: column; align-items: center; gap: 12px; padding: 16px; border: 2px solid #e5e7eb; border-radius: 8px; background: white; cursor: pointer; transition: all 0.2s; }
        .action-button:hover { border-color: #237f87; background: rgba(35, 127, 135, 0.05); }
        .action-icon { width: 48px; height: 48px; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; }
        .action-label { font-size: 13px; font-weight: 500; color: #4b5563; text-align: center; }
        .table-header { padding-bottom: 16px; border-bottom: 1px solid #e5e7eb; margin-bottom: 16px; }
        .table-tabs { display: flex; gap: 8px; flex-wrap: wrap; }
        .tab-button { padding: 8px 16px; border: none; border-radius: 8px; font-size: 13px; font-weight: 500; cursor: pointer; transition: all 0.2s; }
        .tab-button.active { background: #237f87; color: white; }
        .tab-button:not(.active) { background: #f3f4f6; color: #6b7280; }
        .tab-button:not(.active):hover { background: #e5e7eb; }
        .table-wrapper { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 12px 24px; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase; background: #f9fafb; border-bottom: 1px solid #e5e7eb; }
        td { padding: 16px 24px; font-size: 14px; color: #111827; border-bottom: 1px solid #f3f4f6; vertical-align: top; }
        td:nth-child(5) { text-align: right; }
        tr:hover { background: #f9fafb; }
        .status-badge { display: inline-block; padding: 4px 12px; border-radius: 16px; font-size: 12px; font-weight: 500; }
        .status-confirmed, .status-active, .status-available, .status-published, .status-done { background: #dcfce7; color: #16a34a; }
        .status-pending, .status-draft, .status-planned, .status-new { background: #fef3c7; color: #ca8a04; }
        .status-cancelled, .status-archived, .status-inactive, .status-closed { background: #fee2e2; color: #dc2626; }
        .status-vip { background: #f3e8ff; color: #7c3aed; }
        .action-buttons { display: flex; gap: 8px; flex-wrap: wrap; }
        .btn { padding: 6px 12px; border: none; border-radius: 6px; font-size: 12px; font-weight: 500; cursor: pointer; transition: all 0.2s; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; }
        .btn-view { background: #dbeafe; color: #2563eb; }
        .btn-view:hover { background: #bfdbfe; }
        .btn-edit { background: #fef3c7; color: #ca8a04; }
        .btn-edit:hover { background: #fde68a; }
        .btn-danger { background: #fee2e2; color: #dc2626; }
        .btn-danger:hover { background: #fecaca; }
        .btn-primary { background: #237f87; color: white; padding: 10px 20px; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s; }
        .btn-primary:hover { background: #1a6269; }
        .btn-secondary { background: #f3f4f6; color: #374151; padding: 10px 20px; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s; }
        .btn-secondary:hover { background: #e5e7eb; }
        .grid-2 { display: grid; grid-template-columns: 2fr 1fr; gap: 24px; }
        @media (max-width: 1024px) { .grid-2 { grid-template-columns: 1fr; } }
        @media (max-width: 640px) { .search-input { width: 200px; } .header-title { font-size: 18px; } .stats-grid { grid-template-columns: 1fr; } }
        .form-group { margin-bottom: 16px; }
        .form-label { display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 8px; }
        .form-input, .form-select, .form-textarea { width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; font-family: 'Inter', sans-serif; }
        .form-input:focus, .form-select:focus, .form-textarea:focus { outline: none; border-color: #237f87; box-shadow: 0 0 0 3px rgba(35, 127, 135, 0.1); }
        .form-textarea { resize: vertical; min-height: 100px; }
        .sidebar-footer { padding: 16px; border-top: 1px solid #e5e7eb; }
        .admin-user-card { display: flex; align-items: center; gap: 12px; margin-bottom: 12px; }
        .admin-avatar { width: 40px; height: 40px; border-radius: 50%; background: #237f87; color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; }
        .admin-user-name { font-weight: 600; }
        .admin-user-role { font-size: 12px; color: #6b7280; }
        .admin-logout { width: 100%; padding: 10px 12px; border-radius: 8px; border: 1px solid #e5e7eb; background: white; cursor: pointer; }
        .admin-logout:hover { background: #f9fafb; }
        .admin-alert { padding: 12px 16px; border-radius: 10px; margin-bottom: 16px; }
        .admin-alert.success { background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
        .admin-alert.error { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
        .panel-header { display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 16px; flex-wrap: wrap; }
        .panel-title { font-size: 24px; font-weight: 700; }
        .panel-subtitle { color: #6b7280; margin-top: 4px; }
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, 0.5); z-index: 50; align-items: center; justify-content: center; padding: 16px; }
        .modal-overlay.active { display: flex; }
        .modal { background: white; border-radius: 12px; max-width: 720px; width: 100%; max-height: 90vh; overflow-y: auto; }
        .modal-header { padding: 24px; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; justify-content: space-between; }
        .modal-title { font-size: 20px; font-weight: 700; }
        .modal-close { background: none; border: none; cursor: pointer; padding: 4px; color: #6b7280; }
        .modal-body { padding: 24px; }
        .modal-footer { padding: 24px; border-top: 1px solid #e5e7eb; display: flex; gap: 12px; justify-content: flex-end; flex-wrap: wrap; }
        .info-row { display: flex; justify-content: space-between; gap: 16px; padding: 12px 0; border-bottom: 1px solid #f3f4f6; }
        .info-label { font-size: 14px; color: #6b7280; font-weight: 500; }
        .info-value { font-size: 14px; color: #111827; font-weight: 600; text-align: right; }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9 22V12H15V22" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="sidebar-logo-text">iWander</span>
                </div>
            </div>

            <nav class="sidebar-nav">
                <a class="nav-item {{ request()->routeIs('agent.dashboard') ? 'active' : '' }}" href="{{ route('agent.dashboard') }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span class="nav-item-text">Dashboard</span>
                </a>
                <a class="nav-item {{ request()->routeIs('agent.module') && request()->route('module') === 'bookings' ? 'active' : '' }}" href="{{ route('agent.module', ['module' => 'bookings']) }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                    <span class="nav-item-text">Bookings</span>
                </a>
                <a class="nav-item {{ request()->routeIs('agent.module') && request()->route('module') === 'customers' ? 'active' : '' }}" href="{{ route('agent.module', ['module' => 'customers']) }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <span class="nav-item-text">Customers</span>
                </a>
                <a class="nav-item {{ request()->routeIs('agent.module') && request()->route('module') === 'flights' ? 'active' : '' }}" href="{{ route('agent.module', ['module' => 'flights']) }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    <span class="nav-item-text">Flights</span>
                </a>
                <a class="nav-item {{ request()->routeIs('agent.module') && request()->route('module') === 'hotels' ? 'active' : '' }}" href="{{ route('agent.module', ['module' => 'hotels']) }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <span class="nav-item-text">Hotels</span>
                </a>
                <a class="nav-item {{ request()->routeIs('agent.module') && request()->route('module') === 'packages' ? 'active' : '' }}" href="{{ route('agent.module', ['module' => 'packages']) }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                    <span class="nav-item-text">Tour Packages</span>
                </a>
                <a class="nav-item {{ request()->routeIs('agent.module') && request()->route('module') === 'reports' ? 'active' : '' }}" href="{{ route('agent.module', ['module' => 'reports']) }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    <span class="nav-item-text">Reports</span>
                </a>
                <a class="nav-item {{ request()->routeIs('agent.module') && request()->route('module') === 'settings' ? 'active' : '' }}" href="{{ route('agent.module', ['module' => 'settings']) }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span class="nav-item-text">Settings</span>
                </a>

                <div class="sidebar-footer">
                    <div class="admin-user-card">
                        <div class="admin-avatar">{{ strtoupper(substr(auth()->user()?->name ?? 'AG', 0, 2)) }}</div>
                        <div>
                            <div class="admin-user-name">{{ auth()->user()?->name ?? 'Agent User' }}</div>
                            <div class="admin-user-role">Agent Workspace</div>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="admin-logout" type="submit">Logout</button>
                    </form>
                </div>
            </nav>
        </aside>

        <main class="main-content">
            <header class="header">
                <div class="header-left">
                    <button class="hamburger" type="button" onclick="toggleSidebar()">
                        <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <div>
                        <h1 class="header-title">@yield('page_title', 'Dashboard Overview')</h1>
                        <div style="color:#6b7280;font-size:14px;">@yield('page_subtitle', 'Operational control center for the agent modules')</div>
                    </div>
                </div>

                <div class="header-right">
                    <div class="search-container">
                        <svg class="search-icon" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" class="search-input" placeholder="Search records...">
                    </div>
                    <div class="user-avatar">{{ strtoupper(substr(auth()->user()?->name ?? 'AG', 0, 2)) }}</div>
                </div>
            </header>

            <section class="content">
                @if (session('success'))
                    <div class="admin-alert success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="admin-alert error">{{ $errors->first() }}</div>
                @endif

                @yield('content')
            </section>
        </main>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('mobile-open');
        }

        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('active');
            }
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('active');
            }
        }

        document.querySelectorAll('.modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', function (event) {
                if (event.target === overlay) {
                    closeModal(overlay.id);
                }
            });
        });
    </script>
</body>
</html>
