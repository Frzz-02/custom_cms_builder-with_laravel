/**
 * ===================================================================
 * HERO BANNER MEDIA PICKER INTEGRATION
 * ===================================================================
 * File ini menghubungkan media picker dengan hero banner form
 * Menangkap event dari media picker dan update form fields
 */

// Initialize global object untuk hero banner images
if (!window.heroBannerImages) {
    window.heroBannerImages = {};
}

/**
 * Tangkap event dari media picker saat gambar dipilih
 * Event ini di-trigger dari media-picker-input.blade.php
 */
window.addEventListener('media-selected', (event) => {
    const fieldId = event.detail.fieldId;
    const url = event.detail.url;
    
    console.log(`🖼️ Media selected for field: ${fieldId}`, url);
    
    // Update media picker input field dengan URL yang dipilih
    const inputField = document.getElementById(fieldId);
    if (inputField) {
        inputField.value = url;
        
        // Trigger change event untuk preview
        inputField.dispatchEvent(new Event('change', { bubbles: true }));
        console.log(`✅ Updated input field ${fieldId}`);
    }
    
    // Update global image cache untuk hero banner (format: heroImage1, heroImage2, etc)
    if (fieldId.startsWith('heroImage')) {
        const tabNumber = fieldId.replace('heroImage', '');
        window.heroBannerImages[`tab${tabNumber}`] = url;
        console.log(`✅ Updated hero banner image cache tab${tabNumber}:`, url);
        
        // Update preview image jika ada
        const previewContainer = document.getElementById(`heroImagePreview${tabNumber}`);
        if (previewContainer) {
            const img = previewContainer.querySelector('img');
            if (img) {
                img.src = url;
                previewContainer.classList.remove('hidden');
                console.log(`✅ Updated preview image for heroImagePreview${tabNumber}`);
            }
        }
    }
});

/**
 * Support manual URL input pada field heroImage1..heroImage6
 */
document.addEventListener('input', (event) => {
    const input = event.target;
    if (!(input instanceof HTMLInputElement)) return;
    if (!input.id || !input.id.startsWith('heroImage')) return;

    const tabNumber = input.id.replace('heroImage', '');
    if (!tabNumber) return;

    window.heroBannerImages[`tab${tabNumber}`] = (input.value || '').trim();
});

/**
 * Setup media picker untuk hero banner form saat form dibuka
 * Ini memastikan initial value di-set dengan benar saat form di-populate
 */
function setupHeroBannerMediaPickers() {
    for (let i = 1; i <= 6; i++) {
        const inputField = document.getElementById(`heroImage${i}`);
        if (inputField && inputField.value) {
            // Store ke global cache
            window.heroBannerImages[`tab${i}`] = inputField.value;
            console.log(`✅ Setup media picker - Stored tab${i} initial value:`, inputField.value);
        }
    }
}

/**
 * Reset semua hero banner images saat form ditutup
 */
function resetHeroBannerImages() {
    window.heroBannerImages = {};
    console.log('🔄 Reset hero banner images cache');
}

// Export functions
window.setupHeroBannerMediaPickers = setupHeroBannerMediaPickers;
window.resetHeroBannerImages = resetHeroBannerImages;
