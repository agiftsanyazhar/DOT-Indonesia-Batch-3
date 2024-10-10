<div class="sidebar-menu">
    <ul class="menu">

        <li class="sidebar-item {{ request()->is('dashboard/artikel*') ? 'active' : '' }}">
            <a href="{{ route('dashboard.article.index') }}" class="sidebar-link">
                <i class="bi bi-journal"></i>
                <span>Artikel</span>
            </a>
        </li>

    </ul>
</div>