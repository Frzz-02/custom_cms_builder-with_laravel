/**
 * ===================================================================
 * PAGE BUILDER JAVASCRIPT
 * ===================================================================
 * File ini berisi semua kode JavaScript untuk Page Builder
 * Page Builder adalah fitur untuk membuat halaman dengan drag & drop blocks
 * 
 * PENJELASAN DASAR JAVASCRIPT:
 * - Variable: Tempat menyimpan data (seperti kotak penyimpanan)
 * - Function: Kumpulan kode yang bisa dipanggil berulang kali
 * - Event: Sesuatu yang terjadi (klik tombol, scroll, dll)
 * - DOM: Document Object Model - cara JavaScript mengakses HTML
 */

// ===================================================================
// BAGIAN 1: DEKLARASI VARIABEL GLOBAL
// ===================================================================
// Variable global bisa diakses dari mana saja dalam file ini

// Counter untuk memberi nomor unik pada setiap block yang dibuat
// Contoh: block-1, block-2, block-3, dst
let blockCounter = 0;

// Menyimpan ID block yang sedang diedit (null = tidak ada yang diedit)
let currentEditBlockId = null;

// Object sortable dari library SortableJS untuk drag & drop
// null = belum diinisialisasi
let sortable = null;

// Menyimpan ID block hero banner yang menunggu pemilihan style
// Digunakan karena hero banner butuh pilih style dulu sebelum ditambahkan
let pendingHeroBannerBlockId = null;

// Menyimpan ID block testimonials yang menunggu pemilihan style
let pendingTestimonialsBlockId = null;

// Menyimpan ID block featured services yang menunggu pemilihan style
let pendingFeaturedServicesBlockId = null;

// Menyimpan ID block latest news yang menunggu pemilihan style
let pendingLatestNewsBlockId = null;

// Menyimpan ID block about yang menunggu pemilihan style
let pendingAboutBlockId = null;

// Menyimpan ID block product category yang menunggu pemilihan style
let pendingProductCategoryBlockId = null;

// Cache untuk data dari database (untuk optimasi performa)
// Data di-load sekali saat halaman dibuka, lalu disimpan di sini
let cachedTestimonials = [];
let cachedServices = [];
let cachedNewsletters = [];
let cachedContacts = [];
let cachedSectionServices = []; // Untuk hero banner style 2
let isDataLoaded = false;

// Cache untuk data block yang sudah disave (optimasi performa)
// Format: { 'block-1': { title:
//  'xxx', subtitle: 'yyy', ... }, 'block-2': { ... } }
// Setiap block punya data sendiri-sendiri, meskipun tipenya sama
let blockDataCache = {};

// State untuk mencegah race condition saat sync urutan block ke database
let isSyncingBlockOrder = false;
let pendingBlockOrderSync = false;

// ===================================================================
// BAGIAN 2: KONFIGURASI BLOCKS
// ===================================================================
// Object berisi informasi tentang semua jenis block yang tersedia
// Format: 'key': { name: 'Nama', icon: 'nama-icon', color: 'warna' }

const blockConfig = {
    'title': { 
        name: 'Title',              // Nama yang ditampilkan
        icon: 'text',               // Icon yang digunakan
        color: 'slate'              // Warna untuk background icon
    },
    'simple-text': { 
        name: 'Simple text', 
        icon: 'align-left', 
        color: 'slate' 
    },
    'text-editor': { 
        name: 'Text editor', 
        icon: 'edit', 
        color: 'slate' 
    },
    'complete-counts': { 
        name: 'Complete Counts', 
        icon: 'chart-bar', 
        color: 'blue' 
    },
    'hero-banner': { 
        name: 'Hero banner', 
        icon: 'photograph', 
        color: 'indigo' 
    },
    'about': { 
        name: 'About us', 
        icon: 'information-circle', 
        color: 'blue' 
    },
    'brands': { 
        name: 'Brands', 
        icon: 'tag', 
        color: 'amber' 
    },
    'testimonials': { 
        name: 'Testimonials', 
        icon: 'star', 
        color: 'yellow' 
    },
    'recent-product': { 
        name: 'Recent Product', 
        icon: 'shopping-bag', 
        color: 'green' 
    },
    'featured-services': { 
        name: 'Featured Services', 
        icon: 'briefcase', 
        color: 'purple' 
    },
    'newsletter': { 
        name: 'Newsletter', 
        icon: 'mail', 
        color: 'blue' 
    },
    'latestnews': { 
        name: 'Latest News & Blog', 
        icon: 'newspaper', 
        color: 'rose' 
    },
    'comingsoon': {
        name: 'Coming Soon',
        icon: 'clock',
        color: 'violet'
    },
    'contact': { 
        name: 'Contact', 
        icon: 'phone', 
        color: 'teal' 
    },
    'product-category': { 
        name: 'Product Category', 
        icon: 'view-grid', 
        color: 'green' 
    }
};

// ===================================================================
// BAGIAN 3: INISIALISASI SAAT HALAMAN SELESAI LOADING
// ===================================================================

// addEventListener = cara JavaScript "mendengarkan" event/kejadian
// 'DOMContentLoaded' = event yang terjadi saat HTML selesai dimuat
// function() { ... } = kode yang akan dijalankan saat event terjadi
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Page Builder JS Loaded');
    console.log('📍 Current page ID:', window.pageId);
    
    // Pre-load semua data dari database untuk optimasi performa
    preloadAllData();
    
    // Panggil fungsi untuk mengaktifkan drag & drop
    initSortable();
    
    // Check if modal exists
    const modal = document.getElementById('blockLibraryModal');
    if (modal) {
        console.log('✓ Block Library Modal found');
    } else {
        console.error('✗ Block Library Modal NOT found! Please check if library-modal.blade.php is included.');
    }
    
    // ✅ BIND EVENT LISTENERS KE BUTTON (FIX untuk ReferenceError)
    // Menggunakan addEventListener lebih aman daripada onclick inline
    const openLibraryBtn = document.getElementById('openLibraryBtn');
    const addFirstBlockBtn = document.getElementById('addFirstBlockBtn');
    
    if (openLibraryBtn) {
        console.log('✅ Binding click event to openLibraryBtn');
        openLibraryBtn.addEventListener('click', function() {
            console.log('🖱️ Button clicked! Calling openBlockLibrary()...');
            openBlockLibrary();
        });
    } else {
        console.warn('⚠️ openLibraryBtn NOT found!');
    }
    
    if (addFirstBlockBtn) {
        console.log('✅ Binding click event to addFirstBlockBtn');
        addFirstBlockBtn.addEventListener('click', function() {
            console.log('🖱️ Add First Block button clicked!');
            openBlockLibrary();
        });
    } else {
        console.warn('⚠️ addFirstBlockBtn NOT found!');
    }
    
    // Load existing blocks dari database (jika ada)
    loadExistingBlocks();
    
    console.log('✅ Page Builder initialization complete');
});

// ===================================================================
// BAGIAN 3A: PRE-LOADING DATA
// ===================================================================

/**
 * Pre-load semua data dari database saat halaman dibuka
 * Untuk optimasi performa dan mengurangi request ke Supabase
 */
function preloadAllData() {
    console.log('📦 Pre-loading data from database...');
    
    // Fetch testimonials
    fetch('/bagoosh/testimonials/list')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.testimonials) {
                cachedTestimonials = data.testimonials;
                console.log('✅ Testimonials loaded:', cachedTestimonials.length, 'items');
            }
        })
        .catch(error => console.error('❌ Error loading testimonials:', error));
    
    // Fetch services
    fetch('/bagoosh/services/list')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.services) {
                cachedServices = data.services;
                console.log('✅ Services loaded:', cachedServices.length, 'items');
            }
        })
        .catch(error => console.error('❌ Error loading services:', error));
    
    // Fetch newsletters
    fetch('/bagoosh/section-newsletters/list')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.newsletters) {
                cachedNewsletters = data.newsletters;
                console.log('✅ Newsletters loaded:', cachedNewsletters.length, 'items');
                isDataLoaded = true;
            }
        })
        .catch(error => console.error('❌ Error loading newsletters:', error));
    
    // Fetch product categories (untuk hero banner)
    fetch('/bagoosh/product-categories/list')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.data) {
                cachedProductCategories = data.data;
                console.log('✅ Product categories loaded:', cachedProductCategories.length, 'items');
            }
        })
        .catch(error => console.error('❌ Error loading product categories:', error));
    
    // Fetch section services (untuk hero banner style 2)
    fetch('/bagoosh/section-services/list')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.data) {
                cachedSectionServices = data.data;
                console.log('✅ Section services loaded:', cachedSectionServices.length, 'items');
            }
        })
        .catch(error => console.error('❌ Error loading section services:', error));
}

// ===================================================================
// BAGIAN 4: FUNGSI DRAG & DROP (SORTABLE)
// ===================================================================

/**
 * Fungsi untuk menginisialisasi fitur drag & drop menggunakan SortableJS
 * SortableJS = library JavaScript untuk membuat list yang bisa di-drag & drop
 */
function initSortable() {
    // document.getElementById = cara mengambil element HTML berdasarkan ID
    // Kita ambil element dengan ID 'blocksList'
    const el = document.getElementById('blocksList');
    
    // && = operator AND (dan)
    // !sortable = NOT sortable (sortable belum ada/null)
    // Jadi: "jika element ada DAN sortable belum diinisialisasi"
    if (el && !sortable) {
        // Sortable.create = membuat instance sortable baru
        sortable = Sortable.create(el, {
            // animation: durasi animasi saat drag (dalam milidetik)
            // 150ms = 0.15 detik
            animation: 150,
            
            // handle: class CSS yang bisa di-drag
            // Hanya element dengan class 'drag-handle' yang bisa di-drag
            handle: '.drag-handle',
            
            // ghostClass: class yang ditambahkan ke item saat di-drag
            ghostClass: 'sortable-ghost',
            
            // onEnd: function yang dipanggil saat selesai drag
            // Ini adalah "callback function" - fungsi yang dipanggil otomatis
            onEnd: async function() {
                // Update nomor urutan setelah drag selesai
                updateBlockOrder();

                // Sinkronkan sort_id terbaru ke database
                await syncBlockOrderToDatabase();
            }
        });
    }
}

/**
 * Fungsi untuk memperbarui nomor urutan block setelah di-drag
 * Contoh: Block 1, Block 2, Block 3 → setelah drag → Block 2, Block 1, Block 3
 * 
 * PENTING: Fungsi ini juga mengupdate sort_id di cache!
 * Sehingga saat user klik configure > save, sort_id sudah otomatis terupdate
 */
function updateBlockOrder() {
    // querySelectorAll = ambil SEMUA element yang cocok dengan selector
    // '.block-item' = semua element dengan class 'block-item'
    const blocks = document.querySelectorAll('.block-item');
    
    // forEach = loop/perulangan untuk setiap item
    // (block, index) => { ... } = arrow function (cara modern menulis function)
    // block = item saat ini, index = urutan (0, 1, 2, 3, ...)
    blocks.forEach((block, index) => {
        // querySelector = ambil SATU element pertama yang cocok
        // Ambil element dengan class 'block-order' di dalam block ini
        const orderElement = block.querySelector('.block-order');
        
        // textContent = mengubah text di dalam element HTML
        // index + 1 karena index mulai dari 0, tapi kita mau mulai dari 1
        // Contoh: index 0 → tampil 1, index 1 → tampil 2, dst
        orderElement.textContent = index + 1;
        
        // BARU: Update sort_id di cache agar sinkron dengan posisi aktual
        const blockId = block.id;
        if (blockDataCache[blockId]) {
            const newSortId = index + 1;
            blockDataCache[blockId].sort_id = newSortId;
            console.log(`🔄 Updated sort_id in cache: ${blockId} → ${newSortId}`);
        }
    });
}

/**
 * Sinkronisasi urutan block (sort_id) ke database
 * Dipanggil setiap selesai drag & drop
 */
async function syncBlockOrderToDatabase() {
    // Jika sedang sync, tandai ada sync baru dan biarkan loop yang sedang jalan memproses ulang
    if (isSyncingBlockOrder) {
        pendingBlockOrderSync = true;
        return;
    }

    isSyncingBlockOrder = true;

    try {
        do {
            pendingBlockOrderSync = false;

            const blocks = document.querySelectorAll('#blocksList .block-item');
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

            const updates = [];

            blocks.forEach((block, index) => {
                const shortcodeId = block.dataset.shortcodeId;
                const blockId = block.id;
                const newSortId = index + 1;

                if (!shortcodeId || !blockId) return;

                // Selalu update ke database setelah drag-drop agar konsisten
                updates.push({ shortcodeId, blockId, sort_id: newSortId });
            });

            if (updates.length === 0) {
                continue;
            }

            console.log('🔄 Syncing block order to database:', updates);

            const results = await Promise.all(
                updates.map(async (item) => {
                    const response = await fetch(`/bagoosh/page-shortcode/update/${item.shortcodeId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ sort_id: item.sort_id })
                    });

                    let payload = {};
                    try {
                        payload = await response.json();
                    } catch (error) {
                        payload = {};
                    }

                    if (!response.ok) {
                        throw new Error(payload.message || `Failed to update sort_id for shortcode ${item.shortcodeId}`);
                    }

                    return item;
                })
            );

            // Pastikan cache ikut sinkron setelah update DB berhasil
            results.forEach((item) => {
                if (blockDataCache[item.blockId]) {
                    blockDataCache[item.blockId].sort_id = item.sort_id;
                }
            });

            console.log('✅ Block order synced to database successfully');
        } while (pendingBlockOrderSync);
    } catch (error) {
        console.error('❌ Failed to sync block order:', error);
        alert('Failed to update block order in database: ' + error.message);
    } finally {
        isSyncingBlockOrder = false;
    }
}

/**
 * Fungsi untuk mendapatkan next block counter yang benar
 * Menghitung dari block yang ada, bukan dari variable global
 * Ini mencegah skip nomor saat block dihapus
 * 
 * @returns {number} - Nomor counter berikutnya
 */
function getNextBlockCounter() {
    const blocks = document.querySelectorAll('.block-item');
    let maxCounter = 0;
    
    // Loop setiap block untuk cari nomor terbesar
    blocks.forEach(block => {
        const blockId = block.id; // Contoh: "block-3"
        if (blockId && blockId.startsWith('block-')) {
            const num = parseInt(blockId.replace('block-', ''));
            if (!isNaN(num) && num > maxCounter) {
                maxCounter = num;
            }
        }
    });
    
    // Return nomor terbesar + 1
    return maxCounter + 1;
}

/**
 * Fungsi untuk mendapatkan sort_id yang benar berdasarkan posisi AKTUAL di blocklist
 * Ini memastikan sort_id selalu sinkron dengan urutan visual
 * 
 * @param {string} blockId - ID dari block yang mau dicari sort_id-nya
 * @returns {number} - Sort ID berdasarkan posisi aktual (1-based index)
 */
function getCurrentSortId(blockId) {
    const blocks = document.querySelectorAll('.block-item');
    let sortId = 1; // default
    
    blocks.forEach((block, index) => {
        if (block.id === blockId) {
            sortId = index + 1; // Posisi aktual (1-based)
        }
    });
    
    console.log(`📍 Sort ID for ${blockId}: ${sortId}`);
    return sortId;
}

// ===================================================================
// BAGIAN 5: FUNGSI HELPER UNTUK MODAL
// ===================================================================

/**
 * Fungsi helper untuk menutup modal dengan animasi transisi
 * Modal = popup/dialog box yang muncul di tengah layar
 * 
 * @param {string} modalId - ID dari modal yang mau ditutup
 * @param {function} callback - Fungsi yang dipanggil setelah modal tertutup
 */
function closeModalWithTransition(modalId, callback) {
    // getElementById = ambil element berdasarkan ID
    const modal = document.getElementById(modalId);
    
    // if (!modal) = jika modal tidak ditemukan
    // return = keluar dari fungsi (berhenti)
    if (!modal) return;
    
    // Atur style CSS untuk transisi (animasi perubahan)
    // opacity = transparansi (0 = transparan, 1 = solid)
    modal.style.transition = 'opacity 300ms ease-out'; // 300ms = 0.3 detik
    modal.style.opacity = '0'; // Buat modal transparan (fade out)
    
    // setTimeout = jalankan kode setelah waktu tertentu
    // () => { ... } = arrow function yang akan dijalankan
    // 300 = waktu tunggu dalam milidetik (0.3 detik)
    setTimeout(() => {
        // classList.add = tambahkan class CSS
        // 'hidden' = class yang menyembunyikan element
        modal.classList.add('hidden');
        
        // Kembalikan opacity ke 1 untuk nanti dibuka lagi
        modal.style.opacity = '1';
        
        // document.body = element <body> di HTML
        // style.overflow = atur scroll behavior
        // 'auto' = scroll normal (bisa scroll halaman)
        document.body.style.overflow = 'auto';
        
        // if (callback) = jika callback function diberikan
        // typeof callback === 'function' = pastikan callback adalah function
        if (callback && typeof callback === 'function') {
            // Panggil callback function
            callback();
        }
    }, 300); // Waktu harus sama dengan durasi transisi
}

// ===================================================================
// BAGIAN 6: FUNGSI MODAL BLOCK LIBRARY
// ===================================================================

/**
 * Fungsi untuk membuka modal library (daftar block yang tersedia)
 */
function openBlockLibrary() {
    console.log('🔥 openBlockLibrary() DIPANGGIL!');
    console.log('🔍 Mencari modal dengan ID: blockLibraryModal');
    
    // getElementById = ambil element dengan ID tertentu
    const modal = document.getElementById('blockLibraryModal');
    
    console.log('📦 Modal element:', modal);
    
    if (!modal) {
        console.error('❌ Modal blockLibraryModal TIDAK DITEMUKAN!');
        console.log('📋 Semua element dengan ID:', document.querySelectorAll('[id]'));
        alert('Error: Modal tidak ditemukan! Cek console untuk detail.');
        return;
    }
    
    console.log('✅ Modal ditemukan!');
    console.log('🎨 Classes saat ini:', modal.className);
    
    // classList.remove = hapus class dari element
    // 'hidden' = class yang menyembunyikan element
    // Jadi: tampilkan modal dengan menghapus class 'hidden'
    modal.classList.remove('hidden');
    
    console.log('🎨 Classes setelah remove:', modal.className);
    
    // Cegah scroll di halaman utama saat modal terbuka
    // 'hidden' = tidak bisa scroll
    document.body.style.overflow = 'hidden';
    
    console.log('✅✅✅ Modal BERHASIL DIBUKA!');
}

/**
 * Fungsi untuk menutup modal library
 */
function closeBlockLibrary() {
    console.log('🔥 closeBlockLibrary() DIPANGGIL!');
    // Tutup modal dengan animasi transisi
    closeModalWithTransition('blockLibraryModal');
}

// ===================================================================
// BAGIAN 7: FUNGSI MODAL EDIT UNIVERSAL
// ===================================================================

/**
 * Fungsi untuk membuka modal edit block
 * Function ini akan memilih modal yang tepat berdasarkan tipe block
 * 
 * @param {string} blockId - ID dari block yang mau diedit
 */
async function openEditModal(blockId) {
    // Simpan ID block yang sedang diedit ke variable global
    currentEditBlockId = blockId;
    
    // Ambil element block dari DOM
    let block = document.getElementById(blockId);
    
    // Fallback: jika tidak ditemukan dengan id, cari dengan data-block-id
    if (!block) {
        block = document.querySelector(`[data-block-id="${blockId}"]`);
    }
    
    if (!block) {
        console.error('Block not found:', blockId);
        return;
    }
    
    // dataset = cara mengakses attribute data-* di HTML
    // Contoh: <div data-type="hero"> → dataset.type = "hero"
    const blockType = block.dataset.type;
    const shortcodeId = block.dataset.shortcodeId;
    
    // Cek cache dulu sebelum fetch dari database (lebih cepat!)
    let shortcodeData = null;
    
    // Prioritas 1: Cek cache local (paling cepat)
    if (blockDataCache[blockId]) {
        console.log('📦 Loading from cache:', blockId);
        shortcodeData = blockDataCache[blockId];
    }
    // Prioritas 2: Fetch dari database (untuk backward compatibility)
    else if (shortcodeId) {
        console.log('🔄 Loading from database:', shortcodeId);
        try {
            const response = await fetch(`/bagoosh/page-shortcode/show/${shortcodeId}`);
            const result = await response.json();
            if (result.success) {
                shortcodeData = result.data;
                // Simpan ke cache untuk next time
                blockDataCache[blockId] = shortcodeData;
            }
        } catch (error) {
            console.error('Error loading shortcode data:', error);
        }
    }
    
    // if...else if...else = percabangan (pilihan)
    // Buka modal yang sesuai dengan tipe block
    if (blockType === 'title') {
        // Untuk block title
        document.getElementById('editTitleModal').classList.remove('hidden');
        // Populate form jika ada data
        if (shortcodeData) {
            document.getElementById('titleBlockId').value = shortcodeData.id || '';
            document.getElementById('titleBlockTitle').value = shortcodeData.title || '';
            document.getElementById('titleBlockSubtitle').value = shortcodeData.subtitle || '';
            document.getElementById('titleBlockHeading').value = shortcodeData.heading || 'h3';
        } else {
            // Reset form jika tidak ada data
            document.getElementById('titleBlockId').value = '';
            document.getElementById('titleBlockTitle').value = '';
            document.getElementById('titleBlockSubtitle').value = '';
            document.getElementById('titleBlockHeading').value = 'h3';
        }
    } else if (blockType === 'simple-text') {
        // Untuk block simple text
        document.getElementById('editSimpleTextModal').classList.remove('hidden');
        // Populate form jika ada data
        console.log('📝 Simple Text - Loading data:', shortcodeData);
        if (shortcodeData) {
            console.log('✅ Simple Text - Populating form with:', shortcodeData.content);
            document.getElementById('simpleTextBlockId').value = shortcodeData.id || '';
            document.getElementById('simpleTextContent').value = shortcodeData.content || '';
            console.log('✅ Simple Text - Form populated. Input value:', document.getElementById('simpleTextContent').value);
        } else {
            console.log('⚠️ Simple Text - No data, resetting form');
            // Reset form jika tidak ada data
            document.getElementById('simpleTextBlockId').value = '';
            document.getElementById('simpleTextContent').value = '';
        }
    } else if (blockType === 'text-editor') {
        // Untuk block text editor
        document.getElementById('editTextEditorModal').classList.remove('hidden');
        // Populate form jika ada data
        if (shortcodeData) {
            document.getElementById('textEditorBlockId').value = shortcodeData.id || '';
            // Set content to Trix editor
            const trixEditor = document.querySelector('trix-editor[input="textEditorContent"]');
            if (trixEditor) {
                trixEditor.editor.loadHTML(shortcodeData.content || '');
            }
        } else {
            // Reset form jika tidak ada data
            document.getElementById('textEditorBlockId').value = '';
            const trixEditor = document.querySelector('trix-editor[input="textEditorContent"]');
            if (trixEditor) {
                trixEditor.editor.loadHTML('');
            }
        }
    } else if (blockType === 'brands') {
        // Untuk block brands
        document.getElementById('editBrandsModal').classList.remove('hidden');
        // Populate form jika ada data
        if (shortcodeData) {
            document.getElementById('brandsBlockId').value = shortcodeData.id || '';
            // Parse section_brand_id (bisa JSON string atau array) dan centang checkboxes yang sesuai
            let selectedBrandIds = shortcodeData.section_brand_id || [];
            // Jika masih string JSON, parse dulu
            if (typeof selectedBrandIds === 'string') {
                try {
                    selectedBrandIds = JSON.parse(selectedBrandIds);
                } catch (e) {
                    console.error('Failed to parse section_brand_id:', e);
                    selectedBrandIds = [];
                }
            }
            // Reset semua checkboxes dulu
            document.querySelectorAll('#brandsList input[type="checkbox"]').forEach(cb => {
                // Convert checkbox value to string for comparison
                cb.checked = selectedBrandIds.map(String).includes(cb.value);
            });
        } else {
            // Reset form jika tidak ada data
            document.getElementById('brandsBlockId').value = '';
            document.querySelectorAll('#brandsList input[type="checkbox"]').forEach(cb => {
                cb.checked = false;
            });
        }
    } else if (blockType === 'complete-counts') {
        // Untuk block complete counts
        document.getElementById('editCompleteCountsModal').classList.remove('hidden');
        // Populate form jika ada data
        if (shortcodeData) {
            document.getElementById('completeCountsBlockId').value = shortcodeData.id || '';
            document.getElementById('completeCountsTitle').value = shortcodeData.title || '';
            document.getElementById('completeCountsSubtitle').value = shortcodeData.subtitle || '';
            document.getElementById('completeCountsContent').value = shortcodeData.content || '';
            // Parse section_completecount_id (bisa JSON string atau array) dan centang checkboxes yang sesuai
            let selectedCountIds = shortcodeData.section_completecount_id || [];
            // Jika masih string JSON, parse dulu
            if (typeof selectedCountIds === 'string') {
                try {
                    selectedCountIds = JSON.parse(selectedCountIds);
                } catch (e) {
                    console.error('Failed to parse section_completecount_id:', e);
                    selectedCountIds = [];
                }
            }
            // Reset semua checkboxes dulu
            document.querySelectorAll('#completeCountsList input[type="checkbox"]').forEach(cb => {
                // Convert checkbox value to string for comparison
                cb.checked = selectedCountIds.map(String).includes(cb.value);
            });
        } else {
            // Reset form jika tidak ada data
            document.getElementById('completeCountsBlockId').value = '';
            document.getElementById('completeCountsTitle').value = '';
            document.getElementById('completeCountsSubtitle').value = '';
            document.getElementById('completeCountsContent').value = '';
            document.querySelectorAll('#completeCountsList input[type="checkbox"]').forEach(cb => {
                cb.checked = false;
            });
        }
    } else if (blockType === 'hero-banner') {
        // Untuk block hero banner (punya fungsi khusus per style)
        const style = block.dataset.style || '1';
        if (style === '1') {
            openEditHeroBannerModal();
        } else if (style === '2') {
            openEditHeroBannerStyle2Modal();
        } else if (style === '3') {
            openEditHeroBannerStyle3Modal();
        } else {
            alert('Invalid hero banner style: ' + style);
        }
    } else if (blockType === 'about') {
        // Untuk block about (punya fungsi khusus per style)
        const aboutStyle = block.dataset.aboutStyle || '1';
        if (aboutStyle === '1') {
            openEditAboutModal();
        } else {
            alert('About style ' + aboutStyle + ' coming soon!');
        }
    } else if (blockType === 'product-category') {
        // Untuk block product category (punya fungsi khusus)
        openEditProductCategoryModal();
    } else if (blockType === 'testimonials') {
        // Untuk block testimonials (punya fungsi khusus)
        openEditTestimonialsModal();
    } else if (blockType === 'recent-product') {
        // Untuk block recent product (punya fungsi khusus)
        openEditRecentProductModal();
    } else if (blockType === 'featured-services') {
        // Untuk block featured services (punya fungsi khusus)
        openEditFeaturedServicesModal(blockId);
    } else if (blockType === 'newsletter') {
        // Untuk block newsletter (punya fungsi khusus)
        openEditNewsletterModal(blockId);
    } else if (blockType === 'latestnews') {
        // Untuk block latest news (punya fungsi khusus)
        openEditLatestNewsModal(blockId);
    } else if (blockType === 'comingsoon') {
        // Untuk block coming soon
        openEditComingSoonModal(blockId);
    } else if (blockType === 'contact') {
        // Untuk block contact (punya fungsi khusus)
        openEditContactModal(blockId);
    } else {
        // Untuk block lainnya, gunakan modal default
        document.getElementById('editDefaultModal').classList.remove('hidden');
    }
    
    // Cegah scroll halaman saat modal terbuka
    document.body.style.overflow = 'hidden';
}

// ===================================================================
// BAGIAN 8: FUNGSI MODAL TITLE BLOCK
// ===================================================================

/**
 * Menutup modal edit title
 */
function closeEditTitleModal() {
    closeModalWithTransition('editTitleModal', () => {
        // Reset variable setelah modal tertutup
        // null = kosong/tidak ada nilai
        currentEditBlockId = null;
    });
}

/**
 * Menyimpan perubahan title block
 */
async function saveTitleBlock() {
    if (!currentEditBlockId) return;
    
    // Ambil data dari form
    const title = document.getElementById('titleBlockTitle').value;
    const subtitle = document.getElementById('titleBlockSubtitle').value;
    const heading = document.getElementById('titleBlockHeading').value;
    const blockElement = document.getElementById(currentEditBlockId);
    
    // ⭐ PENTING: Ambil shortcodeId dari HIDDEN INPUT FIELD (bukan dataset!)
    // Hidden field adalah single source of truth yang PASTI ter-update setelah save
    const shortcodeId = document.getElementById('titleBlockId').value;
    
    // PENTING: Hitung sort_id dari posisi AKTUAL di blocklist, bukan dari block ID!
    // Ini memastikan sort_id selalu sinkron dengan urutan visual
    const blocks = document.querySelectorAll('.block-item');
    let sortId = 1; // default
    blocks.forEach((block, index) => {
        if (block.id === currentEditBlockId) {
            sortId = index + 1; // Posisi aktual (1-based)
        }
    });
    
    console.log('📊 Sort ID calculation:', {
        blockId: currentEditBlockId,
        extractedSortId: sortId,
        currentBlockCounter: blockCounter
    });
    
    // Ambil element-element untuk loading state
    const saveBtn = document.getElementById('saveTitleBtn');
    const saveIconCheck = document.getElementById('saveTitleIconCheck');
    const saveIconLoading = document.getElementById('saveTitleIconLoading');
    const saveButtonText = document.getElementById('saveTitleButtonText');
    
    // Show loading state
    saveBtn.disabled = true;
    saveIconCheck.classList.add('hidden');
    saveIconLoading.classList.remove('hidden');
    saveButtonText.textContent = 'Saving...';
    
    try {
        let response;
        const data = {
            pages_id: window.pageId,
            type: 'title',
            title: title,
            subtitle: subtitle,
            heading: heading,
            sort_id: sortId
        };
        
        if (shortcodeId) {
            // Update existing shortcode
            response = await fetch(`/bagoosh/page-shortcode/update/${shortcodeId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json', // ⭐ Pastikan Laravel return JSON (bukan HTML!)
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            });
        } else {
            // Create new shortcode
            response = await fetch('/bagoosh/page-shortcode/store', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json', // ⭐ Pastikan Laravel return JSON (bukan HTML!)
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            });
        }
        
        const result = await response.json();
        
        if (result.success) {
            // Update block dengan shortcode ID
            if (result.shortcode_id) {
                blockElement.dataset.shortcodeId = result.shortcode_id;
                // ⭐ CRITICAL: Update HIDDEN INPUT FIELD juga!
                // Tanpa ini, save kedua akan create baru, dan delete tidak bisa hapus database!
                document.getElementById('titleBlockId').value = result.shortcode_id;
            }
            
            // Simpan ke cache local untuk performa (tidak perlu fetch database lagi)
            blockDataCache[currentEditBlockId] = {
                id: result.shortcode_id || shortcodeId,
                title: title,
                subtitle: subtitle,
                heading: heading,
                type: 'title',
                sort_id: sortId
            };
            
            console.log('💾 Saved to cache:', currentEditBlockId, blockDataCache[currentEditBlockId]);
            
            // Update tampilan block
            const titleEl = blockElement.querySelector('h3');
            if (titleEl) {
                titleEl.textContent = title || 'Title';
            }
            
            // Reset button state
            saveBtn.disabled = false;
            saveIconCheck.classList.remove('hidden');
            saveIconLoading.classList.add('hidden');
            saveButtonText.textContent = 'Saved!';
            
            // Close modal after delay
            setTimeout(() => {
                saveButtonText.textContent = 'Save';
                closeEditTitleModal();
            }, 1000);
        } else {
            throw new Error(result.message || 'Failed to save');
        }
    } catch (error) {
        console.error('Error saving title block:', error);
        alert('Failed to save block: ' + error.message);
        
        // Reset button state
        saveBtn.disabled = false;
        saveIconCheck.classList.remove('hidden');
        saveIconLoading.classList.add('hidden');
        saveButtonText.textContent = 'Save';
    }
}

/**
 * Menghapus title block
 */
async function deleteTitleBlock() {
    if (!currentEditBlockId) return;
    if (!confirm('Are you sure you want to delete this block?')) return;

    // ⭐ PENTING: Ambil shortcodeId dari hidden input field (bukan dari dataset!)
    const shortcodeId = document.getElementById('titleBlockId').value;
    
    const deleteBtn = document.getElementById('deleteTitleBtn');
    const deleteIconTrash = document.getElementById('deleteTitleIconTrash');
    const deleteIconLoading = document.getElementById('deleteTitleIconLoading');
    const deleteButtonText = document.getElementById('deleteTitleButtonText');
    
    deleteBtn.disabled = true;
    deleteIconTrash.classList.add('hidden');
    deleteIconLoading.classList.remove('hidden');
    deleteButtonText.textContent = 'Deleting...';

    try {
        // Hanya hapus dari database jika shortcodeId ada (sudah pernah di-save)
        if (shortcodeId) {
            console.log('🗑️ Deleting title block from database:', shortcodeId);
            
            const response = await fetch(`/bagoosh/page-shortcode/delete/${shortcodeId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            
            if (!response.ok) {
                const result = await response.json();
                throw new Error(result.message || 'Failed to delete');
            }
            
            console.log('✅ Deleted from database');
        } else {
            console.log('ℹ️ Block belum disave, skip API call');
        }
        
        // Hapus dari cache
        if (blockDataCache[currentEditBlockId]) {
            delete blockDataCache[currentEditBlockId];
            console.log('🗑️ Deleted from cache:', currentEditBlockId);
        }
        
        closeModalWithTransition('editTitleModal', () => {
            const block = document.getElementById(currentEditBlockId);
            if (block) {
                block.style.transition = 'opacity 300ms ease-out';
                block.style.opacity = '0';
                setTimeout(() => {
                    block.remove();
                    checkEmptyState();
                    updateBlockOrder();
                }, 300);
            }
            currentEditBlockId = null;
            deleteBtn.disabled = false;
            deleteIconTrash.classList.remove('hidden');
            deleteIconLoading.classList.add('hidden');
            deleteButtonText.textContent = 'Delete';
            alert('Block deleted successfully!');
        });
        
    } catch (error) {
        console.error('Error deleting title block:', error);
        alert('Failed to delete title block: ' + error.message);
        
        // Restore button state
        deleteBtn.disabled = false;
        deleteIconTrash.classList.remove('hidden');
        deleteIconLoading.classList.add('hidden');
        deleteButtonText.textContent = 'Delete';
    }
}

// ===================================================================
// BAGIAN 9: FUNGSI MODAL SIMPLE TEXT BLOCK
// ===================================================================

function closeEditSimpleTextModal() {
    closeModalWithTransition('editSimpleTextModal', () => {
        currentEditBlockId = null;
    });
}

async function saveSimpleTextBlock() {
    if (!currentEditBlockId) return;
    
    // Ambil data dari form
    const content = document.getElementById('simpleTextContent').value;
    const blockElement = document.getElementById(currentEditBlockId);
    
    // ⭐ PENTING: Ambil shortcodeId dari HIDDEN INPUT FIELD (bukan dataset!)
    // Hidden field adalah single source of truth yang PASTI ter-update setelah save
    const shortcodeId = document.getElementById('simpleTextBlockId').value;
    
    // PENTING: Hitung sort_id dari posisi AKTUAL di blocklist, bukan dari block ID!
    const blocks = document.querySelectorAll('.block-item');
    let sortId = 1;
    blocks.forEach((block, index) => {
        if (block.id === currentEditBlockId) {
            sortId = index + 1;
        }
    });
    
    console.log('📊 Sort ID calculation:', {
        blockId: currentEditBlockId,
        extractedSortId: sortId,
        currentBlockCounter: blockCounter
    });
    
    // Ambil element-element untuk loading state
    const saveBtn = document.getElementById('saveSimpleTextBtn');
    const saveIconCheck = document.getElementById('saveSimpleTextIconCheck');
    const saveIconLoading = document.getElementById('saveSimpleTextIconLoading');
    const saveButtonText = document.getElementById('saveSimpleTextButtonText');
    
    // Show loading state
    saveBtn.disabled = true;
    saveIconCheck.classList.add('hidden');
    saveIconLoading.classList.remove('hidden');
    saveButtonText.textContent = 'Saving...';
    
    try {
        let response;
        const data = {
            pages_id: window.pageId,
            type: 'simple-text',
            content: content,
            sort_id: sortId
        };
        
        if (shortcodeId) {
            // Update existing shortcode
            response = await fetch(`/bagoosh/page-shortcode/update/${shortcodeId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json', // ⭐ Pastikan Laravel return JSON (bukan HTML!)
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            });
        } else {
            // Create new shortcode
            response = await fetch('/bagoosh/page-shortcode/store', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json', // ⭐ Pastikan Laravel return JSON (bukan HTML!)
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            });
        }
        
        const result = await response.json();
        
        if (result.success) {
            // Update block dengan shortcode ID
            if (result.shortcode_id) {
                blockElement.dataset.shortcodeId = result.shortcode_id;
                // ⭐ CRITICAL: Update HIDDEN INPUT FIELD juga!
                // Tanpa ini, save kedua akan create baru, dan delete tidak bisa hapus database!
                document.getElementById('simpleTextBlockId').value = result.shortcode_id;
            }
            
            // PENTING: Simpan ke cache untuk performa dan konsistensi data
            blockDataCache[currentEditBlockId] = {
                id: result.shortcode_id || shortcodeId,
                content: content,
                type: 'simple-text',
                sort_id: sortId
            };
            
            console.log('💾 Saved to cache:', currentEditBlockId, blockDataCache[currentEditBlockId]);
            
            // Update tampilan block
            const contentEl = blockElement.querySelector('p');
            if (contentEl) {
                contentEl.textContent = content || 'Simple text content';
            }
            
            // Reset button state
            saveBtn.disabled = false;
            saveIconCheck.classList.remove('hidden');
            saveIconLoading.classList.add('hidden');
            saveButtonText.textContent = 'Saved!';
            
            // Close modal after delay
            setTimeout(() => {
                saveButtonText.textContent = 'Save';
                closeEditSimpleTextModal();
            }, 1000);
        } else {
            throw new Error(result.message || 'Failed to save');
        }
    } catch (error) {
        console.error('Error saving simple text block:', error);
        alert('Failed to save block: ' + error.message);
        
        // Reset button state
        saveBtn.disabled = false;
        saveIconCheck.classList.remove('hidden');
        saveIconLoading.classList.add('hidden');
        saveButtonText.textContent = 'Save';
    }
}

async function deleteSimpleTextBlock() {
    if (!currentEditBlockId) return;
    if (!confirm('Are you sure you want to delete this block?')) return;

    // ⭐ PENTING: Ambil shortcodeId dari hidden input field (bukan dari dataset!)
    const shortcodeId = document.getElementById('simpleTextBlockId').value;
    
    const deleteBtn = document.getElementById('deleteSimpleTextBtn');
    const deleteIconTrash = document.getElementById('deleteSimpleTextIconTrash');
    const deleteIconLoading = document.getElementById('deleteSimpleTextIconLoading');
    const deleteButtonText = document.getElementById('deleteSimpleTextButtonText');
    
    deleteBtn.disabled = true;
    deleteIconTrash.classList.add('hidden');
    deleteIconLoading.classList.remove('hidden');
    deleteButtonText.textContent = 'Deleting...';

    try {
        // Hanya hapus dari database jika shortcodeId ada (sudah pernah di-save)
        if (shortcodeId) {
            console.log('🗑️ Deleting simple text block from database:', shortcodeId);
            
            const response = await fetch(`/bagoosh/page-shortcode/delete/${shortcodeId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            
            if (!response.ok) {
                const result = await response.json();
                throw new Error(result.message || 'Failed to delete');
            }
            
            console.log('✅ Deleted from database');
        } else {
            console.log('ℹ️ Block belum disave, skip API call');
        }
        
        // Hapus dari cache
        if (blockDataCache[currentEditBlockId]) {
            delete blockDataCache[currentEditBlockId];
            console.log('🗑️ Deleted from cache:', currentEditBlockId);
        }
        
        closeModalWithTransition('editSimpleTextModal', () => {
            const block = document.getElementById(currentEditBlockId);
            if (block) {
                block.style.transition = 'opacity 300ms ease-out';
                block.style.opacity = '0';
                setTimeout(() => {
                    block.remove();
                    checkEmptyState();
                    updateBlockOrder();
                }, 300);
            }
            currentEditBlockId = null;
            deleteBtn.disabled = false;
            deleteIconTrash.classList.remove('hidden');
            deleteIconLoading.classList.add('hidden');
            deleteButtonText.textContent = 'Delete';
            alert('Block deleted successfully!');
        });
        
    } catch (error) {
        console.error('Error deleting simple text block:', error);
        alert('Failed to delete simple text block: ' + error.message);
        
        // Restore button state
        deleteBtn.disabled = false;
        deleteIconTrash.classList.remove('hidden');
        deleteIconLoading.classList.add('hidden');
        deleteButtonText.textContent = 'Delete';
    }
}

// ===================================================================
// BAGIAN 10: FUNGSI MODAL TEXT EDITOR BLOCK
// ===================================================================

function closeEditTextEditorModal() {
    closeModalWithTransition('editTextEditorModal', () => {
        currentEditBlockId = null;
    });
}

async function saveTextEditorBlock() {
    if (!currentEditBlockId) return;
    
    // Ambil konten dari Trix editor
    // Trix = rich text editor (seperti Microsoft Word di browser)
    const content = document.getElementById('textEditorContent').value;
    const blockElement = document.getElementById(currentEditBlockId);
    
    // ⭐ PENTING: Ambil shortcodeId dari HIDDEN INPUT FIELD (bukan dataset!)
    // Hidden field adalah single source of truth yang PASTI ter-update setelah save
    const shortcodeId = document.getElementById('textEditorBlockId').value;
    
    // PENTING: Hitung sort_id dari posisi AKTUAL di blocklist, bukan dari block ID!
    const blocks = document.querySelectorAll('.block-item');
    let sortId = 1;
    blocks.forEach((block, index) => {
        if (block.id === currentEditBlockId) {
            sortId = index + 1;
        }
    });
    
    console.log('📊 Sort ID calculation:', {
        blockId: currentEditBlockId,
        extractedSortId: sortId,
        currentBlockCounter: blockCounter
    });
    
    // Ambil element-element untuk loading state
    const saveBtn = document.getElementById('saveTextEditorBtn');
    const saveIconCheck = document.getElementById('saveTextEditorIconCheck');
    const saveIconLoading = document.getElementById('saveTextEditorIconLoading');
    const saveButtonText = document.getElementById('saveTextEditorButtonText');
    
    // Show loading state
    saveBtn.disabled = true;
    saveIconCheck.classList.add('hidden');
    saveIconLoading.classList.remove('hidden');
    saveButtonText.textContent = 'Saving...';
    
    try {
        let response;
        const data = {
            pages_id: window.pageId,
            type: 'text-editor',
            content: content,
            sort_id: sortId
        };
        
        if (shortcodeId) {
            // Update existing shortcode
            response = await fetch(`/bagoosh/page-shortcode/update/${shortcodeId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json', // ⭐ Pastikan Laravel return JSON (bukan HTML!)
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            });
        } else {
            // Create new shortcode
            response = await fetch('/bagoosh/page-shortcode/store', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json', // ⭐ Pastikan Laravel return JSON (bukan HTML!)
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            });
        }
        
        const result = await response.json();
        
        if (result.success) {
            // Update block dengan shortcode ID
            if (result.shortcode_id) {
                blockElement.dataset.shortcodeId = result.shortcode_id;
                // ⭐ CRITICAL: Update HIDDEN INPUT FIELD juga!
                // Tanpa ini, save kedua akan create baru, dan delete tidak bisa hapus database!
                document.getElementById('textEditorBlockId').value = result.shortcode_id;
            }
            
            // PENTING: Simpan ke cache untuk performa dan konsistensi data
            blockDataCache[currentEditBlockId] = {
                id: result.shortcode_id || shortcodeId,
                content: content,
                type: 'text-editor',
                sort_id: sortId
            };
            
            console.log('💾 Saved to cache:', currentEditBlockId, blockDataCache[currentEditBlockId]);
            
            // Reset button state
            saveBtn.disabled = false;
            saveIconCheck.classList.remove('hidden');
            saveIconLoading.classList.add('hidden');
            saveButtonText.textContent = 'Saved!';
            
            // Close modal after delay
            setTimeout(() => {
                saveButtonText.textContent = 'Save';
                closeEditTextEditorModal();
            }, 1000);
        } else {
            throw new Error(result.message || 'Failed to save');
        }
    } catch (error) {
        console.error('Error saving text editor block:', error);
        alert('Failed to save block: ' + error.message);
        
        // Reset button state
        saveBtn.disabled = false;
        saveIconCheck.classList.remove('hidden');
        saveIconLoading.classList.add('hidden');
        saveButtonText.textContent = 'Save';
    }
}

async function deleteTextEditorBlock() {
    if (!currentEditBlockId) return;
    if (!confirm('Are you sure you want to delete this block?')) return;

    // ⭐ PENTING: Ambil shortcodeId dari hidden input field (bukan dari dataset!)
    const shortcodeId = document.getElementById('textEditorBlockId').value;
    
    const deleteBtn = document.getElementById('deleteTextEditorBtn');
    const deleteIconTrash = document.getElementById('deleteTextEditorIconTrash');
    const deleteIconLoading = document.getElementById('deleteTextEditorIconLoading');
    const deleteButtonText = document.getElementById('deleteTextEditorButtonText');
    
    deleteBtn.disabled = true;
    deleteIconTrash.classList.add('hidden');
    deleteIconLoading.classList.remove('hidden');
    deleteButtonText.textContent = 'Deleting...';

    try {
        // Hanya hapus dari database jika shortcodeId ada (sudah pernah di-save)
        if (shortcodeId) {
            console.log('🗑️ Deleting text editor block from database:', shortcodeId);
            
            const response = await fetch(`/bagoosh/page-shortcode/delete/${shortcodeId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            
            if (!response.ok) {
                const result = await response.json();
                throw new Error(result.message || 'Failed to delete');
            }
            
            console.log('✅ Deleted from database');
        } else {
            console.log('ℹ️ Block belum disave, skip API call');
        }
        
        // Hapus dari cache
        if (blockDataCache[currentEditBlockId]) {
            delete blockDataCache[currentEditBlockId];
            console.log('🗑️ Deleted from cache:', currentEditBlockId);
        }
        
        closeModalWithTransition('editTextEditorModal', () => {
            const block = document.getElementById(currentEditBlockId);
            if (block) {
                block.style.transition = 'opacity 300ms ease-out';
                block.style.opacity = '0';
                setTimeout(() => {
                    block.remove();
                    checkEmptyState();
                    updateBlockOrder();
                }, 300);
            }
            currentEditBlockId = null;
            deleteBtn.disabled = false;
            deleteIconTrash.classList.remove('hidden');
            deleteIconLoading.classList.add('hidden');
            deleteButtonText.textContent = 'Delete';
            alert('Block deleted successfully!');
        });
        
    } catch (error) {
        console.error('Error deleting text editor block:', error);
        alert('Failed to delete text editor block: ' + error.message);
        
        // Restore button state
        deleteBtn.disabled = false;
        deleteIconTrash.classList.remove('hidden');
        deleteIconLoading.classList.add('hidden');
        deleteButtonText.textContent = 'Delete';
    }
}

// ===================================================================
// BAGIAN 11: FUNGSI MODAL BRANDS BLOCK
// ===================================================================

function closeEditBrandsModal() {
    closeModalWithTransition('editBrandsModal', () => {
        currentEditBlockId = null;
    });
}

async function saveBrandsBlock() {
    if (!currentEditBlockId) return;
    
    // Ambil semua checkbox yang dicentang
    const checkboxes = document.querySelectorAll('#brandsList input[type="checkbox"]:checked');
    const selectedBrands = Array.from(checkboxes).map(cb => parseInt(cb.value));
    
    // Validasi minimal harus pilih 1 brand
    if (selectedBrands.length === 0) {
        alert('Please select at least one brand');
        return;
    }
    
    // Hitung sort_id dari posisi AKTUAL di blocklist
    const sortId = getCurrentSortId(currentEditBlockId);
    
    const shortcodeId = document.getElementById('brandsBlockId').value;
    const pageId = window.pageId;
    
    const saveBtn = document.getElementById('saveBrandsBtn');
    const saveIconCheck = document.getElementById('saveBrandsIconCheck');
    const saveIconLoading = document.getElementById('saveBrandsIconLoading');
    const saveButtonText = document.getElementById('saveBrandsButtonText');
    
    // Disable button dan tampilkan loading
    saveBtn.disabled = true;
    saveIconCheck.classList.add('hidden');
    saveIconLoading.classList.remove('hidden');
    saveButtonText.textContent = 'Saving...';
    
    try {
        const data = {
            type: 'brands',
            section_brand_id: selectedBrands,
            pages_id: pageId,
            sort_id: sortId
        };
        
        // Tentukan endpoint (create atau update)
        const url = shortcodeId 
            ? `/bagoosh/page-shortcode/update/${shortcodeId}`
            : '/bagoosh/page-shortcode/store';
        const method = shortcodeId ? 'PUT' : 'POST';
        
        console.log('💾 Saving brands block:', { url, method, data });
        
        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        
        if (!response.ok) {
            throw new Error(result.message || 'Failed to save');
        }
        
        // Update hidden input dengan ID baru (untuk update berikutnya)
        if (result.data && result.data.id) {
            document.getElementById('brandsBlockId').value = result.data.id;
            
            // Simpan ke cache
            blockDataCache[currentEditBlockId] = {
                id: result.data.id,
                type: 'brands',
                section_brand_id: selectedBrands,
                sort_id: sortId
            };
            console.log('📦 Saved to cache:', blockDataCache[currentEditBlockId]);
        }
        
        // Update tampilan block di UI dengan jumlah brands terpilih
        const block = document.getElementById(currentEditBlockId);
        if (block) {
            const blockContent = block.querySelector('.block-content');
            if (blockContent) {
                blockContent.innerHTML = `
                    <div class="flex items-center gap-2 text-sm text-slate-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>${selectedBrands.length} brand(s) selected</span>
                    </div>
                `;
            }
        }
        
        closeEditBrandsModal();
        alert('Brands saved successfully!');
        
    } catch (error) {
        console.error('Error saving brands:', error);
        alert('Failed to save brands: ' + error.message);
    } finally {
        // Restore button state
        saveBtn.disabled = false;
        saveIconCheck.classList.remove('hidden');
        saveIconLoading.classList.add('hidden');
        saveButtonText.textContent = 'Save';
    }
}

async function deleteBrandsBlock() {
    if (!currentEditBlockId) return;
    if (!confirm('Are you sure you want to delete this block?')) return;

    const shortcodeId = document.getElementById('brandsBlockId').value;
    
    const deleteBtn = document.getElementById('deleteBrandsBtn');
    const deleteIconTrash = document.getElementById('deleteBrandsIconTrash');
    const deleteIconLoading = document.getElementById('deleteBrandsIconLoading');
    const deleteButtonText = document.getElementById('deleteBrandsButtonText');
    
    deleteBtn.disabled = true;
    deleteIconTrash.classList.add('hidden');
    deleteIconLoading.classList.remove('hidden');
    deleteButtonText.textContent = 'Deleting...';

    try {
        // Hanya hapus dari database jika shortcodeId ada (sudah pernah di-save)
        if (shortcodeId) {
            console.log('🗑️ Deleting brands block from database:', shortcodeId);
            
            const response = await fetch(`/bagoosh/page-shortcode/delete/${shortcodeId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            
            if (!response.ok) {
                const result = await response.json();
                throw new Error(result.message || 'Failed to delete');
            }
            
            console.log('✅ Deleted from database');
        } else {
            console.log('ℹ️ Block belum disave, skip API call');
        }
        
        // Hapus dari cache
        if (blockDataCache[currentEditBlockId]) {
            delete blockDataCache[currentEditBlockId];
            console.log('🗑️ Deleted from cache:', currentEditBlockId);
        }
        
        closeModalWithTransition('editBrandsModal', () => {
            const block = document.getElementById(currentEditBlockId);
            if (block) {
                block.style.transition = 'opacity 300ms ease-out';
                block.style.opacity = '0';
                setTimeout(() => {
                    block.remove();
                    checkEmptyState();
                    updateBlockOrder();
                }, 300);
            }
            currentEditBlockId = null;
            deleteBtn.disabled = false;
            deleteIconTrash.classList.remove('hidden');
            deleteIconLoading.classList.add('hidden');
            deleteButtonText.textContent = 'Delete';
            alert('Block deleted successfully!');
        });
        
    } catch (error) {
        console.error('Error deleting brands:', error);
        alert('Failed to delete brands: ' + error.message);
        
        // Restore button state
        deleteBtn.disabled = false;
        deleteIconTrash.classList.remove('hidden');
        deleteIconLoading.classList.add('hidden');
        deleteButtonText.textContent = 'Delete';
    }
}

// ===================================================================
// BAGIAN 12: FUNGSI MODAL COMPLETE COUNTS BLOCK
// ===================================================================

function closeEditCompleteCountsModal() {
    closeModalWithTransition('editCompleteCountsModal', () => {
        currentEditBlockId = null;
    });
}

async function saveCompleteCountsBlock() {
    if (!currentEditBlockId) return;
    
    // Ambil data dari form
    const title = document.getElementById('completeCountsTitle').value.trim();
    const subtitle = document.getElementById('completeCountsSubtitle').value.trim();
    const content = document.getElementById('completeCountsContent').value.trim();
    
    // Ambil semua checkbox yang dicentang
    const checkboxes = document.querySelectorAll('#completeCountsList input[type="checkbox"]:checked');
    const selectedCounts = Array.from(checkboxes).map(cb => parseInt(cb.value));
    
    // Validasi minimal harus pilih 1 complete count
    if (selectedCounts.length === 0) {
        alert('Please select at least one complete count');
        return;
    }
    
    // Hitung sort_id dari posisi AKTUAL di blocklist
    const sortId = getCurrentSortId(currentEditBlockId);
    
    const shortcodeId = document.getElementById('completeCountsBlockId').value;
    const pageId = window.pageId;
    
    const saveBtn = document.getElementById('saveCompleteCountsBtn');
    const saveIconCheck = document.getElementById('saveCompleteCountsIconCheck');
    const saveIconLoading = document.getElementById('saveCompleteCountsIconLoading');
    const saveButtonText = document.getElementById('saveCompleteCountsButtonText');
    
    // Disable button dan tampilkan loading
    saveBtn.disabled = true;
    saveIconCheck.classList.add('hidden');
    saveIconLoading.classList.remove('hidden');
    saveButtonText.textContent = 'Saving...';
    
    try {
        const data = {
            type: 'complete-counts',
            title: title,
            subtitle: subtitle,
            content: content,
            section_completecount_id: selectedCounts,
            pages_id: pageId,
            sort_id: sortId
        };
        
        // Tentukan endpoint (create atau update)
        const url = shortcodeId 
            ? `/bagoosh/page-shortcode/update/${shortcodeId}`
            : '/bagoosh/page-shortcode/store';
        const method = shortcodeId ? 'PUT' : 'POST';
        
        console.log('💾 Saving complete counts block:', { url, method, data });
        
        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        
        if (!response.ok) {
            throw new Error(result.message || 'Failed to save');
        }
        
        // Update hidden input dengan ID baru (untuk update berikutnya)
        if (result.data && result.data.id) {
            document.getElementById('completeCountsBlockId').value = result.data.id;
            
            // Simpan ke cache
            blockDataCache[currentEditBlockId] = {
                id: result.data.id,
                type: 'complete-counts',
                title: title,
                subtitle: subtitle,
                content: content,
                section_completecount_id: selectedCounts,
                sort_id: sortId
            };
            console.log('📦 Saved to cache:', blockDataCache[currentEditBlockId]);
        }
        
        // Update tampilan block di UI
        const block = document.getElementById(currentEditBlockId);
        if (block) {
            const blockContent = block.querySelector('.block-content');
            if (blockContent) {
                blockContent.innerHTML = `
                    <div class="space-y-1">
                        ${title ? `<div class="font-semibold text-slate-700">${title}</div>` : ''}
                        <div class="flex items-center gap-2 text-sm text-slate-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>${selectedCounts.length} count(s) selected</span>
                        </div>
                    </div>
                `;
            }
        }
        
        closeEditCompleteCountsModal();
        alert('Complete Counts saved successfully!');
        
    } catch (error) {
        console.error('Error saving complete counts:', error);
        alert('Failed to save complete counts: ' + error.message);
    } finally {
        // Restore button state
        saveBtn.disabled = false;
        saveIconCheck.classList.remove('hidden');
        saveIconLoading.classList.add('hidden');
        saveButtonText.textContent = 'Save';
    }
}

async function deleteCompleteCountsBlock() {
    if (!currentEditBlockId) return;
    if (!confirm('Are you sure you want to delete this block?')) return;

    const shortcodeId = document.getElementById('completeCountsBlockId').value;
    
    const deleteBtn = document.getElementById('deleteCompleteCountsBtn');
    const deleteIconTrash = document.getElementById('deleteCompleteCountsIconTrash');
    const deleteIconLoading = document.getElementById('deleteCompleteCountsIconLoading');
    const deleteButtonText = document.getElementById('deleteCompleteCountsButtonText');
    
    deleteBtn.disabled = true;
    deleteIconTrash.classList.add('hidden');
    deleteIconLoading.classList.remove('hidden');
    deleteButtonText.textContent = 'Deleting...';

    try {
        // Hanya hapus dari database jika shortcodeId ada (sudah pernah di-save)
        if (shortcodeId) {
            console.log('🗑️ Deleting complete counts block from database:', shortcodeId);
            
            const response = await fetch(`/bagoosh/page-shortcode/delete/${shortcodeId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            
            if (!response.ok) {
                const result = await response.json();
                throw new Error(result.message || 'Failed to delete');
            }
            
            console.log('✅ Deleted from database');
        } else {
            console.log('ℹ️ Block belum disave, skip API call');
        }
        
        // Hapus dari cache
        if (blockDataCache[currentEditBlockId]) {
            delete blockDataCache[currentEditBlockId];
            console.log('🗑️ Deleted from cache:', currentEditBlockId);
        }
        
        closeModalWithTransition('editCompleteCountsModal', () => {
            const block = document.getElementById(currentEditBlockId);
            if (block) {
                block.style.transition = 'opacity 300ms ease-out';
                block.style.opacity = '0';
                setTimeout(() => {
                    block.remove();
                    checkEmptyState();
                    updateBlockOrder();
                }, 300);
            }
            currentEditBlockId = null;
            deleteBtn.disabled = false;
            deleteIconTrash.classList.remove('hidden');
            deleteIconLoading.classList.add('hidden');
            deleteButtonText.textContent = 'Delete';
            alert('Block deleted successfully!');
        });
        
    } catch (error) {
        console.error('Error deleting complete counts:', error);
        alert('Failed to delete complete counts: ' + error.message);
        
        // Restore button state
        deleteBtn.disabled = false;
        deleteIconTrash.classList.remove('hidden');
        deleteIconLoading.classList.add('hidden');
        deleteButtonText.textContent = 'Delete';
    }
}

// ===================================================================
// BAGIAN 13: FUNGSI HERO BANNER - PEMILIHAN STYLE
// ===================================================================

/**
 * Menutup modal pemilihan style hero banner
 */
function closeSelectHeroStyleModal() {
    closeModalWithTransition('selectHeroStyleModal', () => {
        // Jika ada pending block (block yang menunggu style)
        if (pendingHeroBannerBlockId) {
            // Hapus pending block karena user cancel
            pendingHeroBannerBlockId = null;
            blockCounter--; // Kurangi counter karena block dibatalkan
        }
    });
}

/**
 * Memilih style untuk hero banner dan membuat block-nya
 * 
 * @param {string} style - Nomor style yang dipilih ('1', '2', atau '3')
 */
function selectHeroStyle(style) {
    // Jika tidak ada pending block, keluar
    if (!pendingHeroBannerBlockId) return;
    
    // Ambil ID dan config block
    const blockId = pendingHeroBannerBlockId;
    const config = blockConfig['hero-banner'];
    const blocksList = document.getElementById('blocksList');
    
    // Template literal = string dengan backtick ` ` yang bisa insert variable
    // ${variable} = cara insert variable ke dalam string
    // \n = new line (enter)
    const blockHTML = `
        <div id="${blockId}" data-type="hero-banner" data-style="${style}" class="block-item bg-white hover:bg-slate-50 transition-all group">
            <div class="flex items-center gap-4 p-4">
                <div class="drag-handle cursor-move text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                    </svg>
                </div>
                <div class="flex-1 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-${config.color}-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-${config.color}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            ${getBlockIcon('hero-banner')}
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <span class="block-order inline-flex items-center justify-center w-6 h-6 rounded-full bg-slate-200 text-slate-700 text-xs font-bold">${blockCounter}</span>
                            <h3 class="font-semibold text-slate-800">${config.name} - Style ${style}</h3>
                        </div>
                        <p class="text-xs text-slate-500 mt-0.5">Click to configure</p>
                    </div>
                </div>
                <button type="button" 
                        onclick="openEditModal('${blockId}')"
                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium text-sm transition-all opacity-0 group-hover:opacity-100 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Configure
                </button>
            </div>
        </div>
    `;
    
    // insertAdjacentHTML = insert HTML ke posisi tertentu
    // 'beforeend' = di dalam element, setelah child terakhir
    blocksList.insertAdjacentHTML('beforeend', blockHTML);
    
    // Reset pending block ID
    pendingHeroBannerBlockId = null;
    
    // Tutup modal pemilihan style
    closeModalWithTransition('selectHeroStyleModal');
    
    // Cek apakah list kosong atau tidak
    checkEmptyState();
    
    // Update nomor urutan
    updateBlockOrder();
    
    // Re-initialize sortable jika belum ada
    if (!sortable) {
        initSortable();
    }
}

// ===================================================================
// BAGIAN 14: FUNGSI HERO BANNER - EDIT & SAVE
// ===================================================================

// Variable global untuk menyimpan product categories
let cachedProductCategories = [];

/**
 * Populate dropdown kategori produk untuk semua tabs
 */
function populateHeroCategories() {
    // Check if data ready
    if (cachedProductCategories.length === 0) {
        console.warn('⚠️ Product categories not loaded yet');
        return false;
    }
    
    // Loop untuk 6 tabs
    for (let i = 1; i <= 6; i++) {
        const select = document.getElementById(`heroCategory${i}`);
        if (!select) continue;
        
        // Clear existing options (kecuali option pertama "Select Category")
        select.innerHTML = '<option value="">Select Category</option>';
        
        // Add options dari cached categories
        cachedProductCategories.forEach(category => {
            const option = document.createElement('option');
            option.value = category.id;
            option.textContent = category.name;
            select.appendChild(option);
        });
    }
    
    console.log('✅ Hero categories populated:', cachedProductCategories.length, 'items');
    return true;
}

/**
 * Switch antara tabs di modal hero banner
 */
function switchHeroTab(tabNumber) {
    // Hide semua tab content
    for (let i = 1; i <= 6; i++) {
        const tabContent = document.getElementById(`heroTab${i}`);
        const tabBtn = document.querySelector(`[data-tab="${i}"]`);
        
        if (tabContent) {
            tabContent.classList.add('hidden');
        }
        
        if (tabBtn) {
            tabBtn.classList.remove('border-indigo-600', 'text-indigo-600');
            tabBtn.classList.add('border-transparent', 'text-slate-600');
        }
    }
    
    // Show selected tab
    const selectedTab = document.getElementById(`heroTab${tabNumber}`);
    const selectedBtn = document.querySelector(`[data-tab="${tabNumber}"]`);
    
    if (selectedTab) {
        selectedTab.classList.remove('hidden');
    }
    
    if (selectedBtn) {
        selectedBtn.classList.remove('border-transparent', 'text-slate-600');
        selectedBtn.classList.add('border-indigo-600', 'text-indigo-600');
    }
}

/**
 * Handle image upload dan konversi ke WebP
 */
function normalizeHeroImageForStorage(imageUrl) {
    if (!imageUrl) return '';

    const raw = String(imageUrl).trim();
    if (!raw) return '';

    if (raw.startsWith('data:image')) return raw;

    let value = raw;
    if (value.startsWith('http://') || value.startsWith('https://')) {
        try {
            const parsed = new URL(value);
            value = parsed.pathname || value;
        } catch (e) {
            return raw;
        }
    }

    if (value.startsWith('/storage/')) {
        return value.replace(/^\/storage\//, '');
    }

    if (value.startsWith('storage/')) {
        return value.replace(/^storage\//, '');
    }

    return value.replace(/^\//, '');
}

function normalizeHeroImageForPreview(imageUrl) {
    if (!imageUrl) return '';

    const raw = String(imageUrl).trim();
    if (!raw) return '';

    if (raw.startsWith('data:image') || raw.startsWith('http://') || raw.startsWith('https://')) {
        return raw;
    }

    if (raw.startsWith('/storage/')) {
        return raw;
    }

    if (raw.startsWith('storage/')) {
        return `/${raw}`;
    }

    if (raw.startsWith('/')) {
        return raw;
    }

    return `/storage/${raw}`;
}

function setHeroBannerImage(tabNumber, imageUrl) {
    if (!window.heroBannerImages) {
        window.heroBannerImages = {};
    }

    const storageValue = normalizeHeroImageForStorage(imageUrl);
    const previewValue = normalizeHeroImageForPreview(imageUrl);
    window.heroBannerImages[`tab${tabNumber}`] = storageValue;

    window.dispatchEvent(new CustomEvent('media-selected', {
        detail: {
            fieldId: `heroImage${tabNumber}`,
            url: previewValue,
        }
    }));
}

window.addEventListener('media-selected', (event) => {
    const fieldId = event?.detail?.fieldId || '';
    if (!fieldId.startsWith('heroImage')) return;

    const tabNumber = fieldId.replace('heroImage', '');
    if (!tabNumber) return;

    const url = event?.detail?.url || '';
    const storageValue = normalizeHeroImageForStorage(url);

    if (!window.heroBannerImages) {
        window.heroBannerImages = {};
    }

    window.heroBannerImages[`tab${tabNumber}`] = storageValue;
});

async function handleHeroImageUpload(tabNumber, input) {
    const file = input.files[0];
    if (!file) return;
    
    // Validasi tipe file
    if (!file.type.startsWith('image/')) {
        alert('Please select an image file');
        input.value = '';
        return;
    }
    
    try {
        // Convert image to WebP
        const webpDataUrl = await convertImageToWebP(file);
        
        // Show preview
        const preview = document.getElementById(`heroImagePreview${tabNumber}`);
        const previewImg = preview?.querySelector('img');
        
        if (preview && previewImg) {
            previewImg.src = webpDataUrl;
            preview.classList.remove('hidden');
        }
        
        // Store in temporary variable (akan di-upload saat save)
        setHeroBannerImage(tabNumber, webpDataUrl);
        
        console.log(`✅ Image for tab ${tabNumber} converted to WebP`);
    } catch (error) {
        console.error('❌ Error converting image:', error);
        alert('Error processing image');
        input.value = '';
    }
}

/**
 * Convert image to WebP format
 */
function convertImageToWebP(file) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        
        reader.onload = (e) => {
            const img = new Image();
            
            img.onload = () => {
                // Create canvas
                const canvas = document.createElement('canvas');
                canvas.width = img.width;
                canvas.height = img.height;
                
                // Draw image to canvas
                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0);
                
                // Convert to WebP
                const webpDataUrl = canvas.toBlob((blob) => {
                    const reader = new FileReader();
                    reader.onloadend = () => resolve(reader.result);
                    reader.onerror = reject;
                    reader.readAsDataURL(blob);
                }, 'image/webp', 0.9);
            };
            
            img.onerror = reject;
            img.src = e.target.result;
        };
        
        reader.onerror = reject;
        reader.readAsDataURL(file);
    });
}

/**
 * Open modal edit hero banner
 */
async function openEditHeroBannerModal() {
    const block = document.getElementById(currentEditBlockId);
    if (!block) return;
    
    const style = block.dataset.style || '1';
    const shortcodeId = block.dataset.shortcodeId;
    
    // Hanya style 1 yang bisa dibuka modal-nya (sesuai requirement)
    if (style !== '1') {
        alert('Configuration for Style 2 and Style 3 coming soon!');
        return;
    }
    
    // Update display style
    document.getElementById('heroBannerStyleDisplay').textContent = style;
    
    // Check if product categories ready (harus sudah di-preload)
    if (cachedProductCategories.length === 0) {
        alert('Product categories are still loading. Please wait a moment and try again.');
        console.error('❌ Product categories not ready yet');
        return;
    }
    
    // Populate dropdowns
    const populated = populateHeroCategories();
    if (!populated) {
        alert('Failed to load product categories. Please refresh the page.');
        return;
    }
    
    // Load data dari cache jika ada
    if (blockDataCache[currentEditBlockId]) {
        const cachedData = blockDataCache[currentEditBlockId];
        console.log('🔍 Hero Banner Style 1 - Cached data:', cachedData);
        
        // Data bisa berupa direct cache atau dari relationship
        const heroData = cachedData.hero || cachedData;
        console.log('🎯 Hero data to use:', heroData);
        
        // Parse product_category_id dari JSON string jika perlu
        let productCategoryIds = cachedData.product_category_id;
        if (typeof productCategoryIds === 'string') {
            try {
                productCategoryIds = JSON.parse(productCategoryIds);
            } catch (e) {
                console.error('Failed to parse product_category_id:', e);
                productCategoryIds = [];
            }
        }
        if (!Array.isArray(productCategoryIds)) {
            productCategoryIds = [];
        }
        
        console.log('📦 Product Category IDs:', productCategoryIds);
        
        // ⭐ MAPPING FIELD DARI DATABASE KE FORM
        // Database menyimpan: title, title_2, title_3, ... title_6
        // Form butuh: Tab 1, Tab 2, Tab 3, ... Tab 6
        
        // Populate form dengan data dari hero relationship
        for (let i = 1; i <= 6; i++) {
            // Tentukan nama field di database berdasarkan tab number
            const titleField = i === 1 ? 'title' : `title_${i}`;
            const descField = i === 1 ? 'description' : `description_${i}`;
            const actionLabelField = i === 1 ? 'action_label' : `action_label_${i}`;
            const actionUrlField = i === 1 ? 'action_url' : `action_url_${i}`;
            const imageField = i === 1 ? 'image' : `image_${i}`;
            
            console.log(`Tab ${i} - Looking for fields:`, {
                title: titleField,
                desc: descField,
                actionLabel: actionLabelField,
                actionUrl: actionUrlField,
                image: imageField
            });
            console.log(`Tab ${i} - Data from heroData:`, {
                title: heroData[titleField],
                description: heroData[descField],
                actionLabel: heroData[actionLabelField],
                actionUrl: heroData[actionUrlField],
                image: heroData[imageField] ? heroData[imageField].substring(0, 50) + '...' : null
            });
            
            // Set category dari product_category_id array (index ke i-1)
            const categorySelect = document.getElementById(`heroCategory${i}`);
            if (categorySelect) {
                const categoryId = productCategoryIds[i - 1];
                if (categoryId) {
                    categorySelect.value = categoryId;
                    console.log(`✅ Tab ${i} - Set category to:`, categoryId);
                }
            }
            
            // Set title
            const titleInput = document.getElementById(`heroTitle${i}`);
            if (titleInput) {
                const titleValue = heroData[titleField];
                if (titleValue) {
                    titleInput.value = titleValue;
                    console.log(`✅ Tab ${i} - Set title:`, titleValue);
                }
            }
            
            // Set description
            const descInput = document.getElementById(`heroDescription${i}`);
            if (descInput) {
                const descValue = heroData[descField];
                if (descValue) {
                    descInput.value = descValue;
                    console.log(`✅ Tab ${i} - Set description:`, descValue.substring(0, 30) + '...');
                }
            }
            
            // Set action label
            const actionLabelInput = document.getElementById(`heroActionLabel${i}`);
            if (actionLabelInput) {
                const actionLabelValue = heroData[actionLabelField];
                if (actionLabelValue) {
                    actionLabelInput.value = actionLabelValue;
                    console.log(`✅ Tab ${i} - Set action label:`, actionLabelValue);
                }
            }
            
            // Set action URL
            const actionUrlInput = document.getElementById(`heroActionUrl${i}`);
            if (actionUrlInput) {
                const actionUrlValue = heroData[actionUrlField];
                if (actionUrlValue) {
                    actionUrlInput.value = actionUrlValue;
                    console.log(`✅ Tab ${i} - Set action URL:`, actionUrlValue);
                }
            }
            
            // Set image preview / media picker value
            const imageValue = heroData[imageField];
            if (imageValue) {
                setHeroBannerImage(i, imageValue);
                console.log(`✅ Tab ${i} - Set image preview:`, imageValue.substring(0, 50) + '...');
            } else {
                setHeroBannerImage(i, '');
            }
        }
        
        console.log('✅ Hero Banner Style 1 - Form populated successfully');
    } else if (shortcodeId) {
        // Load data dari database jika belum ada di cache
        try {
            const response = await fetch(`/bagoosh/page-shortcode/show/${shortcodeId}`, {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                }
            });
            
            const result = await response.json();
            
            if (result.success && result.data) {
                // Store ke cache
                blockDataCache[currentEditBlockId] = result.data;
                
                // Populate form (recursive call)
                openEditHeroBannerModal();
                return;
            }
        } catch (error) {
            console.error('❌ Error loading data:', error);
        }
    }
    
    // Show tab 1 by default
    switchHeroTab(1);
    
    // Show modal
    document.getElementById('editHeroBannerModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

/**
 * Close modal edit hero banner
 */
function closeEditHeroBannerModal() {
    closeModalWithTransition('editHeroBannerModal', () => {
        // Clear temporary images
        if (window.heroBannerImages) {
            window.heroBannerImages = {};
        }
        
        // Reset form
        for (let i = 1; i <= 6; i++) {
            const categorySelect = document.getElementById(`heroCategory${i}`);
            const titleInput = document.getElementById(`heroTitle${i}`);
            const descInput = document.getElementById(`heroDescription${i}`);
            const actionLabelInput = document.getElementById(`heroActionLabel${i}`);
            const actionUrlInput = document.getElementById(`heroActionUrl${i}`);
            const imageInput = document.getElementById(`heroImage${i}`);
            const preview = document.getElementById(`heroImagePreview${i}`);
            
            if (categorySelect) categorySelect.value = '';
            if (titleInput) titleInput.value = '';
            if (descInput) descInput.value = '';
            if (actionLabelInput) actionLabelInput.value = '';
            if (actionUrlInput) actionUrlInput.value = '';
            if (imageInput) imageInput.value = '';
            if (preview) preview.classList.add('hidden');
            setHeroBannerImage(i, '');
        }
        
        currentEditBlockId = null;
    });
}

/**
 * Save hero banner block
 */
async function saveHeroBannerBlock() {
    const block = document.getElementById(currentEditBlockId);
    if (!block) return;
    
    const style = block.dataset.style || '1';
    const shortcodeId = block.dataset.shortcodeId;
    const pageId = window.pageId;
    const sortId = getCurrentSortId(currentEditBlockId);
    
    // Get button elements for loading state
    const saveBtn = document.getElementById('saveHeroBannerBtn');
    const saveIcon = document.getElementById('saveHeroBannerIcon');
    const saveLoading = document.getElementById('saveHeroBannerLoading');
    const saveText = document.getElementById('saveHeroBannerText');
    
    // Show loading
    if (saveBtn) saveBtn.disabled = true;
    saveIcon?.classList.add('hidden');
    saveLoading?.classList.remove('hidden');
    if (saveText) saveText.textContent = 'Saving...';
    
    try {
        // Collect data dari 6 tabs
        const tabsData = {};
        let hasError = false;
        let errorMessages = [];
        
        for (let i = 1; i <= 6; i++) {
            const categoryId = document.getElementById(`heroCategory${i}`)?.value || '';
            const title = document.getElementById(`heroTitle${i}`)?.value.trim() || '';
            const description = document.getElementById(`heroDescription${i}`)?.value.trim() || '';
            const actionLabel = document.getElementById(`heroActionLabel${i}`)?.value.trim() || '';
            const actionUrl = document.getElementById(`heroActionUrl${i}`)?.value.trim() || '';
            const image = normalizeHeroImageForStorage(
                window.heroBannerImages?.[`tab${i}`]
                || document.getElementById(`heroImage${i}`)?.value.trim()
                || ''
            );
            
            // Validation: SEMUA field wajib diisi (required)
            const missingFields = [];
            if (!categoryId) missingFields.push('Category');
            if (!title) missingFields.push('Title');
            if (!description) missingFields.push('Description');
            if (!actionLabel) missingFields.push('Action Label');
            if (!actionUrl) missingFields.push('Action URL');
            if (!image) missingFields.push('Image');
            
            if (missingFields.length > 0) {
                errorMessages.push(`Tab ${i}: ${missingFields.join(', ')} required`);
                hasError = true;
            }
            
            tabsData[`tab${i}`] = {
                category_id: categoryId,
                title: title,
                description: description,
                action_label: actionLabel,
                action_url: actionUrl,
                image: image
            };
        }
        
        if (hasError) {
            alert('Please complete all required fields:\n\n' + errorMessages.join('\n'));
            throw new Error('Validation failed');
        }
        
        // Collect array of product category IDs from all tabs
        const productCategoryIds = [];
        for (let i = 1; i <= 6; i++) {
            const categoryId = tabsData[`tab${i}`].category_id;
            if (categoryId) {
                productCategoryIds.push(parseInt(categoryId));
            }
        }
        
        // Prepare form data
        const formData = {
            pages_id: pageId,
            type: 'hero-banner',
            hero_style: style,
            sort_id: sortId,
            hero_data: tabsData, // Object data 6 tabs
            product_category_id: productCategoryIds // Array of category IDs
        };
        
        // Determine URL and method
        const url = shortcodeId 
            ? `/bagoosh/page-shortcode/update/${shortcodeId}` 
            : '/bagoosh/page-shortcode/store';
        const method = shortcodeId ? 'PUT' : 'POST';
        
        // Send to API
        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify(formData)
        });
        
        const data = await response.json();
        
        if (!response.ok || !data.success) {
            throw new Error(data.message || 'Failed to save');
        }
        
        // Save ke cache (local array) dengan struktur yang konsisten dengan database
        // Convert tabsData format (tab1, tab2) ke database format (title, title_2, description, description_2, etc)
        const heroDataForCache = {};
        
        for (let i = 1; i <= 6; i++) {
            const tabData = tabsData[`tab${i}`];
            if (tabData) {
                // Map ke field database
                const titleField = i === 1 ? 'title' : `title_${i}`;
                const descField = i === 1 ? 'description' : `description_${i}`;
                const actionLabelField = i === 1 ? 'action_label' : `action_label_${i}`;
                const actionUrlField = i === 1 ? 'action_url' : `action_url_${i}`;
                const imageField = i === 1 ? 'image' : `image_${i}`;
                
                heroDataForCache[titleField] = tabData.title;
                heroDataForCache[descField] = tabData.description;
                heroDataForCache[actionLabelField] = tabData.action_label;
                heroDataForCache[actionUrlField] = tabData.action_url;
                heroDataForCache[imageField] = tabData.image;
            }
        }
        
        blockDataCache[currentEditBlockId] = {
            hero_style: style,
            hero: heroDataForCache, // Data dalam format database untuk konsistensi
            product_category_id: productCategoryIds,
            type: 'hero-banner'
        };
        
        console.log('💾 Updated cache for Hero Banner (converted to DB format):', blockDataCache[currentEditBlockId]);
        
        // Save shortcode ID ke block dataset
        if (block && data.data?.id) {
            block.dataset.shortcodeId = data.data.id;
        }
        
        console.log('✅ Hero banner saved successfully');
        
        closeEditHeroBannerModal();
        alert('Hero banner saved successfully!');
        
    } catch (error) {
        console.error('❌ Save error:', error);
        alert('Error saving hero banner: ' + error.message);
    } finally {
        // Restore button state
        if (saveBtn) {
            saveBtn.disabled = false;
            saveIcon?.classList.remove('hidden');
            saveLoading?.classList.add('hidden');
            if (saveText) saveText.textContent = 'Save';
        }
    }
}

/**
 * Delete hero banner block
 */
async function deleteHeroBannerBlock() {
    if (!currentEditBlockId) return;
    
    if (!confirm('Are you sure you want to delete this Hero Banner block?')) {
        return;
    }
    
    const block = document.getElementById(currentEditBlockId);
    const shortcodeId = block?.dataset.shortcodeId;
    
    // Get button elements
    const deleteBtn = document.getElementById('deleteHeroBannerBtn');
    const deleteIcon = document.getElementById('deleteHeroBannerIcon');
    const deleteLoading = document.getElementById('deleteHeroBannerLoading');
    const deleteText = document.getElementById('deleteHeroBannerText');
    
    // Show loading
    if (deleteBtn) deleteBtn.disabled = true;
    deleteIcon?.classList.add('hidden');
    deleteLoading?.classList.remove('hidden');
    if (deleteText) deleteText.textContent = 'Deleting...';
    
    try {
        // Jika sudah tersimpan di database, hapus dari database
        if (shortcodeId) {
            console.log('🗑️ Deleting hero banner from database:', shortcodeId);
            
            const response = await fetch(`/bagoosh/page-shortcode/delete/${shortcodeId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                }
            });
            
            const data = await response.json();
            
            if (!response.ok) {
                throw new Error(data.message || 'Failed to delete from database');
            }
            console.log('✅ Deleted from database');
        } else {
            console.log('ℹ️ Block not saved yet, removing from UI only');
        }
        
        // Hapus dari cache
        if (blockDataCache[currentEditBlockId]) {
            delete blockDataCache[currentEditBlockId];
            console.log('🗑️ Deleted from cache:', currentEditBlockId);
        }
        
        // Hapus block dari UI
        block?.remove();
        closeEditHeroBannerModal();
        checkEmptyState();
        updateBlockOrder();
        alert('Hero banner deleted successfully!');
        
    } catch (error) {
        console.error('❌ Delete error:', error);
        alert('Error deleting hero banner: ' + error.message);
    } finally {
        // Restore button state (untuk kasus error)
        if (deleteBtn) {
            deleteBtn.disabled = false;
            deleteIcon?.classList.remove('hidden');
            deleteLoading?.classList.add('hidden');
            if (deleteText) deleteText.textContent = 'Delete';
        }
    }
}

// ===================================================================
// BAGIAN 14B: FUNGSI HERO BANNER STYLE 2 - EDIT & SAVE
// ===================================================================

/**
 * Handle image upload untuk hero banner style 2 (4 images)
 */
async function handleHeroStyle2ImageUpload(imageNumber, input) {
    const file = input.files[0];
    if (!file) return;
    
    // Validasi tipe file
    if (!file.type.startsWith('image/')) {
        alert('Please select a valid image file');
        input.value = '';
        return;
    }
    
    try {
        // Convert to WebP
        const webpDataUrl = await convertImageToWebP(file);
        
        // Show preview
        const preview = document.getElementById(`heroStyle2ImagePreview${imageNumber}`);
        const previewImg = preview?.querySelector('img');
        if (preview && previewImg) {
            previewImg.src = webpDataUrl;
            preview.classList.remove('hidden');
        }
        
        // Store in temporary object
        if (!window.heroBannerStyle2Images) {
            window.heroBannerStyle2Images = {};
        }
        window.heroBannerStyle2Images[`image${imageNumber}`] = webpDataUrl;
        
        console.log(`✅ Image ${imageNumber} converted to WebP for Style 2`);
    } catch (error) {
        console.error('❌ Image conversion error:', error);
        alert('Error converting image. Please try again.');
    }
}

window.addEventListener('media-selected', (event) => {
    const fieldId = event?.detail?.fieldId || '';
    const selectedUrl = event?.detail?.url || '';

    if (fieldId.startsWith('heroStyle2Image')) {
        const imageNumber = fieldId.replace('heroStyle2Image', '');
        if (!window.heroBannerStyle2Images) {
            window.heroBannerStyle2Images = {};
        }
        window.heroBannerStyle2Images[`image${imageNumber}`] = normalizeHeroImageForStorage(selectedUrl);
    } else if (fieldId.startsWith('heroStyle3Image')) {
        const imageNumber = fieldId.replace('heroStyle3Image', '');
        if (!window.heroBannerStyle3Images) {
            window.heroBannerStyle3Images = {};
        }
        window.heroBannerStyle3Images[`image${imageNumber}`] = normalizeHeroImageForStorage(selectedUrl);
    }
});

/**
 * Populate checkboxes untuk services dengan limit 3
 */
function populateHeroStyle2Services(selectedIds = []) {
    const container = document.getElementById('heroStyle2ServicesContainer');
    const counter = document.getElementById('heroStyle2ServicesCount');
    
    if (!container) return false;
    
    // Check if data ready
    if (cachedSectionServices.length === 0) {
        container.innerHTML = '<p class=\"text-center text-slate-500 py-4\">No services available</p>';
        return false;
    }
    
    // Clear container
    container.innerHTML = '';
    
    // Create checkboxes
    cachedSectionServices.forEach(service => {
        const isChecked = selectedIds.includes(service.id);
        
        const checkboxHTML = `
            <label class="flex items-center p-3 hover:bg-slate-100 rounded-lg cursor-pointer transition-colors">
                <input type="checkbox" 
                       class="hero-style2-service-checkbox w-4 h-4 text-purple-600 border-slate-300 rounded focus:ring-2 focus:ring-purple-500" 
                       value="${service.id}"
                       ${isChecked ? 'checked' : ''}
                       onchange="handleHeroStyle2ServiceCheckbox(this)">
                <span class="ml-3 text-sm font-medium text-slate-700">${service.name}</span>
            </label>
        `;
        
        container.insertAdjacentHTML('beforeend', checkboxHTML);
    });
    
    // Update counter
    if (counter) {
        counter.textContent = selectedIds.length;
    }
    
    console.log('✅ Services populated for Hero Style 2:', cachedSectionServices.length, 'items');
    return true;
}

/**
 * Handle checkbox change dengan validasi maksimal 3
 */
function handleHeroStyle2ServiceCheckbox(checkbox) {
    const allCheckboxes = document.querySelectorAll('.hero-style2-service-checkbox');
    const checkedCount = Array.from(allCheckboxes).filter(cb => cb.checked).length;
    const counter = document.getElementById('heroStyle2ServicesCount');
    
    // Update counter
    if (counter) {
        counter.textContent = checkedCount;
    }
    
    // Validasi: maksimal 3
    if (checkedCount > 3) {
        checkbox.checked = false;
        alert('You can only select up to 3 services');
        if (counter) {
            counter.textContent = 3;
        }
        return;
    }
    
    // Update counter color
    if (counter) {
        if (checkedCount === 3) {
            counter.classList.remove('text-purple-600');
            counter.classList.add('text-green-600');
        } else {
            counter.classList.remove('text-green-600');
            counter.classList.add('text-purple-600');
        }
    }
}

/**
 * Open modal edit hero banner style 2
 */
async function openEditHeroBannerStyle2Modal() {
    const block = document.getElementById(currentEditBlockId);
    if (!block) return;
    
    const style = block.dataset.style || '2';
    const shortcodeId = block.dataset.shortcodeId;
    
    // Hanya style 2 yang bisa dibuka modal ini
    if (style !== '2') {
        alert('This modal is only for Hero Banner Style 2');
        return;
    }
    
    // Check if section services ready
    if (cachedSectionServices.length === 0) {
        alert('Services data not loaded yet. Please refresh the page.');
        return;
    }
    
    // Populate services checkboxes
    const populated = populateHeroStyle2Services();
    if (!populated) {
        alert('Failed to load services. Please try again.');
        return;
    }
    
    // Load data dari cache jika ada
    if (blockDataCache[currentEditBlockId]) {
        const cachedData = blockDataCache[currentEditBlockId];
        console.log('🔍 Hero Banner Style 2 - Cached data:', cachedData);
        
        // Data bisa berupa direct cache atau dari relationship
        const heroData = cachedData.hero || cachedData;
        console.log('🎯 Hero data to use:', heroData);
        
        // Set title
        const titleInput = document.getElementById('heroStyle2Title');
        if (titleInput && heroData.title) {
            titleInput.value = heroData.title;
            console.log('✅ Set title:', heroData.title);
        }
        
        // Set description
        const descInput = document.getElementById('heroStyle2Description');
        if (descInput && heroData.description) {
            descInput.value = heroData.description;
            console.log('✅ Set description:', heroData.description.substring(0, 50));
        }
        
        // Set action labels and URLs
        // Database uses: action_label (not action_label_1), action_label_2
        // Database uses: action_url (not action_url_1), action_url_2
        const actionLabel1 = document.getElementById('heroStyle2ActionLabel1');
        const actionLabel2 = document.getElementById('heroStyle2ActionLabel2');
        const actionUrl1 = document.getElementById('heroStyle2ActionUrl1');
        const actionUrl2 = document.getElementById('heroStyle2ActionUrl2');
        
        if (actionLabel1 && heroData.action_label) {
            actionLabel1.value = heroData.action_label;
            console.log('✅ Set action label 1:', heroData.action_label);
        }
        if (actionLabel2 && heroData.action_label_2) {
            actionLabel2.value = heroData.action_label_2;
            console.log('✅ Set action label 2:', heroData.action_label_2);
        }
        if (actionUrl1 && heroData.action_url) {
            actionUrl1.value = heroData.action_url;
            console.log('✅ Set action URL 1:', heroData.action_url);
        }
        if (actionUrl2 && heroData.action_url_2) {
            actionUrl2.value = heroData.action_url_2;
            console.log('✅ Set action URL 2:', heroData.action_url_2);
        }
        
        // Set images
        // Database uses: image (not image_1), image_2, image_3, image_4
        // Images are stored as base64 WebP strings: data:image/webp;base64,...
        if (!window.heroBannerStyle2Images) {
            window.heroBannerStyle2Images = {};
        }
        
        // Image 1
        if (heroData.image) {
            const normalizedPreview = normalizeHeroImageForPreview(heroData.image);
            const normalizedStorage = normalizeHeroImageForStorage(heroData.image);
            window.heroBannerStyle2Images['image1'] = normalizedStorage;
            window.dispatchEvent(new CustomEvent('media-selected', {
                detail: { fieldId: 'heroStyle2Image1', url: normalizedPreview }
            }));
        }
        
        // Images 2-4
        for (let i = 2; i <= 4; i++) {
            if (heroData[`image_${i}`]) {
                const normalizedPreview = normalizeHeroImageForPreview(heroData[`image_${i}`]);
                const normalizedStorage = normalizeHeroImageForStorage(heroData[`image_${i}`]);
                window.heroBannerStyle2Images[`image${i}`] = normalizedStorage;
                window.dispatchEvent(new CustomEvent('media-selected', {
                    detail: { fieldId: `heroStyle2Image${i}`, url: normalizedPreview }
                }));
            }
        }
        
        // Parse section_service_id dari JSON string jika perlu dan set checkboxes
        let serviceIds = cachedData.section_service_id;
        if (typeof serviceIds === 'string') {
            try {
                serviceIds = JSON.parse(serviceIds);
            } catch (e) {
                console.error('Failed to parse section_service_id:', e);
                serviceIds = [];
            }
        }
        if (!Array.isArray(serviceIds)) {
            serviceIds = [];
        }
        
        console.log('📦 Service IDs to select:', serviceIds);
        
        // Populate services dengan selected IDs
        if (serviceIds.length > 0) {
            populateHeroStyle2Services(serviceIds);
            console.log('✅ Services checkboxes populated with', serviceIds.length, 'selected');
        }
        
        console.log('✅ Hero Banner Style 2 - Form populated successfully');
    } else if (shortcodeId) {
        // Load data dari database jika belum ada di cache
        try {
            const response = await fetch(`/bagoosh/page-shortcode/show/${shortcodeId}`, {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=\"csrf-token\"]')?.content || ''
                }
            });
            
            const result = await response.json();
            
            if (result.success && result.data) {
                // Store ke cache
                blockDataCache[currentEditBlockId] = result.data;
                
                // Populate form (recursive call)
                openEditHeroBannerStyle2Modal();
                return;
            }
        } catch (error) {
            console.error('❌ Error loading data:', error);
        }
    }
    
    // Show modal
    document.getElementById('editHeroBannerStyle2Modal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

/**
 * Close modal edit hero banner style 2
 */
function closeEditHeroBannerStyle2Modal() {
    closeModalWithTransition('editHeroBannerStyle2Modal', () => {
        // Clear temporary images
        if (window.heroBannerStyle2Images) {
            window.heroBannerStyle2Images = {};
        }
        
        // Reset form
        const titleInput = document.getElementById('heroStyle2Title');
        const descInput = document.getElementById('heroStyle2Description');
        const actionLabel1 = document.getElementById('heroStyle2ActionLabel1');
        const actionLabel2 = document.getElementById('heroStyle2ActionLabel2');
        const actionUrl1 = document.getElementById('heroStyle2ActionUrl1');
        const actionUrl2 = document.getElementById('heroStyle2ActionUrl2');
        
        if (titleInput) titleInput.value = '';
        if (descInput) descInput.value = '';
        if (actionLabel1) actionLabel1.value = '';
        if (actionLabel2) actionLabel2.value = '';
        if (actionUrl1) actionUrl1.value = '';
        if (actionUrl2) actionUrl2.value = '';
        
        // Reset images
        for (let i = 1; i <= 4; i++) {
            const imageInput = document.getElementById(`heroStyle2Image${i}`);
            
            if (imageInput) imageInput.value = '';
            window.dispatchEvent(new CustomEvent('media-selected', {
                detail: { fieldId: `heroStyle2Image${i}`, url: '' }
            }));
        }
        
        // Reset checkboxes
        const checkboxes = document.querySelectorAll('.hero-style2-service-checkbox');
        checkboxes.forEach(cb => cb.checked = false);
        
        const counter = document.getElementById('heroStyle2ServicesCount');
        if (counter) {
            counter.textContent = '0';
            counter.classList.remove('text-green-600');
            counter.classList.add('text-purple-600');
        }
        
        currentEditBlockId = null;
    });
}

/**
 * Save hero banner style 2 block
 */
async function saveHeroBannerStyle2Block() {
    const block = document.getElementById(currentEditBlockId);
    if (!block) return;
    
    const style = block.dataset.style || '2';
    const shortcodeId = block.dataset.shortcodeId;
    const pageId = window.pageId;
    const sortId = getCurrentSortId(currentEditBlockId);
    
    // Get button elements for loading state
    const saveBtn = document.getElementById('saveHeroBannerStyle2Btn');
    const saveIcon = document.getElementById('saveHeroBannerStyle2Icon');
    const saveLoading = document.getElementById('saveHeroBannerStyle2Loading');
    const saveText = document.getElementById('saveHeroBannerStyle2Text');
    
    // Show loading
    if (saveBtn) saveBtn.disabled = true;
    saveIcon?.classList.add('hidden');
    saveLoading?.classList.remove('hidden');
    if (saveText) saveText.textContent = 'Saving...';
    
    try {
        // Collect form data
        const title = document.getElementById('heroStyle2Title')?.value.trim() || '';
        const description = document.getElementById('heroStyle2Description')?.value.trim() || '';
        const actionLabel1 = document.getElementById('heroStyle2ActionLabel1')?.value.trim() || '';
        const actionLabel2 = document.getElementById('heroStyle2ActionLabel2')?.value.trim() || '';
        const actionUrl1 = document.getElementById('heroStyle2ActionUrl1')?.value.trim() || '';
        const actionUrl2 = document.getElementById('heroStyle2ActionUrl2')?.value.trim() || '';
        
        // Collect images
        const image1 = normalizeHeroImageForStorage(
            window.heroBannerStyle2Images?.image1 || document.getElementById('heroStyle2Image1')?.value || ''
        );
        const image2 = normalizeHeroImageForStorage(
            window.heroBannerStyle2Images?.image2 || document.getElementById('heroStyle2Image2')?.value || ''
        );
        const image3 = normalizeHeroImageForStorage(
            window.heroBannerStyle2Images?.image3 || document.getElementById('heroStyle2Image3')?.value || ''
        );
        const image4 = normalizeHeroImageForStorage(
            window.heroBannerStyle2Images?.image4 || document.getElementById('heroStyle2Image4')?.value || ''
        );
        
        // Collect selected services
        const checkboxes = document.querySelectorAll('.hero-style2-service-checkbox:checked');
        const serviceIds = Array.from(checkboxes).map(cb => parseInt(cb.value));
        
        // Validation: ALL fields required
        const missingFields = [];
        if (!title) missingFields.push('Title');
        if (!description) missingFields.push('Description');
        if (!image1) missingFields.push('Image 1');
        if (!image2) missingFields.push('Image 2');
        if (!image3) missingFields.push('Image 3');
        if (!image4) missingFields.push('Image 4');
        if (!actionLabel1) missingFields.push('Action Label 1');
        if (!actionUrl1) missingFields.push('Action URL 1');
        if (!actionLabel2) missingFields.push('Action Label 2');
        if (!actionUrl2) missingFields.push('Action URL 2');
        if (serviceIds.length !== 3) missingFields.push('Exactly 3 Services');
        
        if (missingFields.length > 0) {
            alert('Please complete all required fields:\\n\\n' + missingFields.join('\\n'));
            throw new Error('Validation failed');
        }
        
        // Prepare form data
        // Database expects: action_label (not action_label_1), action_label_2
        // Database expects: action_url (not action_url_1), action_url_2
        // Database expects: image (not image_1), image_2, image_3, image_4
        const formData = {
            pages_id: pageId,
            type: 'hero-banner',
            hero_style: style,
            sort_id: sortId,
            hero_data: {
                title: title,
                description: description,
                action_label: actionLabel1,      // Not action_label_1
                action_label_2: actionLabel2,
                action_url: actionUrl1,          // Not action_url_1
                action_url_2: actionUrl2,
                image: image1,                   // Not image_1
                image_2: image2,
                image_3: image3,
                image_4: image4
            },
            section_service_id: serviceIds // Array of 3 service IDs
        };
        
        // Determine URL and method
        const url = shortcodeId 
            ? `/bagoosh/page-shortcode/update/${shortcodeId}` 
            : '/bagoosh/page-shortcode/store';
        const method = shortcodeId ? 'PUT' : 'POST';
        
        // Send to API
        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name=\"csrf-token\"]')?.content || ''
            },
            body: JSON.stringify(formData)
        });
        
        const data = await response.json();
        
        if (!response.ok || !data.success) {
            throw new Error(data.message || 'Failed to save');
        }
        
        // Save ke cache (local array) dengan struktur yang konsisten
        // Use same field names as database for consistency
        blockDataCache[currentEditBlockId] = {
            hero_style: style,
            hero: {
                title, 
                description,
                action_label: actionLabel1,      // Not action_label_1
                action_label_2: actionLabel2,
                action_url: actionUrl1,          // Not action_url_1
                action_url_2: actionUrl2,
                image: image1,                   // Not image_1
                image_2: image2, 
                image_3: image3, 
                image_4: image4
            },
            section_service_id: serviceIds,
            type: 'hero-banner'
        };
        
        console.log('💾 Updated cache for Hero Banner Style 2:', blockDataCache[currentEditBlockId]);
        
        // Save shortcode ID ke block dataset
        if (block && data.data?.id) {
            block.dataset.shortcodeId = data.data.id;
        }
        
        console.log('✅ Hero banner style 2 saved successfully');
        
        closeEditHeroBannerStyle2Modal();
        alert('Hero banner style 2 saved successfully!');
        
    } catch (error) {
        console.error('❌ Save error:', error);
        alert('Error saving hero banner: ' + error.message);
    } finally {
        // Restore button state
        if (saveBtn) {
            saveBtn.disabled = false;
            saveIcon?.classList.remove('hidden');
            saveLoading?.classList.add('hidden');
            if (saveText) saveText.textContent = 'Save';
        }
    }
}

/**
 * Delete hero banner style 2 block
 */
async function deleteHeroBannerStyle2Block() {
    if (!currentEditBlockId) return;
    
    if (!confirm('Are you sure you want to delete this Hero Banner Style 2 block?')) {
        return;
    }
    
    const block = document.getElementById(currentEditBlockId);
    const shortcodeId = block?.dataset.shortcodeId;
    
    // Get button elements
    const deleteBtn = document.getElementById('deleteHeroBannerStyle2Btn');
    const deleteIcon = document.getElementById('deleteHeroBannerStyle2Icon');
    const deleteLoading = document.getElementById('deleteHeroBannerStyle2Loading');
    const deleteText = document.getElementById('deleteHeroBannerStyle2Text');
    
    // Show loading
    if (deleteBtn) deleteBtn.disabled = true;
    deleteIcon?.classList.add('hidden');
    deleteLoading?.classList.remove('hidden');
    if (deleteText) deleteText.textContent = 'Deleting...';
    
    try {
        // Jika sudah tersimpan di database, hapus dari database
        if (shortcodeId) {
            console.log('🗑️ Deleting hero banner style 2 from database:', shortcodeId);
            
            const response = await fetch(`/bagoosh/page-shortcode/delete/${shortcodeId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=\"csrf-token\"]')?.content || ''
                }
            });
            
            const data = await response.json();
            
            if (!response.ok) {
                throw new Error(data.message || 'Failed to delete from database');
            }
            console.log('✅ Deleted from database');
        } else {
            console.log('ℹ️ Block not saved yet, removing from UI only');
        }
        
        // Hapus dari cache
        if (blockDataCache[currentEditBlockId]) {
            delete blockDataCache[currentEditBlockId];
            console.log('🗑️ Deleted from cache:', currentEditBlockId);
        }
        
        // Hapus block dari UI
        block?.remove();
        closeEditHeroBannerStyle2Modal();
        checkEmptyState();
        updateBlockOrder();
        alert('Hero banner style 2 deleted successfully!');
        
    } catch (error) {
        console.error('❌ Delete error:', error);
        alert('Error deleting hero banner: ' + error.message);
    } finally {
        // Restore button state (untuk kasus error)
        if (deleteBtn) {
            deleteBtn.disabled = false;
            deleteIcon?.classList.remove('hidden');
            deleteLoading?.classList.add('hidden');
            if (deleteText) deleteText.textContent = 'Delete';
        }
    }
}

// ===================================================================
// BAGIAN 14C: FUNGSI HERO BANNER STYLE 3 - EDIT & SAVE
// ===================================================================

/**
 * Handle image upload untuk hero banner style 3 (3 images)
 */
async function handleHeroStyle3ImageUpload(imageNumber, input) {
    if (!input.files || !input.files[0]) return;
    
    const file = input.files[0];
    
    // Validate file type
    if (!file.type.startsWith('image/')) {
        alert('Please select a valid image file');
        input.value = '';
        return;
    }
    
    try {
        // Convert to WebP
        const webpDataUrl = await convertImageToWebP(file);
        
        // Show preview
        const preview = document.getElementById(`heroStyle3ImagePreview${imageNumber}`);
        const previewImg = preview?.querySelector('img');
        
        if (preview && previewImg) {
            previewImg.src = webpDataUrl;
            preview.classList.remove('hidden');
        }
        
        // Store in temporary object
        if (!window.heroBannerStyle3Images) {
            window.heroBannerStyle3Images = {};
        }
        window.heroBannerStyle3Images[`image${imageNumber}`] = webpDataUrl;
        
        console.log(`✅ Image ${imageNumber} converted to WebP for Style 3`);
    } catch (error) {
        console.error('❌ Image conversion error:', error);
        alert('Error converting image. Please try again.');
    }
}

/**
 * Open modal edit hero banner style 3
 */
async function openEditHeroBannerStyle3Modal() {
    const block = document.getElementById(currentEditBlockId);
    if (!block) return;
    
    const style = block.dataset.style || '3';
    const shortcodeId = block.dataset.shortcodeId;
    
    // Hanya style 3 yang bisa dibuka modal ini
    if (style !== '3') {
        alert('This modal is only for Hero Banner Style 3');
        return;
    }
    
    // Load data dari cache jika ada
    if (blockDataCache[currentEditBlockId]) {
        const cachedData = blockDataCache[currentEditBlockId];
        console.log('🔍 Hero Banner Style 3 - Cached data:', cachedData);
        
        // Data bisa berupa direct cache atau dari relationship
        const heroData = cachedData.hero || cachedData;
        console.log('🎯 Hero data to use:', heroData);
        
        // Set titles (cache keys: title, title_2)
        const title1Input = document.getElementById('heroStyle3Title1');
        const title2Input = document.getElementById('heroStyle3Title2');
        if (title1Input && heroData.title) {
            title1Input.value = heroData.title;
            console.log('✅ Set title 1:', heroData.title);
        }
        if (title2Input && heroData.title_2) {
            title2Input.value = heroData.title_2;
            console.log('✅ Set title 2:', heroData.title_2);
        }
        
        // Set description
        const descInput = document.getElementById('heroStyle3Description');
        if (descInput && heroData.description) {
            descInput.value = heroData.description;
            console.log('✅ Set description:', heroData.description.substring(0, 50));
        }
        
        // Set action labels and URLs (cache keys: action_label, action_label_2)
        const actionLabel1 = document.getElementById('heroStyle3ActionLabel1');
        const actionLabel2 = document.getElementById('heroStyle3ActionLabel2');
        const actionUrl1 = document.getElementById('heroStyle3ActionUrl1');
        const actionUrl2 = document.getElementById('heroStyle3ActionUrl2');
        
        if (actionLabel1 && heroData.action_label) {
            actionLabel1.value = heroData.action_label;
            console.log('✅ Set action label 1:', heroData.action_label);
        }
        if (actionLabel2 && heroData.action_label_2) {
            actionLabel2.value = heroData.action_label_2;
            console.log('✅ Set action label 2:', heroData.action_label_2);
        }
        if (actionUrl1 && heroData.action_url) {
            actionUrl1.value = heroData.action_url;
            console.log('✅ Set action URL 1:', heroData.action_url);
        }
        if (actionUrl2 && heroData.action_url_2) {
            actionUrl2.value = heroData.action_url_2;
            console.log('✅ Set action URL 2:', heroData.action_url_2);
        }
        
        // Set images (cache keys: image, image_2, image_3)
        if (!window.heroBannerStyle3Images) {
            window.heroBannerStyle3Images = {};
        }
        
        // Image 1
        if (heroData.image) {
            const normalizedPreview = normalizeHeroImageForPreview(heroData.image);
            const normalizedStorage = normalizeHeroImageForStorage(heroData.image);
            window.heroBannerStyle3Images['image1'] = normalizedStorage;
            window.dispatchEvent(new CustomEvent('media-selected', {
                detail: { fieldId: 'heroStyle3Image1', url: normalizedPreview }
            }));
        }
        
        // Image 2
        if (heroData.image_2) {
            const normalizedPreview = normalizeHeroImageForPreview(heroData.image_2);
            const normalizedStorage = normalizeHeroImageForStorage(heroData.image_2);
            window.heroBannerStyle3Images['image2'] = normalizedStorage;
            window.dispatchEvent(new CustomEvent('media-selected', {
                detail: { fieldId: 'heroStyle3Image2', url: normalizedPreview }
            }));
        }
        
        // Image 3
        if (heroData.image_3) {
            const normalizedPreview = normalizeHeroImageForPreview(heroData.image_3);
            const normalizedStorage = normalizeHeroImageForStorage(heroData.image_3);
            window.heroBannerStyle3Images['image3'] = normalizedStorage;
            window.dispatchEvent(new CustomEvent('media-selected', {
                detail: { fieldId: 'heroStyle3Image3', url: normalizedPreview }
            }));
        }
        
        console.log('✅ Hero Banner Style 3 - Form populated successfully');
    } else if (shortcodeId) {
        // Load data dari database jika belum ada di cache
        try {
            const response = await fetch(`/bagoosh/page-shortcode/show/${shortcodeId}`, {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                }
            });
            
            const result = await response.json();
            
            if (result.success && result.data) {
                // Store ke cache
                blockDataCache[currentEditBlockId] = result.data;
                
                // Populate form (recursive call)
                openEditHeroBannerStyle3Modal();
                return;
            }
        } catch (error) {
            console.error('❌ Error loading data:', error);
        }
    }
    
    // Show modal
    const modal = document.getElementById('editHeroBannerStyle3Modal');
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
}

/**
 * Close modal edit hero banner style 3
 */
function closeEditHeroBannerStyle3Modal() {
    closeModalWithTransition('editHeroBannerStyle3Modal', () => {
        // Reset all inputs
        const title1 = document.getElementById('heroStyle3Title1');
        const title2 = document.getElementById('heroStyle3Title2');
        const description = document.getElementById('heroStyle3Description');
        const actionLabel1 = document.getElementById('heroStyle3ActionLabel1');
        const actionLabel2 = document.getElementById('heroStyle3ActionLabel2');
        const actionUrl1 = document.getElementById('heroStyle3ActionUrl1');
        const actionUrl2 = document.getElementById('heroStyle3ActionUrl2');
        
        if (title1) title1.value = '';
        if (title2) title2.value = '';
        if (description) description.value = '';
        if (actionLabel1) actionLabel1.value = '';
        if (actionLabel2) actionLabel2.value = '';
        if (actionUrl1) actionUrl1.value = '';
        if (actionUrl2) actionUrl2.value = '';
        
        // Reset images
        for (let i = 1; i <= 3; i++) {
            const imageInput = document.getElementById(`heroStyle3Image${i}`);
            
            if (imageInput) imageInput.value = '';
            window.dispatchEvent(new CustomEvent('media-selected', {
                detail: { fieldId: `heroStyle3Image${i}`, url: '' }
            }));
        }
        
        // Clear temporary image storage
        if (window.heroBannerStyle3Images) {
            window.heroBannerStyle3Images = {};
        }
        
        currentEditBlockId = null;
    });
}

/**
 * Save hero banner style 3 block
 */
async function saveHeroBannerStyle3Block() {
    const block = document.getElementById(currentEditBlockId);
    if (!block) return;
    
    const style = block.dataset.style || '3';
    const shortcodeId = block.dataset.shortcodeId;
    const pageId = window.pageId;
    const sortId = getCurrentSortId(currentEditBlockId);
    
    // Get button elements for loading state
    const saveBtn = document.getElementById('saveHeroBannerStyle3Btn');
    const saveIcon = document.getElementById('saveHeroBannerStyle3Icon');
    const saveLoading = document.getElementById('saveHeroBannerStyle3Loading');
    const saveText = document.getElementById('saveHeroBannerStyle3Text');
    
    // Show loading
    if (saveBtn) saveBtn.disabled = true;
    saveIcon?.classList.add('hidden');
    saveLoading?.classList.remove('hidden');
    if (saveText) saveText.textContent = 'Saving...';
    
    try {
        // Collect form data
        const title1 = document.getElementById('heroStyle3Title1')?.value.trim() || '';
        const title2 = document.getElementById('heroStyle3Title2')?.value.trim() || '';
        const description = document.getElementById('heroStyle3Description')?.value.trim() || '';
        const actionLabel1 = document.getElementById('heroStyle3ActionLabel1')?.value.trim() || '';
        const actionLabel2 = document.getElementById('heroStyle3ActionLabel2')?.value.trim() || '';
        const actionUrl1 = document.getElementById('heroStyle3ActionUrl1')?.value.trim() || '';
        const actionUrl2 = document.getElementById('heroStyle3ActionUrl2')?.value.trim() || '';
        
        // Collect images
        const image1 = normalizeHeroImageForStorage(
            window.heroBannerStyle3Images?.image1 || document.getElementById('heroStyle3Image1')?.value || ''
        );
        const image2 = normalizeHeroImageForStorage(
            window.heroBannerStyle3Images?.image2 || document.getElementById('heroStyle3Image2')?.value || ''
        );
        const image3 = normalizeHeroImageForStorage(
            window.heroBannerStyle3Images?.image3 || document.getElementById('heroStyle3Image3')?.value || ''
        );
        
        // Validation: ALL fields required
        const missingFields = [];
        if (!title1) missingFields.push('Title 1');
        if (!title2) missingFields.push('Title 2');
        if (!description) missingFields.push('Description');
        if (!image1) missingFields.push('Image 1');
        if (!image2) missingFields.push('Image 2');
        if (!image3) missingFields.push('Image 3');
        if (!actionLabel1) missingFields.push('Action Label 1');
        if (!actionUrl1) missingFields.push('Action URL 1');
        if (!actionLabel2) missingFields.push('Action Label 2');
        if (!actionUrl2) missingFields.push('Action URL 2');
        
        if (missingFields.length > 0) {
            alert('Please complete all required fields:\n\n' + missingFields.join('\n'));
            throw new Error('Validation failed');
        }
        
        // Prepare form data
        const formData = {
            pages_id: pageId,
            type: 'hero-banner',
            hero_style: style,
            sort_id: sortId,
            hero_data: {
                title: title1,
                title_2: title2,
                description: description,
                action_label: actionLabel1,
                action_label_2: actionLabel2,
                action_url: actionUrl1,
                action_url_2: actionUrl2,
                image: image1,
                image_2: image2,
                image_3: image3
            }
        };
        
        // Determine URL and method
        const url = shortcodeId 
            ? `/bagoosh/page-shortcode/update/${shortcodeId}` 
            : '/bagoosh/page-shortcode/store';
        const method = shortcodeId ? 'PUT' : 'POST';
        
        // Send to API
        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify(formData)
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Update block with shortcode_id if new
            if (data.data?.id && !shortcodeId) {
                block.dataset.shortcodeId = data.data.id;
            }
            
            // Update cache dengan struktur yang konsisten
            blockDataCache[currentEditBlockId] = {
                hero_style: style,
                hero: {
                    title: title1,                // Title 1
                    title_2: title2,              // Title 2
                    description: description,     // Description
                    action_label: actionLabel1,   // Action Label 1
                    action_label_2: actionLabel2, // Action Label 2
                    action_url: actionUrl1,       // Action URL 1
                    action_url_2: actionUrl2,     // Action URL 2
                    image: image1,                // Image 1
                    image_2: image2,              // Image 2
                    image_3: image3               // Image 3
                },
                type: 'hero-banner'
            };
            
            console.log('💾 Updated cache for Hero Banner Style 3:', blockDataCache[currentEditBlockId]);
            
            // Update block title di UI
            const blockTitle = block.querySelector('.block-title');
            if (blockTitle) {
                blockTitle.textContent = `Hero Banner Style 3: ${title1}`;
            }
            
            closeEditHeroBannerStyle3Modal();
            alert('Hero banner style 3 saved successfully!');
        } else {
            throw new Error(data.message || 'Failed to save');
        }
        
    } catch (error) {
        console.error('❌ Save error:', error);
        if (error.message !== 'Validation failed') {
            alert('Error saving hero banner: ' + error.message);
        }
    } finally {
        // Restore button state
        if (saveBtn) saveBtn.disabled = false;
        saveIcon?.classList.remove('hidden');
        saveLoading?.classList.add('hidden');
        if (saveText) saveText.textContent = 'Save';
    }
}

/**
 * Delete hero banner style 3 block
 */
async function deleteHeroBannerStyle3Block() {
    const block = document.getElementById(currentEditBlockId);
    if (!block) return;
    
    if (!confirm('Are you sure you want to delete this hero banner?')) return;
    
    const shortcodeId = block.dataset.shortcodeId;
    
    // Get button elements
    const deleteBtn = document.getElementById('deleteHeroBannerStyle3Btn');
    const deleteIcon = document.getElementById('deleteHeroBannerStyle3IconTrash');
    const deleteLoading = document.getElementById('deleteHeroBannerStyle3IconLoading');
    const deleteText = document.getElementById('deleteHeroBannerStyle3Text');
    
    // Show loading
    if (deleteBtn) deleteBtn.disabled = true;
    deleteIcon?.classList.add('hidden');
    deleteLoading?.classList.remove('hidden');
    if (deleteText) deleteText.textContent = 'Deleting...';
    
    try {
        // Jika sudah tersimpan di database, hapus dari database
        if (shortcodeId) {
            console.log('🗑️ Deleting hero banner style 3 from database:', shortcodeId);
            
            const response = await fetch(`/bagoosh/page-shortcode/delete/${shortcodeId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                }
            });
            
            const data = await response.json();
            
            if (!data.success) {
                throw new Error(data.message || 'Failed to delete from database');
            }
        }
        
        // Hapus dari cache
        if (blockDataCache[currentEditBlockId]) {
            delete blockDataCache[currentEditBlockId];
            console.log('🗑️ Deleted from cache:', currentEditBlockId);
        }
        
        // Hapus block dari UI
        block?.remove();
        closeEditHeroBannerStyle3Modal();
        checkEmptyState();
        updateBlockOrder();
        alert('Hero banner style 3 deleted successfully!');
        
    } catch (error) {
        console.error('❌ Delete error:', error);
        alert('Error deleting hero banner: ' + error.message);
    } finally {
        // Restore button state (untuk kasus error)
        if (deleteBtn) {
            deleteBtn.disabled = false;
            deleteIcon?.classList.remove('hidden');
            deleteLoading?.classList.add('hidden');
            if (deleteText) deleteText.textContent = 'Delete';
        }
    }
}

// ===================================================================
// BAGIAN 15: FUNGSI MODAL DEFAULT
// ===================================================================

function closeEditDefaultModal() {
    closeModalWithTransition('editDefaultModal', () => {
        currentEditBlockId = null;
    });
}

function deleteCurrentBlock() {
    if (!currentEditBlockId) return;
    if (!confirm('Are you sure you want to delete this block?')) return;
    
    closeModalWithTransition('editDefaultModal', () => {
        const block = document.getElementById(currentEditBlockId);
        if (block) {
            block.style.transition = 'opacity 300ms ease-out';
            block.style.opacity = '0';
            setTimeout(() => {
                block.remove();
                checkEmptyState();
                updateBlockOrder();
            }, 300);
        }
        currentEditBlockId = null;
        alert('Block deleted successfully!');
    });
}

// ===================================================================
// BAGIAN 16: FUNGSI MENAMBAH BLOCK
// ===================================================================

/**
 * Menambahkan block baru ke list
 * Fungsi utama yang dipanggil saat user klik "Use" di library
 * 
 * @param {string} type - Tipe block yang mau ditambahkan
 */
function addBlock(type) {
    // Special handling untuk hero-banner
    // Hero banner butuh pilih style dulu sebelum ditambahkan
    if (type === 'hero-banner') {
        blockCounter = getNextBlockCounter(); // Gunakan fungsi baru untuk counter konsisten
        pendingHeroBannerBlockId = `block-${blockCounter}`; // Buat ID untuk pending block
        closeBlockLibrary(); // Tutup library modal
        document.getElementById('selectHeroStyleModal').classList.remove('hidden'); // Buka style modal
        document.body.style.overflow = 'hidden';
        return; // Keluar dari fungsi (berhenti di sini)
    }
    
    // Special handling untuk about (butuh pilih style dulu)
    if (type === 'about') {
        blockCounter = getNextBlockCounter();
        pendingAboutBlockId = `block-${blockCounter}`;
        closeBlockLibrary();
        openSelectAboutStyleModal();
        return;
    }
    
    // Special handling untuk product-category (butuh pilih style dulu)
    if (type === 'product-category') {
        blockCounter = getNextBlockCounter();
        pendingProductCategoryBlockId = `block-${blockCounter}`;
        closeBlockLibrary();
        openSelectProductCategoryStyleModal();
        return;
    }
    
    // Special handling untuk featured-services (butuh pilih style dulu)
    if (type === 'featured-services') {
        blockCounter = getNextBlockCounter();
        pendingFeaturedServicesBlockId = `block-${blockCounter}`;
        closeBlockLibrary();
        document.getElementById('selectServiceStyleModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        return;
    }
    
    // Special handling untuk testimonials (sama seperti hero-banner)
    if (type === 'testimonials') {
        blockCounter = getNextBlockCounter();
        pendingTestimonialsBlockId = `block-${blockCounter}`;
        closeBlockLibrary();
        document.getElementById('selectTestimonialsStyleModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        return;
    }
    
    // Special handling untuk latestnews (butuh pilih style dulu)
    if (type === 'latestnews') {
        blockCounter = getNextBlockCounter();
        pendingLatestNewsBlockId = `block-${blockCounter}`;
        closeBlockLibrary();
        document.getElementById('selectLatestNewsStyleModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        return;
    }   
    
    // Newsletter langsung ditambahkan tanpa pilih style
    if (type === 'newsletter') {
        blockCounter = getNextBlockCounter();
        const blockId = `block-${blockCounter}`;
        const config = blockConfig[type];
        const blocksList = document.getElementById('blocksList');
        
        const blockHTML = `
            <div id="${blockId}" data-type="${type}" class="block-item bg-white hover:bg-slate-50 transition-all group">
                <div class="flex items-center gap-4 p-4">
                    <div class="drag-handle cursor-move text-slate-400 hover:text-slate-600 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                        </svg>
                    </div>
                    <div class="flex-1 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-${config.color}-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-${config.color}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                ${getBlockIcon(type)}
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2">
                                <span class="block-order inline-flex items-center justify-center w-6 h-6 rounded-full bg-slate-200 text-slate-700 text-xs font-bold">${blockCounter}</span>
                                <h3 class="font-semibold text-slate-800">${config.name}</h3>
                            </div>
                            <p class="text-xs text-slate-500 mt-0.5">Click to configure</p>
                        </div>
                    </div>
                    <button type="button" 
                            onclick="openEditModal('${blockId}')"
                            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium text-sm transition-all opacity-0 group-hover:opacity-100 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Configure
                    </button>
                </div>
            </div>
        `;
        
        blocksList.insertAdjacentHTML('beforeend', blockHTML);
        checkEmptyState();
        closeBlockLibrary();
        
        // Langsung buka modal edit
        setTimeout(() => {
            openEditNewsletterModal(blockId);
        }, 100);
        
        return;
    }
    
    // Untuk block lainnya, langsung buat block
    blockCounter = getNextBlockCounter(); // Gunakan fungsi baru untuk counter konsisten
    const blockId = `block-${blockCounter}`; // Buat ID unik untuk block
    const config = blockConfig[type]; // Ambil config dari object blockConfig
    const blocksList = document.getElementById('blocksList'); // Ambil container list
    
    // Buat HTML untuk block baru menggunakan template literal
    const blockHTML = `
        <div id="${blockId}" data-type="${type}" class="block-item bg-white hover:bg-slate-50 transition-all group">
            <div class="flex items-center gap-4 p-4">
                <div class="drag-handle cursor-move text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                    </svg>
                </div>
                <div class="flex-1 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-${config.color}-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-${config.color}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            ${getBlockIcon(type)}
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <span class="block-order inline-flex items-center justify-center w-6 h-6 rounded-full bg-slate-200 text-slate-700 text-xs font-bold">${blockCounter}</span>
                            <h3 class="font-semibold text-slate-800">${config.name}</h3>
                        </div>
                        <p class="text-xs text-slate-500 mt-0.5">Click to configure</p>
                    </div>
                </div>
                <button type="button" 
                        onclick="openEditModal('${blockId}')"
                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium text-sm transition-all opacity-0 group-hover:opacity-100 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Configure
                </button>
            </div>
        </div>
    `;
    
    // Insert HTML ke dalam list
    blocksList.insertAdjacentHTML('beforeend', blockHTML);
    
    // Tutup library modal
    closeBlockLibrary();
    
    // Cek empty state
    checkEmptyState();
    
    // Update nomor urutan
    updateBlockOrder();
    
    // Re-initialize sortable jika belum ada
    if (!sortable) {
        initSortable();
    }
}

// ===================================================================
// BAGIAN 17: FUNGSI HELPER UNTUK ICON
// ===================================================================

/**
 * Mendapatkan SVG path untuk icon block
 * SVG = Scalable Vector Graphics (gambar vektor)
 * 
 * @param {string} type - Tipe block
 * @returns {string} - SVG path untuk icon
 */
function getBlockIcon(type) {
    // Object dengan key-value pairs untuk setiap icon
    const icons = {
        'title': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>',
        'simple-text': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>',
        'text-editor': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>',
        'complete-counts': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>',
        'hero-banner': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>',
        'about': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
        'brands': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>',
        'testimonials': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>',
        'recent-product': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>',
        'product-category': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>',
        'featured-services': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>',
        'newsletter': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>',
        'latestnews': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>',
        'comingsoon': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l2.5 2.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
        'contact': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>'
    };
    
    // Return icon SVG path, atau empty string jika tidak ditemukan
    // || = OR operator, jika icons[type] tidak ada, return ''
    return icons[type] || '';
}

// ===================================================================
// BAGIAN 18: FUNGSI CHECK EMPTY STATE
// ===================================================================

/**
 * Mengecek apakah list block kosong atau tidak
 * Jika kosong, tampilkan pesan "No blocks yet"
 */
function checkEmptyState() {
    // Ambil semua block yang ada
    const blocks = document.querySelectorAll('.block-item');
    const emptyState = document.getElementById('emptyState');
    
    // blocks.length = jumlah block
    // === 0 = sama dengan 0 (exact equality)
    if (blocks.length === 0) {
        // Jika tidak ada block, tampilkan empty state
        emptyState.classList.remove('hidden');
    } else {
        // Jika ada block, sembunyikan empty state
        emptyState.classList.add('hidden');
    }
}

/**
 * Load existing blocks dari database
 * 
 * PENJELASAN:
 * Function ini dipanggil saat halaman pertama kali di-load.
 * Function akan membaca data blocks yang sudah tersimpan di database
 * dan menampilkannya di list.
 * 
 * CARA KERJA:
 * 1. Cek apakah ada data existingShortcodes dari server
 * 2. Loop setiap shortcode
 * 3. Buat block element untuk setiap shortcode
 * 4. Tambahkan ke list
 * 5. Update counter dan empty state
 */
function loadExistingBlocks() {
    console.log('📥 Loading existing blocks from database...');
    
    // Cek apakah ada data dari server
    // window.existingShortcodes = data yang di-set dari Blade template
    if (!window.existingShortcodes || !Array.isArray(window.existingShortcodes)) {
        console.log('ℹ️ No existing shortcodes found');
        return; // Keluar jika tidak ada data
    }
    
    // Ambil container untuk blocks
    const blocksList = document.getElementById('blocksList');
    if (!blocksList) {
        console.error('❌ Blocks list container not found!');
        return;
    }
    
    console.log(`🔄 Found ${window.existingShortcodes.length} existing blocks to load`);
    
    // Loop setiap shortcode dari database (sorted by sort_id dari controller)
    window.existingShortcodes.forEach((shortcode, index) => {
        console.log(`📦 Loading block ${index + 1}/${window.existingShortcodes.length}:`, shortcode.type, shortcode);
        
        // Increment counter untuk ID block baru
        blockCounter++;
        const newBlockId = `block-${blockCounter}`;
        console.log(`🔢 Assigned block ID: ${newBlockId}`);
        
        // ⭐ PENTING: Simpan data ke cache SEBELUM render block
        // Ini memastikan saat user klik Configure, data langsung tersedia di modal
        blockDataCache[newBlockId] = {
            id: shortcode.id,
            type: shortcode.type,
            sort_id: shortcode.sort_id,
            // Common fields
            title: shortcode.title,
            subtitle: shortcode.subtitle,
            heading: shortcode.heading,
            content: shortcode.content,
            // Hero fields
            hero_style: shortcode.hero_style,
            hero: shortcode.hero, // Relationship data
            section_hero_id: shortcode.section_hero_id,
            // About fields
            about_style: shortcode.about_style,
            about: shortcode.about, // Relationship data
            section_about_id: shortcode.section_about_id,
            // Testimonials fields
            testimonials_title: shortcode.testimonials_title,
            testimonials_subtitle: shortcode.testimonials_subtitle,
            testimonials_style: shortcode.testimonials_style,
            section_testimoni_id: shortcode.section_testimoni_id,
            // Product fields
            product_title: shortcode.product_title,
            product_subtitle: shortcode.product_subtitle,
            product_category_id: shortcode.product_category_id,
            product_category_limit: shortcode.product_category_limit,
            product_category_style: shortcode.product_category_style,
            // Service fields
            service_style: shortcode.service_style,
            section_service_id: shortcode.section_service_id,
            // Brand fields
            section_brand_id: shortcode.section_brand_id,
            // Complete Counts fields
            section_completecount_id: shortcode.section_completecount_id,
            // Newsletter fields
            section_newsletter_id: shortcode.section_newsletter_id,
            // Latest News fields
            latestnews_title: shortcode.latestnews_title,
            latestnews_style: shortcode.latestnews_style,
            blog_limit: shortcode.blog_limit,
            // Coming Soon fields
            comingsoon_image: shortcode.comingsoon_image,
            comingsoon_title: shortcode.comingsoon_title,
            comingsoon_subtitle: shortcode.comingsoon_subtitle,
            comingsoon_placeholder: shortcode.comingsoon_placeholder,
            // Contact fields
            contact_title_1: shortcode.contact_title_1,
            contact_subtitle: shortcode.contact_subtitle,
            contact_id: shortcode.contact_id,
        };
        
        console.log(`💾 Cached data for ${newBlockId}:`, blockDataCache[newBlockId]);
        
        // Ambil config untuk block type ini
        const config = blockConfig[shortcode.type] || { name: shortcode.type, icon: 'cube', color: 'gray' };
        
        // Tentukan label berdasarkan type dan data
        let blockLabel = config.name;
        
        // ⭐ Tambahkan data attributes khusus berdasarkan type block
        // Ini penting untuk membuka modal yang sesuai dengan style
        let additionalDataAttributes = '';
        
        if (shortcode.type === 'hero-banner') {
            const heroStyle = shortcode.hero_style || '1';
            additionalDataAttributes = `data-style="${heroStyle}"`;
            blockLabel = `${config.name} - Style ${heroStyle}`;
        } else if (shortcode.type === 'about') {
            const aboutStyle = shortcode.about_style || '1';
            additionalDataAttributes = `data-about-style="${aboutStyle}"`;
            blockLabel = `${config.name} - Style ${aboutStyle}`;
        } else if (shortcode.type === 'product-category') {
            const productCategoryStyle = shortcode.product_category_style || '1';
            additionalDataAttributes = `data-product-category-style="${productCategoryStyle}"`;
            blockLabel = `${config.name} - Style ${productCategoryStyle}`;
        } else if (shortcode.type === 'testimonials') {
            const testimonialsStyle = shortcode.testimonials_style || '1';
            additionalDataAttributes = `data-style="${testimonialsStyle}"`;
            blockLabel = `${config.name} - Style ${testimonialsStyle}`;
        } else if (shortcode.type === 'services') {
            const serviceStyle = shortcode.service_style || '1';
            additionalDataAttributes = `data-style="${serviceStyle}"`;
            blockLabel = `${config.name} - Style ${serviceStyle}`;
        } else if (shortcode.type === 'latest-news') {
            const latestnewsStyle = shortcode.latestnews_style || '1';
            additionalDataAttributes = `data-style="${latestnewsStyle}"`;
            blockLabel = `${config.name} - Style ${latestnewsStyle}`;
        }
        
        // Buat HTML untuk block
        const blockHTML = `
            <div id="${newBlockId}" 
                 class="block-item bg-white border-2 border-slate-200 rounded-xl hover:border-indigo-400 hover:shadow-lg transition-all duration-300 cursor-move group"
                 data-type="${shortcode.type}"
                 data-shortcode-id="${shortcode.id}"
                 ${additionalDataAttributes}>
                <div class="flex items-center justify-between p-4">
                    <div class="flex items-center gap-3 flex-1">
                        <!-- Drag Handle -->
                        <div class="drag-handle cursor-move text-slate-400 group-hover:text-indigo-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/>
                            </svg>
                        </div>
                        
                        <!-- Block Order Number -->
                        <span class="block-order font-bold text-slate-600 text-sm">${shortcode.sort_id || index + 1}</span>
                        
                        <!-- Block Icon & Name -->
                        <div class="flex items-center gap-2 flex-1">
                            <div class="w-10 h-10 rounded-lg bg-${config.color}-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-${config.color}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    ${getBlockIcon(shortcode.type)}
                                </svg>
                            </div>
                            <div>
                                <span class="font-semibold text-slate-800 block">${blockLabel}</span>
                                ${shortcode.title ? `<span class="text-xs text-slate-500">${shortcode.title.substring(0, 30)}${shortcode.title.length > 30 ? '...' : ''}</span>` : ''}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex items-center gap-2">
                        <button type="button" 
                                onclick="openEditModal('${newBlockId}')"
                                class="px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 rounded-lg transition-colors text-sm font-semibold">
                            Configure
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        // Tambahkan block ke list
        blocksList.insertAdjacentHTML('beforeend', blockHTML);
        
        console.log(`✅ Block ${newBlockId} rendered (shortcode ID: ${shortcode.id})`);
    });
    
    // Update empty state setelah semua blocks di-load
    checkEmptyState();
    
    // Update order numbers (tidak perlu karena sudah di-set dari sort_id)
    // updateBlockOrder();
    
    // PENTING: Set blockCounter ke nomor tertinggi yang ada
    // Agar block baru yang ditambahkan tidak bentrok dengan yang lama
    const blocks = document.querySelectorAll('.block-item');
    let maxCounter = 0;
    blocks.forEach(block => {
        const blockId = block.id;
        if (blockId && blockId.startsWith('block-')) {
            const num = parseInt(blockId.replace('block-', ''));
            if (!isNaN(num) && num > maxCounter) {
                maxCounter = num;
            }
        }
    });
    blockCounter = maxCounter; // Set ke nomor tertinggi
    console.log(`🔢 Block counter initialized to: ${blockCounter}`);
    
    console.log(`✅ Successfully loaded ${window.existingShortcodes.length} blocks from database`);
    console.log('📊 Current blockDataCache:', blockDataCache);
}

// ===================================================================
// BAGIAN 19: TESTIMONIALS FUNCTIONS
// ===================================================================

/**
 * Menutup modal pemilihan style testimonials
 */
function closeSelectTestimonialsStyleModal() {
    closeModalWithTransition('selectTestimonialsStyleModal', () => {
        if (pendingTestimonialsBlockId) {
            pendingTestimonialsBlockId = null;
            blockCounter--;
        }
    });
}

/**
 * Memilih style untuk testimonials dan membuat block-nya
 * 
 * @param {string} style - Nomor style yang dipilih ('1', '2', atau '3')
 */
function selectTestimonialsStyle(style) {
    if (!pendingTestimonialsBlockId) return;
    
    const blockId = pendingTestimonialsBlockId;
    const config = blockConfig['testimonials'];
    const blocksList = document.getElementById('blocksList');
    
    const blockHTML = `
        <div id="${blockId}" data-type="testimonials" data-style="${style}" class="block-item bg-white hover:bg-slate-50 transition-all group">
            <div class="flex items-center gap-4 p-4">
                <div class="drag-handle cursor-move text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                    </svg>
                </div>
                <div class="flex-1 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-${config.color}-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-${config.color}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            ${getBlockIcon('testimonials')}
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <span class="block-order inline-flex items-center justify-center w-6 h-6 rounded-full bg-slate-200 text-slate-700 text-xs font-bold">${blockCounter}</span>
                            <h3 class="font-semibold text-slate-800">${config.name} - Style ${style}</h3>
                        </div>
                        <p class="text-xs text-slate-500 mt-0.5">Click to configure</p>
                    </div>
                </div>
                <button type="button" 
                        onclick="openEditModal('${blockId}')"
                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium text-sm transition-all opacity-0 group-hover:opacity-100 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Configure
                </button>
            </div>
        </div>
    `;
    
    blocksList.insertAdjacentHTML('beforeend', blockHTML);
    pendingTestimonialsBlockId = null;
    closeModalWithTransition('selectTestimonialsStyleModal');
    checkEmptyState();
    updateBlockOrder();
    
    if (!sortable) {
        initSortable();
    }
}

/**
 * Membuka modal edit testimonials
 */
async function openEditTestimonialsModal() {
    const block = document.getElementById(currentEditBlockId);
    const style = block?.dataset.style || '1';
    const shortcodeId = block?.dataset.shortcodeId || '';
    
    // Reset form fields dulu (penting untuk block baru)
    document.getElementById('testimonials_title').value = '';
    document.getElementById('testimonials_subtitle').value = '';
    document.getElementById('testimonials_shortcode_id').value = '';
    
    document.getElementById('testimonials_style_value').value = style;
    
    const styleNames = {
        '1': 'Style 1: Classic Grid',
        '2': 'Style 2: Slider View',
        '3': 'Style 3: Masonry Layout'
    };
    document.getElementById('testimonials_style_display').textContent = styleNames[style] || 'Unknown Style';
    
    // Load data dari cache atau database jika ada
    let shortcodeData = null;
    let selectedTestimonialIds = [];
    
    // Prioritas 1: Cek cache local
    if (blockDataCache[currentEditBlockId]) {
        console.log('📦 Loading testimonials from cache:', currentEditBlockId);
        shortcodeData = blockDataCache[currentEditBlockId];
        selectedTestimonialIds = shortcodeData.section_testimoni_id || [];
    }
    // Prioritas 2: Fetch dari database
    else if (shortcodeId) {
        console.log('🔄 Loading testimonials from database:', shortcodeId);
        try {
            const response = await fetch(`/bagoosh/page-shortcode/show/${shortcodeId}`);
            const result = await response.json();
            if (result.success) {
                shortcodeData = result.data;
                selectedTestimonialIds = shortcodeData.section_testimoni_id || [];
                // Simpan ke cache
                blockDataCache[currentEditBlockId] = shortcodeData;
            }
        } catch (error) {
            console.error('Error loading testimonials data:', error);
        }
    }
    
    // Populate form jika ada data
    if (shortcodeData) {
        document.getElementById('testimonials_shortcode_id').value = shortcodeData.id || '';
        document.getElementById('testimonials_title').value = shortcodeData.testimonials_title || '';
        document.getElementById('testimonials_subtitle').value = shortcodeData.testimonials_subtitle || '';
    } else {
        // Form sudah di-reset di atas
        document.getElementById('testimonials_shortcode_id').value = shortcodeId;
    }
    
    // Fetch daftar testimonials dan restore selection
    fetchTestimonialsList(selectedTestimonialIds);
    
    document.getElementById('editTestimonialsModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

/**
 * Menutup modal edit testimonials
 */
function closeEditTestimonialsModal() {
    closeModalWithTransition('editTestimonialsModal', () => {
        // Reset form
        document.getElementById('testimonials_title').value = '';
        document.getElementById('testimonials_subtitle').value = '';
        document.getElementById('testimonials_shortcode_id').value = '';
        document.getElementById('testimonials_style_value').value = '';
        
        // Uncheck all checkboxes
        document.querySelectorAll('#testimonialsList input[type="checkbox"]').forEach(cb => {
            cb.checked = false;
        });
        
        // Reset button states
        const saveBtn = document.getElementById('saveTestimonialsBtn');
        const saveIconCheck = document.getElementById('saveTestimonialsIconCheck');
        const saveIconLoading = document.getElementById('saveTestimonialsIconLoading');
        const saveButtonText = document.getElementById('saveTestimonialsButtonText');
        if (saveBtn) {
            saveBtn.disabled = false;
            saveIconCheck?.classList.remove('hidden');
            saveIconLoading?.classList.add('hidden');
            if (saveButtonText) saveButtonText.textContent = 'Save Changes';
        }
        
        const deleteBtn = document.getElementById('deleteTestimonialsBtn');
        const deleteIconTrash = document.getElementById('deleteTestimonialsIconTrash');
        const deleteIconLoading = document.getElementById('deleteTestimonialsIconLoading');
        const deleteButtonText = document.getElementById('deleteTestimonialsButtonText');
        if (deleteBtn) {
            deleteBtn.disabled = false;
            deleteIconTrash?.classList.remove('hidden');
            deleteIconLoading?.classList.add('hidden');
            if (deleteButtonText) deleteButtonText.textContent = 'Delete';
        }
        
        currentEditBlockId = null;
    });
}

/**
 * Fetch (ambil) daftar testimonials dari server
 * Menggunakan AJAX dengan fetch API
 */
/**
 * Fetch testimonials list dan populate checkboxes
 * @param {array} selectedIds - Array of testimonial IDs yang sudah dipilih (untuk restore)
 */
function fetchTestimonialsList(selectedIds = []) {
    // Ambil container untuk menampilkan list
    const listContainer = document.getElementById('testimonialsList');
    
    // Gunakan cached data kalau sudah ada
    if (cachedTestimonials.length > 0) {
        listContainer.innerHTML = cachedTestimonials.map(testimonial => {
            const isChecked = selectedIds.includes(testimonial.id) ? 'checked' : '';
            return `
                <label class="flex items-start gap-3 p-3 border-2 border-slate-200 rounded-lg hover:bg-yellow-50 hover:border-yellow-300 transition-colors cursor-pointer">
                    <input type="checkbox" 
                           name="testimonials[]" 
                           value="${testimonial.id}" 
                           class="mt-1 w-5 h-5 text-yellow-600 rounded focus:ring-yellow-500" 
                           ${isChecked}>
                    <div class="flex-1">
                        <div class="font-semibold text-slate-800">${testimonial.name}</div>
                        <div class="text-sm text-slate-600">${testimonial.position}</div>
                        <div class="text-sm text-slate-500 mt-1">${testimonial.content.substring(0, 100)}...</div>
                        <div class="flex items-center gap-1 mt-2">
                            ${generateStars(testimonial.star)}
                        </div>
                    </div>
                </label>
            `;
        }).join('');
        console.log('✅ Testimonials loaded from cache:', cachedTestimonials.length, 'items');
        return;
    }
    
    // Kalau cached data belum ada, fetch dari server
    listContainer.innerHTML = '<div class="flex items-center justify-center py-8"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-yellow-600"></div></div>';
    
    // Kirim request ke server untuk ambil data
    fetch('/bagoosh/testimonials/list')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.testimonials) {
                // Simpan ke cache
                cachedTestimonials = data.testimonials;
                
                if (data.testimonials.length === 0) {
                    listContainer.innerHTML = '<p class="text-center py-8 text-slate-500">No testimonials available</p>';
                    return;
                }
                
                listContainer.innerHTML = data.testimonials.map(testimonial => {
                    const isChecked = selectedIds.includes(testimonial.id) ? 'checked' : '';
                    return `
                        <label class="flex items-start gap-3 p-3 border-2 border-slate-200 rounded-lg hover:bg-yellow-50 hover:border-yellow-300 transition-colors cursor-pointer">
                            <input type="checkbox" 
                                   name="testimonials[]" 
                                   value="${testimonial.id}" 
                                   class="mt-1 w-5 h-5 text-yellow-600 rounded focus:ring-yellow-500" 
                                   ${isChecked}>
                            <div class="flex-1">
                                <div class="font-semibold text-slate-800">${testimonial.name}</div>
                                <div class="text-sm text-slate-600">${testimonial.position}</div>
                                <div class="text-sm text-slate-500 mt-1">${testimonial.content.substring(0, 100)}...</div>
                                <div class="flex items-center gap-1 mt-2">
                                    ${generateStars(testimonial.star)}
                                </div>
                            </div>
                        </label>
                    `;
                }).join('');
                console.log('✅ Testimonials loaded:', data.testimonials.length, 'items');
            } else {
                listContainer.innerHTML = '<p class="text-center py-8 text-red-500">Failed to load testimonials</p>';
            }
        })
        .catch(error => {
            console.error('Error fetching testimonials:', error);
            listContainer.innerHTML = '<p class="text-center py-8 text-red-500">Error loading testimonials</p>';
        });
}

/**
 * Generate star icons based on rating
 * Helper function untuk menampilkan bintang rating
 * 
 * @param {number} count - Jumlah bintang (1-5)
 * @returns {string} - HTML untuk star icons
 */
function generateStars(count) {
    let stars = '';
    // for loop = perulangan dengan counter
    // i = 0, 1, 2, 3, 4 (total 5 kali)
    for (let i = 0; i < 5; i++) {
        // Jika i kurang dari count, buat bintang penuh (filled)
        // Jika tidak, buat bintang kosong (outlined)
        if (i < count) {
            stars += '<svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>';
        } else {
            stars += '<svg class="w-4 h-4 text-slate-300" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>';
        }
    }
    return stars;
}

/**
 * Menyimpan testimonials block ke database
 */
async function saveTestimonialsBlock() {
    if (!currentEditBlockId) return;
    
    // Ambil nilai dari form
    const title = document.getElementById('testimonials_title').value.trim();
    const subtitle = document.getElementById('testimonials_subtitle').value.trim();
    const style = document.getElementById('testimonials_style_value').value;
    const shortcodeId = document.getElementById('testimonials_shortcode_id').value;
    const pageId = window.pageId;
    
    // Ambil semua checkbox yang dicentang
    const checkboxes = document.querySelectorAll('#testimonialsList input[type="checkbox"]:checked');
    const selectedIds = Array.from(checkboxes).map(cb => parseInt(cb.value));
    
    // Validasi minimal harus pilih 1 testimonial
    if (selectedIds.length === 0) {
        alert('Please select at least one testimonial');
        return;
    }
    
    // Hitung sort_id dari posisi AKTUAL di blocklist
    const sortId = getCurrentSortId(currentEditBlockId);
    
    const saveBtn = document.getElementById('saveTestimonialsBtn');
    const saveIconCheck = document.getElementById('saveTestimonialsIconCheck');
    const saveIconLoading = document.getElementById('saveTestimonialsIconLoading');
    const saveButtonText = document.getElementById('saveTestimonialsButtonText');
    
    saveBtn.disabled = true;
    saveIconCheck.classList.add('hidden');
    saveIconLoading.classList.remove('hidden');
    saveButtonText.textContent = 'Saving...';

    try {
        const data = {
            type: 'testimonials',
            testimonials_title: title,
            testimonials_subtitle: subtitle,
            testimonials_style: style,
            section_testimoni_id: selectedIds,
            pages_id: pageId,
            sort_id: sortId
        };
        
        const url = shortcodeId 
            ? `/bagoosh/page-shortcode/update/${shortcodeId}`
            : '/bagoosh/page-shortcode/store';
        const method = shortcodeId ? 'PUT' : 'POST';
        
        console.log('💾 Saving testimonials block:', { url, method, data });
        
        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        
        if (!response.ok) {
            throw new Error(result.message || 'Failed to save');
        }
        
        // Update hidden input dengan ID baru (untuk update berikutnya)
        if (result.data && result.data.id) {
            document.getElementById('testimonials_shortcode_id').value = result.data.id;
            
            // Simpan ke cache
            blockDataCache[currentEditBlockId] = {
                id: result.data.id,
                type: 'testimonials',
                testimonials_title: title,
                testimonials_subtitle: subtitle,
                testimonials_style: style,
                section_testimoni_id: selectedIds,
                sort_id: sortId
            };
            console.log('📦 Saved to cache:', blockDataCache[currentEditBlockId]);
        }
        
        // Update tampilan block di UI
        const block = document.getElementById(currentEditBlockId);
        if (block) {
            const blockContent = block.querySelector('.block-content');
            if (blockContent) {
                blockContent.innerHTML = `
                    <div class="space-y-1">
                        ${title ? `<div class="font-semibold text-slate-700">${title}</div>` : ''}
                        <div class="flex items-center gap-2 text-sm text-slate-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>${selectedIds.length} testimonial(s) selected</span>
                        </div>
                    </div>
                `;
            }
        }
        
        closeEditTestimonialsModal();
        alert('Testimonials saved successfully!');
        
    } catch (error) {
        console.error('Error saving testimonials:', error);
        alert('Failed to save testimonials: ' + error.message);
    } finally {
        // Restore button state
        saveBtn.disabled = false;
        saveIconCheck.classList.remove('hidden');
        saveIconLoading.classList.add('hidden');
        saveButtonText.textContent = 'Save Changes';
    }
}

/**
 * Menghapus testimonials block
 */
async function deleteTestimonialsBlock() {
    if (!currentEditBlockId) return;
    if (!confirm('Are you sure you want to delete this testimonials block?')) return;
    
    const shortcodeId = document.getElementById('testimonials_shortcode_id').value;
    const deleteBtn = document.getElementById('deleteTestimonialsBtn');
    const deleteIconTrash = document.getElementById('deleteTestimonialsIconTrash');
    const deleteIconLoading = document.getElementById('deleteTestimonialsIconLoading');
    const deleteButtonText = document.getElementById('deleteTestimonialsButtonText');
    
    deleteBtn.disabled = true;
    deleteIconTrash.classList.add('hidden');
    deleteIconLoading.classList.remove('hidden');
    deleteButtonText.textContent = 'Deleting...';
    
    try {
        // Jika ada shortcodeId = data sudah tersimpan di database, perlu API call
        if (shortcodeId) {
            const response = await fetch(`/bagoosh/page-shortcode/delete/${shortcodeId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            
            const result = await response.json();
            
            if (!response.ok) {
                throw new Error(result.message || 'Failed to delete from database');
            }
        }
        // Jika tidak ada shortcodeId = block baru belum tersimpan, langsung hapus dari UI saja
        
        // Hapus dari cache
        delete blockDataCache[currentEditBlockId];
        
        // Hapus dari UI dengan animasi
        const block = document.getElementById(currentEditBlockId);
        if (block) {
            block.style.transition = 'opacity 300ms';
            block.style.opacity = '0';
            setTimeout(() => {
                block.remove();
                checkEmptyState();
                updateBlockOrder();
            }, 300);
        }
        
        closeEditTestimonialsModal();
        alert('Testimonials block deleted successfully!');
        
    } catch (error) {
        console.error('Error deleting testimonials block:', error);
        alert('Failed to delete: ' + error.message);
    } finally {
        // Restore button state
        deleteBtn.disabled = false;
        deleteIconTrash.classList.remove('hidden');
        deleteIconLoading.classList.add('hidden');
        deleteButtonText.textContent = 'Delete';
    }
}

// ===================================================================
// BAGIAN 20: RECENT PRODUCT FUNCTIONS
// ===================================================================

/**
 * Membuka modal edit recent product
 */
async function openEditRecentProductModal() {
    const block = document.getElementById(currentEditBlockId);
    const shortcodeId = block?.dataset.shortcodeId || '';
    
    // Reset form fields dulu (penting untuk block baru)
    document.getElementById('recentproduct_title').value = '';
    document.getElementById('recentproduct_subtitle').value = '';
    document.getElementById('recentproduct_shortcode_id').value = '';
    
    // Load data dari cache atau database jika ada
    let shortcodeData = null;
    
    // Prioritas 1: Cek cache local
    if (blockDataCache[currentEditBlockId]) {
        console.log('📦 Loading recent product from cache:', currentEditBlockId);
        shortcodeData = blockDataCache[currentEditBlockId];
    }
    // Prioritas 2: Fetch dari database
    else if (shortcodeId) {
        console.log('🔄 Loading recent product from database:', shortcodeId);
        try {
            const response = await fetch(`/bagoosh/page-shortcode/show/${shortcodeId}`);
            const result = await response.json();
            if (result.success) {
                shortcodeData = result.data;
                // Simpan ke cache
                blockDataCache[currentEditBlockId] = shortcodeData;
            }
        } catch (error) {
            console.error('Error loading recent product data:', error);
        }
    }
    
    // Populate form jika ada data
    if (shortcodeData) {
        document.getElementById('recentproduct_shortcode_id').value = shortcodeData.id || '';
        document.getElementById('recentproduct_title').value = shortcodeData.product_title || '';
        document.getElementById('recentproduct_subtitle').value = shortcodeData.product_subtitle || '';
    } else {
        // Form sudah di-reset di atas
        document.getElementById('recentproduct_shortcode_id').value = shortcodeId;
    }
    
    document.getElementById('editRecentProductModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

/**
 * Menutup modal edit recent product
 */
function closeEditRecentProductModal() {
    closeModalWithTransition('editRecentProductModal', () => {
        // Reset form
        document.getElementById('recentproduct_title').value = '';
        document.getElementById('recentproduct_subtitle').value = '';
        document.getElementById('recentproduct_shortcode_id').value = '';
        
        // Reset button states
        const saveBtn = document.getElementById('saveRecentProductBtn');
        const saveIconCheck = document.getElementById('saveRecentProductIconCheck');
        const saveIconLoading = document.getElementById('saveRecentProductIconLoading');
        const saveButtonText = document.getElementById('saveRecentProductButtonText');
        if (saveBtn) {
            saveBtn.disabled = false;
            saveIconCheck?.classList.remove('hidden');
            saveIconLoading?.classList.add('hidden');
            if (saveButtonText) saveButtonText.textContent = 'Save Changes';
        }
        
        const deleteBtn = document.getElementById('deleteRecentProductBtn');
        const deleteIconTrash = document.getElementById('deleteRecentProductIconTrash');
        const deleteIconLoading = document.getElementById('deleteRecentProductIconLoading');
        const deleteButtonText = document.getElementById('deleteRecentProductButtonText');
        if (deleteBtn) {
            deleteBtn.disabled = false;
            deleteIconTrash?.classList.remove('hidden');
            deleteIconLoading?.classList.add('hidden');
            if (deleteButtonText) deleteButtonText.textContent = 'Delete';
        }
        
        currentEditBlockId = null;
    });
}

/**
 * Menyimpan recent product block ke database
 */
async function saveRecentProductBlock() {
    if (!currentEditBlockId) return;
    
    const title = document.getElementById('recentproduct_title').value.trim();
    const subtitle = document.getElementById('recentproduct_subtitle').value.trim();
    const shortcodeId = document.getElementById('recentproduct_shortcode_id').value;
    const pageId = window.pageId;
    
    // Hitung sort_id dari posisi AKTUAL di blocklist
    const sortId = getCurrentSortId(currentEditBlockId);
    
    const saveBtn = document.getElementById('saveRecentProductBtn');
    const saveIconCheck = document.getElementById('saveRecentProductIconCheck');
    const saveIconLoading = document.getElementById('saveRecentProductIconLoading');
    const saveButtonText = document.getElementById('saveRecentProductButtonText');
    
    saveBtn.disabled = true;
    saveIconCheck.classList.add('hidden');
    saveIconLoading.classList.remove('hidden');
    saveButtonText.textContent = 'Saving...';

    try {
        const data = {
            type: 'recent-product',
            product_title: title,
            product_subtitle: subtitle,
            pages_id: pageId,
            sort_id: sortId
        };
        
        const url = shortcodeId 
            ? `/bagoosh/page-shortcode/update/${shortcodeId}`
            : '/bagoosh/page-shortcode/store';
        const method = shortcodeId ? 'PUT' : 'POST';
        
        console.log('💾 Saving recent product block:', { url, method, data });
        
        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        
        if (!response.ok) {
            throw new Error(result.message || 'Failed to save');
        }
        
        // Update hidden input dengan ID baru (untuk update berikutnya)
        if (result.data && result.data.id) {
            document.getElementById('recentproduct_shortcode_id').value = result.data.id;
            
            // Simpan ke cache
            blockDataCache[currentEditBlockId] = {
                id: result.data.id,
                type: 'recent-product',
                product_title: title,
                product_subtitle: subtitle,
                sort_id: sortId
            };
            console.log('📦 Saved to cache:', blockDataCache[currentEditBlockId]);
        }
        
        // Update tampilan block di UI
        const block = document.getElementById(currentEditBlockId);
        if (block) {
            const blockContent = block.querySelector('.block-content');
            if (blockContent) {
                blockContent.innerHTML = `
                    <div class="space-y-1">
                        ${title ? `<div class="font-semibold text-slate-700">${title}</div>` : ''}
                        ${subtitle ? `<div class="text-sm text-slate-600">${subtitle}</div>` : ''}
                    </div>
                `;
            }
        }
        
        closeEditRecentProductModal();
        alert('Recent product block saved successfully!');
        
    } catch (error) {
        console.error('Error saving recent product:', error);
        alert('Failed to save recent product: ' + error.message);
    } finally {
        // Restore button state
        saveBtn.disabled = false;
        saveIconCheck.classList.remove('hidden');
        saveIconLoading.classList.add('hidden');
        saveButtonText.textContent = 'Save Changes';
    }
}

/**
 * Menghapus recent product block
 */
async function deleteRecentProductBlock() {
    if (!currentEditBlockId) return;
    if (!confirm('Are you sure you want to delete this recent product block?')) return;
    
    const shortcodeId = document.getElementById('recentproduct_shortcode_id').value;
    const deleteBtn = document.getElementById('deleteRecentProductBtn');
    const deleteIconTrash = document.getElementById('deleteRecentProductIconTrash');
    const deleteIconLoading = document.getElementById('deleteRecentProductIconLoading');
    const deleteButtonText = document.getElementById('deleteRecentProductButtonText');
    
    deleteBtn.disabled = true;
    deleteIconTrash.classList.add('hidden');
    deleteIconLoading.classList.remove('hidden');
    deleteButtonText.textContent = 'Deleting...';
    
    try {
        // Jika ada shortcodeId = data sudah tersimpan di database, perlu API call
        if (shortcodeId) {
            const response = await fetch(`/bagoosh/page-shortcode/delete/${shortcodeId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            
            const result = await response.json();
            
            if (!response.ok) {
                throw new Error(result.message || 'Failed to delete from database');
            }
        }
        // Jika tidak ada shortcodeId = block baru belum tersimpan, langsung hapus dari UI saja
        
        // Hapus dari cache
        delete blockDataCache[currentEditBlockId];
        
        // Hapus dari UI dengan animasi
        const block = document.getElementById(currentEditBlockId);
        if (block) {
            block.style.transition = 'opacity 300ms';
            block.style.opacity = '0';
            setTimeout(() => {
                block.remove();
                checkEmptyState();
                updateBlockOrder();
            }, 300);
        }
        
        closeEditRecentProductModal();
        alert('Recent product block deleted successfully!');
        
    } catch (error) {
        console.error('Error deleting recent product block:', error);
        alert('Failed to delete: ' + error.message);
    } finally {
        // Restore button state
        deleteBtn.disabled = false;
        deleteIconTrash.classList.remove('hidden');
        deleteIconLoading.classList.add('hidden');
        deleteButtonText.textContent = 'Delete';
    }
}

// ===================================================================
// BAGIAN 21: FEATURED SERVICES FUNCTIONS
// ===================================================================

/**
 * Menutup modal pemilihan style featured services
 */
function closeSelectServiceStyleModal() {
    closeModalWithTransition('selectServiceStyleModal', () => {
        if (pendingFeaturedServicesBlockId) {
            pendingFeaturedServicesBlockId = null;
            blockCounter--;
        }
    });
}

/**
 * Memilih style untuk featured services dan membuat block-nya
 */
function selectServiceStyle(style) {
    if (!pendingFeaturedServicesBlockId) return;
    
    const blockId = pendingFeaturedServicesBlockId;
    const config = blockConfig['featured-services'];
    const blocksList = document.getElementById('blocksList');
    
    const blockHTML = `
        <div id="${blockId}" data-type="featured-services" data-style="${style}" class="block-item bg-white hover:bg-slate-50 transition-all group">
            <div class="flex items-center gap-4 p-4">
                <div class="drag-handle cursor-move text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                    </svg>
                </div>
                <div class="flex-1 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-${config.color}-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-${config.color}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            ${getBlockIcon('featured-services')}
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <span class="block-order inline-flex items-center justify-center w-6 h-6 rounded-full bg-slate-200 text-slate-700 text-xs font-bold">${blockCounter}</span>
                            <h3 class="font-semibold text-slate-800">${config.name} - Style ${style}</h3>
                        </div>
                        <p class="text-xs text-slate-500 mt-0.5">Click to configure</p>
                    </div>
                </div>
                <button type="button" 
                        onclick="openEditModal('${blockId}')"
                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium text-sm transition-all opacity-0 group-hover:opacity-100 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Configure
                </button>
            </div>
        </div>
    `;
    
    blocksList.insertAdjacentHTML('beforeend', blockHTML);
    checkEmptyState();
    closeSelectServiceStyleModal();
    pendingFeaturedServicesBlockId = null;
    
    // Langsung buka modal edit
    setTimeout(() => {
        openEditFeaturedServicesModal(blockId);
    }, 100);
}

/**
 * Membuka modal edit featured services
 */
async function openEditFeaturedServicesModal(blockId) {
    currentEditBlockId = blockId;
    
    const block = document.getElementById(blockId);
    if (!block) return;
    
    const style = block?.dataset.style || '1';
    const shortcodeId = block?.dataset.shortcodeId || '';
    
    document.getElementById('serviceStyle').value = style;
    document.getElementById('serviceStyleDisplay').value = `Style ${style}`;
    
    // Load data dari cache atau database jika ada
    let shortcodeData = null;
    let selectedServiceIds = [];
    
    // Prioritas 1: Cek cache local
    if (blockDataCache[currentEditBlockId]) {
        console.log('📦 Loading featured services from cache:', currentEditBlockId);
        shortcodeData = blockDataCache[currentEditBlockId];
        selectedServiceIds = shortcodeData.section_service_id || [];
    }
    // Prioritas 2: Fetch dari database
    else if (shortcodeId) {
        console.log('🔄 Loading featured services from database:', shortcodeId);
        try {
            const response = await fetch(`/bagoosh/page-shortcode/show/${shortcodeId}`);
            const result = await response.json();
            if (result.success) {
                shortcodeData = result.data;
                selectedServiceIds = shortcodeData.section_service_id || [];
                // Simpan ke cache
                blockDataCache[currentEditBlockId] = shortcodeData;
            }
        } catch (error) {
            console.error('Error loading featured services data:', error);
        }
    }
    
    // Fetch daftar services dan restore selection
    fetchServicesList(selectedServiceIds);
    
    // Tampilkan modal
    const modal = document.getElementById('editFeaturedServicesModal');
    if (!modal) return;
    
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

/**
 * Menutup modal edit featured services
 */
function closeEditFeaturedServicesModal() {
    const modal = document.getElementById('editFeaturedServicesModal');
    if (!modal) return;
    
    closeModalWithTransition('editFeaturedServicesModal', () => {
        currentEditBlockId = null;
    });
}

/**
 * Mengambil data services dari server
 * @param {array} selectedIds - Array of service IDs yang sudah dipilih (untuk restore)
 */
function fetchServicesList(selectedIds = []) {
    const listContainer = document.getElementById('servicesList');
    if (!listContainer) return;
    
    // Gunakan cached data kalau sudah ada
    if (cachedServices.length > 0) {
        listContainer.innerHTML = cachedServices.map(service => {
            const isChecked = selectedIds.includes(service.id) ? 'checked' : '';
            return `
                <label class="flex items-center gap-3 p-3 border border-slate-200 rounded-lg hover:bg-purple-50 hover:border-purple-300 transition-colors cursor-pointer">
                    <input type="checkbox" 
                           name="services[]" 
                           value="${service.id}" 
                           class="w-5 h-5 text-purple-600 rounded focus:ring-purple-500" 
                           ${isChecked}>
                    <div class="flex-1">
                        <div class="font-semibold text-slate-800">${service.name}</div>
                        ${service.description ? `<div class="text-sm text-slate-500 mt-1">${service.description}</div>` : ''}
                    </div>
                </label>
            `;
        }).join('');
        console.log('✅ Services loaded from cache:', cachedServices.length, 'items');
        return;
    }
    
    // Kalau cached data belum ada, fetch dari server
    listContainer.innerHTML = '<div class="flex items-center justify-center py-8"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-purple-600"></div></div>';
    
    fetch('/bagoosh/services/list')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.services && data.services.length > 0) {
                // Simpan ke cache
                cachedServices = data.services;
                
                listContainer.innerHTML = data.services.map(service => {
                    const isChecked = selectedIds.includes(service.id) ? 'checked' : '';
                    return `
                        <label class="flex items-center gap-3 p-3 border border-slate-200 rounded-lg hover:bg-purple-50 hover:border-purple-300 transition-colors cursor-pointer">
                            <input type="checkbox" 
                                   name="services[]" 
                                   value="${service.id}" 
                                   class="w-5 h-5 text-purple-600 rounded focus:ring-purple-500" 
                                   ${isChecked}>
                            <div class="flex-1">
                                <div class="font-semibold text-slate-800">${service.name}</div>
                                ${service.description ? `<div class="text-sm text-slate-500 mt-1">${service.description}</div>` : ''}
                            </div>
                        </label>
                    `;
                }).join('');
                console.log('✅ Services loaded:', data.services.length, 'items');
            } else {
                listContainer.innerHTML = '<p class="text-center py-8 text-slate-500">No services available</p>';
            }
        })
        .catch(error => {
            console.error('Error fetching services:', error);
            listContainer.innerHTML = '<p class="text-center py-8 text-red-500">Error loading services</p>';
        });
}

/**
 * Menyimpan featured services block ke database
 */
async function saveFeaturedServicesBlock() {
    if (!currentEditBlockId) return;
    
    const checkboxes = document.querySelectorAll('#servicesList input[type="checkbox"]:checked');
    const selectedIds = Array.from(checkboxes).map(cb => parseInt(cb.value));
    
    if (selectedIds.length === 0) {
        alert('Please select at least one service');
        return;
    }
    
    const block = document.getElementById(currentEditBlockId);
    if (!block) return;
    
    const style = document.getElementById('serviceStyle').value;
    const shortcodeId = block.dataset.shortcodeId;
    const pageId = window.pageId;
    
    // Hitung sort_id dari posisi AKTUAL di blocklist
    const sortId = getCurrentSortId(currentEditBlockId);
    
    const saveBtn = document.getElementById('saveFeaturedServicesBtn');
    const saveIcon = document.getElementById('saveFeaturedServicesIcon');
    const saveLoading = document.getElementById('saveFeaturedServicesLoading');
    const saveText = document.getElementById('saveFeaturedServicesText');
    
    saveBtn.disabled = true;
    saveIcon.classList.add('hidden');
    saveLoading.classList.remove('hidden');
    saveText.textContent = 'Saving...';
    
    try {
        const formData = {
            pages_id: pageId,
            service_style: style,
            section_service_id: selectedIds,
            type: 'featured-services',
            sort_id: sortId
        };
        
        console.log('💾 Saving featured services:', formData);
        
        const url = shortcodeId 
            ? `/bagoosh/page-shortcode/update/${shortcodeId}`
            : '/bagoosh/page-shortcode/store';
        const method = shortcodeId ? 'PUT' : 'POST';
        
        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(formData)
        });
        
        const data = await response.json();
        
        if (!response.ok) {
            throw new Error(data.message || 'Failed to save');
        }
        
        // Simpan ke cache
        if (data.data && data.data.id) {
            blockDataCache[currentEditBlockId] = {
                id: data.data.id,
                type: 'service',
                service_style: style,
                section_service_id: selectedIds,
                sort_id: sortId
            };
            console.log('📦 Saved to cache:', blockDataCache[currentEditBlockId]);
            
            // PENTING: Simpan shortcodeId ke dataset untuk fungsi delete
            if (block) {
                block.dataset.shortcodeId = data.data.id;
                console.log('✅ Saved shortcodeId to block dataset:', data.data.id);
            }
        }
        
        // Update block content
        const blockContent = block.querySelector('.block-content');
        if (blockContent) {
            blockContent.innerHTML = `
                <div class="space-y-1">
                    <div class="font-semibold text-slate-700">Style ${style}</div>
                    <div class="flex items-center gap-2 text-sm text-slate-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>${selectedIds.length} service(s) selected</span>
                    </div>
                </div>
            `;
        }
        
        closeEditFeaturedServicesModal();
        alert('Featured Services saved successfully!');
        
    } catch (error) {
        console.error('Error saving featured services:', error);
        alert('Failed to save featured services: ' + error.message);
    } finally {
        saveBtn.disabled = false;
        saveIcon.classList.remove('hidden');
        saveLoading.classList.add('hidden');
        saveText.textContent = 'Save';
    }
}

/**
 * Menghapus featured services block
 */
async function deleteFeaturedServicesBlock() {
    if (!currentEditBlockId) return;
    if (!confirm('Are you sure you want to delete this Featured Services block?')) {
        return;
    }
    
    const block = document.getElementById(currentEditBlockId);
    if (!block) return;
    
    const shortcodeId = block.dataset.shortcodeId;
    
    const deleteBtn = document.getElementById('deleteFeaturedServicesBtn');
    const deleteIcon = document.getElementById('deleteFeaturedServicesIcon');
    const deleteLoading = document.getElementById('deleteFeaturedServicesLoading');
    const deleteText = document.getElementById('deleteFeaturedServicesText');
    
    deleteBtn.disabled = true;
    deleteIcon.classList.add('hidden');
    deleteLoading.classList.remove('hidden');
    deleteText.textContent = 'Deleting...';
    
    try {
        // Jika ada shortcodeId = data sudah tersimpan di database, perlu API call
        if (shortcodeId) {
            console.log('🗑️ Deleting featured services from database:', shortcodeId);
            const response = await fetch(`/bagoosh/page-shortcode/delete/${shortcodeId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            
            const data = await response.json();
            
            if (!response.ok) {
                throw new Error(data.message || 'Failed to delete from database');
            }
            console.log('✅ Deleted from database');
        } else {
            console.log('ℹ️ Block not saved yet, removing from UI only');
        }
        
        // Hapus dari cache
        if (blockDataCache[currentEditBlockId]) {
            delete blockDataCache[currentEditBlockId];
            console.log('🗑️ Deleted from cache:', currentEditBlockId);
        }
        
        // Hapus dari UI
        block.remove();
        checkEmptyState();
        updateBlockOrder();
        closeEditFeaturedServicesModal();
        alert('Featured Services deleted successfully!');
        
    } catch (error) {
        console.error('Error deleting featured services:', error);
        alert('Failed to delete: ' + error.message);
    } finally {
        deleteBtn.disabled = false;
        deleteIcon.classList.remove('hidden');
        deleteLoading.classList.add('hidden');
        deleteText.textContent = 'Delete';
    }
}

// ===================================================================
// BAGIAN 22: NEWSLETTER FUNCTIONS
// ===================================================================

/**
 * Membuka modal edit newsletter
 */
async function openEditNewsletterModal(blockId) {
    currentEditBlockId = blockId;
    
    const block = document.getElementById(blockId);
    if (!block) return;
    
    const shortcodeId = block?.dataset.shortcodeId || '';
    
    // Load data dari cache atau database jika ada
    let shortcodeData = null;
    let newsletterId = '';
    
    // Prioritas 1: Cek cache local
    if (blockDataCache[currentEditBlockId]) {
        console.log('📦 Loading newsletter from cache:', currentEditBlockId);
        shortcodeData = blockDataCache[currentEditBlockId];
        newsletterId = shortcodeData.section_newsletter_id || '';
    }
    // Prioritas 2: Fetch dari database
    else if (shortcodeId) {
        console.log('🔄 Loading newsletter from database:', shortcodeId);
        try {
            const response = await fetch(`/bagoosh/page-shortcode/show/${shortcodeId}`);
            const result = await response.json();
            if (result.success) {
                shortcodeData = result.data;
                newsletterId = shortcodeData.section_newsletter_id || '';
                // Simpan ke cache
                blockDataCache[currentEditBlockId] = shortcodeData;
            }
        } catch (error) {
            console.error('Error loading newsletter data:', error);
        }
    }
    
    // Fetch daftar newsletter dan set selected value
    fetchNewsletterList(newsletterId);
    
    // Tampilkan modal
    const modal = document.getElementById('editNewsletterModal');
    if (!modal) return;
    
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

/**
 * Menutup modal edit newsletter
 * 
 * PENJELASAN:
 * Function ini dipanggil saat:
 * - User klik tombol X (close)
 * - User klik tombol Cancel
 * - User tekan ESC
 * - Setelah berhasil save/delete
 */
function closeEditNewsletterModal() {
    // Panggil helper function untuk tutup dengan animasi
    // Callback function: kode yang dijalankan setelah modal tertutup
    closeModalWithTransition('editNewsletterModal', () => {
        // Reset currentEditBlockId ke null
        // Artinya: tidak ada block yang sedang di-edit
        currentEditBlockId = null;
    });
}

/**
 * Fetch (ambil) daftar newsletter dari server
 * Menggunakan AJAX dengan fetch API
 * 
 * PENJELASAN AJAX:
 * AJAX = Asynchronous JavaScript And XML
 * Cara kirim/terima data dari server TANPA reload halaman
 * 
 * ANALOGI:
 * Seperti kamu pesan makanan via apps:
 * 1. Kamu pesan (kirim request)
 * 2. Sambil tunggu, kamu bisa main HP (tidak freeze)
 * 3. Makanan datang (terima response)
 * 4. Kamu makan (proses data)
 * 
 * @param {string} selectedId - ID newsletter yang sedang dipilih (optional)
 */
function fetchNewsletterList(selectedId = '') {
    // Ambil element dropdown/select
    const selectElement = document.getElementById('newsletterSelect');
    
    // Kalau element tidak ditemukan, keluar dari function
    if (!selectElement) return;
    
    // Gunakan cached data kalau sudah ada
    if (cachedNewsletters.length > 0) {
        // Buat HTML untuk options dropdown dari cached data
        let optionsHTML = '<option value="">-- Select Newsletter --</option>';
        
        // Loop untuk setiap newsletter
        cachedNewsletters.forEach(newsletter => {
            // Cek apakah newsletter ini yang sedang dipilih
            const isSelected = newsletter.id == selectedId ? 'selected' : '';
            optionsHTML += `<option value="${newsletter.id}" ${isSelected}>${newsletter.title}</option>`;
        });
        
        // Update dropdown dengan options baru
        selectElement.innerHTML = optionsHTML;
        console.log('✅ Newsletter list loaded from cache:', cachedNewsletters.length, 'items');
        return;
    }
    
    // Kalau cached data belum ada, fetch dari server
    selectElement.innerHTML = '<option value="">Loading newsletters...</option>';
    
    fetch('/bagoosh/section-newsletters/list')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.newsletters && data.newsletters.length > 0) {
                // Simpan ke cache
                cachedNewsletters = data.newsletters;
                
                let optionsHTML = '<option value="">-- Select Newsletter --</option>';
                
                data.newsletters.forEach(newsletter => {
                    const isSelected = newsletter.id == selectedId ? 'selected' : '';
                    optionsHTML += `<option value="${newsletter.id}" ${isSelected}>${newsletter.title}</option>`;
                });
                
                selectElement.innerHTML = optionsHTML;
                console.log('✅ Newsletter list loaded:', data.newsletters.length, 'items');
            } else {
                selectElement.innerHTML = '<option value="">No newsletters found</option>';
                console.log('⚠️ No newsletters available');
            }
        })
        .catch(error => {
            console.error('❌ Error fetching newsletters:', error);
            selectElement.innerHTML = '<option value="">Error loading newsletters</option>';
            alert('Failed to load newsletters. Please try again.');
        });
}

/**
 * Menyimpan newsletter block ke database
 * 
 * PENJELASAN:
 * Function ini dipanggil saat user klik button "Save".
 * Function akan:
 * 1. Ambil data dari form (newsletter ID yang dipilih)
 * 2. Kirim ke server via AJAX
 * 3. Update block di UI kalau berhasil
 * 
 * ALUR:
 * 1. Show loading state (disable button, ganti icon)
 * 2. Validate: cek newsletter sudah dipilih atau belum
 * 3. Prepare data untuk dikirim
 * 4. Kirim via fetch() POST/PUT
 * 5. Process response
 * 6. Update UI atau tampilkan error
 * 7. Reset button state
 */
async function saveNewsletterBlock() {
    // FASE 1: PERSIAPAN & LOADING STATE
    // ===================================
    
    // Ambil element-element untuk loading state
    const saveBtn = document.getElementById('saveNewsletterBtn');
    const saveIcon = document.getElementById('saveNewsletterIcon');
    const saveLoading = document.getElementById('saveNewsletterLoading');
    const saveText = document.getElementById('saveNewsletterText');
    
    // Show loading state
    // disabled = true → button tidak bisa diklik (prevent double-click)
    saveBtn.disabled = true;
    saveIcon.classList.add('hidden');           // Sembunyikan icon check
    saveLoading.classList.remove('hidden');     // Tampilkan spinner loading
    saveText.textContent = 'Saving...';         // Ubah text button
    
    // FASE 2: AMBIL DATA DARI FORM
    // =============================
    
    // Ambil newsletter ID yang dipilih dari dropdown
    const newsletterSelect = document.getElementById('newsletterSelect');
    const newsletterId = newsletterSelect.value;
    
    // VALIDASI: Cek apakah user sudah pilih newsletter
    if (!newsletterId) {
        // Kalau belum pilih, tampilkan alert dan reset button
        alert('Please select a newsletter!');
        
        // Reset button state
        saveBtn.disabled = false;
        saveIcon.classList.remove('hidden');
        saveLoading.classList.add('hidden');
        saveText.textContent = 'Save';
        
        // Keluar dari function (return = berhenti)
        return;
    }
    
    // Ambil block element untuk cek apakah sudah pernah disave
    const block = document.getElementById(currentEditBlockId);
    const shortcodeId = block?.dataset.shortcodeId || '';
    
    console.log('💾 Saving newsletter block...');
    console.log('Newsletter ID:', newsletterId);
    console.log('Shortcode ID:', shortcodeId);
    
    // FASE 3: PREPARE DATA
    // ====================
    
    // window.pageId = variable global yang diset dari blade template
    // Berisi ID halaman yang sedang di-edit
    const pageId = window.pageId;
    
    // Hitung sort_id dari posisi AKTUAL di blocklist
    const sortId = getCurrentSortId(currentEditBlockId);
    
    // Object berisi data yang akan dikirim ke server
    const formData = {
        pages_id: pageId,                      // ID halaman
        section_newsletter_id: newsletterId,   // ID newsletter yang dipilih
        type: 'newsletter',                    // Tipe block
        sort_id: sortId                        // Urutan block
    };
    
    console.log('📦 Form data:', formData);
    
    // FASE 4: TENTUKAN ENDPOINT
    // =========================
    
    // Tentukan URL dan method berdasarkan apakah ini CREATE atau UPDATE
    // Ternary operator: condition ? valueIfTrue : valueIfFalse
    const url = shortcodeId 
        ? `/bagoosh/page-shortcode/update/${shortcodeId}`  // UPDATE: kalau shortcodeId ada
        : '/bagoosh/page-shortcode/store';                 // CREATE: kalau shortcodeId kosong
    
    const method = shortcodeId ? 'PUT' : 'POST';
    
    console.log('🌐 Request:', method, url);
    
    // FASE 5: KIRIM KE SERVER
    // =======================
    
    // fetch() = fungsi untuk kirim HTTP request
    fetch(url, {
        method: method,                        // HTTP method (POST atau PUT)
        headers: {
            'Content-Type': 'application/json',  // Format data: JSON
            // CSRF Token = token keamanan Laravel untuk prevent CSRF attack
            // querySelector = ambil SATU element pertama yang cocok
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        // body = data yang dikirim
        // JSON.stringify() = ubah object JavaScript jadi string JSON
        body: JSON.stringify(formData)
    })
    // FASE 6: PROSES RESPONSE
    // ========================
    
    // .then() pertama: parse response jadi JSON
    .then(response => response.json())
    
    // .then() kedua: proses data response
    .then(data => {
        console.log('📨 Server response:', data);
        
        // Cek apakah response success
        if (data.success) {
            // SUKSES! 🎉
            
            // Update dengan ID dari response
            if (data.data && data.data.id) {
                // Simpan ke cache
                blockDataCache[currentEditBlockId] = {
                    id: data.data.id,
                    type: 'newsletter',
                    section_newsletter_id: newsletterId,
                    sort_id: sortId
                };
                console.log('📦 Saved to cache:', blockDataCache[currentEditBlockId]);
                
                // PENTING: Simpan shortcodeId ke dataset untuk fungsi delete
                if (block) {
                    block.dataset.shortcodeId = data.data.id;
                    console.log('✅ Saved shortcodeId to block dataset:', data.data.id);
                }
            }
            
            // Tampilkan success message
            alert('Newsletter block saved successfully! 🎉');
            
            // Tutup modal
            closeEditNewsletterModal();
        } else {
            // GAGAL! ❌
            // Tampilkan error message dari server
            const errorMsg = data.message || 'Failed to save newsletter';
            alert('Error: ' + errorMsg);
            console.error('❌ Save failed:', errorMsg);
        }
    })
    
    // .catch() = tangani network error atau server error
    .catch(error => {
        console.error('❌ Network error:', error);
        alert('Network error! Please check your connection and try again.');
    })
    
    // .finally() = jalan SELALU, sukses atau gagal
    // Digunakan untuk reset button state
    .finally(() => {
        // FASE 7: RESET BUTTON STATE
        // ===========================
        
        // Kembalikan button ke state normal
        saveBtn.disabled = false;
        saveIcon.classList.remove('hidden');     // Tampilkan icon check
        saveLoading.classList.add('hidden');     // Sembunyikan spinner
        saveText.textContent = 'Save';           // Kembalikan text
        
        console.log('🔄 Button state reset');
    });
}

/**
 * Menghapus newsletter block
 * 
 * PENJELASAN:
 * Function ini dipanggil saat user klik button "Delete".
 * Function akan:
 * 1. Konfirmasi: "Are you sure?"
 * 2. Kalau block sudah disave: hapus dari database dulu
 * 3. Hapus dari UI dengan animasi fade out
 * 4. Update empty state kalau list jadi kosong
 * 
 * ALUR:
 * 1. Konfirmasi delete
 * 2. Show loading state
 * 3. Cek apakah ada di database (punya shortcodeId)
 * 4. Kalau ada: kirim DELETE request
 * 5. Kalau tidak: langsung hapus dari UI
 * 6. Remove block dengan animasi
 * 7. Cek empty state
 */
async function deleteNewsletterBlock() {
    if (!currentEditBlockId) return;
    if (!confirm('Are you sure you want to delete this newsletter block?')) return;
    
    const block = document.getElementById(currentEditBlockId);
    const shortcodeId = block?.dataset.shortcodeId || '';
    
    const deleteBtn = document.getElementById('deleteNewsletterBtn');
    const deleteIcon = document.getElementById('deleteNewsletterIcon');
    const deleteLoading = document.getElementById('deleteNewsletterLoading');
    const deleteText = document.getElementById('deleteNewsletterText');
    
    deleteBtn.disabled = true;
    deleteIcon.classList.add('hidden');
    deleteLoading.classList.remove('hidden');
    deleteText.textContent = 'Deleting...';
    
    try {
        // Jika ada shortcodeId = data sudah tersimpan di database, perlu API call
        if (shortcodeId) {
            console.log('🗑️ Deleting newsletter from database:', shortcodeId);
            const response = await fetch(`/bagoosh/page-shortcode/delete/${shortcodeId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            
            const result = await response.json();
            
            if (!response.ok) {
                throw new Error(result.message || 'Failed to delete from database');
            }
            console.log('✅ Deleted from database');
        } else {
            console.log('ℹ️ Block not saved yet, removing from UI only');
        }
        
        // Hapus dari cache
        if (blockDataCache[currentEditBlockId]) {
            delete blockDataCache[currentEditBlockId];
            console.log('🗑️ Deleted from cache:', currentEditBlockId);
        }
        
        // Hapus dari UI dengan animasi
        closeModalWithTransition('editNewsletterModal', () => {
            if (block) {
                block.style.transition = 'opacity 300ms';
                block.style.opacity = '0';
                setTimeout(() => {
                    block.remove();
                    checkEmptyState();
                    updateBlockOrder();
                }, 300);
            }
            currentEditBlockId = null;
            alert('Newsletter block deleted successfully!');
        });
        
    } catch (error) {
        console.error('Error deleting newsletter:', error);
        alert('Failed to delete: ' + error.message);
    } finally {
        // Restore button state
        deleteBtn.disabled = false;
        deleteIcon.classList.remove('hidden');
        deleteLoading.classList.add('hidden');
        deleteText.textContent = 'Delete';
    }
}

// ===================================================================
// BAGIAN 21: EVENT LISTENERS (KEYBOARD & CLICK)
// ===================================================================

/**
 * Event listener untuk tombol Escape (ESC)
 * Menutup modal saat user tekan ESC
 */
document.addEventListener('keydown', function(e) {
    // e.key = tombol yang ditekan
    // 'Escape' = tombol ESC
    if (e.key === 'Escape') {
        // Tutup semua modal yang mungkin terbuka
        closeBlockLibrary();
        closeEditTitleModal();
        closeEditSimpleTextModal();
        closeEditTextEditorModal();
        closeEditBrandsModal();
        closeEditCompleteCountsModal();
        closeEditHeroBannerModal();
        closeSelectHeroStyleModal();
        closeEditTestimonialsModal();
        closeSelectTestimonialsStyleModal();
        closeEditRecentProductModal();
        closeSelectServiceStyleModal();
        closeEditFeaturedServicesModal();
        closeEditNewsletterModal();
        closeEditComingSoonModal();
        closeEditDefaultModal();
    }
});

/**
 * Event listener untuk klik di backdrop modal
 * Menutup modal saat user klik area gelap di luar modal
 */

// Block Library Modal
document.getElementById('blockLibraryModal')?.addEventListener('click', function(e) {
    // e.target = element yang di-klik
    // this = element yang punya event listener (modal itself)
    // Jika yang diklik adalah backdrop (bukan isi modal), tutup modal
    if (e.target === this) {
        closeBlockLibrary();
    }
});

// Title Modal
document.getElementById('editTitleModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditTitleModal();
    }
});

// Simple Text Modal
document.getElementById('editSimpleTextModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditSimpleTextModal();
    }
});

// Text Editor Modal
document.getElementById('editTextEditorModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditTextEditorModal();
    }
});

// Brands Modal
document.getElementById('editBrandsModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditBrandsModal();
    }
});

// Complete Counts Modal
document.getElementById('editCompleteCountsModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditCompleteCountsModal();
    }
});

// Default Modal
document.getElementById('editDefaultModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditDefaultModal();
    }
});

// Newsletter Modal
document.getElementById('editNewsletterModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditNewsletterModal();
    }
});

// Coming Soon Modal
document.getElementById('editComingSoonModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditComingSoonModal();
    }
});

// ===================================================================
// BAGIAN 22: SEO & SLUG AUTO-GENERATE
// ===================================================================

/**
 * Auto-generate slug dari title
 * Slug = URL-friendly version of title
 * Contoh: "Hello World" → "hello-world"
 */

// Ambil element input
const titleInput = document.getElementById('title');
const slugInput = document.getElementById('slug');
const metaTitleInput = document.getElementById('meta_title');
const metaDescInput = document.getElementById('meta_description');
const isHomePageSlugLocked = window.isHomePageSlugLocked === true;

// Simpan slug original (untuk page yang sudah ada)
// Agar tidak berubah-ubah saat edit title
const originalSlug = slugInput?.value || '';

// Event listener untuk input title
titleInput?.addEventListener('input', function() {
    // Jika halaman home/index, slug tidak boleh auto-generate
    if (!isHomePageSlugLocked && slugInput) {
        // Jika slug masih original atau kosong, generate slug baru
        if (!originalSlug || slugInput.value === '' || slugInput.value === originalSlug) {
            // generateSlug() = function untuk ubah text jadi slug
            slugInput.value = generateSlug(this.value);
        }
    }
    // Update SEO preview
    updateSEOPreview();
});

// Event listener untuk input slug manual
slugInput?.addEventListener('input', updateSEOPreview);

// Event listener untuk meta title
metaTitleInput?.addEventListener('input', function() {
    // Batasi karakter di 60 (optimal untuk Google)
    if (this.value.length > 60) {
        this.value = this.value.substring(0, 60);
    }
    updateSEOPreview();
});

// Event listener untuk meta description
metaDescInput?.addEventListener('input', function() {
    // Batasi karakter di 160 (optimal untuk Google)
    if (this.value.length > 160) {
        this.value = this.value.substring(0, 160);
    }
    updateSEOPreview();
});

/**
 * Fungsi untuk generate slug dari text
 * 
 * @param {string} text - Text yang mau dijadikan slug
 * @returns {string} - Slug yang sudah di-format
 */
function generateSlug(text) {
    return text
        .toLowerCase() // Ubah jadi huruf kecil
        .trim() // Hapus spasi di awal dan akhir
        .replace(/[^\w\s-]/g, '') // Hapus karakter spesial
        .replace(/[\s_-]+/g, '-') // Ubah spasi dan underscore jadi dash
        .replace(/^-+|-+$/g, ''); // Hapus dash di awal dan akhir
}

/**
 * Update preview SEO (Google search result preview)
 */
function updateSEOPreview() {
    // Ambil atau create element preview
    const preview = document.getElementById('seo-preview');
    if (!preview) return;
    
    // Ambil nilai dari input
    const title = metaTitleInput?.value || titleInput?.value || 'Page Title';
    const url = slugInput?.value || 'page-url';
    const desc = metaDescInput?.value || 'Page description will appear here...';
    
    // Update preview dengan nilai baru
    const previewTitle = preview.querySelector('.preview-title');
    const previewUrl = preview.querySelector('.preview-url');
    const previewDesc = preview.querySelector('.preview-desc');
    
    if (previewTitle) previewTitle.textContent = title;
    if (previewUrl) previewUrl.textContent = window.location.origin + '/' + url;
    if (previewDesc) previewDesc.textContent = desc;
}

// ===================================================================
// BAGIAN 30: LATEST NEWS FUNCTIONS
// ===================================================================

/**
 * Menutup modal pemilihan style latest news
 */
function closeSelectLatestNewsStyleModal() {
    closeModalWithTransition('selectLatestNewsStyleModal', () => {
        pendingLatestNewsBlockId = null;
        blockCounter--;
    });
}

/**
 * Memilih style untuk latest news dan membuat block-nya
 * 
 * @param {string} style - Nomor style yang dipilih ('1', '2', atau '3')
 */
function selectLatestNewsStyle(style) {
    const blockId = pendingLatestNewsBlockId;
    const blocksList = document.getElementById('blocksList');
    const config = blockConfig['latestnews'];
    
    console.log('Creating Latest News block with style:', style);
    
    // Buat HTML untuk block dengan style yang dipilih
    const blockHTML = `
        <div id="${blockId}"
             class="block-item group bg-white hover:bg-slate-50 transition-all duration-200" 
             data-block-id="${blockId}"
             data-type="latestnews"
             data-style="${style}">
            <div class="flex items-center justify-between p-4 gap-4">
                <div class="flex items-center gap-3 flex-1 min-w-0">
                    <div class="drag-handle flex-shrink-0 p-2 text-slate-400 hover:text-slate-600 cursor-move transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                        </svg>
                    </div>
                    <div class="flex-shrink-0 w-10 h-10 bg-${config.color}-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-${config.color}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            ${getBlockIcon('latestnews')}
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <span class="block-order inline-flex items-center justify-center w-6 h-6 rounded-full bg-slate-200 text-slate-700 text-xs font-bold">${blockCounter}</span>
                            <h3 class="font-semibold text-slate-800">${config.name}</h3>
                            <span class="text-xs bg-rose-100 text-rose-700 px-2 py-0.5 rounded-full font-medium">Style ${style}</span>
                        </div>
                        <p class="text-xs text-slate-500 mt-0.5">Click to configure</p>
                    </div>
                </div>
                <button type="button" 
                        onclick="openEditModal('${blockId}')"
                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium text-sm transition-all opacity-0 group-hover:opacity-100 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Configure
                </button>
            </div>
        </div>
    `;
    
    // Insert block ke dalam list
    blocksList.insertAdjacentHTML('beforeend', blockHTML);
    
    // Reset state dan tutup modal
    pendingLatestNewsBlockId = null;
    closeModalWithTransition('selectLatestNewsStyleModal', () => {
        document.body.style.overflow = '';
    });
    
    // Update UI
    checkEmptyState();
    updateBlockOrder();
}

/**
 * Membuka modal edit latest news
 */
async function openEditLatestNewsModal(blockId) {
    console.log('Opening Latest News modal for block:', blockId);
    
    // Set current block ID dulu
    currentEditBlockId = blockId;
    
    // Cari block element (konsisten dengan block lain - gunakan getElementById)
    let block = document.getElementById(blockId);
    
    // Fallback: jika tidak ditemukan dengan id, cari dengan data-block-id (backward compatibility)
    if (!block) {
        block = document.querySelector(`[data-block-id="${blockId}"]`);
    }
    
    if (!block) {
        console.error('❌ Block not found:', blockId);
        return;
    }
    
    // Load data dari cache atau database jika ada
    let shortcodeData = null;
    let title = '';
    let blogLimit = '4';
    let style = block.dataset.style || '1';
    
    const shortcodeId = block.dataset.shortcodeId || '';
    
    // Prioritas 1: Cek cache local (paling cepat!)
    if (blockDataCache[currentEditBlockId]) {
        console.log('📦 Loading latest news from cache:', currentEditBlockId);
        shortcodeData = blockDataCache[currentEditBlockId];
        title = shortcodeData.latestnews_title || '';
        blogLimit = shortcodeData.blog_limit || '4';
        style = shortcodeData.latestnews_style || style;
    }
    // Prioritas 2: Fetch dari database (untuk backward compatibility)
    else if (shortcodeId) {
        console.log('🔄 Loading latest news from database:', shortcodeId);
        try {
            const response = await fetch(`/bagoosh/page-shortcode/show/${shortcodeId}`);
            const result = await response.json();
            if (result.success) {
                shortcodeData = result.data;
                title = shortcodeData.latestnews_title || '';
                blogLimit = shortcodeData.blog_limit || '4';
                style = shortcodeData.latestnews_style || style;
                // Simpan ke cache untuk next time
                blockDataCache[currentEditBlockId] = shortcodeData;
            }
        } catch (error) {
            console.error('Error loading latest news data:', error);
        }
    } else {
        // Block baru, ambil dari dataset kalau ada
        title = block.dataset.title || '';
        blogLimit = block.dataset.blogLimit || '4';
    }
    
    console.log('✅ Latest News data loaded:', { title, blogLimit, style, shortcodeId });
    
    // Set nilai ke form
    document.getElementById('latestNewsTitle').value = title;
    document.getElementById('latestNewsBlogLimit').value = blogLimit;
    
    // Buka modal
    document.getElementById('editLatestNewsModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

/**
 * Menutup modal edit latest news
 */
function closeEditLatestNewsModal() {
    closeModalWithTransition('editLatestNewsModal', () => {
        currentEditBlockId = null;
    });
}

/**
 * Menyimpan latest news block ke database
 */
async function saveLatestNewsBlock() {
    console.log('Saving Latest News block...');
    
    // Validasi: pastikan ada block yang sedang diedit
    if (!currentEditBlockId) {
        alert('Error: No block selected');
        return;
    }
    
    // Ambil nilai dari form
    const title = document.getElementById('latestNewsTitle').value.trim();
    const blogLimit = parseInt(document.getElementById('latestNewsBlogLimit').value);
    
    // Validasi input
    if (!title) {
        alert('Please enter a title');
        document.getElementById('latestNewsTitle').focus();
        return;
    }
    
    if (!blogLimit || blogLimit < 4) {
        alert('Blog limit must be 4 or more');
        document.getElementById('latestNewsBlogLimit').focus();
        return;
    }
    
    // Ambil block element dan data (konsisten dengan block lain - gunakan getElementById)
    let block = document.getElementById(currentEditBlockId);
    
    // Fallback: jika tidak ditemukan dengan id, cari dengan data-block-id
    if (!block) {
        block = document.querySelector(`[data-block-id="${currentEditBlockId}"]`);
    }
    
    if (!block) {
        console.error('❌ Block not found:', currentEditBlockId);
        return;
    }
    
    const style = block.dataset.style || '1';
    const shortcodeId = block.dataset.shortcodeId || null;
    
    // Hitung sort_id dari posisi AKTUAL di blocklist
    const sortId = getCurrentSortId(currentEditBlockId);
    
    console.log('Form data:', { title, blogLimit, style, shortcodeId });
    
    // Tampilkan loading state
    document.getElementById('latestNewsLoadingState').classList.remove('hidden');
    document.getElementById('latestNewsFormContent').classList.add('hidden');
    
    try {
        // Siapkan data untuk dikirim ke server
        const formData = {
            pages_id: window.pageId,
            type: 'latestnews',
            latestnews_title: title,
            blog_limit: blogLimit,
            latestnews_style: style,
            sort_id: sortId
        };
        
        console.log('Sending data to server:', formData);
        
        // Tentukan URL dan method berdasarkan apakah update atau create
        const url = shortcodeId 
            ? `/bagoosh/page-shortcode/update/${shortcodeId}`
            : '/bagoosh/page-shortcode/store';
        const method = shortcodeId ? 'PUT' : 'POST';
        
        // Kirim request ke server
        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify(formData)
        });
        
        const data = await response.json();
        console.log('Save response:', data);
        
        if (!response.ok) {
            throw new Error(data.message || 'Failed to save');
        }
        
        // Simpan ke cache
        if (data.data && data.data.id) {
            blockDataCache[currentEditBlockId] = {
                id: data.data.id,
                type: 'latestnews',
                latestnews_title: title,
                blog_limit: blogLimit,
                latestnews_style: style,
                sort_id: sortId
            };
            console.log('📦 Saved to cache:', blockDataCache[currentEditBlockId]);
            
            // PENTING: Simpan shortcodeId ke dataset untuk fungsi delete
            if (block) {
                block.dataset.shortcodeId = data.data.id;
                console.log('✅ Saved shortcodeId to block dataset:', data.data.id);
            }
        }
        
        // Update block content
        const blockContent = block.querySelector('.block-content');
        if (blockContent) {
            blockContent.innerHTML = `
                <div class="space-y-1">
                    ${title ? `<div class="font-semibold text-slate-700">${title}</div>` : ''}
                    <div class="text-sm text-slate-600">Showing ${blogLimit} latest posts</div>
                </div>
            `;
        }
        
        // Tutup modal
        closeEditLatestNewsModal();
        
        // Tampilkan notifikasi sukses
        alert('Latest News block saved successfully!');
        
    } catch (error) {
        console.error('Save error:', error);
        alert('Error saving Latest News block: ' + error.message);
    } finally {
        // Sembunyikan loading state
        document.getElementById('latestNewsLoadingState').classList.add('hidden');
        document.getElementById('latestNewsFormContent').classList.remove('hidden');
    }
}

async function deleteLatestNewsBlock() {
    if (!currentEditBlockId) return;
    
    if (!confirm('Are you sure you want to delete this Latest News block?')) {
        return;
    }
    
    // Ambil block element (konsisten dengan block lain - gunakan getElementById)
    let block = document.getElementById(currentEditBlockId);
    
    // Fallback: jika tidak ditemukan dengan id, cari dengan data-block-id
    if (!block) {
        block = document.querySelector(`[data-block-id="${currentEditBlockId}"]`);
    }
    
    const shortcodeId = block?.dataset.shortcodeId;
    
    // Ambil element untuk loading state
    const deleteBtn = document.getElementById('deleteLatestNewsBtn');
    const deleteIcon = document.getElementById('deleteLatestNewsIcon');
    const deleteLoading = document.getElementById('deleteLatestNewsLoading');
    const deleteText = document.getElementById('deleteLatestNewsText');
    
    // Show loading state
    if (deleteBtn) deleteBtn.disabled = true;
    deleteIcon?.classList.add('hidden');
    deleteLoading?.classList.remove('hidden');
    if (deleteText) deleteText.textContent = 'Deleting...';
    
    console.log('📋 Block element:', block);
    console.log('📋 Shortcode ID:', shortcodeId);
    
    try {
        // Jika ada shortcodeId = data sudah tersimpan di database, perlu API call
        if (shortcodeId) {
            console.log('🗑️ Deleting latest news from database:', shortcodeId);
            const response = await fetch(`/bagoosh/page-shortcode/delete/${shortcodeId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                }
            });
            
            const data = await response.json();
            
            if (!response.ok) {
                throw new Error(data.message || 'Failed to delete from database');
            }
            console.log('✅ Deleted from database');
        } else {
            console.log('ℹ️ Block not saved yet, removing from UI only');
        }
        
        // Hapus dari cache
        if (blockDataCache[currentEditBlockId]) {
            delete blockDataCache[currentEditBlockId];
            console.log('🗑️ Deleted from cache:', currentEditBlockId);
        }
        
        // Hapus block dari UI  
        block?.remove();
        closeEditLatestNewsModal();
        checkEmptyState();
        updateBlockOrder();
        alert('Latest News block deleted successfully!');
        
    } catch (error) {
        console.error('Delete error:', error);
        alert('Error deleting Latest News block: ' + error.message);
    } finally {
        // Restore button state jika masih ada (untuk kasus error)
        if (deleteBtn) {
            deleteBtn.disabled = false;
            deleteIcon?.classList.remove('hidden');
            deleteLoading?.classList.add('hidden');
            if (deleteText) deleteText.textContent = 'Delete';
        }
    }
}

// ===================================================================
// BAGIAN 30B: COMING SOON FUNCTIONS
// ===================================================================

/**
 * Membuka modal edit coming soon
 */
async function openEditComingSoonModal(blockId) {
    console.log('Opening Coming Soon modal for block:', blockId);

    currentEditBlockId = blockId;

    let block = document.getElementById(blockId);
    if (!block) {
        block = document.querySelector(`[data-block-id="${blockId}"]`);
    }

    if (!block) {
        console.error('❌ Block not found:', blockId);
        return;
    }

    let shortcodeData = null;
    let image = '';
    let title = '';
    let subtitle = '';
    let placeholder = '';

    const shortcodeId = block.dataset.shortcodeId || '';

    if (blockDataCache[currentEditBlockId]) {
        console.log('📦 Loading coming soon from cache:', currentEditBlockId);
        shortcodeData = blockDataCache[currentEditBlockId];
        image = shortcodeData.comingsoon_image || '';
        title = shortcodeData.comingsoon_title || '';
        subtitle = shortcodeData.comingsoon_subtitle || '';
        placeholder = shortcodeData.comingsoon_placeholder || '';
    } else if (shortcodeId) {
        console.log('🔄 Loading coming soon from database:', shortcodeId);
        try {
            const response = await fetch(`/bagoosh/page-shortcode/show/${shortcodeId}`);
            const result = await response.json();
            if (result.success) {
                shortcodeData = result.data;
                image = shortcodeData.comingsoon_image || '';
                title = shortcodeData.comingsoon_title || '';
                subtitle = shortcodeData.comingsoon_subtitle || '';
                placeholder = shortcodeData.comingsoon_placeholder || '';
                blockDataCache[currentEditBlockId] = shortcodeData;
            }
        } catch (error) {
            console.error('Error loading coming soon data:', error);
        }
    }

    document.getElementById('comingSoonImage').value = image;
    document.getElementById('comingSoonTitle').value = title;
    document.getElementById('comingSoonSubtitle').value = subtitle;
    document.getElementById('comingSoonPlaceholder').value = placeholder;

    const mediaInput = document.querySelector('[name="comingSoonImage"]');
    if (mediaInput) {
        mediaInput.value = image;
        mediaInput.dispatchEvent(new Event('input', { bubbles: true }));
        mediaInput.dispatchEvent(new Event('change', { bubbles: true }));
    }

    document.getElementById('editComingSoonModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

/**
 * Menutup modal edit coming soon
 */
function closeEditComingSoonModal() {
    closeModalWithTransition('editComingSoonModal', () => {
        currentEditBlockId = null;
    });
}

/**
 * Menyimpan coming soon block ke database
 */
async function saveComingSoonBlock() {
    if (!currentEditBlockId) {
        alert('Error: No block selected');
        return;
    }

    const image = document.getElementById('comingSoonImage').value.trim();
    const title = document.getElementById('comingSoonTitle').value.trim();
    const subtitle = document.getElementById('comingSoonSubtitle').value.trim();
    const placeholder = document.getElementById('comingSoonPlaceholder').value.trim();

    if (!title) {
        alert('Please enter a title');
        document.getElementById('comingSoonTitle').focus();
        return;
    }

    let block = document.getElementById(currentEditBlockId);
    if (!block) {
        block = document.querySelector(`[data-block-id="${currentEditBlockId}"]`);
    }

    if (!block) {
        console.error('❌ Block not found:', currentEditBlockId);
        return;
    }

    const shortcodeId = block.dataset.shortcodeId || null;
    const sortId = getCurrentSortId(currentEditBlockId);

    document.getElementById('comingSoonLoadingState').classList.remove('hidden');
    document.getElementById('comingSoonFormContent').classList.add('hidden');

    try {
        const formData = {
            pages_id: window.pageId,
            type: 'comingsoon',
            comingsoon_image: image,
            comingsoon_title: title,
            comingsoon_subtitle: subtitle,
            comingsoon_placeholder: placeholder,
            sort_id: sortId
        };

        const url = shortcodeId
            ? `/bagoosh/page-shortcode/update/${shortcodeId}`
            : '/bagoosh/page-shortcode/store';
        const method = shortcodeId ? 'PUT' : 'POST';

        const response = await fetch(url, {
            method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify(formData)
        });

        const data = await response.json();
        if (!response.ok) {
            throw new Error(data.message || 'Failed to save');
        }

        if (data.data && data.data.id) {
            blockDataCache[currentEditBlockId] = {
                id: data.data.id,
                type: 'comingsoon',
                comingsoon_image: image,
                comingsoon_title: title,
                comingsoon_subtitle: subtitle,
                comingsoon_placeholder: placeholder,
                sort_id: sortId
            };

            block.dataset.shortcodeId = data.data.id;
        }

        const blockContent = block.querySelector('.block-content');
        if (blockContent) {
            blockContent.innerHTML = `
                <div class="space-y-1">
                    ${title ? `<div class="font-semibold text-slate-700">${title}</div>` : ''}
                    ${subtitle ? `<div class="text-sm text-slate-600">${subtitle}</div>` : ''}
                    ${placeholder ? `<div class="text-xs text-slate-500">Placeholder: ${placeholder}</div>` : ''}
                </div>
            `;
        }

        closeEditComingSoonModal();
        alert('Coming Soon block saved successfully!');
    } catch (error) {
        console.error('Save error:', error);
        alert('Error saving Coming Soon block: ' + error.message);
    } finally {
        document.getElementById('comingSoonLoadingState').classList.add('hidden');
        document.getElementById('comingSoonFormContent').classList.remove('hidden');
    }
}

/**
 * Hapus coming soon block
 */
async function deleteComingSoonBlock() {
    if (!currentEditBlockId) return;

    if (!confirm('Are you sure you want to delete this Coming Soon block?')) {
        return;
    }

    let block = document.getElementById(currentEditBlockId);
    if (!block) {
        block = document.querySelector(`[data-block-id="${currentEditBlockId}"]`);
    }

    const shortcodeId = block?.dataset.shortcodeId;

    const deleteBtn = document.getElementById('deleteComingSoonBtn');
    const deleteIcon = document.getElementById('deleteComingSoonIcon');
    const deleteLoading = document.getElementById('deleteComingSoonLoading');
    const deleteText = document.getElementById('deleteComingSoonText');

    if (deleteBtn) deleteBtn.disabled = true;
    deleteIcon?.classList.add('hidden');
    deleteLoading?.classList.remove('hidden');
    if (deleteText) deleteText.textContent = 'Deleting...';

    try {
        if (shortcodeId) {
            const response = await fetch(`/bagoosh/page-shortcode/delete/${shortcodeId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                }
            });

            const data = await response.json();
            if (!response.ok) {
                throw new Error(data.message || 'Failed to delete from database');
            }
        }

        if (blockDataCache[currentEditBlockId]) {
            delete blockDataCache[currentEditBlockId];
        }

        block?.remove();
        closeEditComingSoonModal();
        checkEmptyState();
        updateBlockOrder();
        alert('Coming Soon block deleted successfully!');
    } catch (error) {
        console.error('Delete error:', error);
        alert('Error deleting Coming Soon block: ' + error.message);
    } finally {
        if (deleteBtn) {
            deleteBtn.disabled = false;
            deleteIcon?.classList.remove('hidden');
            deleteLoading?.classList.add('hidden');
            if (deleteText) deleteText.textContent = 'Delete';
        }
    }
}

// ===================================================================
// BAGIAN 31: CONTACT FUNCTIONS
// ===================================================================

/**
 * Membuka modal edit contact
 */
async function openEditContactModal(blockId) {
    console.log('Opening Contact modal for block:', blockId);
    
    currentEditBlockId = blockId;
    
    let block = document.getElementById(blockId);
    if (!block) {
        block = document.querySelector(`[data-block-id="${blockId}"]`);
    }
    
    if (!block) {
        console.error('Block not found:', blockId);
        return;
    }
    
    const shortcodeId = block.dataset.shortcodeId || '';
    
    // Reset form fields dulu
    document.getElementById('contactTitle').value = '';
    document.getElementById('contactSubtitle').value = '';
    
    // Load data dari cache atau database jika ada
    let shortcodeData = null;
    let selectedContactIds = [];
    
    // Prioritas 1: Cek cache local
    if (blockDataCache[currentEditBlockId]) {
        console.log('📦 Loading contact from cache:', currentEditBlockId);
        shortcodeData = blockDataCache[currentEditBlockId];
        selectedContactIds = shortcodeData.contact_id || [];
    }
    // Prioritas 2: Fetch dari database
    else if (shortcodeId) {
        console.log('🔄 Loading contact from database:', shortcodeId);
        try {
            const response = await fetch(`/bagoosh/page-shortcode/show/${shortcodeId}`);
            const result = await response.json();
            if (result.success) {
                shortcodeData = result.data;
                selectedContactIds = shortcodeData.contact_id || [];
                // Simpan ke cache
                blockDataCache[currentEditBlockId] = shortcodeData;
            }
        } catch (error) {
            console.error('Error loading contact data:', error);
        }
    }
    
    // Populate form jika ada data
    if (shortcodeData) {
        document.getElementById('contactTitle').value = shortcodeData.contact_title_1 || '';
        document.getElementById('contactSubtitle').value = shortcodeData.contact_subtitle || '';
    }
    
    console.log('Block data:', { shortcodeData, selectedContactIds });
    
    // Load contacts list dengan selected IDs
    fetchContactsList(selectedContactIds);
    
    // Buka modal
    document.getElementById('editContactModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

/**
 * Menutup modal edit contact
 */
function closeEditContactModal() {
    closeModalWithTransition('editContactModal', () => {
        currentEditBlockId = null;
    });
}

/**
 * Fetch dan tampilkan daftar contacts dengan checkbox
 */
function fetchContactsList(selectedIds = []) {
    console.log('Fetching contacts list with selected IDs:', selectedIds);
    
    const container = document.getElementById('contactsCheckboxList');
    const loadingState = document.getElementById('contactsListLoading');
    const emptyState = document.getElementById('contactsEmptyState');
    
    // Tampilkan loading
    loadingState?.classList.remove('hidden');
    container?.classList.add('hidden');
    emptyState?.classList.add('hidden');
    
    // Gunakan cached data jika tersedia
    if (cachedContacts && cachedContacts.length > 0) {
        console.log('Using cached contacts:', cachedContacts.length);
        renderContactsList(cachedContacts, selectedIds);
        return;
    }
    
    // Fetch dari server jika cache kosong
    fetch('/bagoosh/contacts/list')
        .then(response => response.json())
        .then(data => {
            console.log('Contacts fetched:', data.length);
            cachedContacts = data;
            renderContactsList(data, selectedIds);
        })
        .catch(error => {
            console.error('Error fetching contacts:', error);
            loadingState?.classList.add('hidden');
            emptyState?.classList.remove('hidden');
        });
}

/**
 * Render contacts list dengan checkbox
 */
function renderContactsList(contacts, selectedIds = []) {
    const container = document.getElementById('contactsCheckboxList');
    const loadingState = document.getElementById('contactsListLoading');
    const emptyState = document.getElementById('contactsEmptyState');
    
    // Sembunyikan loading
    loadingState?.classList.add('hidden');
    
    if (!contacts || contacts.length === 0) {
        emptyState?.classList.remove('hidden');
        return;
    }
    
    // Generate checkbox HTML
    let html = '';
    contacts.forEach(contact => {
        const isChecked = selectedIds.includes(contact.id);
        html += `
            <label class="flex items-center gap-3 p-3 rounded-lg hover:bg-teal-50 cursor-pointer transition-colors border-2 border-transparent hover:border-teal-200">
                <input type="checkbox" 
                       value="${contact.id}" 
                       ${isChecked ? 'checked' : ''}
                       class="w-5 h-5 text-teal-600 border-slate-300 rounded focus:ring-2 focus:ring-teal-500 focus:ring-offset-0 cursor-pointer">
                <div class="flex-1">
                    <p class="font-semibold text-slate-800">${contact.title || 'Untitled'}</p>
                    ${contact.contact_1 ? `<p class="text-xs text-slate-500 mt-0.5">${contact.contact_1}</p>` : ''}
                </div>
            </label>
        `;
    });
    
    container.innerHTML = html;
    container.classList.remove('hidden');
    
    console.log(`✅ Rendered ${contacts.length} contacts`);
}

/**
 * Menyimpan contact block ke database
 */
async function saveContactBlock() {
    console.log('Saving Contact block...');
    
    // Validasi: pastikan ada block yang sedang diedit
    if (!currentEditBlockId) {
        alert('Error: No block selected');
        return;
    }
    
    // Ambil nilai dari form
    const title = document.getElementById('contactTitle').value.trim();
    const subtitle = document.getElementById('contactSubtitle').value.trim();
    
    // Ambil selected contact IDs
    const selectedContactIds = [];
    document.querySelectorAll('#contactsCheckboxList input[type="checkbox"]:checked').forEach(checkbox => {
        selectedContactIds.push(parseInt(checkbox.value));
    });
    
    // Validasi input
    if (!title) {
        alert('Please enter a title');
        document.getElementById('contactTitle').focus();
        return;
    }
    
    if (selectedContactIds.length === 0) {
        alert('Please select at least one contact');
        return;
    }
    
    // Ambil block element
    let block = document.getElementById(currentEditBlockId);
    if (!block) {
        block = document.querySelector(`[data-block-id="${currentEditBlockId}"]`);
    }
    
    if (!block) {
        console.error('Block not found:', currentEditBlockId);
        return;
    }
    
    const shortcodeId = block.dataset.shortcodeId || null;
    
    // Hitung sort_id dari posisi AKTUAL di blocklist
    const sortId = getCurrentSortId(currentEditBlockId);
    
    console.log('Form data:', { title, subtitle, selectedContactIds, shortcodeId });
    
    // Tampilkan loading state
    const loadingState = document.getElementById('contactLoadingState');
    const formContent = document.getElementById('contactFormContent');
    loadingState?.classList.remove('hidden');
    formContent?.classList.add('hidden');
    
    try {
        // Siapkan data untuk dikirim ke server
        const formData = {
            pages_id: window.pageId,
            type: 'contact',
            contact_title_1: title,
            contact_subtitle: subtitle,
            contact_id: selectedContactIds,
            sort_id: sortId
        };
        
        console.log('💾 Sending data to server:', formData);
        
        // Tentukan URL dan method
        const url = shortcodeId 
            ? `/bagoosh/page-shortcode/update/${shortcodeId}`
            : '/bagoosh/page-shortcode/store';
        const method = shortcodeId ? 'PUT' : 'POST';
        
        // Kirim request ke server
        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify(formData)
        });
        
        const data = await response.json();
        console.log('Save response:', data);
        
        if (!response.ok) {
            throw new Error(data.message || 'Failed to save');
        }
        
        // Simpan ke cache
        if (data.data && data.data.id) {
            blockDataCache[currentEditBlockId] = {
                id: data.data.id,
                type: 'contact',
                contact_title_1: title,
                contact_subtitle: subtitle,
                contact_id: selectedContactIds,
                sort_id: sortId
            };
            console.log('📦 Saved to cache:', blockDataCache[currentEditBlockId]);
            
            // PENTING: Simpan shortcodeId ke dataset untuk fungsi delete
            if (block) {
                block.dataset.shortcodeId = data.data.id;
                console.log('✅ Saved shortcodeId to block dataset:', data.data.id);
            }
        }
        
        // Tutup modal
        closeEditContactModal();
        
        // Tampilkan notifikasi sukses
        alert('Contact block saved successfully!');
        
    } catch (error) {
        console.error('Save error:', error);
        alert('Error saving Contact block: ' + error.message);
    } finally {
        // Sembunyikan loading state
        loadingState?.classList.add('hidden');
        formContent?.classList.remove('hidden');
    }
}

/**
 * Menghapus contact block
 */
async function deleteContactBlock() {
    console.log('Deleting Contact block...');
    
    if (!currentEditBlockId) {
        console.error('No block selected for deletion');
        return;
    }
    
    // Konfirmasi penghapusan
    if (!confirm('Are you sure you want to delete this Contact block?')) {
        return;
    }
    
    let block = document.getElementById(currentEditBlockId);
    if (!block) {
        block = document.querySelector(`[data-block-id="${currentEditBlockId}"]`);
    }
    
    if (!block) {
        console.error('Block not found:', currentEditBlockId);
        return;
    }
    
    const shortcodeId = block?.dataset.shortcodeId;
    
    // Ambil element untuk loading state
    const deleteBtn = document.getElementById('deleteContactBtn');
    const deleteIcon = document.getElementById('deleteContactIcon');
    const deleteLoading = document.getElementById('deleteContactLoading');
    const deleteText = document.getElementById('deleteContactText');
    
    // Show loading state
    if (deleteBtn) deleteBtn.disabled = true;
    deleteIcon?.classList.add('hidden');
    deleteLoading?.classList.remove('hidden');
    if (deleteText) deleteText.textContent = 'Deleting...';
    
    console.log('📋 Block element:', block);
    console.log('📋 Shortcode ID:', shortcodeId);
    
    try {
        // Jika ada shortcodeId = data sudah tersimpan di database, perlu API call
        if (shortcodeId) {
            console.log('🗑️ Deleting contact from database:', shortcodeId);
            const response = await fetch(`/bagoosh/page-shortcode/delete/${shortcodeId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                }
            });
            
            const data = await response.json();
            console.log('📨 Delete response:', data);
            
            if (!response.ok) {
                throw new Error(data.message || 'Failed to delete from database');
            }
            console.log('✅ Deleted from database');
        } else {
            console.log('ℹ️ Block not saved yet, removing from UI only');
        }
        
        // Hapus dari cache
        if (blockDataCache[currentEditBlockId]) {
            delete blockDataCache[currentEditBlockId];
            console.log('🗑️ Deleted from cache:', currentEditBlockId);
        }
        
        // Hapus block dari UI
        block.remove();
        closeEditContactModal();
        checkEmptyState();
        updateBlockOrder();
        alert('Contact block deleted successfully!');
        
    } catch (error) {
        console.error('❌ Delete error:', error);
        alert('Error deleting Contact block: ' + error.message);
    } finally {
        // Restore button state jika masih ada (untuk kasus error)
        if (deleteBtn) {
            deleteBtn.disabled = false;
            deleteIcon?.classList.remove('hidden');
            deleteLoading?.classList.add('hidden');
            if (deleteText) deleteText.textContent = 'Delete';
        }
    }
}

// ===================================================================
// BAGIAN 21: FUNGSI ABOUT US BLOCK
// ===================================================================

// Object untuk menyimpan data gambar About yang sedang diedit
window.aboutImages = {};

window.addEventListener('media-selected', (event) => {
    const fieldId = event?.detail?.fieldId || '';
    if (!fieldId.startsWith('aboutImage')) return;

    const imageNumber = fieldId.replace('aboutImage', '');
    if (!imageNumber) return;

    const selectedUrl = event?.detail?.url || '';
    window.aboutImages[`image_${imageNumber}`] = normalizeHeroImageForStorage(selectedUrl);
});

/**
 * Handle image upload untuk About block
 */
async function handleAboutImageUpload(imageNumber, input) {
    if (!input.files || !input.files[0]) {
        return;
    }
    
    const file = input.files[0];
    
    // Validasi type
    if (!file.type.startsWith('image/')) {
        alert('Please select an image file');
        input.value = '';
        return;
    }
    
    try {
        // Convert ke WebP
        const webpBase64 = await convertImageToWebP(file);
        
        // Store in memory
        window.aboutImages[`image_${imageNumber}`] = webpBase64;
        
        // Show preview
        const preview = document.getElementById(`aboutImage${imageNumber}Preview`);
        const previewImg = preview?.querySelector('img');
        if (preview && previewImg) {
            previewImg.src = webpBase64;
            preview.classList.remove('hidden');
        }
    } catch (error) {
        console.error('Error processing image:', error);
        alert('Error processing image: ' + error.message);
        input.value = '';
    }
}

/**
 * Toggle between upload and URL input for About images
 */
function toggleAboutImageInput(imageNumber, type) {
    const uploadSection = document.getElementById(`aboutImage${imageNumber}UploadSection`);
    const urlSection = document.getElementById(`aboutImage${imageNumber}UrlSection`);
    
    if (type === 'upload') {
        uploadSection?.classList.remove('hidden');
        urlSection?.classList.add('hidden');
    } else if (type === 'url') {
        uploadSection?.classList.add('hidden');
        urlSection?.classList.remove('hidden');
    }
}

/**
 * Handle URL input for About images
 */
function handleAboutImageUrl(imageNumber, input) {
    const url = input.value.trim();
    
    if (!url) {
        return;
    }
    
    // Validasi URL format
    try {
        new URL(url);
    } catch (error) {
        alert('Please enter a valid URL');
        return;
    }
    
    // Store URL in memory
    window.aboutImages[`image_${imageNumber}`] = url;
    
    // Show preview
    const preview = document.getElementById(`aboutImage${imageNumber}Preview`);
    const previewImg = preview?.querySelector('img');
    if (preview && previewImg) {
        previewImg.src = url;
        previewImg.onerror = function() {
            alert('Failed to load image from URL. Please check the URL.');
            previewImg.src = '';
            preview.classList.add('hidden');
        };
        preview.classList.remove('hidden');
    }
}

/**
 * Buka modal select About style
 */
function openSelectAboutStyleModal() {
    const modal = document.getElementById('selectAboutStyleModal');
    if (modal) {
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.querySelector('.bg-white')?.classList.add('animate-fade-in');
        }, 10);
    }
}

/**
 * Tutup modal select About style
 */
function closeSelectAboutStyleModal() {
    const modal = document.getElementById('selectAboutStyleModal');
    if (modal) {
        modal.querySelector('.bg-white')?.classList.remove('animate-fade-in');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }
}

/**
 * Proses setelah user memilih About style
 */
function selectAboutStyle(style) {
    console.log('About style selected:', style);
    
    if (!pendingAboutBlockId) {
        console.error('No pending About block ID');
        return;
    }
    
    // Ambil ID dan config block
    const blockId = pendingAboutBlockId;
    const config = blockConfig['about'];
    const blocksList = document.getElementById('blocksList');
    
    // Buat HTML untuk block About
    const blockHTML = `
        <div id="${blockId}" data-type="about" data-about-style="${style}" class="block-item bg-white hover:bg-slate-50 transition-all group">
            <div class="flex items-center gap-4 p-4">
                <div class="drag-handle cursor-move text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                    </svg>
                </div>
                <div class="flex-1 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-${config.color}-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-${config.color}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            ${getBlockIcon('about')}
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <span class="block-order inline-flex items-center justify-center w-6 h-6 rounded-full bg-slate-200 text-slate-700 text-xs font-bold">${blockCounter}</span>
                            <h3 class="font-semibold text-slate-800 block-label">${config.name} - Style ${style}</h3>
                        </div>
                        <p class="text-xs text-slate-500 mt-0.5">Click to configure</p>
                    </div>
                </div>
                <button type="button" 
                        onclick="openEditModal('${blockId}')"
                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium text-sm transition-all opacity-0 group-hover:opacity-100 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Configure
                </button>
            </div>
        </div>
    `;
    
    // Insert block ke dalam list
    blocksList.insertAdjacentHTML('beforeend', blockHTML);
    
    // Close style selection modal
    closeSelectAboutStyleModal();
    
    // Cek empty state
    checkEmptyState();
    
    // Update block order
    updateBlockOrder();
    
    // Re-initialize sortable jika belum ada
    if (!sortable) {
        initSortable();
    }
    
    // Reset pendingAboutBlockId
    pendingAboutBlockId = null;
    
    // Notify user untuk style yang belum ready
    if (style !== '1') {
        alert('Style ' + style + ' coming soon! Please wait for further updates.');
    }
}

/**
 * Buka modal edit About (Style 1)
 */
async function openEditAboutModal() {
    console.log('Opening About modal for:', currentEditBlockId);
    
    if (!currentEditBlockId) {
        console.error('No block selected');
        return;
    }
    
    const modal = document.getElementById('editAboutModal');
    if (!modal) {
        console.error('About modal not found');
        return;
    }
    
    // Reset form
    document.getElementById('aboutSectionLabel').value = '';
    document.getElementById('aboutSectionTitle').value = '';
    document.getElementById('aboutSectionDescription').value = '';
    document.getElementById('aboutBenefitTitle').value = '';
    
    // Reset images
    window.aboutImages = {};
    for (let i = 1; i <= 3; i++) {
        const input = document.getElementById(`aboutImage${i}`);
        const alt = document.getElementById(`aboutImage${i}Alt`);

        if (input) input.value = '';
        if (alt) alt.value = '';

        window.dispatchEvent(new CustomEvent('media-selected', {
            detail: { fieldId: `aboutImage${i}`, url: '' }
        }));
    }
    
    // Reset benefits
    for (let i = 1; i <= 6; i++) {
        const textInput = document.getElementById(`aboutBenefit${i}Text`);
        const iconInput = document.getElementById(`aboutBenefit${i}Icon`);
        const enabledCheck = document.getElementById(`aboutBenefit${i}Enabled`);
        
        if (textInput) textInput.value = '';
        if (iconInput) iconInput.value = '';
        if (enabledCheck) enabledCheck.checked = true;
    }
    
    // Cek cache dulu
    const cachedData = blockDataCache[currentEditBlockId];
    console.log('📦 About - Cached data:', cachedData);
    
    if (cachedData) {
        // Data bisa berupa direct cache atau dari relationship
        const aboutData = cachedData.about || cachedData;
        console.log('🎯 About data to use:', aboutData);
        
        // Load dari cache
        document.getElementById('aboutSectionLabel').value = aboutData.section_label || '';
        document.getElementById('aboutSectionTitle').value = aboutData.section_title || '';
        document.getElementById('aboutSectionDescription').value = aboutData.section_description || '';
        document.getElementById('aboutBenefitTitle').value = aboutData.benefit_title || '';
        
        // Load images
        for (let i = 1; i <= 3; i++) {
            if (aboutData[`image_${i}_source`]) {
                const imageSource = aboutData[`image_${i}_source`];

                window.aboutImages[`image_${i}`] = normalizeHeroImageForStorage(imageSource);

                window.dispatchEvent(new CustomEvent('media-selected', {
                    detail: {
                        fieldId: `aboutImage${i}`,
                        url: normalizeHeroImageForPreview(imageSource)
                    }
                }));
            }
            if (aboutData[`image_${i}_alt`]) {
                document.getElementById(`aboutImage${i}Alt`).value = aboutData[`image_${i}_alt`];
            }
        }
        
        // Load benefits
        for (let i = 1; i <= 6; i++) {
            if (aboutData[`benefit_${i}_text`]) {
                document.getElementById(`aboutBenefit${i}Text`).value = aboutData[`benefit_${i}_text`];
            }
            if (aboutData[`benefit_${i}_icon`]) {
                document.getElementById(`aboutBenefit${i}Icon`).value = aboutData[`benefit_${i}_icon`];
            }
            if (aboutData[`benefit_${i}_enabled`] !== undefined) {
                document.getElementById(`aboutBenefit${i}Enabled`).checked = aboutData[`benefit_${i}_enabled`];
            }
        }
    } else {
        // Load dari database jika ada shortcode_id
        const block = document.getElementById(currentEditBlockId);
        const shortcodeId = block?.dataset.shortcodeId;
        
        if (shortcodeId) {
            try {
                const response = await fetch(`/bagoosh/page-shortcode/show/${shortcodeId}`);
                const data = await response.json();
                console.log('📨 Loaded from database:', data);
                
                if (data.success && data.data.about) {
                    const aboutData = data.data.about;
                    
                    document.getElementById('aboutSectionLabel').value = aboutData.section_label || '';
                    document.getElementById('aboutSectionTitle').value = aboutData.section_title || '';
                    document.getElementById('aboutSectionDescription').value = aboutData.section_description || '';
                    document.getElementById('aboutBenefitTitle').value = aboutData.benefit_title || '';
                    
                    // Load images dari database
                    for (let i = 1; i <= 3; i++) {
                        if (aboutData[`image_${i}_source`]) {
                            const imageSource = aboutData[`image_${i}_source`];

                            window.aboutImages[`image_${i}`] = normalizeHeroImageForStorage(imageSource);

                            window.dispatchEvent(new CustomEvent('media-selected', {
                                detail: {
                                    fieldId: `aboutImage${i}`,
                                    url: normalizeHeroImageForPreview(imageSource)
                                }
                            }));
                        }
                        if (aboutData[`image_${i}_alt`]) {
                            document.getElementById(`aboutImage${i}Alt`).value = aboutData[`image_${i}_alt`];
                        }
                    }
                    
                    // Load benefits dari database
                    for (let i = 1; i <= 6; i++) {
                        if (aboutData[`benefit_${i}_text`]) {
                            document.getElementById(`aboutBenefit${i}Text`).value = aboutData[`benefit_${i}_text`];
                        }
                        if (aboutData[`benefit_${i}_icon`]) {
                            document.getElementById(`aboutBenefit${i}Icon`).value = aboutData[`benefit_${i}_icon`];
                        }
                        if (aboutData[`benefit_${i}_enabled`] !== undefined) {
                            document.getElementById(`aboutBenefit${i}Enabled`).checked = aboutData[`benefit_${i}_enabled`];
                        }
                    }
                }
            } catch (error) {
                console.error('Error loading About data:', error);
            }
        }
    }
    
    // Show modal
    modal.classList.remove('hidden');
}

/**
 * Tutup modal edit About
 */
function closeEditAboutModal() {
    const modal = document.getElementById('editAboutModal');
    if (modal) {
        modal.classList.add('hidden');
    }
    currentEditBlockId = null;
}

/**
 * Simpan About block
 */
async function saveAboutBlock() {
    console.log('Saving About block...');
    
    if (!currentEditBlockId) {
        console.error('No block selected');
        return;
    }
    
    // Show loading state
    const saveBtn = document.getElementById('saveAboutBtn');
    const saveIcon = document.getElementById('saveAboutIcon');
    const saveLoading = document.getElementById('saveAboutLoading');
    const saveText = document.getElementById('saveAboutText');
    const deleteBtn = document.getElementById('deleteAboutBtn');
    
    if (saveBtn) saveBtn.disabled = true;
    if (deleteBtn) deleteBtn.disabled = true;
    if (saveIcon) saveIcon.classList.add('hidden');
    if (saveLoading) saveLoading.classList.remove('hidden');
    if (saveText) saveText.textContent = 'Saving...';
    
    try {
        // Validasi required fields
        const sectionTitle = document.getElementById('aboutSectionTitle').value.trim();
        
        if (!sectionTitle) {
            alert('Please fill in the Section Title');
            return;
        }
        
        // Sync images from media picker input values
        for (let i = 1; i <= 3; i++) {
            const inputValue = document.getElementById(`aboutImage${i}`)?.value.trim() || '';
            if (inputValue) {
                window.aboutImages[`image_${i}`] = normalizeHeroImageForStorage(inputValue);
            }
        }

        // Validasi images (minimal 3 image required)
        if (!window.aboutImages.image_1 || !window.aboutImages.image_2 || !window.aboutImages.image_3) {
            alert('Please upload all 3 images');
            return;
        }
        
        // Kumpulkan semua data
        const aboutData = {
            section_label: document.getElementById('aboutSectionLabel').value.trim(),
            section_title: sectionTitle,
            section_description: document.getElementById('aboutSectionDescription').value.trim(),
            benefit_title: document.getElementById('aboutBenefitTitle').value.trim(),
        };
        
        // Images with type
        for (let i = 1; i <= 3; i++) {
            aboutData[`image_${i}_type`] = 'url';
            aboutData[`image_${i}_source`] = window.aboutImages[`image_${i}`] || '';
            aboutData[`image_${i}_alt`] = document.getElementById(`aboutImage${i}Alt`).value.trim();
        }
        
        // Benefits
        for (let i = 1; i <= 6; i++) {
            aboutData[`benefit_${i}_text`] = document.getElementById(`aboutBenefit${i}Text`).value.trim();
            aboutData[`benefit_${i}_icon`] = document.getElementById(`aboutBenefit${i}Icon`).value;
            aboutData[`benefit_${i}_enabled`] = document.getElementById(`aboutBenefit${i}Enabled`).checked;
        }
        
        console.log('📦 About data to save:', aboutData);
        
        // Prepare data untuk API
        const block = document.getElementById(currentEditBlockId);
        const shortcodeId = block?.dataset.shortcodeId;
        const sortId = getCurrentSortId(currentEditBlockId) || 0;
        const aboutStyle = block?.dataset.aboutStyle || '1';
        
        // Update cache dengan struktur yang konsisten
        blockDataCache[currentEditBlockId] = {
            about_style: aboutStyle,
            about: aboutData,
            type: 'about'
        };
        
        console.log('💾 Updated cache for About block:', blockDataCache[currentEditBlockId]);
        
        const payload = {
            pages_id: window.pageId,
            type: 'about',
            about_style: aboutStyle,
            sort_id: sortId,
            about_data: aboutData
        };
        
        console.log('📤 Sending payload:', payload);
        
        let response;
        
        if (shortcodeId) {
            // Update existing
            response = await fetch(`/bagoosh/page-shortcode/update/${shortcodeId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify(payload)
            });
        } else {
            // Create new
            response = await fetch('/bagoosh/page-shortcode/store', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify(payload)
            });
        }
        
        const data = await response.json();
        console.log('📨 Server response:', data);
        
        if (!response.ok) {
            throw new Error(data.message || 'Failed to save');
        }
        
        // Update shortcodeId di block element
        if (data.data && data.data.id) {
            block.dataset.shortcodeId = data.data.id;
        }
        
        // Update label block
        const label = block.querySelector('.block-label');
        if (label) {
            label.textContent = `About Us - ${sectionTitle.substring(0, 30)}${sectionTitle.length > 30 ? '...' : ''}`;
        }
        
        closeEditAboutModal();
        alert('About block saved successfully!');
        
    } catch (error) {
        console.error('❌ Save error:', error);
        alert('Error saving About block: ' + error.message);
    } finally {
        // Hide loading state
        if (saveBtn) saveBtn.disabled = false;
        if (deleteBtn) deleteBtn.disabled = false;
        if (saveIcon) saveIcon.classList.remove('hidden');
        if (saveLoading) saveLoading.classList.add('hidden');
        if (saveText) saveText.textContent = 'Save Changes';
    }
}

/**
 * Hapus About block
 */
async function deleteAboutBlock() {
    console.log('Deleting About block...');
    
    if (!currentEditBlockId) {
        console.error('No block selected for deletion');
        return;
    }
    
    if (!confirm('Are you sure you want to delete this About block?')) {
        return;
    }
    
    let block = document.getElementById(currentEditBlockId);
    if (!block) {
        block = document.querySelector(`[data-block-id="${currentEditBlockId}"]`);
    }
    
    if (!block) {
        console.error('Block not found:', currentEditBlockId);
        return;
    }
    
    // Show loading state
    const saveBtn = document.getElementById('saveAboutBtn');
    const deleteBtn = document.getElementById('deleteAboutBtn');
    const deleteIcon = document.getElementById('deleteAboutIcon');
    const deleteLoading = document.getElementById('deleteAboutLoading');
    const deleteText = document.getElementById('deleteAboutText');
    
    if (saveBtn) saveBtn.disabled = true;
    if (deleteBtn) deleteBtn.disabled = true;
    if (deleteIcon) deleteIcon.classList.add('hidden');
    if (deleteLoading) deleteLoading.classList.remove('hidden');
    if (deleteText) deleteText.textContent = 'Deleting...';
    
    const shortcodeId = block?.dataset.shortcodeId;
    
    try {
        // Hapus dari database jika sudah tersimpan
        if (shortcodeId) {
            console.log('🗑️ Deleting from database:', shortcodeId);
            const response = await fetch(`/bagoosh/page-shortcode/delete/${shortcodeId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                }
            });
            
            const data = await response.json();
            console.log('📨 Delete response:', data);
            
            if (!response.ok) {
                throw new Error(data.message || 'Failed to delete from database');
            }
            console.log('✅ Deleted from database');
        } else {
            console.log('ℹ️ Block not saved yet, removing from UI only');
        }
        
        // Hapus dari cache
        if (blockDataCache[currentEditBlockId]) {
            delete blockDataCache[currentEditBlockId];
            console.log('🗑️ Deleted from cache:', currentEditBlockId);
        }
        
        // Hapus block dari UI
        block.remove();
        closeEditAboutModal();
        checkEmptyState();
        updateBlockOrder();
        alert('About block deleted successfully!');
        
    } catch (error) {
        console.error('❌ Delete error:', error);
        alert('Error deleting About block: ' + error.message);
    } finally {
        // Hide loading state
        if (saveBtn) saveBtn.disabled = false;
        if (deleteBtn) deleteBtn.disabled = false;
        if (deleteIcon) deleteIcon.classList.remove('hidden');
        if (deleteLoading) deleteLoading.classList.add('hidden');
        if (deleteText) deleteText.textContent = 'Delete Block';
    }
}

// ===================================================================
// PRODUCT CATEGORY BLOCK FUNCTIONS
// ===================================================================

/**
 * Buka modal select Product Category style
 */
function openSelectProductCategoryStyleModal() {
    const modal = document.getElementById('selectProductCategoryStyleModal');
    if (modal) {
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.querySelector('.bg-white')?.classList.add('animate-fade-in');
        }, 10);
    }
}

/**
 * Tutup modal select Product Category style
 */
function closeSelectProductCategoryStyleModal() {
    const modal = document.getElementById('selectProductCategoryStyleModal');
    if (modal) {
        modal.querySelector('.bg-white')?.classList.remove('animate-fade-in');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }
}

/**
 * Proses setelah user memilih Product Category style
 */
function selectProductCategoryStyle(style) {
    console.log('Product Category style selected:', style);
    
    if (!pendingProductCategoryBlockId) {
        console.error('No pending Product Category block ID');
        return;
    }
    
    // Ambil ID dan config block
    const blockId = pendingProductCategoryBlockId;
    const config = blockConfig['product-category'];
    const blocksList = document.getElementById('blocksList');
    
    // Buat HTML untuk block Product Category
    const blockHTML = `
        <div id="${blockId}" data-type="product-category" data-product-category-style="${style}" class="block-item bg-white hover:bg-slate-50 transition-all group">
            <div class="flex items-center gap-4 p-4">
                <div class="drag-handle cursor-move text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                    </svg>
                </div>
                <div class="flex-1 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-${config.color}-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-${config.color}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            ${getBlockIcon('product-category')}
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <span class="block-order inline-flex items-center justify-center w-6 h-6 rounded-full bg-slate-200 text-slate-700 text-xs font-bold">${blockCounter}</span>
                            <h3 class="font-semibold text-slate-800 block-label">${config.name} - Style ${style}</h3>
                        </div>
                        <p class="text-xs text-slate-500 mt-0.5">Click to configure</p>
                    </div>
                </div>
                <button type="button" 
                        onclick="openEditModal('${blockId}')"
                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium text-sm transition-all opacity-0 group-hover:opacity-100 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Configure
                </button>
            </div>
        </div>
    `;
    
    // Insert block ke dalam list
    blocksList.insertAdjacentHTML('beforeend', blockHTML);
    
    // Close style selection modal
    closeSelectProductCategoryStyleModal();
    
    // Cek empty state
    checkEmptyState();
    
    // Update block order
    updateBlockOrder();
    
    // Re-initialize sortable jika belum ada
    if (!sortable) {
        initSortable();
    }
    
    // Reset pendingProductCategoryBlockId
    pendingProductCategoryBlockId = null;
}

/**
 * Buka modal edit Product Category
 */
async function openEditProductCategoryModal() {
    console.log('Opening Product Category modal for:', currentEditBlockId);
    
    if (!currentEditBlockId) {
        console.error('No block selected');
        return;
    }
    
    const modal = document.getElementById('editProductCategoryModal');
    if (!modal) {
        console.error('Product Category modal not found');
        return;
    }
    
    // Reset form
    document.getElementById('productCategoryTitle').value = '';
    document.getElementById('productCategorySubtitle').value = '';
    document.getElementById('productCategoryLimit').value = '12';
    
    // Cek cache dulu
    const cachedData = blockDataCache[currentEditBlockId];
    console.log('📦 Cached data:', cachedData);
    
    if (cachedData) {
        // Load dari cache
        document.getElementById('productCategoryTitle').value = cachedData.product_title || '';
        document.getElementById('productCategorySubtitle').value = cachedData.product_subtitle || '';
        document.getElementById('productCategoryLimit').value = cachedData.product_category_limit || '12';
    } else {
        // Load dari database jika ada shortcode_id
        const block = document.getElementById(currentEditBlockId);
        const shortcodeId = block?.dataset.shortcodeId;
        
        if (shortcodeId) {
            try {
                const response = await fetch(`/bagoosh/page-shortcode/show/${shortcodeId}`);
                const data = await response.json();
                console.log('📨 Loaded from database:', data);
                
                if (data.success && data.data) {
                    const shortcodeData = data.data;
                    
                    document.getElementById('productCategoryTitle').value = shortcodeData.product_title || '';
                    document.getElementById('productCategorySubtitle').value = shortcodeData.product_subtitle || '';
                    document.getElementById('productCategoryLimit').value = shortcodeData.product_category_limit || '12';
                }
            } catch (error) {
                console.error('Error loading Product Category data:', error);
            }
        }
    }
    
    // Show modal
    modal.classList.remove('hidden');
}

/**
 * Tutup modal edit Product Category
 */
function closeEditProductCategoryModal() {
    const modal = document.getElementById('editProductCategoryModal');
    if (modal) {
        modal.classList.add('hidden');
    }
    currentEditBlockId = null;
}

/**
 * Simpan Product Category block
 */
async function saveProductCategoryBlock() {
    console.log('Saving Product Category block...');
    
    if (!currentEditBlockId) {
        console.error('No block selected');
        return;
    }
    
    // Show loading state
    const saveBtn = document.getElementById('saveProductCategoryBtn');
    const saveIcon = document.getElementById('saveProductCategoryIcon');
    const saveLoading = document.getElementById('saveProductCategoryLoading');
    const saveText = document.getElementById('saveProductCategoryText');
    const deleteBtn = document.getElementById('deleteProductCategoryBtn');
    
    if (saveBtn) saveBtn.disabled = true;
    if (deleteBtn) deleteBtn.disabled = true;
    if (saveIcon) saveIcon.classList.add('hidden');
    if (saveLoading) saveLoading.classList.remove('hidden');
    if (saveText) saveText.textContent = 'Saving...';
    
    try {
        // Validasi required fields
        const productTitle = document.getElementById('productCategoryTitle').value.trim();
        const productCategoryLimit = document.getElementById('productCategoryLimit').value;
        
        if (!productTitle) {
            alert('Please fill in the Section Title');
            return;
        }
        
        if (!productCategoryLimit || productCategoryLimit < 1) {
            alert('Please enter a valid Items Per Page value (minimum 1)');
            return;
        }
        
        // Kumpulkan semua data
        const productCategoryData = {
            product_title: productTitle,
            product_subtitle: document.getElementById('productCategorySubtitle').value.trim(),
            product_category_limit: parseInt(productCategoryLimit)
        };
        
        console.log('📦 Product Category data to save:', productCategoryData);
        
        // Prepare data untuk API
        const block = document.getElementById(currentEditBlockId);
        const shortcodeId = block?.dataset.shortcodeId;
        const sortId = getCurrentSortId(currentEditBlockId) || 0;
        const productCategoryStyle = block?.dataset.productCategoryStyle || '1';
        
        // Update cache dengan semua data termasuk style
        blockDataCache[currentEditBlockId] = {
            ...productCategoryData,
            product_category_style: productCategoryStyle,
            type: 'product-category'
        };
        
        const payload = {
            pages_id: window.pageId,
            type: 'product-category',
            product_title: productCategoryData.product_title,
            product_subtitle: productCategoryData.product_subtitle,
            product_category_limit: productCategoryData.product_category_limit,
            product_category_style: productCategoryStyle,
            sort_id: sortId
        };
        
        console.log('📤 Sending payload:', payload);
        
        let response;
        
        if (shortcodeId) {
            // Update existing
            response = await fetch(`/bagoosh/page-shortcode/update/${shortcodeId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify(payload)
            });
        } else {
            // Create new
            response = await fetch('/bagoosh/page-shortcode/store', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify(payload)
            });
        }
        
        const data = await response.json();
        console.log('📨 Server response:', data);
        
        if (!response.ok) {
            throw new Error(data.message || 'Failed to save');
        }
        
        // Update shortcodeId di block element
        if (data.data && data.data.id) {
            block.dataset.shortcodeId = data.data.id;
        }
        
        // Update label block
        const label = block.querySelector('.block-label');
        if (label) {
            label.textContent = `Product Category - ${productTitle.substring(0, 30)}${productTitle.length > 30 ? '...' : ''}`;
        }
        
        closeEditProductCategoryModal();
        alert('Product Category block saved successfully!');
        
    } catch (error) {
        console.error('❌ Save error:', error);
        alert('Error saving Product Category block: ' + error.message);
    } finally {
        // Hide loading state
        if (saveBtn) saveBtn.disabled = false;
        if (deleteBtn) deleteBtn.disabled = false;
        if (saveIcon) saveIcon.classList.remove('hidden');
        if (saveLoading) saveLoading.classList.add('hidden');
        if (saveText) saveText.textContent = 'Save Changes';
    }
}

/**
 * Hapus Product Category block
 */
async function deleteProductCategoryBlock() {
    console.log('Deleting Product Category block...');
    
    if (!currentEditBlockId) {
        console.error('No block selected for deletion');
        return;
    }
    
    if (!confirm('Are you sure you want to delete this Product Category block?')) {
        return;
    }
    
    let block = document.getElementById(currentEditBlockId);
    if (!block) {
        block = document.querySelector(`[data-block-id="${currentEditBlockId}"]`);
    }
    
    if (!block) {
        console.error('Block not found:', currentEditBlockId);
        return;
    }
    
    // Show loading state
    const saveBtn = document.getElementById('saveProductCategoryBtn');
    const deleteBtn = document.getElementById('deleteProductCategoryBtn');
    const deleteIcon = document.getElementById('deleteProductCategoryIcon');
    const deleteLoading = document.getElementById('deleteProductCategoryLoading');
    const deleteText = document.getElementById('deleteProductCategoryText');
    
    if (saveBtn) saveBtn.disabled = true;
    if (deleteBtn) deleteBtn.disabled = true;
    if (deleteIcon) deleteIcon.classList.add('hidden');
    if (deleteLoading) deleteLoading.classList.remove('hidden');
    if (deleteText) deleteText.textContent = 'Deleting...';
    
    const shortcodeId = block?.dataset.shortcodeId;
    
    try {
        // Hapus dari database jika sudah tersimpan
        if (shortcodeId) {
            console.log('🗑️ Deleting from database:', shortcodeId);
            const response = await fetch(`/bagoosh/page-shortcode/delete/${shortcodeId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                }
            });
            
            const data = await response.json();
            console.log('📨 Delete response:', data);
            
            if (!response.ok) {
                throw new Error(data.message || 'Failed to delete from database');
            }
            console.log('✅ Deleted from database');
        } else {
            console.log('ℹ️ Block not saved yet, removing from UI only');
        }
        
        // Hapus dari cache
        if (blockDataCache[currentEditBlockId]) {
            delete blockDataCache[currentEditBlockId];
            console.log('🗑️ Deleted from cache:', currentEditBlockId);
        }
        
        // Hapus block dari UI
        block.remove();
        closeEditProductCategoryModal();
        checkEmptyState();
        updateBlockOrder();
        alert('Product Category block deleted successfully!');
        
    } catch (error) {
        console.error('❌ Delete error:', error);
        alert('Error deleting Product Category block: ' + error.message);
    } finally {
        // Hide loading state
        if (saveBtn) saveBtn.disabled = false;
        if (deleteBtn) deleteBtn.disabled = false;
        if (deleteIcon) deleteIcon.classList.remove('hidden');
        if (deleteLoading) deleteLoading.classList.add('hidden');
        if (deleteText) deleteText.textContent = 'Delete Block';
    }
}

// ===================================================================
// EXPOSE FUNCTIONS TO GLOBAL WINDOW OBJECT (FOR HTML ONCLICK)
// ===================================================================
// Function-function ini perlu accessible dari onclick attributes di HTML
// Mendaftarkan semua function ke window object

console.log('🔌 Binding functions to window object...');

// Core functions
window.openBlockLibrary = openBlockLibrary;
window.closeBlockLibrary = closeBlockLibrary;
window.addBlock = addBlock;
window.openEditModal = openEditModal;

// ⭐ EXPOSE MODAL FUNCTIONS (FIX UNTUK ONCLICK HANDLERS)
// Title Block
window.closeEditTitleModal = closeEditTitleModal;
window.saveTitleBlock = saveTitleBlock;
window.deleteTitleBlock = deleteTitleBlock;

// Simple Text Block
window.closeEditSimpleTextModal = closeEditSimpleTextModal;
window.saveSimpleTextBlock = saveSimpleTextBlock;
window.deleteSimpleTextBlock = deleteSimpleTextBlock;

// Text Editor Block
window.closeEditTextEditorModal = closeEditTextEditorModal;
window.saveTextEditorBlock = saveTextEditorBlock;
window.deleteTextEditorBlock = deleteTextEditorBlock;

// Brands Block
window.closeEditBrandsModal = closeEditBrandsModal;
window.saveBrandsBlock = saveBrandsBlock;
window.deleteBrandsBlock = deleteBrandsBlock;

// Complete Counts Block
window.closeEditCompleteCountsModal = closeEditCompleteCountsModal;
window.saveCompleteCountsBlock = saveCompleteCountsBlock;
window.deleteCompleteCountsBlock = deleteCompleteCountsBlock;

// Hero Banner Modals
window.closeSelectHeroStyleModal = closeSelectHeroStyleModal;
window.selectHeroStyle = selectHeroStyle;
window.closeEditHeroBannerModal = closeEditHeroBannerModal;
window.saveHeroBannerBlock = saveHeroBannerBlock;
window.deleteHeroBannerBlock = deleteHeroBannerBlock;
window.closeEditHeroBannerStyle2Modal = closeEditHeroBannerStyle2Modal;
window.saveHeroBannerStyle2Block = saveHeroBannerStyle2Block;
window.deleteHeroBannerStyle2Block = deleteHeroBannerStyle2Block;
window.closeEditHeroBannerStyle3Modal = closeEditHeroBannerStyle3Modal;
window.saveHeroBannerStyle3Block = saveHeroBannerStyle3Block;
window.deleteHeroBannerStyle3Block = deleteHeroBannerStyle3Block;

// About Block
window.closeSelectAboutStyleModal = closeSelectAboutStyleModal;
window.selectAboutStyle = selectAboutStyle;
window.closeEditAboutModal = closeEditAboutModal;
window.saveAboutBlock = saveAboutBlock;
window.deleteAboutBlock = deleteAboutBlock;

// Testimonials Block
window.closeSelectTestimonialsStyleModal = closeSelectTestimonialsStyleModal;
window.selectTestimonialsStyle = selectTestimonialsStyle;
window.closeEditTestimonialsModal = closeEditTestimonialsModal;
window.saveTestimonialsBlock = saveTestimonialsBlock;
window.deleteTestimonialsBlock = deleteTestimonialsBlock;

// Recent Product Block
window.closeEditRecentProductModal = closeEditRecentProductModal;
window.saveRecentProductBlock = saveRecentProductBlock;
window.deleteRecentProductBlock = deleteRecentProductBlock;

// Featured Services Block
window.closeSelectServiceStyleModal = closeSelectServiceStyleModal;
window.selectServiceStyle = selectServiceStyle;
window.closeEditFeaturedServicesModal = closeEditFeaturedServicesModal;
window.saveFeaturedServicesBlock = saveFeaturedServicesBlock;
window.deleteFeaturedServicesBlock = deleteFeaturedServicesBlock;

// Newsletter Block
window.closeEditNewsletterModal = closeEditNewsletterModal;
window.saveNewsletterBlock = saveNewsletterBlock;
window.deleteNewsletterBlock = deleteNewsletterBlock;

// Latest News Block
window.closeSelectLatestNewsStyleModal = closeSelectLatestNewsStyleModal;
window.selectLatestNewsStyle = selectLatestNewsStyle;
window.closeEditLatestNewsModal = closeEditLatestNewsModal;
window.saveLatestNewsBlock = saveLatestNewsBlock;
window.deleteLatestNewsBlock = deleteLatestNewsBlock;

// Coming Soon Block
window.closeEditComingSoonModal = closeEditComingSoonModal;
window.saveComingSoonBlock = saveComingSoonBlock;
window.deleteComingSoonBlock = deleteComingSoonBlock;

// Contact Block
window.closeEditContactModal = closeEditContactModal;
window.saveContactBlock = saveContactBlock;
window.deleteContactBlock = deleteContactBlock;

// Product Category Block
window.closeSelectProductCategoryStyleModal = closeSelectProductCategoryStyleModal;
window.selectProductCategoryStyle = selectProductCategoryStyle;
window.closeEditProductCategoryModal = closeEditProductCategoryModal;
window.saveProductCategoryBlock = saveProductCategoryBlock;
window.deleteProductCategoryBlock = deleteProductCategoryBlock;

// Test function - bisa dipanggil dari console
window.testModal = function() {
    console.log('🧪 TEST FUNCTION CALLED');
    console.log('📌 openBlockLibrary exists?', typeof openBlockLibrary);
    console.log('📌 window.openBlockLibrary exists?', typeof window.openBlockLibrary);
    
    const modal = document.getElementById('blockLibraryModal');
    console.log('📌 Modal exists?', !!modal);
    
    if (modal) {
        console.log('📌 Modal classes:', modal.className);
        console.log('📌 Calling openBlockLibrary()...');
        openBlockLibrary();
    } else {
        console.error('❌ Modal NOT found!');
    }
};

console.log('✅ All functions successfully bound to window object');
console.log('💡 Untuk test, ketik di console: window.testModal() atau testModal()');

// ===================================================================
// END OF FILE
// ===================================================================
