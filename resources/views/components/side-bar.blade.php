<div class="d-flex">
    <!-- Sidebar -->
    <div class="bg-dark text-white vh-100 p-3" id="sidebar">
        <h4>Menu</h4>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link text-white">
                    <i class="fas fa-home"></i>
                    <span class="ms-2 text-capitalize">home</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('contacts.index') }}" class="nav-link text-white">
                    <i class="fas fa-home"></i>
                    <span class="ms-2 text-capitalize">contatos</span>
                </a>
            </li>

            @can('admin')
                <li class="nav-item">
                    <a href="{{ route('users') }}" class="nav-link text-white">
                        <i class="fas fa-home"></i>
                        <span class="ms-2 text-capitalize">usuários</span>
                    </a>
                </li>
            @endcan
        </ul>
    </div>
</div>
