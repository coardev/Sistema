<div class="sidebar">
            <nav class="sidebar-nav">
                <ul class="nav">
                    <li @click="menu=0" class="nav-item">
                        <a class="nav-link active" href="#"><i class="icon-speedometer"></i>Rancho Alegre </a>
                    </li>
                    <li align="center" class="nav-title">
                        Opciones del Sistema
                    </li>
                    <li align="center" @click="menu=6" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-notebook"></i>Clientes</a>
                            </li>
                            
                          
                            <li style="background-color:#29363D; border-color:#29363D;border-radius:0; color:white" id="myBtn" align="center" @click="menu=17" class="nav-item">
                                <a  class="nav-link" href="#"><i class="icon-user-following"></i>Realizar Venta</a>
                               
                                </li>

                            

                            

                            <li align="center" @click="menu=19" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-notebook"></i>Cancelacion Venta Articulo</a>
                            </li>

                            <li align="center" @click="menu=23" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-notebook"></i>Realizar Venta Interna (Inventario Interno)</a>
                            </li>

                            <li align="center" @click="menu=24" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-notebook"></i>Detalle Salida Inventario Interno</a>
                            </li>
                            
                            
                        
                   
            </nav>
            <button class="sidebar-minimizer brand-minimizer" type="button"></button>
        </div>
       