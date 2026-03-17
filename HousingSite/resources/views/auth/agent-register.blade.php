<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Become a Verified Agent - CasaAmor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-green: #1a936f;
            --dark-green: #114b47;
        }
        .bg-primary { background-color: var(--primary-green) !important; }
        .btn-primary { 
            background-color: var(--primary-green); 
            border-color: var(--primary-green);
        }
        .btn-primary:hover {
            background-color: var(--dark-green);
            border-color: var(--dark-green);
        }
        .registration-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
        }
        .step-indicator {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .step {
            text-align: center;
            flex: 1;
        }
        .step-number {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            font-weight: bold;
        }
        .step.active .step-number {
            background: var(--primary-green);
            color: white;
        }
        .upload-area {
            border: 2px dashed #dee2e6;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .upload-area:hover {
            border-color: var(--primary-green);
            background: #f8f9fa;
        }
        .image-preview-wrapper {
            padding: 10px;
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px dashed #dee2e6;
            margin-top: 10px;
        }
        .image-preview-wrapper img {
            transition: transform 0.2s;
            max-width: 100%;
            height: auto;
        }
        .image-preview-wrapper img:hover {
            transform: scale(1.05);
        }
        .file-info {
            background: #e9ecef;
            padding: 8px 12px;
            border-radius: 6px;
            margin-top: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="registration-container bg-white shadow rounded">
            <!-- Header -->
            <div class="text-center mb-4">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="CasaAmor" style="height: 50px;" class="mb-3">
                </a>
                <h2>Become a Verified Agent</h2>
                <p class="text-muted">Join Kenya's trusted housing platform. Complete verification to start listing properties.</p>
            </div>

            <!-- Error Display -->
            @if($errors->any())
            <div class="alert alert-danger">
                <h5><i class="fas fa-exclamation-triangle me-2"></i>Please fix the following errors:</h5>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
            </div>
            @endif

            @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
            @endif

            <!-- Step Indicator -->
            <div class="step-indicator">
                <div class="step active">
                    <div class="step-number">1</div>
                    <small>Account Info</small>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <small>ID Verification</small>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <small>Professional Details</small>
                </div>
            </div>

            <form action="{{ route('agent.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Step 1: Basic Account Information -->
                <div class="mb-4">
                    <h5 class="mb-3">📝 Account Information</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   placeholder="As it appears on ID" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email Address *</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                   placeholder="your@email.com" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone Number *</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                   placeholder="07..." value="{{ old('phone') }}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password *</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                                   placeholder="Create password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm Password *</label>
                        <input type="password" name="password_confirmation" class="form-control" 
                               placeholder="Repeat password" required>
                    </div>
                </div>

                <!-- Step 2: Identity Verification -->
                <div class="mb-4">
                    <h5 class="mb-3">🆔 Identity Verification</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">National ID Number *</label>
                            <input type="text" name="id_number" class="form-control @error('id_number') is-invalid @enderror" 
                                   placeholder="Your Kenyan ID number" value="{{ old('id_number') }}" required>
                            @error('id_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">KRA PIN *</label>
                            <input type="text" name="kra_pin" class="form-control @error('kra_pin') is-invalid @enderror" 
                                   placeholder="Your KRA PIN" value="{{ old('kra_pin') }}" required>
                            @error('kra_pin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- ID Document Upload -->
                    <div class="mb-3">
                        <label class="form-label">Upload National ID (Front & Back) *</label>
                        <div class="upload-area @error('id_document') border-danger @enderror" onclick="document.getElementById('id_document').click()">
                            <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                            <p class="mb-1">Click to upload ID documents</p>
                            <small class="text-muted">Upload clear images of front and back of your ID (JPEG, PNG, PDF - Max 2MB)</small>
                            <input type="file" name="id_document" id="id_document" class="d-none" accept=".jpeg,.jpg,.png,.pdf">
                            @error('id_document')
                                <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div id="id_document_preview" class="mt-2"></div>
                    </div>

                    <!-- Passport Photo (Optional but recommended) -->
                    <div class="mb-3">
                        <label class="form-label">Passport Photo</label>
                        <div class="upload-area @error('selfie_id') border-danger @enderror" onclick="document.getElementById('selfie_id').click()">
                            <i class="fas fa-camera fa-2x text-muted mb-2"></i>
                            <p class="mb-1">Click to upload passport photo</p>
                            <small class="text-muted">Upload a clear passport-size photo with a plain background (JPEG, PNG - Max 2MB)</small>
                            <input type="file" name="selfie_id" id="selfie_id" class="d-none" accept=".jpeg,.jpg,.png">
                            @error('selfie_id')
                                <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div id="selfie_id_preview" class="mt-2"></div>
                    </div>
                </div>

                <!-- Step 3: Professional Details -->
                <div class="mb-4">
                    <h5 class="mb-3">💼 Professional Details</h5>
                    <div class="mb-3">
                        <label class="form-label">Agency/Company Name</label>
                        <input type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror" 
                               placeholder="If applicable" value="{{ old('company_name') }}">
                        @error('company_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Business Registration Number</label>
                        <input type="text" name="business_reg_number" class="form-control @error('business_reg_number') is-invalid @enderror" 
                               placeholder="If registered business" value="{{ old('business_reg_number') }}">
                        @error('business_reg_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Office Address/Location *</label>
                        <input type="text" name="business_address" class="form-control @error('business_address') is-invalid @enderror" 
                               placeholder="Your business location" value="{{ old('business_address') }}" required>
                        @error('business_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Years of Experience *</label>
                        <select name="experience" class="form-control @error('experience') is-invalid @enderror" required>
                            <option value="">Select experience</option>
                            <option value="0-1" {{ old('experience') == '0-1' ? 'selected' : '' }}>0-1 years</option>
                            <option value="1-3" {{ old('experience') == '1-3' ? 'selected' : '' }}>1-3 years</option>
                            <option value="3-5" {{ old('experience') == '3-5' ? 'selected' : '' }}>3-5 years</option>
                            <option value="5+" {{ old('experience') == '5+' ? 'selected' : '' }}>5+ years</option>
                        </select>
                        @error('experience')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Professional Bio</label>
                        <textarea name="bio" class="form-control @error('bio') is-invalid @enderror" rows="3" 
                                  placeholder="Tell us about your real estate experience...">{{ old('bio') }}</textarea>
                        @error('bio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Agreement -->
                <div class="mb-4">
                    <div class="form-check">
                        <input class="form-check-input @error('terms') is-invalid @enderror" type="checkbox" name="terms" id="terms" required {{ old('terms') ? 'checked' : '' }}>
                        <label class="form-check-label" for="terms">
                            I agree to the <a href="#">Terms of Service</a> and <a href="#">Code of Conduct</a>
                        </label>
                        @error('terms')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="background_check" id="background_check" {{ old('background_check') ? 'checked' : '' }}>
                        <label class="form-check-label" for="background_check">
                            I consent to background verification checks
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-user-check me-2"></i> Apply for Verification
                    </button>
                </div>

                <div class="text-center mt-3">
                    <small class="text-muted">
                        Your application will be reviewed within 24-48 hours. You'll receive email confirmation.
                    </small>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ID Document preview
            const idDocumentInput = document.getElementById('id_document');
            const idDocumentPreview = document.getElementById('id_document_preview');
            
            idDocumentInput.addEventListener('change', function(e) {
                handleFilePreview(this.files[0], idDocumentPreview, true);
            });
            
            // Selfie ID preview
            const selfieIdInput = document.getElementById('selfie_id');
            const selfieIdPreview = document.getElementById('selfie_id_preview');
            
            selfieIdInput.addEventListener('change', function(e) {
                handleFilePreview(this.files[0], selfieIdPreview, false);
            });
            
            function handleFilePreview(file, previewContainer, isDocument) {
                previewContainer.innerHTML = ''; // Clear previous preview
                
                if (!file) return;
                
                if (file.type.startsWith('image/')) {
                    // Create image preview
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.maxWidth = '200px';
                        img.style.maxHeight = '200px';
                        img.style.borderRadius = '8px';
                        img.style.border = '2px solid #ddd';
                        img.className = 'mb-2';
                        
                        const wrapper = document.createElement('div');
                        wrapper.className = 'image-preview-wrapper';
                        wrapper.innerHTML = `
                            <div class="mb-2">
                                <small class="text-muted"><i class="fas fa-eye me-1"></i>Preview:</small>
                            </div>
                        `;
                        wrapper.appendChild(img);
                        
                        // Add file info
                        const fileInfo = document.createElement('div');
                        fileInfo.className = 'file-info';
                        fileInfo.innerHTML = `
                            <small>
                                <i class="fas fa-file me-1"></i>
                                <strong>${file.name}</strong> (${formatFileSize(file.size)})
                            </small>
                        `;
                        wrapper.appendChild(fileInfo);
                        
                        previewContainer.appendChild(wrapper);
                    };
                    reader.readAsDataURL(file);
                } else if (file.type === 'application/pdf') {
                    // Show PDF file info
                    previewContainer.innerHTML = `
                        <div class="alert alert-info py-2">
                            <i class="fas fa-file-pdf text-danger me-2"></i>
                            <strong>PDF Document Selected</strong>
                            <div class="file-info mt-2">
                                <small>
                                    <i class="fas fa-file me-1"></i>
                                    ${file.name} (${formatFileSize(file.size)})
                                </small>
                            </div>
                            <small class="text-muted d-block mt-1">PDF preview not available - document will be uploaded</small>
                        </div>
                    `;
                }
            }
            
            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }
        });
    </script>
</body>
</html>