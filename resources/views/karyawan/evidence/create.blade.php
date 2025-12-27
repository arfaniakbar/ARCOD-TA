<x-karyawan-layout>
    <head>
        {{-- Memuat file CSS dan JS Dropzone --}}
        <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
        <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    </head>

    <style>
        /* Gaya umum (Tailwind like utilities) */
        .card { background-color: #fff; padding: 24px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .card-header { font-size: 1.25rem; font-weight: 600; color: #1f2937; border-bottom: 1px solid #e5e7eb; padding-bottom: 16px; margin-bottom: 24px; }
        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 500; color: #374151; }
        .form-group input, .form-group textarea, .form-group select { 
            width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; box-sizing: border-box; 
        }
        .btn-submit { display: block; width: 100%; padding: 0.875rem; border: none; border-radius: 8px; background-color: #dc2626; color: white; font-weight: 600; cursor: pointer; transition: background-color 0.2s; }
        .btn-submit:disabled { background-color: #fca5a5; cursor: not-allowed; }
        .alert { padding: 1rem; border-radius: 8px; font-weight: 500; margin-bottom: 1.5rem; }
        .alert-danger { background-color: #fee2e2; color: #991b1b; border: 1px solid #f87171; white-space: pre-line; }
        .alert-success { background-color: #dcfce7; color: #166534; border: 1px solid #86efac; }
        
        /* Dropzone Styling */
        .dropzone { border: 2px dashed #dc2626; border-radius: 12px; background: #fee2e2; padding: 15px; transition: all 0.3s; min-height: 150px; display: flex; flex-wrap: wrap; justify-content: center; align-items: center; }
        .dropzone .dz-message { color: #b91c1c; }
        .dropzone .dz-preview { background: #fff; border-radius: 14px; border: 1px solid #e5e7eb; padding: 12px; margin: 12px; width: 220px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); display: flex; flex-direction: column; align-items: center; position: relative; }
        .dropzone .dz-preview .dz-image { width: 100%; height: 140px; margin-bottom: 10px; }
        .dropzone .dz-preview .dz-image img { width: 100%; height: 100%; object-fit: cover; border-radius: 12px; }
        .caption-input { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 8px; background: #f9fafb; text-align: center; font-size: 0.85rem; color: #1f2937; margin-bottom: 10px; }
        .remove-btn { position: absolute; top: -10px; right: -10px; background: #ef4444; color: white; border: none; border-radius: 50%; width: 28px; height: 28px; font-weight: bold; cursor: pointer; }
    </style>

    <div class="card">
        <h2 class="card-header">Upload Evidence</h2>
        
        <div id="notification-area" style="display: none;"></div>

        <form 
            action="{{ route('karyawan.evidence.store') }}" 
            id="evidence-form" 
            method="POST" 
            enctype="multipart/form-data">
            
            @csrf

            <div class="form-group">
                <label for="lokasi">Masukkan Lokasi Anda</label>
                <input type="text" id="lokasi" name="lokasi" placeholder="Contoh: Telkom STO Banjarmasin" required>
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi Umum (Opsional)</label>
                <textarea id="deskripsi" name="deskripsi" rows="3" placeholder="Deskripsi umum atau catatan tambahan..."></textarea>
            </div>
            
            {{-- START: DROPDOWN MASTER DATA (SEMUA WAJIB) --}}
            
            {{-- Pangwas (WAJIB) --}}
            <div class="form-group">
                <label for="pangwas_id">Pilih Waspang (Waspang)</label>
                <select id="pangwas_id" name="pangwas_id" class="form-group select" required>
                    <option value="">-- Pilih Waspang --</option>
                    @foreach ($pangwas_list as $pangwas)
                        <option value="{{ $pangwas->id }}">{{ $pangwas->nama_pangwas }}</option>
                    @endforeach
                </select>
            </div>
            
            {{-- Tematik (Wajib) --}}
            <div class="form-group">
                <label for="tematik_id">Pilih Tematik</label>
                <select id="tematik_id" name="tematik_id" class="form-group select" required>
                    <option value="">-- Pilih Tematik --</option>
                    @foreach ($tematik_list as $tematik)
                        <option value="{{ $tematik->id }}">{{ $tematik->nama_tematik }}</option>
                    @endforeach
                </select>
            </div>
            
            {{-- Purchase Order (PO) (Wajib) --}}
            <div class="form-group">
                <label for="po_id">Nomor Purchase Order (PO)</label>
                <select id="po_id" name="po_id" class="form-group select" required>
                    <option value="">-- Pilih Nomor PO --</option>
                    @foreach ($po_list as $po)
                        <option value="{{ $po->id }}">{{ $po->no_po }}</option>
                    @endforeach
                </select>
            </div>
            
            {{-- END: DROPDOWN MASTER DATA --}}


            <div class="form-group">
                <label>File Evidence</label>
                <div id="evidence-dropzone" class="dropzone">
                    <div class="dz-message" data-dz-message><span>Seret foto/folder ke sini atau klik untuk memilih | Max 1000 file @ 50MB per file</span></div>
                </div>
            </div>

            <button type="button" id="submit-button" class="btn-submit" style="margin-top: 1rem;">Upload Evidence</button>
        </form>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            
            if (document.querySelector("#evidence-dropzone").dropzone) {
                Dropzone.forElement("#evidence-dropzone").destroy();
            }

            const previewTemplate = `
                <div class="dz-preview dz-file-preview">
                    <div class="dz-image"><img data-dz-thumbnail /></div>
                    <input type="text" name="caption[]" class="caption-input" placeholder="Deskripsi foto (opsional)...">
                    <button type="button" data-dz-remove class="remove-btn">X</button>
                    <div class="dz-error-message"><span data-dz-errormessage></span></div>
                </div>
            `;

            Dropzone.autoDiscover = false;
            let myDropzone = new Dropzone("#evidence-dropzone", { 
                url: "{{ route('karyawan.evidence.store') }}",
                paramName: "file",
                autoProcessQueue: false,
                uploadMultiple: true,
                parallelUploads: 10, // Upload 10 files at a time
                maxFiles: 1000, // Max 1000 files (very high limit)
                maxFilesize: 50, // 50MB per file (reasonable for images)
                acceptedFiles: 'image/*',
                addRemoveLinks: false,
                previewTemplate: previewTemplate,
                timeout: 300000, // 5 minutes timeout
                
                init: function() {
                    const self = this;
                    const form = document.querySelector("#evidence-form");
                    const submitButton = document.querySelector("#submit-button");
                    const notificationArea = document.querySelector("#notification-area");
                    
                    let folderName = null; 

                    // --- LOGIKA DETEKSI FOLDER DROP ---
                    const dropzoneElement = document.getElementById('evidence-dropzone');

                    dropzoneElement.addEventListener('drop', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        folderName = null; 

                        if (e.dataTransfer.items && e.dataTransfer.items.length > 0) {
                            const item = e.dataTransfer.items[0];
                            if (item.webkitGetAsEntry) { 
                                const entry = item.webkitGetAsEntry();
                                
                                if (entry && entry.isDirectory) {
                                    folderName = entry.name;
                                }
                            }
                        }
                    });
                    
                    // --- LOGIKA UTAMA: MENGISI CAPTION ---
                    this.on("addedfile", function(file) {
                        let captionInput = file.previewElement.querySelector('.caption-input');
                        
                        if (captionInput) {
                            let fileName = file.name;
                            let baseName = fileName.replace(/\.[^/.]+$/, ""); 
                            let finalCaption = baseName;

                            // Jika ada folder path dari browser
                            if (file.fullPath) {
                                finalCaption = file.fullPath;
                            } else if (file.webkitRelativePath) {
                                finalCaption = file.webkitRelativePath;
                            } else if (folderName) {
                                finalCaption = `${folderName}/${baseName}`;
                            }

                            captionInput.value = finalCaption;
                        }
                    });
                    
                    // 1. Tombol Submit diklik
                    submitButton.addEventListener("click", function(e) {
                        e.preventDefault();
                        e.stopPropagation();

                        // --- 💡 VALIDASI DROPDOWN BARU (Semua Wajib) ---
                        if (document.querySelector("#lokasi").value.trim() === "" ||
                            document.querySelector("#pangwas_id").value === "" ||
                            document.querySelector("#tematik_id").value === "" ||
                            document.querySelector("#po_id").value === "") {
                            
                            notificationArea.innerHTML = `<div class="alert alert-danger">Lokasi, Pengawas, Tematik, dan Nomor PO wajib diisi!</div>`;
                            notificationArea.style.display = 'block';
                            return;
                        }
                        // --- AKHIR VALIDASI DROPDOWN ---
                        
                        if (self.getQueuedFiles().length > 0) {
                            submitButton.disabled = true;
                            submitButton.innerText = 'Mengupload...';
                            self.processQueue();
                        } else {
                            notificationArea.innerHTML = `<div class="alert alert-danger">Mohon pilih minimal satu file gambar!</div>`;
                            notificationArea.style.display = 'block';
                        }
                    });

                    // 2. Saat Dropzone akan mengirim data
                    this.on("sendingmultiple", function(files, xhr, formData) {
                        // Menambahkan data form biasa
                        formData.append("_token", form.querySelector('input[name="_token"]').value);
                        formData.append("lokasi", form.querySelector('#lokasi').value);
                        formData.append("deskripsi", form.querySelector('#deskripsi').value);
                        
                        // --- 💡 TAMBAHKAN DATA DROPDOWN BARU KE FORMDATA ---
                        formData.append("pangwas_id", form.querySelector('#pangwas_id').value);
                        formData.append("tematik_id", form.querySelector('#tematik_id').value);
                        formData.append("po_id", form.querySelector('#po_id').value);
                        // ----------------------------------------------------

                        // Mengambil data caption dari input
                        files.forEach(function(file) {
                            let captionInput = file.previewElement.querySelector('.caption-input');
                            formData.append("caption[]", captionInput ? captionInput.value : '');
                        });
                        
                        notificationArea.style.display = 'none';
                    });

                    // 3. Sukses Upload
                    this.on("successmultiple", function(files, response) {
                        // Tampilkan notifikasi sukses
                        notificationArea.innerHTML = `
                            <div class="alert alert-success">
                                ${response.message || 'Evidence berhasil di-upload!'}
                            </div>
                        `;
                        notificationArea.style.display = 'block';
                        
                        // Reset form
                        form.querySelector('#lokasi').value = '';
                        form.querySelector('#deskripsi').value = '';
                        form.querySelector('#pangwas_id').selectedIndex = 0;
                        form.querySelector('#tematik_id').selectedIndex = 0;
                        form.querySelector('#po_id').selectedIndex = 0;
                        self.removeAllFiles(true);
                        
                        submitButton.disabled = false;
                        submitButton.innerText = 'Upload Evidence';
                        
                        // Scroll ke atas biar notifikasi keliatan
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    });

                    // 4. Gagal Upload
                    this.on("errormultiple", function(files, response) {
                        let errorMessage = "Terjadi kesalahan:\n";
                        if (response.errors) {
                            for (let field in response.errors) {
                                errorMessage += `- ${response.errors[field].join(', ')}\n`;
                            }
                        } else {
                            errorMessage = response.message || "Gagal mengupload file. Ukuran file mungkin terlalu besar atau format salah.";
                        }
                        
                        notificationArea.innerHTML = `<div class="alert alert-danger">${errorMessage.replace(/\n/g, '<br>')}</div>`;
                        notificationArea.style.display = 'block';
                        
                        submitButton.disabled = false;
                        submitButton.innerText = 'Upload Evidence';
                    });
                }
            });
        });
    </script>
    @endpush
</x-karyawan-layout>