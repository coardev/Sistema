<div class="sidebar">
            <nav class="sidebar-nav">
                <ul class="nav">
                    <li @click="menu=0" class="nav-item">
                        <a class="nav-link active" href="#"><i class="icon-speedometer"></i>Rancho Alegre</a>
                    </li>
                    <li class="nav-title">
                        Opciones del Sistema
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-bag"></i>Inventario</a>
                        <ul class="nav-dropdown-items">
                       
                            <li @click="menu=15" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-bag"></i>Artículos</a>
                            </li>
                            <li @click="menu=1" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-bag"></i>Categorías</a>
                            </li>
                          
                           
                        </ul>
                    </li>
                    </ul>
            </nav>
            <button class="sidebar-minimizer brand-minimizer" type="button"></button>
        </div>