<x-karyawan-layout>
    <head>
        {{-- CRITICAL: Disable auto-discover BEFORE loading Dropzone --}}
        <script>
            window.Dropzone = window.Dropzone || {};
            window.Dropzone.autoDiscover = false;
        </script>
        
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
        .upload-area { border: 2px dashed #dc2626; border-radius: 12px; background: #fee2e2; padding: 15px; transition: all 0.3s; min-height: 150px; display: flex; flex-wrap: wrap; justify-content: center; align-items: center; }
        .upload-area .dz-message { color: #b91c1c; }
        .upload-area .dz-preview { background: #fff; border-radius: 14px; border: 1px solid #e5e7eb; padding: 12px; margin: 12px; width: 220px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); display: flex; flex-direction: column; align-items: center; position: relative; }
        .upload-area .dz-preview .dz-image { width: 100%; height: 140px; margin-bottom: 10px; }
        .upload-area .dz-preview .dz-image img { width: 100%; height: 100%; object-fit: cover; border-radius: 12px; }
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
                <div id="evidence-dropzone" class="upload-area">
                    <div class="dz-message" data-dz-message><span>Seret foto/folder ke sini atau klik untuk memilih | Max 50 file @ 10MB per file</span></div>
                </div>
                
                <!-- Tombol Upload Folder -->
                <div style="margin-top: 1rem; text-align: center;">
                    <input type="file" id="folder-input" webkitdirectory directory multiple style="display: none;" accept="image/*">
                    <button type="button" id="select-folder-btn" class="btn-submit" style="width: auto; padding: 0.5rem 1.5rem; background-color: #059669; display: inline-block;">
                        📁 Pilih Folder
                    </button>
                    <p style="font-size: 0.875rem; color: #6b7280; margin-top: 0.5rem;">
                        Klik tombol di atas untuk memilih folder yang berisi foto
                    </p>
                </div>
            </div>

            <button type="button" id="submit-button" class="btn-submit" style="margin-top: 1rem;">Upload Evidence</button>
        </form>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            
            // Destroy any existing dropzone instance
            const dropzoneElement = document.querySelector("#evidence-dropzone");
            if (dropzoneElement && dropzoneElement.dropzone) {
                dropzoneElement.dropzone.destroy();
            }

            const previewTemplate = `
                <div class="dz-preview dz-file-preview">
                    <div class="dz-image"><img data-dz-thumbnail /></div>
                    <input type="text" name="caption[]" class="caption-input" placeholder="Deskripsi foto (opsional)...">
                    <button type="button" data-dz-remove class="remove-btn">X</button>
                    <div class="dz-error-message"><span data-dz-errormessage></span></div>
                </div>
            `;

            let myDropzone = new Dropzone("#evidence-dropzone", { 
                url: "{{ route('karyawan.evidence.store') }}",
                paramName: "file",
                autoProcessQueue: false,
                uploadMultiple: true, // Back to multiple upload
                parallelUploads: 3, // Reduced to 3 for better stability
                maxFiles: 1000,
                maxFilesize: 50,
                acceptedFiles: 'image/*',
                addRemoveLinks: false,
                previewTemplate: previewTemplate,
                timeout: 900000, // 15 minutes timeout
                
                init: function() {
                    const self = this;
                    const form = document.querySelector("#evidence-form");
                    const submitButton = document.querySelector("#submit-button");
                    const notificationArea = document.querySelector("#notification-area");
                    const folderInput = document.querySelector("#folder-input");
                    const selectFolderBtn = document.querySelector("#select-folder-btn");
                    
                    let folderName = null;

                    // --- HANDLER UNTUK TOMBOL PILIH FOLDER ---
                    selectFolderBtn.addEventListener('click', function() {
                        folderInput.click();
                    });

                    folderInput.addEventListener('change', function(e) {
                        const files = Array.from(e.target.files);
                        console.log("Folder selected with", files.length, "files");
                        
                        if (files.length > 0) {
                            // Get folder name from first file's path
                            const firstFile = files[0];
                            if (firstFile.webkitRelativePath) {
                                const pathParts = firstFile.webkitRelativePath.split('/');
                                folderName = pathParts[0];
                                console.log("Folder name:", folderName);
                            }
                            
                            // Add all files to dropzone
                            files.forEach(file => {
                                // Preserve the relative path
                                if (file.webkitRelativePath) {
                                    file.fullPath = file.webkitRelativePath;
                                }
                                self.addFile(file);
                            });
                            
                            notificationArea.innerHTML = `<div class="alert alert-success">Folder "${folderName}" berhasil dipilih dengan ${files.length} file!</div>`;
                            notificationArea.style.display = 'block';
                        }
                    });


                    // --- LOGIKA DETEKSI FOLDER DROP ---
                    const dropzoneElement = document.getElementById('evidence-dropzone');

                    // Helper function to read all files from a directory recursively
                    async function readDirectory(directoryEntry, path = '') {
                        const files = [];
                        const reader = directoryEntry.createReader();
                        
                        return new Promise((resolve, reject) => {
                            const readEntries = () => {
                                reader.readEntries(async (entries) => {
                                    if (entries.length === 0) {
                                        resolve(files);
                                        return;
                                    }
                                    
                                    for (const entry of entries) {
                                        if (entry.isFile) {
                                            const file = await new Promise((res) => {
                                                entry.file((f) => {
                                                    f.fullPath = path + '/' + f.name;
                                                    res(f);
                                                });
                                            });
                                            
                                            // Only add image files
                                            if (file.type.startsWith('image/')) {
                                                files.push(file);
                                            }
                                        } else if (entry.isDirectory) {
                                            const subFiles = await readDirectory(entry, path + '/' + entry.name);
                                            files.push(...subFiles);
                                        }
                                    }
                                    
                                    readEntries(); // Continue reading
                                }, reject);
                            };
                            
                            readEntries();
                        });
                    }

                    dropzoneElement.addEventListener('drop', async function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        folderName = null; 

                        if (e.dataTransfer.items && e.dataTransfer.items.length > 0) {
                            const item = e.dataTransfer.items[0];
                            if (item.webkitGetAsEntry) { 
                                const entry = item.webkitGetAsEntry();
                                
                                if (entry && entry.isDirectory) {
                                    folderName = entry.name;
                                    console.log("Folder dropped:", folderName);
                                    
                                    // Show loading message
                                    notificationArea.innerHTML = `<div class="alert alert-success">Membaca folder "${folderName}"...</div>`;
                                    notificationArea.style.display = 'block';
                                    
                                    try {
                                        // Read all files from the directory
                                        const files = await readDirectory(entry, folderName);
                                        console.log("Found", files.length, "image files in folder");
                                        
                                        // Add all files to dropzone
                                        files.forEach(file => {
                                            self.addFile(file);
                                        });
                                        
                                        notificationArea.innerHTML = `<div class="alert alert-success">Folder "${folderName}" berhasil ditambahkan dengan ${files.length} file!</div>`;
                                        notificationArea.style.display = 'block';
                                    } catch (error) {
                                        console.error("Error reading folder:", error);
                                        notificationArea.innerHTML = `<div class="alert alert-danger">Gagal membaca folder. Silakan gunakan tombol "Pilih Folder" di bawah.</div>`;
                                        notificationArea.style.display = 'block';
                                    }
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
                    
                    // Show total progress
                    this.on("totaluploadprogress", function(progress) {
                        submitButton.innerText = `Mengupload... ${Math.round(progress)}%`;
                    });
                    
                    // 1. Tombol Submit diklik
                    submitButton.addEventListener("click", function(e) {
                        e.preventDefault();
                        e.stopPropagation();

                        // Validasi
                        if (document.querySelector("#lokasi").value.trim() === "" ||
                            document.querySelector("#pangwas_id").value === "" ||
                            document.querySelector("#tematik_id").value === "" ||
                            document.querySelector("#po_id").value === "") {
                            
                            notificationArea.innerHTML = `<div class="alert alert-danger">Lokasi, Pengawas, Tematik, dan Nomor PO wajib diisi!</div>`;
                            notificationArea.style.display = 'block';
                            return;
                        }
                        
                        const queuedFiles = self.getQueuedFiles();
                        if (queuedFiles.length > 0) {
                            submitButton.disabled = true;
                            submitButton.innerText = 'Mengupload... 0%';
                            
                            console.log("=== STARTING UPLOAD ===");
                            console.log("Queued files:", queuedFiles.length);
                            console.log("Dropzone URL:", self.options.url);
                            console.log("Upload multiple:", self.options.uploadMultiple);
                            
                            self.processQueue();
                        } else {
                            notificationArea.innerHTML = `<div class="alert alert-danger">Mohon pilih minimal satu file gambar!</div>`;
                            notificationArea.style.display = 'block';
                        }
                    });

                    // 2. Saat mengirim data
                    this.on("sendingmultiple", function(files, xhr, formData) {
                        console.log("=== SENDING REQUEST ===");
                        console.log("Files count:", files.length);
                        console.log("XHR ready state:", xhr.readyState);
                        console.log("Request URL:", xhr.responseURL || self.options.url);
                        
                        // Add form data
                        const token = form.querySelector('input[name="_token"]').value;
                        const lokasi = form.querySelector('#lokasi').value;
                        const pangwas_id = form.querySelector('#pangwas_id').value;
                        const tematik_id = form.querySelector('#tematik_id').value;
                        const po_id = form.querySelector('#po_id').value;
                        
                        console.log("Form data:", { token: token ? "present" : "missing", lokasi, pangwas_id, tematik_id, po_id });
                        
                        formData.append("_token", token);
                        formData.append("lokasi", lokasi);
                        formData.append("deskripsi", form.querySelector('#deskripsi').value);
                        formData.append("pangwas_id", pangwas_id);
                        formData.append("tematik_id", tematik_id);
                        formData.append("po_id", po_id);

                        // Add captions
                        files.forEach(function(file) {
                            let captionInput = file.previewElement.querySelector('.caption-input');
                            formData.append("caption[]", captionInput ? captionInput.value : '');
                        });
                        
                        notificationArea.style.display = 'none';
                    });

                    // 3. Success
                    this.on("successmultiple", function(files, response) {
                        console.log("Upload successful:", response);
                        
                        notificationArea.innerHTML = `
                            <div class="alert alert-success">
                                ${response.message || 'Evidence berhasil di-upload! Total ' + files.length + ' foto telah disimpan.'}
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
                        
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    });

                    // 4. Error
                    this.on("errormultiple", function(files, errorResponse, xhr) {
                        console.error("Upload error:", errorResponse, "XHR status:", xhr ? xhr.status : 'no xhr');
                        
                        let errorMessage = "Gagal mengupload file.";
                        
                        // Handle different error types
                        if (xhr && xhr.status === 0) {
                            errorMessage = "Koneksi terputus atau timeout. Silakan coba lagi dengan file yang lebih sedikit atau ukuran yang lebih kecil.";
                        } else if (typeof errorResponse === 'string') {
                            errorMessage = errorResponse;
                        } else if (errorResponse && errorResponse.message) {
                            errorMessage = errorResponse.message;
                        } else if (errorResponse && errorResponse.errors) {
                            errorMessage = "Error validasi:\n";
                            for (let field in errorResponse.errors) {
                                errorMessage += `- ${errorResponse.errors[field].join(', ')}\n`;
                            }
                        }
                        
                        notificationArea.innerHTML = `<div class="alert alert-danger">${errorMessage.replace(/\n/g, '<br>')}</div>`;
                        notificationArea.style.display = 'block';
                        
                        submitButton.disabled = false;
                        submitButton.innerText = 'Upload Evidence';
                        
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    });
                    
                    // Individual file error
                    this.on("error", function(file, errorMessage, xhr) {
                        console.error("File error:", file.name, errorMessage, "XHR:", xhr);
                    });
                    
                    // Timeout
                    this.on("timeout", function(file, timeoutMessage, xhr) {
                        console.error("Timeout:", file.name);
                    });
                }
            });
        });
    </script>
    @endpush
</x-karyawan-layout>