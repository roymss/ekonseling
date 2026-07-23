<div class="container mx-auto px-4" x-data="{ mobileMenuOpen: false }">                          
    <nav class="flex items-center justify-between py-3.5" role="navigation">
        <div class="flex items-center justify-between w-full md:w-auto">
            <?php 
                $logo = \Illuminate\Support\Facades\DB::table('logo')->orderBy('id_logo', 'DESC')->skip(0)->take(1)->get();
                foreach ($logo as $row) {
                    echo "<a class='block hover:opacity-95 transition-opacity' href='".url('/')."'><img class='h-11 md:h-12 w-auto object-contain' src='".url('/')."/asset/logo/$row->gambar' alt='Logo'/></a>";
                }
            ?>
            <!-- Mobile Menu Button -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-slate-700 hover:text-emerald-600 focus:outline-none p-2 rounded-lg hover:bg-emerald-50 transition-colors">
                <i class="fa-solid fa-bars text-xl" x-show="!mobileMenuOpen"></i>
                <i class="fa-solid fa-xmark text-xl" x-show="mobileMenuOpen" style="display:none;"></i>
            </button>
        </div>
        
        <!-- Desktop Menu / Mobile Dropdown -->
        <div :class="{'block': mobileMenuOpen, 'hidden': !mobileMenuOpen}" class="absolute md:relative top-full left-0 w-full md:w-auto bg-white/95 md:bg-transparent shadow-xl md:shadow-none border-b md:border-none border-slate-100 md:flex items-center space-y-4 md:space-y-0 md:space-x-6 z-50 p-4 md:p-0 transition-all duration-300">
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
                                $html .= "<ul class='flex flex-col md:flex-row md:items-center md:space-x-7 px-2 md:px-0 py-2 md:py-0 font-medium text-slate-700 text-sm'>";
                            }else{
                                $html .= "<ul class='md:absolute left-0 hidden md:group-hover:block bg-white/95 backdrop-blur-md text-slate-800 md:shadow-2xl py-3 md:mt-3 md:rounded-2xl min-w-[220px] z-50 md:border md:border-emerald-100 ml-4 md:ml-0 transition-all duration-300 opacity-0 md:group-hover:opacity-100 transform translate-y-2 md:group-hover:translate-y-0'>";
                            }
                            foreach ($menu->parents[$parent] as $itemId) {
                                if (!isset($menu->parents[$itemId])) {
                                    $linkClass = $parent == '0' ? "block py-2.5 md:py-1 font-semibold text-slate-700 hover:text-emerald-600 transition-all duration-200 uppercase tracking-wide text-xs md:text-sm relative after:content-[''] after:absolute after:w-full after:scale-x-0 after:h-0.5 after:-bottom-1 after:left-0 after:bg-emerald-600 after:origin-bottom-right after:transition-transform after:duration-300 group-hover:after:scale-x-100 group-hover:after:origin-bottom-left" : "block px-4 py-2 text-slate-600 hover:bg-emerald-50 hover:text-emerald-600 hover:pl-6 transition-all duration-200 text-xs font-medium";
                                    
                                    if(preg_match("/^http/", $menu->items[$itemId]->link)) {
                                        $html .= "<li class='relative group'><a class='".$linkClass."' target='_BLANK' href='".$menu->items[$itemId]->link."'>".$menu->items[$itemId]->nama_menu."</a></li>";
                                    }else{
                                        $html .= "<li class='relative group'><a class='".$linkClass."' href='".url($menu->items[$itemId]->link)."'>".$menu->items[$itemId]->nama_menu."</a></li>";
                                    }
                                }
                                if (isset($menu->parents[$itemId])) {
                                    $linkClass = $parent == '0' ? "block py-2.5 md:py-1 font-semibold text-slate-700 hover:text-emerald-600 transition-all duration-200 uppercase tracking-wide text-xs md:text-sm flex items-center justify-between md:justify-start relative after:content-[''] after:absolute after:w-full after:scale-x-0 after:h-0.5 after:-bottom-1 after:left-0 after:bg-emerald-600 after:origin-bottom-right after:transition-transform after:duration-300 group-hover:after:scale-x-100 group-hover:after:origin-bottom-left" : "block px-4 py-2 text-slate-600 hover:bg-emerald-50 hover:text-emerald-600 hover:pl-6 transition-all duration-200 text-xs font-medium flex items-center justify-between";
                                    
                                    if(preg_match("/^http/", $menu->items[$itemId]->link)) {
                                        $html .= "<li class='relative group'><a class='".$linkClass."' target='_BLANK' href='".$menu->items[$itemId]->link."'>".$menu->items[$itemId]->nama_menu." <i class='fa-solid fa-chevron-down text-[10px] ml-1.5 opacity-60'></i></a>";
                                    }else{
                                        $html .= "<li class='relative group'><a class='".$linkClass."' href='".url($menu->items[$itemId]->link)."'>".$menu->items[$itemId]->nama_menu." <i class='fa-solid fa-chevron-down text-[10px] ml-1.5 opacity-60'></i></a>";
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

            <!-- Quick Action Button -->
            <div class="pt-2 md:pt-0">
                <a href="{{ url('/konsultasi') }}" class="inline-flex items-center space-x-2 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold px-4 py-2 rounded-xl text-xs shadow-md shadow-emerald-600/20 hover:shadow-lg hover:shadow-emerald-600/30 hover:-translate-y-0.5 transition-all duration-200">
                    <i class="fa-solid fa-comments text-emerald-200"></i>
                    <span>Konsultasi Online</span>
                </a>
            </div>
        </div>
    </nav>
</div>