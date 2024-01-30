 <div class="vertical-menu">
     <div data-simplebar class="h-100">
         <div id="sidebar-menu">
             <ul class="metismenu list-unstyled" id="side-menu">
                 <li class="menu-title" key="t-menu">Menu</li>
                 <li>
                     <a href="{{ route('dashboard') }}" class="waves-effect">
                         <i class="bx bx-home-circle"></i><span class="badge rounded-pill bg-info float-end">DAMKAR
                             </span>
                         <span key="t-dashboards">Dashboards</span>
                     </a>
                 </li>
                 <li class="menu-title" key="t-apps">Apps</li>
                                 
                 <li>
                    <a href="{{ route('piket.index') }}" class="waves-effect">
                        <i class="bx bx-user-circle"></i>
                        <span key="t-calendar">Kelompok Piket</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('anggota.index') }}" class="waves-effect">
                        <i class="bx bx-user-circle"></i>
                        <span key="t-calendar">Anggota</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('jadwal_piket.index') }}" class="waves-effect">
                        <i class="bx bx-user-circle"></i>
                        <span key="t-calendar">Jadwal Piket</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('absensi_piket.index') }}" class="waves-effect">
                        <i class="bx bx-user-circle"></i>
                        <span key="t-calendar">Absen Piket</span>
                    </a>
                </li>
             </ul>
         </div>
     </div>
 </div>
