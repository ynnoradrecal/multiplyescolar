<div class="col-md-3 left_col">

  <div class="left_col scroll-view">

    <div class="navbar nav_title text-center" style="border: 0;">

      <a href="{{ url('admin/painel') }}" class="site_title"><span>Multiply Escolar</span></a>

    </div>



    <div class="clearfix"></div>



    <!-- menu profile quick info -->

    <div class="profile clearfix">

      <div class="profile_pic">

        <img src="{{ url('') . $user->foto }}" alt="..." class="img-circle profile_img">

      </div>

      <div class="profile_info">

        <span>Bem vindo,</span>

        <h2>{{ $user->nome }}</h2>

      </div>

    </div>

    <!-- /menu profile quick info -->



    <br />



    <!-- sidebar menu -->

    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

      <div class="menu_section">

        <ul class="nav side-menu">

          <li><a href="{{ url('admin/painel') }}"><i class="fa fa-home"></i> Painel </a>

          </li>

          <li><a><i class="fa fa-credit-card"></i> Vendas <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li><a href="{{ url('admin/sales/order') }}">Pedidos</a></li>
              <!-- <li class=""><a>Relatório<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu" style="display: none;">
                  <li><a href="{{ url('admin/sales/aband-cart') }}">Carrinhos Abandonados</a>
                  <li><a href="{{ url('admin/relatorio/visitas') }}">Visitas</a>
                  </li>
                </ul>
              </li> -->
            </ul>
          </li>

          <li><a href="{{ url('admin/accounts') }}"><i class="fa fa-users"></i> Contas </a></li>

          <li><a href="{{ url('admin/events') }}"><i class="fa fa-cube"></i> Eventos </a></li>
          
          <li><a><i class="fa fa-bullhorn"></i> Promoções <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li><a href="{{ url('admin/promocoes/cupom') }}">Cupom de Desconto</a></li>
            </ul>
          </li>

          <li><a><i class="fa fa-edit"></i> Catálogo <span class="fa fa-chevron-down"></span></a>

            <ul class="nav child_menu">

              <li><a href="{{ url('admin/catalogo/politica') }}">Politicas</a></li>

              <li><a href="{{ url('admin/catalogo/produtos') }}">Galeria</a></li>

              <li><a href="{{ url('admin/catalogo/fotos') }}">Fotos</a></li>

            </ul>

          </li>

          <li><a><i class="fa fa-puzzle-piece"></i> Módulos <span class="fa fa-chevron-down"></span></a>

            <ul class="nav child_menu">

              <li><a href="{{ url('admin/developer') }}">Developer</a></li>

              <li><a href="{{ url('admin/delivery-methods') }}">Entregas</a></li>

              <li><a href="{{ url('admin/payment-methods') }}">Pagamentos</a></li>

              <li><a href="{{ url('admin/loja') }}">Loja</a></li>

            </ul>

          </li>

          <li><a><i class="fa fa-gears"></i> Configurações <span class="fa fa-chevron-down"></span></a>

            <ul class="nav child_menu">

              <li><a href="{{ url('admin/administrativo/usuario') }}" class="">Usuário</a></li>

            

            </ul>

          </li>

        </ul>

      </div>

    </div>

    <!-- /sidebar menu -->

  </div>

</div>



<!-- top navigation -->

<div class="top_nav">

  <div class="nav_menu">

    <nav>

      <div class="nav toggle">

        <a id="menu_toggle"><i class="fa fa-bars"></i></a>

      </div>



      <ul class="nav navbar-nav navbar-right">

        <li class="">

          <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">

            <img src="{{ url('') . $user->foto }}" alt="">{{ $user->nome }}

            <span class=" fa fa-angle-down"></span>

          </a>

          <ul class="dropdown-menu dropdown-usermenu pull-right">

            <li><a href="javascript:;"> Perfil</a></li>

            <li><a href="{{ url('admin/login/out') }}"><i class="fa fa-sign-out pull-right"></i> Sair</a></li>

          </ul>

        </li>



        <li role="presentation" class="dropdown">

          <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">

            <i class="fa fa-envelope-o"></i>

            <span class="badge bg-blue">6</span>

          </a>

          <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">

            @for ($i = 0; $i < 4; $i++)

            <li>

              <a>

                <span class="image"><img src="{{ asset('images/yoshio.jpg') }}" alt="Profile Image" /></span>

                <span>

                  <span>João da Silva</span>

                  <span class="time">3 Março 2017</span>

                </span>

                <span class="message">

                  Film festivals used to be do-or-die moments for movie makers. They were where...

                </span>

              </a>

            </li>

            @endfor

            <li>

              <div class="text-center">

                <a>

                  <strong>Visualizar Todos</strong>

                </a>

              </div>

            </li>

          </ul>

        </li>

      </ul>

    </nav>

  </div>

</div>

<!-- /top navigation -->

