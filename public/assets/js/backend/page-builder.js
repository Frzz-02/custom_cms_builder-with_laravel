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

// Cache untuk data dari database (untuk optimasi performa)
// Data di-load sekali saat halaman dibuka, lalu disimpan di sini
let cachedTestimonials = [];
let cachedServices = [];
let cachedNewsletters = [];
let cachedContacts = [];
let isDataLoaded = false;

// Cache untuk data block yang sudah disave (optimasi performa)
// Format: { 'block-1': { title: 'xxx', subtitle: 'yyy', ... }, 'block-2': { ... } }
// Setiap block punya data sendiri-sendiri, meskipun tipenya sama
let blockDataCache = {};

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
    'contact': { 
        name: 'Contact', 
        icon: 'phone', 
        color: 'teal' 
    }
};

// ===================================================================
// BAGIAN 3: INISIALISASI SAAT HALAMAN SELESAI LOADING
// ===================================================================

// addEventListener = cara JavaScript "mendengarkan" event/kejadian
// 'DOMContentLoaded' = event yang terjadi saat HTML selesai dimuat
// function() { ... } = kode yang akan dijalankan saat event terjadi
document.addEventListener('DOMContentLoaded', function() {
    console.log('Page Builder JS Loaded');
    
    // Pre-load semua data dari database untuk optimasi performa
    preloadAllData();
    
    // Panggil fungsi untuk mengaktifkan drag & drop
    initSortable();
    
    // Check if modal exists
    const modal = document.getElementById('blockLibraryModal');
    if (modal) {
        console.log('✓ Block Library Modal found');
    } else {
        console.error('✗ Block Library Modal NOT found!');
    }
    
    // Load existing blocks dari database (jika ada)
    loadExistingBlocks();
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
            onEnd: function() {
                // Update nomor urutan setelah drag selesai
                updateBlockOrder();
            }
        });
    }
}

/**
 * Fungsi untuk memperbarui nomor urutan block setelah di-drag
 * Contoh: Block 1, Block 2, Block 3 → setelah drag → Block 2, Block 1, Block 3
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
    });
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
    console.log('openBlockLibrary() called');
    
    // getElementById = ambil element dengan ID tertentu
    const modal = document.getElementById('blockLibraryModal');
    
    if (!modal) {
        console.error('Modal blockLibraryModal not found!');
        alert('Error: Modal not found. Please refresh the page.');
        return;
    }
    
    console.log('Opening modal...');
    
    // classList.remove = hapus class dari element
    // 'hidden' = class yang menyembunyikan element
    // Jadi: tampilkan modal dengan menghapus class 'hidden'
    modal.classList.remove('hidden');
    
    // Cegah scroll di halaman utama saat modal terbuka
    // 'hidden' = tidak bisa scroll
    document.body.style.overflow = 'hidden';
    
    console.log('Modal opened successfully');
}

/**
 * Fungsi untuk menutup modal library
 */
function closeBlockLibrary() {
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
        if (shortcodeData) {
            document.getElementById('simpleTextBlockId').value = shortcodeData.id || '';
            document.getElementById('simpleTextContent').value = shortcodeData.content || '';
        } else {
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
        // Untuk block hero banner (punya fungsi khusus)
        openEditHeroBannerModal();
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
    const shortcodeId = blockElement.dataset.shortcodeId;
    
    // Extract sort_id dari block ID (block-1, block-2, etc)
    // blockCounter adalah angka yang digunakan saat block dibuat
    const sortId = parseInt(currentEditBlockId.replace('block-', ''));
    
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
    // if (!currentEditBlockId) = jika tidak ada block yang sedang diedit
    // return = keluar dari fungsi
    if (!currentEditBlockId) return;
    
    // confirm() = menampilkan dialog konfirmasi Yes/No
    // return true jika user klik OK, false jika Cancel
    if (!confirm('Are you sure you want to delete this block?')) return;

    // getElementById = ambil element berdasarkan ID
    const blockElement = document.getElementById(currentEditBlockId);
    const shortcodeId = blockElement.dataset.shortcodeId;
    
    // Ambil element-element untuk loading state
    const deleteBtn = document.getElementById('deleteTitleBtn');
    const deleteIconTrash = document.getElementById('deleteTitleIconTrash');
    const deleteIconLoading = document.getElementById('deleteTitleIconLoading');
    const deleteButtonText = document.getElementById('deleteTitleButtonText');
    
    // Show loading state (tampilkan animasi loading)
    // disabled = true = tombol tidak bisa diklik
    deleteBtn.disabled = true;
    // classList.add = tambah class, classList.remove = hapus class
    deleteIconTrash.classList.add('hidden'); // Sembunyikan icon trash
    deleteIconLoading.classList.remove('hidden'); // Tampilkan icon loading (spinning)
    deleteButtonText.textContent = 'Deleting...'; // Ubah text tombol

    // if (shortcodeId) = jika block sudah pernah disave ke database
    if (shortcodeId) {
        console.log('🗑️ Deleting from database:', shortcodeId);
        try {
            // Delete dari database
            const response = await fetch(`/bagoosh/page-shortcode/delete/${shortcodeId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            
            const result = await response.json();
            
            if (!result.success) {
                throw new Error(result.message || 'Failed to delete');
            }
            
            console.log('✅ Deleted from database');
        } catch (error) {
            console.error('Error deleting from database:', error);
            alert('Failed to delete block: ' + error.message);
            
            // Reset button state
            deleteBtn.disabled = false;
            deleteIconTrash.classList.remove('hidden');
            deleteIconLoading.classList.add('hidden');
            deleteButtonText.textContent = 'Delete';
            return;
        }
    } else {
        console.log('ℹ️ Block was never saved, just removing from UI');
    }
    
    // Hapus dari cache (baik sudah disave atau belum)
    if (blockDataCache[currentEditBlockId]) {
        delete blockDataCache[currentEditBlockId];
        console.log('🧹 Removed from cache:', currentEditBlockId);
    }

    // Tutup modal dan hapus block dari tampilan
    closeModalWithTransition('editTitleModal', () => {
        // Ambil element block yang mau dihapus
        const block = document.getElementById(currentEditBlockId);
        
        // if (block) = jika block ditemukan
        if (block) {
            // Atur animasi fade out
            block.style.transition = 'opacity 300ms ease-out';
            block.style.opacity = '0'; // Buat transparan
            
            // Tunggu animasi selesai, baru hapus dari DOM
            setTimeout(() => {
                // remove() = hapus element dari HTML
                block.remove();
                
                // Cek apakah masih ada block atau tidak
                checkEmptyState();
                
                // Update nomor urutan block
                updateBlockOrder();
            }, 300);
        }
        
        // Reset variable
        currentEditBlockId = null;
        
        // Reset button state (kembalikan tombol ke kondisi normal)
        deleteBtn.disabled = false;
        deleteIconTrash.classList.remove('hidden');
        deleteIconLoading.classList.add('hidden');
        deleteButtonText.textContent = 'Delete';
        
        // alert() = tampilkan pesan popup
        alert('Block deleted successfully!');
    });
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
    const shortcodeId = blockElement.dataset.shortcodeId;
    
    // Extract sort_id dari block ID (block-1, block-2, etc)
    // blockCounter adalah angka yang digunakan saat block dibuat
    const sortId = parseInt(currentEditBlockId.replace('block-', ''));
    
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
            }
            
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

    const blockElement = document.getElementById(currentEditBlockId);
    const shortcodeId = blockElement.dataset.shortcodeId;
    
    const deleteBtn = document.getElementById('deleteSimpleTextBtn');
    const deleteIconTrash = document.getElementById('deleteSimpleTextIconTrash');
    const deleteIconLoading = document.getElementById('deleteSimpleTextIconLoading');
    const deleteButtonText = document.getElementById('deleteSimpleTextButtonText');
    
    deleteBtn.disabled = true;
    deleteIconTrash.classList.add('hidden');
    deleteIconLoading.classList.remove('hidden');
    deleteButtonText.textContent = 'Deleting...';

    if (shortcodeId) {
        try {
            // Delete dari database
            const response = await fetch(`/bagoosh/page-shortcode/delete/${shortcodeId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            
            const result = await response.json();
            
            if (!result.success) {
                throw new Error(result.message || 'Failed to delete');
            }
        } catch (error) {
            console.error('Error deleting from database:', error);
            alert('Failed to delete block: ' + error.message);
            
            // Reset button state
            deleteBtn.disabled = false;
            deleteIconTrash.classList.remove('hidden');
            deleteIconLoading.classList.add('hidden');
            deleteButtonText.textContent = 'Delete';
            return;
        }
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
    const shortcodeId = blockElement.dataset.shortcodeId;
    
    // Extract sort_id dari block ID (block-1, block-2, etc)
    // blockCounter adalah angka yang digunakan saat block dibuat
    const sortId = parseInt(currentEditBlockId.replace('block-', ''));
    
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
            }
            
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

    const blockElement = document.getElementById(currentEditBlockId);
    const shortcodeId = blockElement.dataset.shortcodeId;
    
    const deleteBtn = document.getElementById('deleteTextEditorBtn');
    const deleteIconTrash = document.getElementById('deleteTextEditorIconTrash');
    const deleteIconLoading = document.getElementById('deleteTextEditorIconLoading');
    const deleteButtonText = document.getElementById('deleteTextEditorButtonText');
    
    deleteBtn.disabled = true;
    deleteIconTrash.classList.add('hidden');
    deleteIconLoading.classList.remove('hidden');
    deleteButtonText.textContent = 'Deleting...';

    if (shortcodeId) {
        try {
            // Delete dari database
            const response = await fetch(`/bagoosh/page-shortcode/delete/${shortcodeId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            
            const result = await response.json();
            
            if (!result.success) {
                throw new Error(result.message || 'Failed to delete');
            }
        } catch (error) {
            console.error('Error deleting from database:', error);
            alert('Failed to delete block: ' + error.message);
            
            // Reset button state
            deleteBtn.disabled = false;
            deleteIconTrash.classList.remove('hidden');
            deleteIconLoading.classList.add('hidden');
            deleteButtonText.textContent = 'Delete';
            return;
        }
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
    const selectedBrands = Array.from(checkboxes).map(cb => cb.value);
    
    // Validasi minimal harus pilih 1 brand
    if (selectedBrands.length === 0) {
        alert('Please select at least one brand');
        return;
    }
    
    // Extract sort_id dari block ID (block-1, block-2, dll)
    const sortId = parseInt(currentEditBlockId.replace('block-', ''));
    
    console.log('📊 Sort ID calculation:', {
        blockId: currentEditBlockId,
        extractedSortId: sortId,
        currentBlockCounter: blockCounter
    });
    
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
    const selectedCounts = Array.from(checkboxes).map(cb => cb.value);
    
    // Validasi minimal harus pilih 1 complete count
    if (selectedCounts.length === 0) {
        alert('Please select at least one complete count');
        return;
    }
    
    // Extract sort_id dari block ID (block-1, block-2, dll)
    const sortId = parseInt(currentEditBlockId.replace('block-', ''));
    
    console.log('📊 Sort ID calculation:', {
        blockId: currentEditBlockId,
        extractedSortId: sortId,
        currentBlockCounter: blockCounter
    });
    
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

function openEditHeroBannerModal() {
    const block = document.getElementById(currentEditBlockId);
    
    // Optional chaining (?.) = akses property dengan aman
    // Jika block null/undefined, hasilnya null (tidak error)
    const style = block?.dataset.style || '1';
    const shortcodeId = block?.dataset.shortcodeId || '';
    
    document.getElementById('hero_style_value').value = style;
    document.getElementById('hero_shortcode_id').value = shortcodeId;
    
    // Tampilkan style yang dipilih
    const styleNames = {
        '1': 'Style 1: Classic Hero',
        '2': 'Style 2: Split Screen',
        '3': 'Style 3: Full Background'
    };
    document.getElementById('hero_style_display').textContent = styleNames[style] || 'Unknown Style';
    
    // Jika ada data tersimpan, fetch dan populate form
    if (shortcodeId) {
        // TODO: Fetch data from API
    }
    
    document.getElementById('editHeroBannerModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeEditHeroBannerModal() {
    closeModalWithTransition('editHeroBannerModal', () => {
        currentEditBlockId = null;
    });
}

function populateHeroBannerForm(data) {
    // TODO: Populate form fields with data
    console.log('Populating form with:', data);
}

function handleImageUpload(fieldName, fileInput) {
    // TODO: Implement image upload
    console.log('Uploading image for:', fieldName);
}

/**
 * Menyimpan hero banner ke database
 * Menggunakan AJAX (Asynchronous JavaScript And XML)
 * AJAX = cara kirim/terima data tanpa reload halaman
 */
function saveHeroBannerBlock() {
    // Ambil data dari form
    const style = document.getElementById('hero_style_value').value;
    const shortcodeId = document.getElementById('hero_shortcode_id').value;
    
    // window.pageId = variable global yang diset dari blade template
    const pageId = window.pageId;
    
    // Ambil element untuk loading state
    const saveBtn = document.getElementById('saveHeroBtn');
    const saveIconCheck = document.getElementById('saveHeroIconCheck');
    const saveIconLoading = document.getElementById('saveHeroIconLoading');
    const saveButtonText = document.getElementById('saveHeroButtonText');
    
    // Show loading state
    saveBtn.disabled = true;
    saveIconCheck.classList.add('hidden');
    saveIconLoading.classList.remove('hidden');
    saveButtonText.textContent = 'Saving...';

    // Prepare form data untuk dikirim ke server
    // Object = struktur data dengan key-value pairs
    const formData = {
        pages_id: pageId,
        hero_style: style,
        type: 'hero-banner',
        sort_id: blockCounter
    };

    // Tentukan URL dan method berdasarkan apakah ini create atau update
    // Ternary operator: condition ? valueIfTrue : valueIfFalse
    const url = shortcodeId 
        ? `/bagoosh/page-shortcode/update/${shortcodeId}` // URL untuk update
        : '/bagoosh/page-shortcode/store'; // URL untuk create
    
    const method = shortcodeId ? 'PUT' : 'POST';

    // fetch() = cara modern untuk AJAX request
    // Kirim data ke server
    fetch(url, {
        method: method, // POST atau PUT
        headers: {
            // Headers = informasi tambahan yang dikirim ke server
            'Content-Type': 'application/json', // Kita kirim data JSON
            // CSRF token = security token untuk Laravel
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        // JSON.stringify() = ubah object JavaScript jadi string JSON
        body: JSON.stringify(formData)
    })
    // .then() = promise chain - jalankan kode setelah request selesai
    // response => response.json() = ubah response jadi JSON
    .then(response => response.json())
    // data = hasil dari response.json()
    .then(data => {
        // if (data.success) = jika server response success
        if (data.success) {
            // Simpan ID shortcode ke block
            const block = document.getElementById(currentEditBlockId);
            if (block && data.id) {
                block.dataset.shortcodeId = data.id;
            }
            
            // Reset button state
            saveBtn.disabled = false;
            saveIconCheck.classList.remove('hidden');
            saveIconLoading.classList.add('hidden');
            saveButtonText.textContent = 'Save Changes';
            
            closeEditHeroBannerModal();
            alert('Hero banner saved successfully!');
        } else {
            alert('Failed to save hero banner');
            saveBtn.disabled = false;
            saveIconCheck.classList.remove('hidden');
            saveIconLoading.classList.add('hidden');
            saveButtonText.textContent = 'Save Changes';
        }
    })
    // .catch() = tangkap error jika ada masalah
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while saving');
        saveBtn.disabled = false;
        saveIconCheck.classList.remove('hidden');
        saveIconLoading.classList.add('hidden');
        saveButtonText.textContent = 'Save Changes';
    });
}

/**
 * Menghapus hero banner dari database dan UI
 */
function deleteHeroBannerBlock() {
    // || = OR operator
    // (!currentEditBlockId || !confirm(...)) = jika tidak ada block ATAU user klik cancel
    if (!currentEditBlockId || !confirm('Are you sure?')) return;
    
    const shortcodeId = document.getElementById('hero_shortcode_id').value;
    const deleteBtn = document.getElementById('deleteHeroBtn');
    const deleteIconTrash = document.getElementById('deleteHeroIconTrash');
    const deleteIconLoading = document.getElementById('deleteHeroIconLoading');
    const deleteButtonText = document.getElementById('deleteHeroButtonText');
    
    deleteBtn.disabled = true;
    deleteIconTrash.classList.add('hidden');
    deleteIconLoading.classList.remove('hidden');
    deleteButtonText.textContent = 'Deleting...';
    
    // Arrow function untuk menghapus block dari UI
    const removeBlock = () => {
        closeModalWithTransition('editHeroBannerModal', () => {
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
            currentEditBlockId = null;
            alert('Hero banner deleted successfully!');
        });
    };
    
    // Jika sudah tersimpan di database, hapus dari database dulu
    if (shortcodeId) {
        fetch(`/bagoosh/page-shortcode/delete/${shortcodeId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) removeBlock();
            else alert('Error: ' + (data.message || 'Failed to delete'));
        })
        .catch(() => alert('Error deleting'));
    } else {
        // Jika belum tersimpan, langsung hapus dari UI
        removeBlock();
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
        blockCounter++; // Increment counter (tambah 1)
        pendingHeroBannerBlockId = `block-${blockCounter}`; // Buat ID untuk pending block
        closeBlockLibrary(); // Tutup library modal
        document.getElementById('selectHeroStyleModal').classList.remove('hidden'); // Buka style modal
        document.body.style.overflow = 'hidden';
        return; // Keluar dari fungsi (berhenti di sini)
    }
    
    // Special handling untuk featured-services (butuh pilih style dulu)
    if (type === 'featured-services') {
        blockCounter++;
        pendingFeaturedServicesBlockId = `block-${blockCounter}`;
        closeBlockLibrary();
        document.getElementById('selectServiceStyleModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        return;
    }
    
    // Special handling untuk testimonials (sama seperti hero-banner)
    if (type === 'testimonials') {
        blockCounter++;
        pendingTestimonialsBlockId = `block-${blockCounter}`;
        closeBlockLibrary();
        document.getElementById('selectTestimonialsStyleModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        return;
    }
    
    // Special handling untuk latestnews (butuh pilih style dulu)
    if (type === 'latestnews') {
        blockCounter++;
        pendingLatestNewsBlockId = `block-${blockCounter}`;
        closeBlockLibrary();
        document.getElementById('selectLatestNewsStyleModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        return;
    }   
    
    // Newsletter langsung ditambahkan tanpa pilih style
    if (type === 'newsletter') {
        blockCounter++;
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
    blockCounter++; // Increment counter
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
        'featured-services': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>',
        'newsletter': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>',
        'latestnews': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>',
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
    console.log('📥 Loading existing blocks...');
    
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
    
    // Loop setiap shortcode dari database
    window.existingShortcodes.forEach((shortcode, index) => {
        console.log(`Loading block ${index + 1}:`, shortcode);
        
        // Increment counter untuk ID block baru
        blockCounter++;
        const newBlockId = `block-${blockCounter}`;
        
        // Ambil config untuk block type ini
        const config = blockConfig[shortcode.type] || { name: shortcode.type, icon: 'cube', color: 'gray' };
        
        // Tentukan label berdasarkan type
        let blockLabel = config.name;
        
        // Buat HTML untuk block
        // Template literal dengan backtick ` ` bisa insert variable dengan ${}
        const blockHTML = `
            <div id="${newBlockId}" 
                 class="block-item bg-white border-2 border-slate-200 rounded-xl hover:border-indigo-400 hover:shadow-lg transition-all duration-300 cursor-move group"
                 data-type="${shortcode.type}"
                 data-shortcode-id="${shortcode.id}"
                 ${shortcode.section_newsletter_id ? `data-newsletter-id="${shortcode.section_newsletter_id}"` : ''}
                 ${shortcode.latestnews_title ? `data-title="${shortcode.latestnews_title}"` : ''}
                 ${shortcode.blog_limit ? `data-blog-limit="${shortcode.blog_limit}"` : ''}
                 ${shortcode.latestnews_style ? `data-style="${shortcode.latestnews_style}"` : ''}
                 ${shortcode.contact_title_1 ? `data-contact-title="${shortcode.contact_title_1}"` : ''}
                 ${shortcode.contact_subtitle ? `data-contact-subtitle="${shortcode.contact_subtitle}"` : ''}
                 ${shortcode.contact_id ? `data-contact-ids='${JSON.stringify(shortcode.contact_id)}'` : ''}>
                <div class="flex items-center justify-between p-4">
                    <div class="flex items-center gap-3 flex-1">
                        <!-- Drag Handle -->
                        <div class="cursor-move text-slate-400 group-hover:text-indigo-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/>
                            </svg>
                        </div>
                        
                        <!-- Block Order Number -->
                        <span class="block-order font-bold text-slate-600 text-sm">${blockCounter}</span>
                        
                        <!-- Block Icon & Name -->
                        <div class="flex items-center gap-2 flex-1">
                            <div class="w-10 h-10 rounded-lg bg-${config.color}-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-${config.color}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    ${getBlockIcon(shortcode.type)}
                                </svg>
                            </div>
                            <span class="font-semibold text-slate-800">${blockLabel}</span>
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
        // insertAdjacentHTML = cara efisien menambah HTML tanpa overwrite yang lain
        // 'beforeend' = tambahkan di akhir (sebelum closing tag)
        blocksList.insertAdjacentHTML('beforeend', blockHTML);
        
        console.log(`✅ Block ${newBlockId} loaded successfully`);
    });
    
    // Update empty state setelah semua blocks di-load
    checkEmptyState();
    
    // Update order numbers
    updateBlockOrder();
    
    console.log(`✅ Loaded ${window.existingShortcodes.length} blocks from database`);
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
function openEditTestimonialsModal() {
    const block = document.getElementById(currentEditBlockId);
    const style = block?.dataset.style || '1';
    const shortcodeId = block?.dataset.shortcodeId || '';
    
    // Ambil selected testimonial IDs kalau ada
    let selectedTestimonialIds = [];
    if (block?.dataset.testimonialIds) {
        try {
            selectedTestimonialIds = JSON.parse(block.dataset.testimonialIds);
        } catch (e) {
            console.error('Error parsing testimonial IDs:', e);
        }
    }
    
    document.getElementById('testimonials_style_value').value = style;
    document.getElementById('testimonials_shortcode_id').value = shortcodeId;
    
    const styleNames = {
        '1': 'Style 1: Classic Grid',
        '2': 'Style 2: Slider View',
        '3': 'Style 3: Masonry Layout'
    };
    document.getElementById('testimonials_style_display').textContent = styleNames[style] || 'Unknown Style';
    
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
function saveTestimonialsBlock() {
    // Ambil nilai dari form
    const title = document.getElementById('testimonials_title').value;
    const subtitle = document.getElementById('testimonials_subtitle').value;
    const style = document.getElementById('testimonials_style_value').value;
    const shortcodeId = document.getElementById('testimonials_shortcode_id').value;
    const pageId = window.pageId;
    
    // Ambil semua checkbox yang dicentang
    const checkboxes = document.querySelectorAll('#testimonialsList input[type="checkbox"]:checked');
    
    // Ubah jadi array berisi ID (angka)
    // parseInt() = ubah string jadi number
    const selectedIds = Array.from(checkboxes).map(cb => parseInt(cb.value));
    
    // Show loading state
    const saveBtn = document.getElementById('saveTestimonialsBtn');
    const saveIconCheck = document.getElementById('saveTestimonialsIconCheck');
    const saveIconLoading = document.getElementById('saveTestimonialsIconLoading');
    const saveButtonText = document.getElementById('saveTestimonialsButtonText');
    
    saveBtn.disabled = true;
    saveIconCheck.classList.add('hidden');
    saveIconLoading.classList.remove('hidden');
    saveButtonText.textContent = 'Saving...';

    // Prepare data untuk dikirim
    const formData = {
        pages_id: pageId,
        testimonials_title: title,
        testimonials_subtitle: subtitle,
        testimonials_style: style,
        // IMPORTANT: Kirim array langsung, JANGAN pakai JSON.stringify()
        // Laravel akan otomatis convert array ke JSON karena ada $casts
        section_testimoni_id: selectedIds,
        type: 'testimonials',
        sort_id: blockCounter
    };

    const url = shortcodeId 
        ? `/bagoosh/page-shortcode/update/${shortcodeId}`
        : '/bagoosh/page-shortcode/store';
    const method = shortcodeId ? 'PUT' : 'POST';

    // Kirim data ke server
    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const block = document.getElementById(currentEditBlockId);
            if (block && data.id) {
                block.dataset.shortcodeId = data.id;
                // Store selected testimonial IDs for future edits
                block.dataset.testimonialIds = JSON.stringify(selectedIds);
            }
            
            saveBtn.disabled = false;
            saveIconCheck.classList.remove('hidden');
            saveIconLoading.classList.add('hidden');
            saveButtonText.textContent = 'Save Changes';
            
            closeEditTestimonialsModal();
            alert('Testimonials saved successfully!');
        } else {
            alert('Failed to save testimonials');
            saveBtn.disabled = false;
            saveIconCheck.classList.remove('hidden');
            saveIconLoading.classList.add('hidden');
            saveButtonText.textContent = 'Save Changes';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while saving');
        saveBtn.disabled = false;
        saveIconCheck.classList.remove('hidden');
        saveIconLoading.classList.add('hidden');
        saveButtonText.textContent = 'Save Changes';
    });
}

/**
 * Menghapus testimonials block
 */
function deleteTestimonialsBlock() {
    if (!currentEditBlockId || !confirm('Are you sure?')) return;
    
    const shortcodeId = document.getElementById('testimonials_shortcode_id').value;
    const deleteBtn = document.getElementById('deleteTestimonialsBtn');
    const deleteIconTrash = document.getElementById('deleteTestimonialsIconTrash');
    const deleteIconLoading = document.getElementById('deleteTestimonialsIconLoading');
    const deleteButtonText = document.getElementById('deleteTestimonialsButtonText');
    
    deleteBtn.disabled = true;
    deleteIconTrash.classList.add('hidden');
    deleteIconLoading.classList.remove('hidden');
    deleteButtonText.textContent = 'Deleting...';
    
    const removeBlock = () => {
        closeModalWithTransition('editTestimonialsModal', () => {
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
            currentEditBlockId = null;
            alert('Testimonials deleted successfully!');
        });
    };
    
    if (shortcodeId) {
        fetch(`/bagoosh/page-shortcode/delete/${shortcodeId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) removeBlock();
            else alert('Error: ' + (data.message || 'Failed to delete'));
        })
        .catch(() => alert('Error deleting'));
    } else {
        removeBlock();
    }
}

// ===================================================================
// BAGIAN 20: RECENT PRODUCT FUNCTIONS
// ===================================================================

/**
 * Membuka modal edit recent product
 */
function openEditRecentProductModal() {
    const block = document.getElementById(currentEditBlockId);
    const shortcodeId = block?.dataset.shortcodeId || '';
    
    document.getElementById('recentproduct_shortcode_id').value = shortcodeId;
    
    // TODO: If there's saved data, fetch and populate
    
    document.getElementById('editRecentProductModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

/**
 * Menutup modal edit recent product
 */
function closeEditRecentProductModal() {
    closeModalWithTransition('editRecentProductModal', () => {
        currentEditBlockId = null;
    });
}

/**
 * Menyimpan recent product block ke database
 */
function saveRecentProductBlock() {
    const title = document.getElementById('recentproduct_title').value;
    const subtitle = document.getElementById('recentproduct_subtitle').value;
    const shortcodeId = document.getElementById('recentproduct_shortcode_id').value;
    const pageId = window.pageId;
    
    const saveBtn = document.getElementById('saveRecentProductBtn');
    const saveIconCheck = document.getElementById('saveRecentProductIconCheck');
    const saveIconLoading = document.getElementById('saveRecentProductIconLoading');
    const saveButtonText = document.getElementById('saveRecentProductButtonText');
    
    saveBtn.disabled = true;
    saveIconCheck.classList.add('hidden');
    saveIconLoading.classList.remove('hidden');
    saveButtonText.textContent = 'Saving...';

    const formData = {
        pages_id: pageId,
        product_title: title,
        product_subtitle: subtitle,
        type: 'recent-product',
        sort_id: blockCounter
    };

    const url = shortcodeId 
        ? `/bagoosh/page-shortcode/update/${shortcodeId}`
        : '/bagoosh/page-shortcode/store';
    const method = shortcodeId ? 'PUT' : 'POST';

    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const block = document.getElementById(currentEditBlockId);
            if (block && data.id) block.dataset.shortcodeId = data.id;
            
            saveBtn.disabled = false;
            saveIconCheck.classList.remove('hidden');
            saveIconLoading.classList.add('hidden');
            saveButtonText.textContent = 'Save Changes';
            
            closeEditRecentProductModal();
            alert('Recent product block saved successfully!');
        } else {
            alert('Failed to save');
            saveBtn.disabled = false;
            saveIconCheck.classList.remove('hidden');
            saveIconLoading.classList.add('hidden');
            saveButtonText.textContent = 'Save Changes';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error saving');
        saveBtn.disabled = false;
        saveIconCheck.classList.remove('hidden');
        saveIconLoading.classList.add('hidden');
        saveButtonText.textContent = 'Save Changes';
    });
}

/**
 * Menghapus recent product block
 */
function deleteRecentProductBlock() {
    if (!currentEditBlockId || !confirm('Are you sure?')) return;
    
    const shortcodeId = document.getElementById('recentproduct_shortcode_id').value;
    const deleteBtn = document.getElementById('deleteRecentProductBtn');
    const deleteIconTrash = document.getElementById('deleteRecentProductIconTrash');
    const deleteIconLoading = document.getElementById('deleteRecentProductIconLoading');
    const deleteButtonText = document.getElementById('deleteRecentProductButtonText');
    
    deleteBtn.disabled = true;
    deleteIconTrash.classList.add('hidden');
    deleteIconLoading.classList.remove('hidden');
    deleteButtonText.textContent = 'Deleting...';
    
    const removeBlock = () => {
        closeModalWithTransition('editRecentProductModal', () => {
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
            currentEditBlockId = null;
            alert('Recent product deleted successfully!');
        });
    };
    
    if (shortcodeId) {
        fetch(`/bagoosh/page-shortcode/delete/${shortcodeId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) removeBlock();
            else alert('Error: ' + (data.message || 'Failed to delete'));
        })
        .catch(() => alert('Error deleting'));
    } else {
        removeBlock();
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
function openEditFeaturedServicesModal(blockId) {
    currentEditBlockId = blockId;
    
    const block = document.getElementById(blockId);
    if (!block) return;
    
    const style = block?.dataset.style || '1';
    const shortcodeId = block?.dataset.shortcodeId || '';
    
    // Ambil selected service IDs kalau ada (stored sebagai JSON di dataset)
    let selectedServiceIds = [];
    if (block?.dataset.serviceIds) {
        try {
            selectedServiceIds = JSON.parse(block.dataset.serviceIds);
        } catch (e) {
            console.error('Error parsing service IDs:', e);
        }
    }
    
    document.getElementById('serviceStyle').value = style;
    document.getElementById('serviceStyleDisplay').value = `Style ${style}`;
    
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
function saveFeaturedServicesBlock() {
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
    
    const saveBtn = document.getElementById('saveFeaturedServicesBtn');
    const saveIcon = document.getElementById('saveFeaturedServicesIcon');
    const saveLoading = document.getElementById('saveFeaturedServicesLoading');
    const saveText = document.getElementById('saveFeaturedServicesText');
    
    saveBtn.disabled = true;
    saveIcon.classList.add('hidden');
    saveLoading.classList.remove('hidden');
    saveText.textContent = 'Saving...';
    
    const formData = {
        pages_id: pageId,
        service_style: style,
        section_service_id: selectedIds,
        type: 'service',
        sort_id: blockCounter
    };
    
    const url = shortcodeId 
        ? `/bagoosh/page-shortcode/update/${shortcodeId}`
        : '/bagoosh/page-shortcode/store';
    const method = shortcodeId ? 'PUT' : 'POST';
    
    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Store shortcode ID dan selected service IDs di block dataset
            if (block && data.shortcode_id) {
                block.dataset.shortcodeId = data.shortcode_id;
                block.dataset.serviceIds = JSON.stringify(selectedIds);
            }
            
            closeEditFeaturedServicesModal();
            alert('Featured Services saved successfully!');
        } else {
            alert('Failed to save featured services');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error saving featured services');
    })
    .finally(() => {
        saveBtn.disabled = false;
        saveIcon.classList.remove('hidden');
        saveLoading.classList.add('hidden');
        saveText.textContent = 'Save';
    });
}

/**
 * Menghapus featured services block
 */
function deleteFeaturedServicesBlock() {
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
    
    const removeBlock = () => {
        block.remove();
        checkEmptyState();
        updateBlockOrder();
        closeEditFeaturedServicesModal();
    };
    
    if (shortcodeId) {
        fetch(`/bagoosh/page-shortcode/delete/${shortcodeId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                removeBlock();
                alert('Featured Services deleted successfully!');
            } else {
                alert('Error deleting from database, but block will be removed from UI');
                removeBlock();
            }
        })
        .catch(() => {
            alert('Error deleting from database, but block will be removed from UI');
            removeBlock();
        })
        .finally(() => {
            deleteBtn.disabled = false;
            deleteIcon.classList.remove('hidden');
            deleteLoading.classList.add('hidden');
            deleteText.textContent = 'Delete';
        });
    } else {
        removeBlock();
    }
}

// ===================================================================
// BAGIAN 22: NEWSLETTER FUNCTIONS
// ===================================================================

/**
 * Membuka modal edit newsletter
 */
function openEditNewsletterModal(blockId) {
    currentEditBlockId = blockId;
    
    const block = document.getElementById(blockId);
    if (!block) return;
    
    const shortcodeId = block?.dataset.shortcodeId || '';
    const newsletterId = block?.dataset.newsletterId || '';
    
    // Fetch daftar newsletter dari server
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
function saveNewsletterBlock() {
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
    
    // Extract sort_id dari block ID (block-1, block-2, etc)
    // blockCounter adalah angka yang digunakan saat block dibuat
    const sortId = parseInt(currentEditBlockId.replace('block-', ''));
    
    console.log('📊 Sort ID calculation:', {
        blockId: currentEditBlockId,
        extractedSortId: sortId,
        currentBlockCounter: blockCounter
    });
    
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
            
            // Update block dengan shortcode ID dari server
            // PENTING: Server harus return 'id' atau 'shortcode_id'
            const savedId = data.id || data.shortcode_id;
            
            if (savedId && block) {
                // dataset.shortcodeId = set attribute data-shortcode-id
                block.dataset.shortcodeId = savedId;
                block.dataset.newsletterId = newsletterId;
                console.log('✅ Block updated with shortcode ID:', savedId);
                console.log('✅ Newsletter ID stored:', newsletterId);
            } else {
                console.warn('⚠️ No ID returned from server!', data);
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
function deleteNewsletterBlock() {
    // FASE 1: VALIDASI & KONFIRMASI
    // ==============================
    
    // Cek apakah ada block yang sedang di-edit
    // || = operator OR
    // !currentEditBlockId = jika currentEditBlockId kosong/null
    // !confirm(...) = jika user klik Cancel
    if (!currentEditBlockId || !confirm('Are you sure you want to delete this newsletter block?')) {
        return;  // Keluar dari function
    }
    
    console.log('🗑️ Deleting newsletter block:', currentEditBlockId);
    
    // FASE 2: LOADING STATE
    // =====================
    
    // Ambil element-element untuk loading state
    const deleteBtn = document.getElementById('deleteNewsletterBtn');
    const deleteIcon = document.getElementById('deleteNewsletterIcon');
    const deleteLoading = document.getElementById('deleteNewsletterLoading');
    const deleteText = document.getElementById('deleteNewsletterText');
    
    // Show loading state
    deleteBtn.disabled = true;
    deleteIcon.classList.add('hidden');
    deleteLoading.classList.remove('hidden');
    deleteText.textContent = 'Deleting...';
    
    // FASE 3: CEK SHORTCODE ID
    // ========================
    
    // Ambil block element
    const block = document.getElementById(currentEditBlockId);
    
    // Ambil shortcode ID (kalau ada berarti sudah disave di database)
    const shortcodeId = block?.dataset.shortcodeId || '';
    
    console.log('📋 Block element:', block);
    console.log('📋 All dataset:', block?.dataset);
    console.log('📋 Shortcode ID:', shortcodeId);
    console.log('📋 Has shortcode?', shortcodeId ? 'YES - Will delete from database' : 'NO - Only remove from UI');
    
    // FASE 4: HELPER FUNCTION UNTUK REMOVE UI
    // ========================================
    
    /**
     * Helper function untuk menghapus block dari tampilan
     * Function ini dipanggil setelah berhasil hapus dari database
     * atau kalau block belum pernah disave
     */
    const removeBlockFromUI = () => {
        // Tutup modal dengan animasi
        closeModalWithTransition('editNewsletterModal', () => {
            // Ambil block element (double-check)
            const blockElement = document.getElementById(currentEditBlockId);
            
            if (blockElement) {
                // Fade out animation
                // transition = durasi animasi CSS
                blockElement.style.transition = 'opacity 300ms';
                blockElement.style.opacity = '0';  // Buat transparan
                
                // Tunggu animasi selesai, baru remove dari DOM
                setTimeout(() => {
                    // .remove() = hapus element dari HTML
                    blockElement.remove();
                    
                    // Cek apakah list jadi kosong
                    // Kalau kosong, tampilkan empty state
                    checkEmptyState();
                    
                    // Update nomor urutan blocks yang tersisa
                    updateBlockOrder();
                    
                    console.log('✅ Block removed from UI');
                }, 300);  // 300ms = sama dengan durasi transition
            }
            
            // Reset currentEditBlockId
            currentEditBlockId = null;
            
            // Tampilkan success message
            alert('Newsletter block deleted successfully! 🗑️');
        });
    };
    
    // FASE 5: DELETE LOGIC
    // ====================
    
    // Cek apakah block sudah pernah disave (punya shortcodeId)
    if (shortcodeId) {
        // SUDAH DISAVE → Hapus dari database dulu
        console.log('📡 Sending DELETE request to server...');
        
        fetch(`/bagoosh/page-shortcode/delete/${shortcodeId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log('📨 Delete response:', data);
            
            if (data.success) {
                // Berhasil hapus dari database
                // Sekarang hapus dari UI
                console.log('✅ Deleted from database');
                removeBlockFromUI();
            } else {
                // Gagal hapus dari database
                const errorMsg = data.message || 'Failed to delete';
                alert('Error: ' + errorMsg);
                console.error('❌ Delete failed:', errorMsg);
                
                // Reset button state
                deleteBtn.disabled = false;
                deleteIcon.classList.remove('hidden');
                deleteLoading.classList.add('hidden');
                deleteText.textContent = 'Delete';
            }
        })
        .catch(error => {
            console.error('❌ Network error:', error);
            alert('Network error! Please try again.');
            
            // Reset button state
            deleteBtn.disabled = false;
            deleteIcon.classList.remove('hidden');
            deleteLoading.classList.add('hidden');
            deleteText.textContent = 'Delete';
        });
    } else {
        // BELUM DISAVE → Langsung hapus dari UI
        console.log('ℹ️ Block not saved yet, removing from UI only');
        removeBlockFromUI();
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

// Simpan slug original (untuk page yang sudah ada)
// Agar tidak berubah-ubah saat edit title
const originalSlug = slugInput?.value || '';

// Event listener untuk input title
titleInput?.addEventListener('input', function() {
    // Jika slug masih original atau kosong, generate slug baru
    if (!originalSlug || slugInput.value === '' || slugInput.value === originalSlug) {
        // generateSlug() = function untuk ubah text jadi slug
        slugInput.value = generateSlug(this.value);
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
function openEditLatestNewsModal(blockId) {
    console.log('Opening Latest News modal for block:', blockId);
    
    const block = document.querySelector(`[data-block-id="${blockId}"]`);
    if (!block) {
        console.error('Block not found:', blockId);
        return;
    }
    
    // Set current block ID
    currentEditBlockId = blockId;
    
    // Ambil data dari block dataset
    const title = block.dataset.title || '';
    const blogLimit = block.dataset.blogLimit || '4';
    
    console.log('Block data:', { title, blogLimit });
    
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
function saveLatestNewsBlock() {
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
    
    // Ambil block element dan data
    const block = document.querySelector(`[data-block-id="${currentEditBlockId}"]`);
    if (!block) {
        console.error('Block not found:', currentEditBlockId);
        return;
    }
    
    const style = block.dataset.style;
    const shortcodeId = block.dataset.shortcodeId || null;
    
    console.log('Form data:', { title, blogLimit, style, shortcodeId });
    
    // Tampilkan loading state
    document.getElementById('latestNewsLoadingState').classList.remove('hidden');
    document.getElementById('latestNewsFormContent').classList.add('hidden');
    
    // Siapkan data untuk dikirim ke server
    const formData = {
        pages_id: window.pageId,
        type: 'latestnews',
        latestnews_title: title,
        blog_limit: blogLimit,
        latestnews_style: style,
        sort_id: Array.from(document.querySelectorAll('.block-item')).indexOf(block) + 1
    };
    
    console.log('Sending data to server:', formData);
    
    // Tentukan URL dan method berdasarkan apakah update atau create
    const url = shortcodeId 
        ? `/bagoosh/page-shortcode/update/${shortcodeId}`
        : '/bagoosh/page-shortcode/store';
    const method = shortcodeId ? 'PUT' : 'POST';
    
    // Kirim request ke server
    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        console.log('Save response:', data);
        
        if (data.success) {
            // Simpan ID shortcode ke block dataset
            const savedId = data.id || data.shortcode_id;
            if (savedId && block) {
                block.dataset.shortcodeId = savedId;
                block.dataset.title = title;
                block.dataset.blogLimit = blogLimit;
                console.log('✅ Block updated with shortcode ID:', savedId);
                console.log('✅ Title:', title);
                console.log('✅ Blog limit:', blogLimit);
            } else {
                console.warn('⚠️ No ID returned from server!', data);
            }
            
            // Tutup modal
            closeEditLatestNewsModal();
            
            // Tampilkan notifikasi sukses
            alert('Latest News block saved successfully!');
        } else {
            throw new Error(data.message || 'Failed to save');
        }
    })
    .catch(error => {
        console.error('Save error:', error);
        alert('Error saving Latest News block: ' + error.message);
    })
    .finally(() => {
        // Sembunyikan loading state
        document.getElementById('latestNewsLoadingState').classList.add('hidden');
        document.getElementById('latestNewsFormContent').classList.remove('hidden');
    });
}

/**
 * Menghapus latest news block
 */
function deleteLatestNewsBlock() {
    console.log('Deleting Latest News block...');
    
    if (!currentEditBlockId) {
        console.error('No block selected for deletion');
        return;
    }
    
    // Konfirmasi penghapusan
    if (!confirm('Are you sure you want to delete this Latest News block?')) {
        return;
    }
    
    const block = document.querySelector(`[data-block-id="${currentEditBlockId}"]`);
    const shortcodeId = block?.dataset.shortcodeId;
    
    console.log('📋 Block element:', block);
    console.log('📋 All dataset:', block?.dataset);
    console.log('📋 Shortcode ID:', shortcodeId);
    console.log('📋 Has shortcode?', shortcodeId ? 'YES - Will delete from database' : 'NO - Only remove from UI');
    
    // Jika block sudah tersimpan di database, hapus dari database dulu
    if (shortcodeId) {
        console.log('📡 Sending DELETE request to server...');
        
        fetch(`/bagoosh/page-shortcode/delete/${shortcodeId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log('📨 Delete response:', data);
            
            if (data.success) {
                console.log('✅ Successfully deleted from database');
                // Hapus block dari UI
                block?.remove();
                closeEditLatestNewsModal();
                checkEmptyState();
                updateBlockOrder();
                alert('Latest News block deleted successfully!');
            } else {
                throw new Error(data.message || 'Failed to delete');
            }
        })
        .catch(error => {
            console.error('❌ Delete error:', error);
            alert('Error deleting Latest News block: ' + error.message);
        });
    } else {
        // Jika belum tersimpan, langsung hapus dari UI
        console.log('ℹ️ Block not saved yet, removing from UI only');
        block?.remove();
        closeEditLatestNewsModal();
        checkEmptyState();
        updateBlockOrder();
    }
}

// ===================================================================
// BAGIAN 31: CONTACT FUNCTIONS
// ===================================================================

/**
 * Membuka modal edit contact
 */
function openEditContactModal(blockId) {
    console.log('Opening Contact modal for block:', blockId);
    
    let block = document.getElementById(blockId);
    if (!block) {
        block = document.querySelector(`[data-block-id="${blockId}"]`);
    }
    
    if (!block) {
        console.error('Block not found:', blockId);
        return;
    }
    
    // Set current block ID
    currentEditBlockId = blockId;
    
    // Ambil data dari block dataset
    const title = block.dataset.contactTitle || '';
    const subtitle = block.dataset.contactSubtitle || '';
    let selectedContactIds = [];
    
    try {
        if (block.dataset.contactIds) {
            selectedContactIds = JSON.parse(block.dataset.contactIds);
        }
    } catch (e) {
        console.error('Error parsing contact IDs:', e);
    }
    
    console.log('Block data:', { title, subtitle, selectedContactIds });
    
    // Set nilai ke form
    document.getElementById('contactTitle').value = title;
    document.getElementById('contactSubtitle').value = subtitle;
    
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
function saveContactBlock() {
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
    
    console.log('Form data:', { title, subtitle, selectedContactIds, shortcodeId });
    
    // Tampilkan loading state
    document.getElementById('contactLoadingState').classList.remove('hidden');
    document.getElementById('contactFormContent').classList.add('hidden');
    
    // Siapkan data untuk dikirim ke server
    const formData = {
        pages_id: window.pageId,
        type: 'contact',
        contact_title_1: title,
        contact_subtitle: subtitle,
        contact_id: selectedContactIds, // Laravel akan convert ke JSON
        sort_id: Array.from(document.querySelectorAll('.block-item')).indexOf(block) + 1
    };
    
    console.log('Sending data to server:', formData);
    
    // Tentukan URL dan method
    const url = shortcodeId 
        ? `/bagoosh/page-shortcode/update/${shortcodeId}`
        : '/bagoosh/page-shortcode/store';
    const method = shortcodeId ? 'PUT' : 'POST';
    
    // Kirim request ke server
    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        console.log('Save response:', data);
        
        if (data.success) {
            // Simpan data ke block dataset
            const savedId = data.id || data.shortcode_id;
            if (savedId && block) {
                block.dataset.shortcodeId = savedId;
                block.dataset.contactTitle = title;
                block.dataset.contactSubtitle = subtitle;
                block.dataset.contactIds = JSON.stringify(selectedContactIds);
                console.log('✅ Block updated with shortcode ID:', savedId);
                console.log('✅ Selected contacts:', selectedContactIds);
            } else {
                console.warn('⚠️ No ID returned from server!', data);
            }
            
            // Tutup modal
            closeEditContactModal();
            
            // Tampilkan notifikasi sukses
            alert('Contact block saved successfully!');
        } else {
            throw new Error(data.message || 'Failed to save');
        }
    })
    .catch(error => {
        console.error('Save error:', error);
        alert('Error saving Contact block: ' + error.message);
    })
    .finally(() => {
        // Sembunyikan loading state
        document.getElementById('contactLoadingState').classList.add('hidden');
        document.getElementById('contactFormContent').classList.remove('hidden');
    });
}

/**
 * Menghapus contact block
 */
function deleteContactBlock() {
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
    
    const shortcodeId = block?.dataset.shortcodeId;
    
    console.log('📋 Block element:', block);
    console.log('📋 Shortcode ID:', shortcodeId);
    
    // Jika block sudah tersimpan di database, hapus dari database dulu
    if (shortcodeId) {
        console.log('📡 Sending DELETE request to server...');
        
        fetch(`/bagoosh/page-shortcode/delete/${shortcodeId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log('📨 Delete response:', data);
            
            if (data.success) {
                console.log('✅ Successfully deleted from database');
                // Hapus block dari UI
                block?.remove();
                closeEditContactModal();
                checkEmptyState();
                updateBlockOrder();
                alert('Contact block deleted successfully!');
            } else {
                throw new Error(data.message || 'Failed to delete');
            }
        })
        .catch(error => {
            console.error('❌ Delete error:', error);
            alert('Error deleting Contact block: ' + error.message);
        });
    } else {
        // Jika belum tersimpan, langsung hapus dari UI
        console.log('ℹ️ Block not saved yet, removing from UI only');
        block?.remove();
        closeEditContactModal();
        checkEmptyState();
        updateBlockOrder();
    }
}

// ===================================================================
// END OF FILE
// ===================================================================
