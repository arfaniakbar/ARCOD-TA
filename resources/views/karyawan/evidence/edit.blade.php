<x-karyawan-layout>
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    
    <style>
        .card { background-color: #fff; padding: 24px; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); }
        .card-header { font-size: 1.25rem; font-weight: 600; color: #1f2937; border-bottom: 1px solid #e5e7eb; padding-bottom: 16px; margin-bottom: 24px; }
        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 500; color: #374151; }
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; box-sizing: border-box; }
        .form-footer { margin-top: 24px; display: flex; justify-content: flex-end; gap: 12px; }
        .btn { display: inline-flex; align-items: center; padding: 8px 16px; border-radius: 6px; font-weight: 600; text-decoration: none; border: none; cursor: pointer; }
        .btn-red { background-color: #dc2626; color: white; }
        .btn-red:hover { background-color: #b91c1c; }
        .btn-secondary { background-color: #e5e7eb; color: #1f2937; }
        .btn-secondary:hover { background-color: #d1d5db; }

        /* File preview grid */
        .file-preview-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
            margin-top: 12px;
        }
        
        .file-preview-item {
            position: relative;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .file-preview-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.12);
        }
        
        .file-preview-item img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }
        
        .file-preview-item .file-info {
            padding: 12px;
            font-size: 0.875rem;
            color: #374151;
            font-weight: 500;
            text-align: center;
            background: #f9fafb;
            border-top: 1px solid #e5e7eb;
            word-break: break-word;
        }
        
        .file-preview-item .delete-btn {
            width: calc(100% - 24px);
            margin: 12px;
            background: #fff;
            color: #dc2626;
            border: 2px solid #dc2626;
            padding: 10px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.875rem;
            font-weight: 600;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }
        
        .file-preview-item .delete-btn:hover {
            background: #dc2626;
            color: white;
            transform: scale(1.02);
        }
        
        .file-preview-item .delete-btn:active {
            transform: scale(0.98);
        }

        .alert { padding: 1rem; border-radius: 8px; font-weight: 500; margin-bottom: 1.5rem; }
        .alert-success { background-color: #dcfce7; color: #166534; border: 1px solid #86efac; }
        .alert-danger { background-color: #fee2e2; color: #991b1b; border: 1px solid #f87171; }

        /* Dropzone styling */
        .dropzone {
            border: 2px dashed #d1d5db;
            border-radius: 8px;
            background: #f9fafb;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .dropzone:hover {
            border-color: #3b82f6;
            background: #eff6ff;
        }
        
        .dropzone .dz-message {
            font-weight: 500;
            color: #6b7280;
        }
    </style>

    <div class="card">
        <h2 class="card-header">Edit Evidence</h2>
        
        {{-- Notification Area --}}
        <div id="notification-area" style="display: none;"></div>
        
        <form id="editForm" action="{{ route('karyawan.evidence.update', $evidence->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="lokasi">Masukkan Lokasi Anda <span style="color: red;">*</span></label>
                <input type="text" id="lokasi" name="lokasi" value="{{ old('lokasi', $evidence->lokasi) }}" required>
            </div>
            
            <div class="form-group">
                <label for="deskripsi">Deskripsi (Opsional)</label>
                <textarea id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $evidence->deskripsi) }}</textarea>
            </div>

            <div class="form-group">
                <label for="pangwas_id">Pangwas <span style="color: red;">*</span></label>
                <select id="pangwas_id" name="pangwas_id" required>
                    <option value="">-- Pilih Pangwas --</option>
                    @foreach($pangwas_list as $pangwas)
                        <option value="{{ $pangwas->id }}" {{ old('pangwas_id', $evidence->pangwas_id) == $pangwas->id ? 'selected' : '' }}>
                            {{ $pangwas->nama_pangwas }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="tematik_id">Tematik <span style="color: red;">*</span></label>
                <select id="tematik_id" name="tematik_id" required>
                    <option value="">-- Pilih Tematik --</option>
                    @foreach($tematik_list as $tematik)
                        <option value="{{ $tematik->id }}" {{ old('tematik_id', $evidence->tematik_id) == $tematik->id ? 'selected' : '' }}>
                            {{ $tematik->nama_tematik }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="po_id">Purchase Order (PO) <span style="color: red;">*</span></label>
                <select id="po_id" name="po_id" required>
                    <option value="">-- Pilih PO --</option>
                    @foreach($po_list as $po)
                        <option value="{{ $po->id }}" {{ old('po_id', $evidence->po_id) == $po->id ? 'selected' : '' }}>
                            {{ $po->no_po }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- File Evidence Saat Ini --}}
            <div class="form-group">
                <label>File Evidence Saat Ini</label>
                <div class="file-preview-grid" id="currentFilesGrid">
                    @if(is_array($evidence->file_path) && count($evidence->file_path) > 0)
                        @foreach($evidence->file_path as $index => $fileData)
                            @php
                                $path = $fileData['path'] ?? null;
                                $caption = $fileData['caption'] ?? 'File ' . ($index + 1);
                            @endphp
                            @if($path)
                                <div class="file-preview-item" data-file-index="{{ $index }}">
                                    <img src="{{ Storage::url($path) }}" alt="{{ $caption }}">
                                    <div class="file-info">{{ $caption }}</div>
                                    <button type="button" class="delete-btn" onclick="deleteFile({{ $index }})">
                                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                        </svg>
                                        Hapus
                                    </button>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <p style="color: #6b7280; grid-column: 1/-1;">Tidak ada file.</p>
                    @endif
                </div>
                {{-- Hidden input untuk menyimpan file yang dihapus --}}
                <input type="hidden" name="deleted_files" id="deletedFiles" value="">
            </div>

            {{-- Upload File Baru dengan Dropzone --}}
            <div class="form-group">
                <label for="newFiles">Upload File Baru (Opsional)</label>
                <div id="myDropzone" class="dropzone">
                    <div class="dz-message">
                        <p>📁 Klik atau drag & drop file di sini</p>
                        <small style="color: #6b7280;">Format: JPEG, JPG, PNG | Tanpa batasan ukuran & jumlah</small>
                    </div>
                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('karyawan.evidence.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-red">Update Evidence</button>
            </div>
        </form>
    </div>

    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script>
        Dropzone.autoDiscover = false;
        
        let deletedFiles = [];
        
        // Fungsi untuk menghapus file
        function deleteFile(index) {
            if (confirm('Yakin ingin menghapus file ini?')) {
                deletedFiles.push(index);
                document.getElementById('deletedFiles').value = JSON.stringify(deletedFiles);
                
                // Hapus elemen dari tampilan
                const fileItem = document.querySelector(`[data-file-index="${index}"]`);
                if (fileItem) {
                    fileItem.remove();
                }
                
                // Cek jika tidak ada file lagi
                const grid = document.getElementById('currentFilesGrid');
                if (grid.children.length === 0) {
                    grid.innerHTML = '<p style="color: #6b7280; grid-column: 1/-1;">Tidak ada file.</p>';
                }
            }
        }
        
        // Inisialisasi Dropzone
        const myDropzone = new Dropzone("#myDropzone", {
            url: "{{ route('karyawan.evidence.update', $evidence->id) }}", 
            autoProcessQueue: false,
            uploadMultiple: true,
            parallelUploads: 100,
            maxFiles: null,
            maxFilesize: null,
            acceptedFiles: "image/jpeg,image/jpg,image/png",
            addRemoveLinks: true,
            dictDefaultMessage: "Klik atau drag & drop file/folder di sini",
            dictRemoveFile: "Hapus",
            dictInvalidFileType: "Format file tidak valid (hanya JPEG, JPG, PNG)",
            
            init: function() {
                const dz = this;
                const form = document.getElementById('editForm');
                
                // Tangkap file dengan path/folder structure
                this.on("addedfile", function(file) {
                    // Ambil relative path jika ada (untuk folder upload)
                    if (file.fullPath) {
                        file.customName = file.fullPath;
                    } else if (file.webkitRelativePath) {
                        file.customName = file.webkitRelativePath;
                    } else {
                        file.customName = file.name;
                    }
                    
                    console.log('File added with path:', file.customName);
                });
                
                // Submit form handler
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    if (dz.getQueuedFiles().length > 0) {
                        // Ada file baru, process via Dropzone
                        dz.processQueue();
                    } else {
                        // Tidak ada file baru, submit form biasa (redirect)
                        form.submit();
                    }
                });
                
                // Dropzone sending handler
                this.on("sendingmultiple", function(files, xhr, formData) {
                    // Tambahkan semua field form ke formData
                    const formElements = form.elements;
                    for (let i = 0; i < formElements.length; i++) {
                        const element = formElements[i];
                        if (element.name && element.type !== 'file') {
                            formData.append(element.name, element.value);
                        }
                    }
                    
                    // Tambahkan custom path untuk setiap file
                    files.forEach((file, index) => {
                        formData.append('file_paths[]', file.customName || file.name);
                    });
                });
                
                // Success handler
                this.on("successmultiple", function(files, response) {
                    // Simpan pesan sukses ke localStorage
                    if (response.message) {
                        localStorage.setItem('successMessage', response.message);
                    }
                    
                    // Redirect langsung ke riwayat
                    if (response.redirect) {
                        window.location.href = response.redirect;
                    } else {
                        window.location.href = "{{ route('karyawan.evidence.index') }}";
                    }
                });
                
                // Error handler
                this.on("errormultiple", function(files, response) {
                    const notificationArea = document.getElementById('notification-area');
                    notificationArea.innerHTML = `
                        <div class="alert alert-danger">
                            Gagal mengupload file: ${response.message || 'Unknown error'}
                        </div>
                    `;
                    notificationArea.style.display = 'block';
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            }
        });
    </script>
</x-karyawan-layout>