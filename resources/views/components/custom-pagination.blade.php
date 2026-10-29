@if ($paginator->hasPages())
    <nav class="flex flex-col md:flex-row items-center justify-between gap-4 py-2 text-xs text-slate-600">
        <div>
            @if ($paginator->onFirstPage())
                <span class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-300 cursor-not-allowed">
                    <i class="fa-solid fa-chevron-left mr-1"></i> Trước
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-1.5 rounded-lg border border-slate-200 hover:bg-slate-100 hover:text-blue-600 transition">
                    <i class="fa-solid fa-chevron-left mr-1"></i> Trước
                </a>
            @endif
        </div>

        <div class="flex items-center gap-1.5 flex-wrap justify-center">
            @php
                $current = $paginator->currentPage();
                $last = $paginator->lastPage();
                
                $pages = [];
                if ($last <= 7) {
                    $pages = range(1, $last);
                } else {
                    if ($current <= 3) {
                        $pages = [1, 2, 3, '...', $last - 1, $last];
                    } elseif ($current >= $last - 2) {
                        $pages = [1, 2, '...', $last - 2, $last - 1, $last];
                    } else {
                        $pages = [1, 2, '...', $current, '...', $last - 1, $last];
                    }
                }
            @endphp

            @foreach ($pages as $p)
                @if ($p === '...')
                    <button type="button" onclick="jumpToPageCustom({{ $last }})"
                            class="px-2.5 py-1.5 rounded-lg border border-dashed border-slate-300 text-slate-500 font-bold hover:bg-blue-50 hover:text-blue-600 hover:border-blue-400 transition cursor-pointer"
                            title="Bấm để nhập trang nhanh">
                        ...
                    </button>
                @elseif ($p == $current)
                    <span class="px-3 py-1.5 rounded-lg bg-blue-600 text-white font-bold shadow-xs">
                        {{ $p }}
                    </span>
                @else
                    <a href="{{ $paginator->url($p) }}" class="px-3 py-1.5 rounded-lg border border-slate-200 hover:bg-slate-100 hover:text-blue-600 transition">
                        {{ $p }}
                    </a>
                @endif
            @endforeach
        </div>

        <div class="flex items-center gap-3">
            <form onsubmit="jumpToPageDirect(event, {{ $last }})" class="flex items-center gap-1.5 border-r border-slate-200 pr-3">
                <span class="text-slate-500 font-medium whitespace-nowrap">Đến trang:</span>
                <input type="number" 
                       min="1" 
                       max="{{ $last }}" 
                       value="{{ $current }}"
                       class="w-14 px-2 py-1 text-center font-bold text-slate-800 border border-slate-200 rounded-lg focus:outline-hidden focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                <button type="submit" class="px-2.5 py-1 bg-slate-800 hover:bg-blue-600 text-white font-bold rounded-lg transition cursor-pointer">
                    Đi
                </button>
            </form>

            <div>
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-1.5 rounded-lg border border-slate-200 hover:bg-slate-100 hover:text-blue-600 transition">
                        Sau <i class="fa-solid fa-chevron-right ml-1"></i>
                    </a>
                @else
                    <span class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-300 cursor-not-allowed">
                        Sau <i class="fa-solid fa-chevron-right ml-1"></i>
                    </span>
                @endif
            </div>
        </div>
    </nav>

    <script>
        function navigateToPage(pageNum) {
            let currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set('page', pageNum);
            window.location.href = currentUrl.toString();
        }

        function jumpToPageCustom(maxPage) {
            let inputPage = prompt('Nhập số trang (Từ 1 đến ' + maxPage + '):');
            if (inputPage === null) return;
            
            inputPage = inputPage.trim();
            if (!inputPage || isNaN(inputPage) || !Number.isInteger(Number(inputPage))) {
                alert('⚠️ Vui lòng nhập số trang hợp lệ!');
                return;
            }
            
            let pageNum = parseInt(inputPage, 10);
            if (pageNum < 1 || pageNum > maxPage) {
                alert('⚠️ Số trang không tồn tại! Hệ thống chỉ có từ trang 1 đến trang ' + maxPage + '.');
                return;
            }
            
            navigateToPage(pageNum);
        }

        function jumpToPageDirect(event, maxPage) {
            event.preventDefault();
            const input = event.target.querySelector('input[type="number"]');
            if (!input) return;

            let inputPage = input.value.trim();
            if (!inputPage || isNaN(inputPage) || !Number.isInteger(Number(inputPage))) {
                alert('⚠️ Vui lòng nhập số trang hợp lệ!');
                return;
            }

            let pageNum = parseInt(inputPage, 10);
            if (pageNum < 1 || pageNum > maxPage) {
                alert('⚠️ Số trang không tồn tại! Hệ thống chỉ có từ trang 1 đến trang ' + maxPage + '.');
                return;
            }

            navigateToPage(pageNum);
        }
    </script>
@endif