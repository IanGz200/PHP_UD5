<!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="<?php echo $_ENV['HOST.FOLDER'] ?>" class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['HOST.FOLDER'] . 'inicio' ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Inicio
              </p>
            </a>
          </li> 
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item <?php echo (in_array($_SERVER['REQUEST_URI'], [$_ENV['HOST.FOLDER'] . 'demo-proveedores'])) ? 'menu-open' : '';?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Panel de control
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo $_ENV['HOST.FOLDER'] ?>demo-proveedores" class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['HOST.FOLDER'] . 'demo-proveedores' ? 'active' : ''; ?>">
                  <i class="fas fa-laptop-code nav-icon"></i>
                  <p>Demo Proveedores</p>
                </a>
              </li>              
            </ul>
              <ul class="nav nav-treeview">
                  <li class="nav-item">
                      <a href="<?php echo $_ENV['HOST.FOLDER'] ?>ejercicio1"
                         class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['HOST.FOLDER'] . 'ejercicio1' ? 'active' : ''; ?>">
                          <i class="fas fa-laptop-code nav-icon"></i>
                          <p>Ejercicio 1</p>
                      </a>
                  </li>
              </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->