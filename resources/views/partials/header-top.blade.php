<div class="container mx-auto px-4">  
    <nav class="flex items-center justify-between py-2 text-sm" role="navigation">         
        <div class="flex items-center space-x-6">
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
                                $html .= "<ul class='absolute left-0 hidden group-hover:block bg-white text-gray-800 shadow-lg py-2 mt-2 rounded-md min-w-[200px] z-50 transition-all duration-200 border border-gray-100'>";
                            }
                            foreach ($menu->parents[$parent] as $itemId) {
                                if (!isset($menu->parents[$itemId])) {
                                    $linkClass = $parent == '0' ? "hover:text-green-300 transition-colors font-medium" : "block px-4 py-2 hover:bg-green-50 hover:text-green-600 transition-colors text-sm";
                                    
                                    if(preg_match("/^http/", $menu->items[$itemId]->link)) {
                                        $html .= "<li class='relative group'><a class='".$linkClass."' target='_BLANK' href='".$menu->items[$itemId]->link."'>".$menu->items[$itemId]->nama_menu."</a></li>";
                                    }else{
                                        $html .= "<li class='relative group'><a class='".$linkClass."' href='".url('/').''.$menu->items[$itemId]->link."'>".$menu->items[$itemId]->nama_menu."</a></li>";
                                    }
                                }
                                if (isset($menu->parents[$itemId])) {
                                    $linkClass = $parent == '0' ? "hover:text-green-300 transition-colors font-medium flex items-center" : "block px-4 py-2 hover:bg-green-50 hover:text-green-600 transition-colors text-sm flex items-center justify-between";
                                    
                                    if(preg_match("/^http/", $menu->items[$itemId]->link)) {
                                        $html .= "<li class='relative group'><a class='".$linkClass."' target='_BLANK' href='".$menu->items[$itemId]->link."'>".$menu->items[$itemId]->nama_menu." <i class='fa-solid fa-chevron-down text-[10px] ml-1.5'></i></a>";
                                    }else{
                                        $html .= "<li class='relative group'><a class='".$linkClass."' href='".url('/').''.$menu->items[$itemId]->link."'>".$menu->items[$itemId]->nama_menu." <i class='fa-solid fa-chevron-down text-[10px] ml-1.5'></i></a>";
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

        <ul class="flex items-center space-x-6 font-medium">
            @if (session('level') == 'inovator')
                <li><a class='hover:text-green-300 transition-colors' href='{{ url('/user/profile') }}'>DASHBOARD</a></li>
                <li><a class='hover:text-green-300 transition-colors' href='{{ url('/user/logout') }}'>LOGOUT</a></li>
            @else
                <li><a class='hover:text-green-300 transition-colors' href='{{ url('/user/login') }}'>LOGIN</a></li>
                <li><a class='hover:text-green-300 transition-colors' href='{{ url('/user/pendaftaran') }}'>REGISTER</a></li>
            @endif
        </ul>
    </nav>
</div>