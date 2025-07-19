// File: public/js/validation-modal.js
// Universal validation modal for all forms

class ValidationModal {
    constructor() {
        this.createModal();
        this.bindEvents();
    }

    createModal() {
        // Create modal HTML
        const modalHTML = `
        <div class="modal fade" id="validationModal" tabindex="-1" aria-labelledby="validationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.15);">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-bold text-primary" id="validationModalLabel">
                            <i class="fas fa-shield-check me-2"></i>Konfirmasi Data
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-2">
                        <div class="text-center mb-3">
                            <div class="validation-icon bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-clipboard-check text-primary fs-4"></i>
                            </div>
                        </div>
                        <h6 class="text-center fw-bold mb-3" id="validationTitle">Periksa Data Sebelum Menyimpan</h6>
                        <div id="validationContent" class="bg-light rounded p-3">
                            <!-- Content akan diisi dinamis -->
                        </div>
                        <div class="mt-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="confirmDataAccuracy">
                                <label class="form-check-label small text-muted" for="confirmDataAccuracy">
                                    Saya telah memeriksa dan memastikan data yang dimasukkan sudah benar
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Batal
                        </button>
                        <button type="button" class="btn btn-primary" id="confirmSubmit" disabled>
                            <i class="fas fa-save me-2"></i>Ya, Simpan Data
                        </button>
                    </div>
                </div>
            </div>
        </div>`;

        // Add modal to body if not exists
        if (!document.getElementById('validationModal')) {
            document.body.insertAdjacentHTML('beforeend', modalHTML);
        }
    }

    bindEvents() {
        // Enable/disable confirm button based on checkbox
        document.addEventListener('change', (e) => {
            if (e.target.id === 'confirmDataAccuracy') {
                const confirmBtn = document.getElementById('confirmSubmit');
                confirmBtn.disabled = !e.target.checked;
            }
        });

        // Handle form submissions
        document.addEventListener('submit', (e) => {
            const form = e.target;
            
            // Skip if form has data-skip-validation attribute
            if (form.hasAttribute('data-skip-validation')) {
                return;
            }

            // Only intercept forms with specific patterns
            const formAction = form.action;
            const shouldValidate = formAction.includes('/store') || 
                                 formAction.includes('/create') || 
                                 form.classList.contains('needs-validation-modal');

            if (shouldValidate) {
                e.preventDefault();
                this.showValidationModal(form);
            }
        });
    }

    showValidationModal(form) {
        const formData = new FormData(form);
        const formType = this.detectFormType(form);
        
        // Update modal content
        document.getElementById('validationTitle').textContent = `Konfirmasi Data ${formType}`;
        document.getElementById('validationContent').innerHTML = this.generateValidationContent(formData, formType);
        
        // Reset checkbox
        document.getElementById('confirmDataAccuracy').checked = false;
        document.getElementById('confirmSubmit').disabled = true;

        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('validationModal'));
        modal.show();

        // Handle confirm button
        document.getElementById('confirmSubmit').onclick = () => {
            modal.hide();
            this.submitForm(form);
        };
    }

    detectFormType(form) {
        const action = form.action.toLowerCase();
        
        if (action.includes('user')) return 'User';
        if (action.includes('siswa')) return 'Siswa';
        if (action.includes('kriteria')) return 'Kriteria';
        if (action.includes('penilaian')) return 'Penilaian';
        
        return 'Data';
    }

    generateValidationContent(formData, formType) {
        let content = '<div class="row g-2">';
        
        // Define field mappings for different form types
        const fieldMappings = {
            'User': {
                'name': 'Nama Lengkap',
                'email': 'Email',
                'role': 'Role',
                'nip': 'NIP',
                'telepon': 'Telepon'
            },
            'Siswa': {
                'kode': 'Kode Siswa',
                'nama': 'Nama Lengkap',
                'jenis_kelamin': 'Jenis Kelamin',
                'tanggal_lahir': 'Tanggal Lahir',
                'nama_orang_tua': 'Nama Orang Tua'
            },
            'Kriteria': {
                'kode': 'Kode Kriteria',
                'nama': 'Nama Kriteria',
                'tren': 'Tren',
                'bobot': 'Bobot',
                'keterangan': 'Keterangan'
            },
            'Penilaian': {
                'siswa_id': 'Siswa',
                'kriteria_id': 'Kriteria',
                'nilai_mentah': 'Nilai Mentah'
            }
        };

        const fields = fieldMappings[formType] || {};
        let itemCount = 0;

        for (const [key, value] of formData.entries()) {
            if (fields[key] && value && !key.includes('password') && !key.includes('_token')) {
                let displayValue = value;
                
                // Special handling for select fields
                if (key === 'siswa_id') {
                    const select = document.querySelector(`select[name="${key}"]`);
                    displayValue = select ? select.options[select.selectedIndex].text : value;
                } else if (key === 'kriteria_id') {
                    const select = document.querySelector(`select[name="${key}"]`);
                    displayValue = select ? select.options[select.selectedIndex].text : value;
                } else if (key === 'bobot') {
                    displayValue = (parseFloat(value) * 100).toFixed(1) + '%';
                }

                content += `
                <div class="col-6">
                    <div class="border rounded p-2 bg-white">
                        <small class="text-muted fw-bold d-block">${fields[key]}</small>
                        <span class="small">${displayValue}</span>
                    </div>
                </div>`;
                itemCount++;
            }
        }

        if (itemCount === 0) {
            content += '<div class="col-12 text-center text-muted">Tidak ada data untuk ditampilkan</div>';
        }

        content += '</div>';
        
        // Add warning message
        content += `
        <div class="alert alert-warning alert-sm mt-3 mb-0">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <small>Pastikan semua data sudah benar sebelum menyimpan. Data yang sudah disimpan akan mempengaruhi perhitungan CPI.</small>
        </div>`;

        return content;
    }

    submitForm(form) {
        // Add loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            const originalHTML = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';

            // Restore button after timeout as fallback
            setTimeout(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalHTML;
            }, 10000);
        }

        // Submit form with skip validation attribute
        form.setAttribute('data-skip-validation', 'true');
        form.submit();
    }
}

// Initialize validation modal when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new ValidationModal();
});

// Additional utility functions for custom validations
function showCustomValidation(title, data, callback) {
    const modal = document.getElementById('validationModal');
    if (modal) {
        document.getElementById('validationTitle').textContent = title;
        document.getElementById('validationContent').innerHTML = data;
        document.getElementById('confirmDataAccuracy').checked = false;
        document.getElementById('confirmSubmit').disabled = true;
        
        const bsModal = new bootstrap.Modal(modal);
        bsModal.show();
        
        document.getElementById('confirmSubmit').onclick = () => {
            bsModal.hide();
            if (callback) callback();
        };
    }
}

// CSS for modal styling
const validationModalCSS = `
<style>
.validation-modal .modal-content {
    border-radius: 12px;
    border: none;
    box-shadow: 0 10px 40px rgba(0,0,0,0.15);
}

.validation-icon {
    transition: all 0.3s ease;
}

.validation-icon:hover {
    transform: scale(1.1);
}

.alert-sm {
    padding: 8px 12px;
    font-size: 12px;
}

.alert-sm .fas {
    font-size: 11px;
}

.form-check-input:checked {
    background-color: var(--primary-color, #3b82f6);
    border-color: var(--primary-color, #3b82f6);
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.modal.show .modal-dialog {
    animation: modalSlideIn 0.3s ease-out;
}
</style>`;

// Inject CSS if not already present
if (!document.getElementById('validation-modal-css')) {
    const styleElement = document.createElement('div');
    styleElement.id = 'validation-modal-css';
    styleElement.innerHTML = validationModalCSS;
    document.head.appendChild(styleElement);
}