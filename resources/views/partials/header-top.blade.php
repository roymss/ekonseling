<div class="container mx-auto px-4">  
    <nav class="flex items-center justify-between py-2 text-xs md:text-sm font-medium tracking-wide" role="navigation">         
        <div class="flex items-center space-x-6 text-emerald-100">
          <?php 
                if (!function_exists('top_menu')) {
                    function top_menu() {
                        $query = \Illuminate\Support\Facades\DB::select("SELECT id_menu, nama_menu, link, id_parent FROM menu where aktif='Ya' AND position='Top' order by urutan");
                        $menu = (object) array('items' => array(),'parents' => array());
                        foreach ($query as $menus) {
                            $menu->items[$menus->id_menu] = $menus;
                            $menu->parents[$menus->id_parent][] = $menus->id_menu;
                        }
                        if ($menu->items) {
                            $result = build_top_menu(0, $menu);
                            return $result;
                        }else{
                            return FALSE;
                        }
                    }
                }

                if (!function_exists('build_top_menu')) {
                    function build_top_menu($parent, $menu) {
                        $html = "";
                        if (isset($menu->parents[$parent])) {
                            if ($parent=='0'){
                                $html .= "<ul class='flex items-center space-x-6'>";
                            }else{
                                $html .= "<ul class='absolute left-0 hidden group-hover:block bg-slate-900 text-slate-100 shadow-xl py-2 mt-2 rounded-xl min-w-[200px] z-50 transition-all duration-200 border border-slate-800'>";
                            }
                            foreach ($menu->parents[$parent] as $itemId) {
                                if (!isset($menu->parents[$itemId])) {
                                    $linkClass = $parent == '0' ? "hover:text-emerald-300 transition-colors font-medium text-xs md:text-sm uppercase tracking-wider" : "block px-4 py-2 hover:bg-emerald-600/20 hover:text-emerald-300 transition-colors text-xs";
                                    
                                    if(preg_match("/^http/", $menu->items[$itemId]->link)) {
                                        $html .= "<li class='relative group'><a class='".$linkClass."' target='_BLANK' href='".$menu->items[$itemId]->link."'>".$menu->items[$itemId]->nama_menu."</a></li>";
                                    }else{
                                        $html .= "<li class='relative group'><a class='".$linkClass."' href='".url('/').''.$menu->items[$itemId]->link."'>".$menu->items[$itemId]->nama_menu."</a></li>";
                                    }
                                }
                                if (isset($menu->parents[$itemId])) {
                                    $linkClass = $parent == '0' ? "hover:text-emerald-300 transition-colors font-medium uppercase tracking-wider flex items-center" : "block px-4 py-2 hover:bg-emerald-600/20 hover:text-emerald-300 transition-colors text-xs flex items-center justify-between";
                                    
                                    if(preg_match("/^http/", $menu->items[$itemId]->link)) {
                                        $html .= "<li class='relative group'><a class='".$linkClass."' target='_BLANK' href='".$menu->items[$itemId]->link."'>".$menu->items[$itemId]->nama_menu." <i class='fa-solid fa-chevron-down text-[10px] ml-1.5 opacity-75'></i></a>";
                                    }else{
                                        $html .= "<li class='relative group'><a class='".$linkClass."' href='".url('/').''.$menu->items[$itemId]->link."'>".$menu->items[$itemId]->nama_menu." <i class='fa-solid fa-chevron-down text-[10px] ml-1.5 opacity-75'></i></a>";
                                    }
                                    $html .= build_top_menu($itemId, $menu);
                                    $html .= "</li>";
                                }
                            }
                            $html .= "</ul>";
                        }
                        return $html;
                    }
                }
                echo top_menu();
            ?>
        </div>

        <ul class="flex items-center space-x-3 text-xs">
            @if (session()->has('level') && in_array(session('level'), ['inovator', 'user', 'admin', 'psikolog']))
                @php
                    if (session('level') == 'admin') {
                        $dashUrl = url('/admin/home');
                        $logoutUrl = url('/admin/logout');
                    } elseif (session('level') == 'psikolog') {
                        $dashUrl = url('/psikolog/chat');
                        $logoutUrl = url('/user/logout');
                    } else {
                        $dashUrl = url('/user/profile');
                        $logoutUrl = url('/user/logout');
                    }
                @endphp
                <li>
                    <a class='inline-flex items-center space-x-1.5 bg-emerald-700/80 hover:bg-emerald-600 text-white font-medium px-3.5 py-1 rounded-full border border-emerald-500/30 transition-all shadow-sm' href='{{ $dashUrl }}'>
                        <i class="fa-solid fa-user-gear text-emerald-300 text-xs"></i>
                        <span>DASHBOARD</span>
                    </a>
                </li>
                <li>
                    <a class='inline-flex items-center space-x-1 bg-red-600/80 hover:bg-red-500 text-white font-medium px-3.5 py-1 rounded-full border border-red-400/30 transition-all shadow-sm' href='{{ $logoutUrl }}'>
                        <i class="fa-solid fa-right-from-bracket text-xs"></i>
                        <span>LOGOUT</span>
                    </a>
                </li>
            @else
                <li>
                    <a class='inline-flex items-center space-x-1.5 bg-white/10 hover:bg-white/20 text-emerald-100 font-medium px-3.5 py-1 rounded-full border border-white/10 hover:border-emerald-300/40 transition-all' href='{{ url('/user/login') }}'>
                        <i class="fa-solid fa-right-to-bracket text-emerald-300 text-xs"></i>
                        <span>MASUK</span>
                    </a>
                </li>
                <li>
                    <a class='inline-flex items-center space-x-1.5 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold px-3.5 py-1 rounded-full transition-all shadow-sm hover:shadow-emerald-500/20' href='{{ url('/user/pendaftaran') }}'>
                        <i class="fa-solid fa-user-plus text-xs"></i>
                        <span>DAFTAR</span>
                    </a>
                </li>
            @endif
        </ul>
    </nav>
</div>