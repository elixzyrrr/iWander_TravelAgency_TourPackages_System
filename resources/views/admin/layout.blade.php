<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - iWander</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Gwendolyn:wght@700&display=swap" rel="stylesheet">
    @vite(['resources/css/admin.css', 'resources/js/app.js'])
    <style>
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 3000;
            background: rgba(2, 6, 23, 0.55);
            align-items: center;
            justify-content: center;
            padding: 16px;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal {
            width: 100%;
            max-width: 640px;
            background: #ffffff;
            border-radius: 14px;
            box-shadow: 0 24px 60px rgba(2, 6, 23, 0.28);
        }

        .modal-header,
        .modal-body,
        .modal-footer {
            padding-left: 20px;
            padding-right: 20px;
        }

        .modal-header {
            padding-top: 20px;
            padding-bottom: 12px;
        }

        .modal-body {
            padding-top: 8px;
            padding-bottom: 10px;
        }

        .modal-footer {
            padding-top: 12px;
            padding-bottom: 20px;
        }

        .logout-modal {
            max-width: 420px;
            padding: 18px;
        }

        .logout-modal .modal-body {
            color: #475467;
        }

        .logout-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }

        .logout-cancel-btn,
        .logout-confirm-btn {
            border: 1px solid transparent;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .logout-cancel-btn {
            background: #f8fafc;
            color: #334155;
            border-color: #dbe1ea;
        }

        .logout-cancel-btn:hover {
            background: #eef2f7;
        }

        .logout-confirm-btn {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: #ffffff;
            box-shadow: 0 8px 18px rgba(220, 38, 38, 0.25);
        }

        .logout-confirm-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 22px rgba(220, 38, 38, 0.3);
        }
    </style>
</head>
<body>
    <div class="admin-shell">
        <aside class="admin-sidebar">
            <div class="admin-brand">
                <div class="admin-brand-mark">
                    <svg viewBox="0 0 61 47" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" style="color: var(--admin-primary);">
                        <path d="M6 24L55 6L33 41L28 27L6 24Z" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M28 27L55 6" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <div>
                        <div class="admin-brand-name">iWander</div>
                        <span class="admin-badge">ADMIN</span>
                    </div>
                </div>
            </div>

            <nav class="admin-nav">
                <div class="admin-nav-group">
                    <div class="admin-nav-label">Overview</div>
                    <a class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <span>Dashboard</span>
                    </a>
                </div>

                <div class="admin-nav-group">
                    <div class="admin-nav-label">Management</div>
                    <a class="admin-nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <span>Users</span>
                    </a>
                    <a class="admin-nav-link {{ request()->routeIs('admin.authentication*') ? 'active' : '' }}" href="{{ route('admin.authentication') }}">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        <span>Authentication</span>
                    </a>
                </div>

                <div class="admin-nav-group">
                    <div class="admin-nav-label">Settings</div>
                    <a class="admin-nav-link {{ request()->routeIs('admin.system*') ? 'active' : '' }}" href="{{ route('admin.system') }}">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>System Config</span>
                    </a>
                    <a class="admin-nav-link {{ request()->routeIs('admin.financial*') ? 'active' : '' }}" href="{{ route('admin.financial') }}">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Financial</span>
                    </a>
                </div>

                <div class="admin-nav-group">
                    <div class="admin-nav-label">Reports</div>
                    <a class="admin-nav-link {{ request()->routeIs('admin.analytics*') ? 'active' : '' }}" href="{{ route('admin.analytics') }}">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        <span>Analytics</span>
                    </a>
                </div>
            </nav>

            <div class="admin-sidebar-footer">
                <div class="admin-user-card">
                    <div class="admin-avatar">AD</div>
                    <div>
                        <div class="admin-user-name">Admin User</div>
                        <div class="admin-user-role">System Admin</div>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="admin-logout" type="submit">Logout</button>
                </form>
            </div>
        </aside>

        <main class="admin-main">
            <header class="admin-topbar">
                <div>
                    <h1 class="admin-page-title">@yield('page_title', 'Dashboard')</h1>
                    <div class="admin-topbar-subtitle">@yield('page_subtitle', 'Operational control center for the admin modules')</div>
                </div>
                <div class="admin-toolbar">
                    <span class="admin-pill">{{ now()->format('M d, Y') }}</span>
                </div>
            </header>

            <section class="admin-content">
                @if (session('success'))
                    <div class="admin-alert success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="admin-alert error">
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                @yield('content')
            </section>
        </main>
    </div>

    <!-- Logout confirmation modal -->
    <div id="logout-modal" class="modal-overlay" style="display:none; align-items:center; justify-content:center;">
        <div class="modal logout-modal">
            <div class="modal-header">
                <div>
                    <h3 class="modal-title">Confirm Logout</h3>
                </div>
            </div>
            <div class="modal-body">
                Are you sure you want to logout from this session?
            </div>
            <div class="modal-footer logout-actions">
                <button type="button" class="logout-cancel-btn" onclick="closeLogoutModal()">Cancel</button>
                <button type="button" class="logout-confirm-btn" id="confirm-logout-btn">Logout</button>
            </div>
        </div>
    </div>
    <!-- Settings modal -->
    <div id="settings-modal" class="modal-overlay" style="display:none; align-items:center; justify-content:center;">
        <div class="modal" style="max-width:520px; padding:18px;">
            <div class="modal-header">
                <div>
                    <h3 class="modal-title">Settings</h3>
                </div>
                <button type="button" class="modal-close" onclick="document.getElementById('settings-modal').classList.remove('active')">Close</button>
            </div>
            <div class="modal-body">Settings content goes here.</div>
            <div class="modal-footer" style="display:flex; gap:8px; justify-content:flex-end;">
                <button type="button" class="btn-secondary" onclick="document.getElementById('settings-modal').classList.remove('active')">Close</button>
                <button type="button" class="btn-primary" onclick="alert('Save settings - implement later');">Save</button>
            </div>
        </div>
    </div>

    <!-- About modal -->
    <div id="about-modal" class="modal-overlay" style="display:none; align-items:center; justify-content:center;">
        <div class="modal" style="max-width:520px; padding:18px;">
            <div class="modal-header">
                <div>
                    <h3 class="modal-title">About</h3>
                </div>
                <button type="button" class="modal-close" onclick="document.getElementById('about-modal').classList.remove('active')">Close</button>
            </div>
            <div class="modal-body">iWander admin panel — version info and credits.</div>
            <div class="modal-footer" style="display:flex; gap:8px; justify-content:flex-end;">
                <button type="button" class="btn-secondary" onclick="document.getElementById('about-modal').classList.remove('active')">Close</button>
            </div>
        </div>
    </div>

    <script>
        (function () {
            function bindAdminLogout() {
                const modal = document.getElementById('logout-modal');
                const confirmBtn = document.getElementById('confirm-logout-btn');
                const form = document.querySelector('form[action="{{ route('logout') }}"]');

                if (!modal || !confirmBtn || !form || form.dataset.adminLogoutBound === '1') {
                    return;
                }

                form.dataset.adminLogoutBound = '1';

                function openLogoutModal() {
                    modal.style.display = 'flex';
                    modal.classList.add('active');
                }

                function closeLogoutModal() {
                    modal.style.display = 'none';
                    modal.classList.remove('active');
                }

                window.closeLogoutModal = closeLogoutModal;

                form.addEventListener('submit', function (event) {
                    if (form.dataset.logoutConfirmed === '1') {
                        return;
                    }

                    event.preventDefault();
                    openLogoutModal();
                });

                confirmBtn.addEventListener('click', function () {
                    form.dataset.logoutConfirmed = '1';
                    closeLogoutModal();
                    form.submit();
                });

                modal.addEventListener('click', function (event) {
                    if (event.target === modal) {
                        closeLogoutModal();
                    }
                });
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', bindAdminLogout);
            } else {
                bindAdminLogout();
            }
        })();
    </script>
</body>
</html>
