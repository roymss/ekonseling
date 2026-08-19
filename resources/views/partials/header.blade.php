<div class="w-full bg-[#F9F9FF] border-b border-[#C4C6CF] h-[81px] flex items-center" x-data="{ mobileMenuOpen: false }">                          
    <nav class="container mx-auto px-4 md:px-20 h-full flex items-center justify-between" role="navigation">
        <!-- Brand -->
        <div class="flex items-center gap-3">
            <?php 
                $logo = \Illuminate\Support\Facades\DB::table('logo')->orderBy('id_logo', 'DESC')->first();
                $logoImg = ($logo && !empty($logo->gambar) && file_exists(public_path('asset/logo/' . $logo->gambar)) && !in_array($logo->gambar, ['logoo.png', 'logodivpas.png', 'logodivpas1.png'])) 
                    ? url('asset/logo/' . $logo->gambar) 
                    : url('asset/logo/ekonseling-logo.svg'); // Kita akan gunakan ini sebagai fallback
            ?>
            <a class='flex items-center gap-3 hover:opacity-95 transition-opacity' href='{{ url('/') }}'>
                <img class='w-10 h-10 object-cover rounded-xl' src='{{ $logoImg }}' alt='Logo E-Konseling'/>
                <span class="text-[#002045] font-['Inter'] font-bold text-[30px] hidden md:block">E-Konseling Pemerintah</span>
            </a>
            
            <!-- Mobile Menu Button -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-slate-700 hover:text-[#002045] focus:outline-none p-2 rounded-lg transition-colors ml-auto">
                <i class="fa-solid fa-bars text-xl" x-show="!mobileMenuOpen"></i>
                <i class="fa-solid fa-xmark text-xl" x-show="mobileMenuOpen" style="display:none;"></i>
            </button>
        </div>
        
        <!-- Desktop Menu / Mobile Dropdown -->
        @if(!Auth::check() && !session()->has('username'))
        <div :class="{'block': mobileMenuOpen, 'hidden': !mobileMenuOpen}" class="absolute top-[81px] left-0 w-full md:static md:w-auto bg-[#F9F9FF] md:bg-transparent shadow-xl md:shadow-none border-b md:border-none border-[#C4C6CF] md:flex items-center z-50 p-4 md:p-0 transition-all duration-300">
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
                                $html .= "<ul class='flex flex-col md:flex-row md:items-center md:gap-6 px-2 md:px-0 py-2 md:py-0'>";
                            }else{
                                $html .= "<ul class='md:absolute left-0 hidden md:group-hover:block bg-white text-slate-800 md:shadow-2xl py-3 md:mt-3 md:rounded-lg min-w-[220px] z-50 md:border md:border-slate-200 ml-4 md:ml-0 transition-all duration-300 opacity-0 md:group-hover:opacity-100'>";
                            }
                            foreach ($menu->parents[$parent] as $itemId) {
                                if (!isset($menu->parents[$itemId])) {
                                    $linkClass = $parent == '0' ? "block py-2 md:py-1 font-medium text-[14px] text-[#43474E] hover:text-[#002045] font-['Inter'] transition-colors" : "block px-4 py-2 text-[#43474E] hover:bg-[#F9F9FF] hover:text-[#002045] transition-colors text-[14px] font-medium font-['Inter']";
                                    
                                    // Set style for active or special items if needed, for now use standard
                                    if(preg_match("/^http/", $menu->items[$itemId]->link)) {
                                        $html .= "<li class='relative group'><a class='".$linkClass."' target='_BLANK' href='".$menu->items[$itemId]->link."'>".$menu->items[$itemId]->nama_menu."</a></li>";
                                    }else{
                                        $html .= "<li class='relative group'><a class='".$linkClass."' href='".url($menu->items[$itemId]->link)."'>".$menu->items[$itemId]->nama_menu."</a></li>";
                                    }
                                }
                                if (isset($menu->parents[$itemId])) {
                                    $linkClass = $parent == '0' ? "block py-2 md:py-1 font-medium text-[14px] text-[#43474E] hover:text-[#002045] font-['Inter'] transition-colors flex items-center" : "block px-4 py-2 text-[#43474E] hover:bg-[#F9F9FF] hover:text-[#002045] transition-colors text-[14px] font-medium font-['Inter'] flex items-center justify-between";
                                    
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
        </div>
        @endif

        <!-- Trailing Action -->
        <div class="hidden md:flex ml-8">
            @if(Auth::check() || session()->has('username'))
                @php
                    $level = session('level');
                    if ($level == 'admin') {
                        $dashboardUrl = url('/admin/dashboard');
                        $dashboardText = 'Dashboard Admin';
                    } elseif ($level == 'psikolog') {
                        $dashboardUrl = url('/psikolog/profile');
                        $dashboardText = 'Dashboard Konselor';
                    } else {
                        $dashboardUrl = url('/user/profile');
                        $dashboardText = 'Dashboard Warga';
                    }
                @endphp
                <a href="{{ $dashboardUrl }}" class="flex items-center gap-2 bg-[#002045] hover:bg-[#001530] text-white px-6 py-3 rounded-xl transition-colors h-[44px]">
                    <span class="font-['Inter'] font-medium text-[14px]">{{ $dashboardText }}</span>
                    <i class="fa-regular fa-user text-sm"></i>
                </a>
            @else
                <a href="{{ url('/user/login') }}" class="flex items-center justify-center bg-[#002045] hover:bg-[#001530] text-white px-6 py-2 rounded-xl transition-colors h-[36px]">
                    <span class="font-['Inter'] font-medium text-[14px] text-center w-full">Login</span>
                </a>
            @endif
        </div>
    </nav>
</div>