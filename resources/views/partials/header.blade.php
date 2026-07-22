<div class="container mx-auto px-4" x-data="{ mobileMenuOpen: false }">                          
    <nav class="flex items-center justify-between py-4" role="navigation">
        <div class="flex items-center justify-between w-full md:w-auto">
            <?php 
                $logo = \Illuminate\Support\Facades\DB::table('logo')->orderBy('id_logo', 'DESC')->skip(0)->take(1)->get();
                foreach ($logo as $row) {
                    echo "<a class='block' href='".url('/')."'><img class='h-12' src='".url('/')."/asset/logo/$row->gambar' alt='Logo'/></a>";
                }
            ?>
            <!-- Mobile Menu Button -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-gray-600 hover:text-green-600 focus:outline-none">
                <i class="fa-solid fa-bars text-2xl"></i>
            </button>
        </div>
        
        <!-- Desktop Menu / Mobile Dropdown -->
        <div :class="{'block': mobileMenuOpen, 'hidden': !mobileMenuOpen}" class="absolute md:relative top-full left-0 w-full md:w-auto bg-white md:bg-transparent shadow-lg md:shadow-none border-b md:border-none border-gray-100 md:flex items-center z-50">
            <?php 
                if (!function_exists('main_menu')) {
                    function main_menu() {
                        $query = \Illuminate\Support\Facades\DB::select("SELECT id_menu, nama_menu, link, id_parent FROM menu where aktif='Ya' AND position='Bottom' order by urutan");
                        $menu = (object) array('items' => array(),'parents' => array());
                        foreach ($query as $menus) {
                            $menu->items[$menus->id_menu] = $menus;
                            $menu->parents[$menus->id_parent][] = $menus->id_menu;
                        }
                        if ($menu->items) {
                            $result = build_main_menu(0, $menu);
                            return $result;
                        }else{
                            return FALSE;
                        }
                    }
                }

                if (!function_exists('build_main_menu')) {
                    function build_main_menu($parent, $menu) {
                        $html = "";
                        if (isset($menu->parents[$parent])) {
                            if ($parent=='0'){
                                $html .= "<ul class='flex flex-col md:flex-row md:space-x-8 px-4 md:px-0 py-4 md:py-0 font-medium text-gray-700'>";
                            }else{
                                $html .= "<ul class='md:absolute left-0 hidden md:group-hover:block bg-white/90 backdrop-blur-sm text-gray-800 md:shadow-xl py-2 md:mt-4 md:rounded-lg min-w-[200px] z-50 md:border md:border-gray-100 ml-4 md:ml-0 transition-all duration-300 opacity-0 md:group-hover:opacity-100 transform translate-y-2 md:group-hover:translate-y-0'>";
                            }
                            foreach ($menu->parents[$parent] as $itemId) {
                                if (!isset($menu->parents[$itemId])) {
                                    $linkClass = $parent == '0' ? "block py-2 md:py-0 font-semibold text-gray-700 hover:text-green-600 transition-all duration-300 uppercase text-sm relative after:content-[''] after:absolute after:w-full after:scale-x-0 after:h-0.5 after:-bottom-1 after:left-0 after:bg-green-600 after:origin-bottom-right after:transition-transform after:duration-300 group-hover:after:scale-x-100 group-hover:after:origin-bottom-left" : "block px-4 py-2 text-gray-600 hover:bg-green-50 hover:text-green-600 hover:pl-6 transition-all duration-300 text-sm font-medium";
                                    
                                    if(preg_match("/^http/", $menu->items[$itemId]->link)) {
                                        $html .= "<li class='relative group'><a class='".$linkClass."' target='_BLANK' href='".$menu->items[$itemId]->link."'>".$menu->items[$itemId]->nama_menu."</a></li>";
                                    }else{
                                        $html .= "<li class='relative group'><a class='".$linkClass."' href='".url($menu->items[$itemId]->link)."'>".$menu->items[$itemId]->nama_menu."</a></li>";
                                    }
                                }
                                if (isset($menu->parents[$itemId])) {
                                    $linkClass = $parent == '0' ? "block py-2 md:py-0 font-semibold text-gray-700 hover:text-green-600 transition-all duration-300 uppercase text-sm flex items-center justify-between md:justify-start relative after:content-[''] after:absolute after:w-full after:scale-x-0 after:h-0.5 after:-bottom-1 after:left-0 after:bg-green-600 after:origin-bottom-right after:transition-transform after:duration-300 group-hover:after:scale-x-100 group-hover:after:origin-bottom-left" : "block px-4 py-2 text-gray-600 hover:bg-green-50 hover:text-green-600 hover:pl-6 transition-all duration-300 text-sm font-medium flex items-center justify-between";
                                    
                                    if(preg_match("/^http/", $menu->items[$itemId]->link)) {
                                        $html .= "<li class='relative group'><a class='".$linkClass."' target='_BLANK' href='".$menu->items[$itemId]->link."'>".$menu->items[$itemId]->nama_menu." <i class='fa-solid fa-chevron-down text-[10px] ml-1.5'></i></a>";
                                    }else{
                                        $html .= "<li class='relative group'><a class='".$linkClass."' href='".url($menu->items[$itemId]->link)."'>".$menu->items[$itemId]->nama_menu." <i class='fa-solid fa-chevron-down text-[10px] ml-1.5'></i></a>";
                                    }
                                    $html .= build_main_menu($itemId, $menu);
                                    $html .= "</li>";
                                }
                            }
                            $html .= "</ul>";
                        }
                        return $html;
                    }
                }
                echo main_menu();
            ?>
        </div>
    </nav>
</div>