@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 text-primary fw-bold">Konfigurasi Website</h4>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.config.web.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <ul class="nav nav-pills mb-4 gap-2" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active fw-bold px-4 border" id="pills-general-tab" data-bs-toggle="pill" data-bs-target="#pills-general" type="button" role="tab">
                    <i class="bi bi-gear-fill me-2"></i> Umum & Tampilan
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold px-4 border" id="pills-pages-tab" data-bs-toggle="pill" data-bs-target="#pills-pages" type="button" role="tab">
                    <i class="bi bi-file-earmark-text-fill me-2"></i> Isi Halaman Footer
                </button>
            </li>
        </ul>

        <div class="tab-content" id="pills-tabContent">
            
            <div class="tab-pane fade show active" id="pills-general" role="tabpanel">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-header bg-white py-3">
                                <h6 class="fw-bold mb-0 text-dark">Identitas Website</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label text-secondary small">Nama Website</label>
                                    <input type="text" name="app_name" class="form-control" 
                                        value="{{ \App\Models\Configuration::getBy('app_name') ?? 'STORE GAME' }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-secondary small">Deskripsi Footer Singkat</label>
                                    <textarea name="footer_description" class="form-control" rows="3">{{ \App\Models\Configuration::getBy('footer_description') }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-secondary small">Nomor WhatsApp Admin (Format: 628...)</label>
                                    <input type="number" name="whatsapp_number" class="form-control" 
                                        value="{{ \App\Models\Configuration::getBy('whatsapp_number') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        
                        <div class="card border-0 shadow-sm rounded-4 mb-3">
                            <div class="card-header bg-white py-3">
                                <h6 class="fw-bold mb-0 text-dark">Logo & Banner</h6>
                            </div>
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <label class="form-label d-block text-secondary small text-start">Logo Website</label>
                                    @if($logo = \App\Models\Configuration::getBy('app_logo'))
                                        <img src="{{ asset($logo) }}" class="img-fluid rounded mb-2 border p-1" style="max-height: 60px;">
                                    @endif
                                    <input type="file" name="app_logo" class="form-control form-control-sm">
                                </div>
                                <div class="mb-0">
                                    <label class="form-label d-block text-secondary small text-start">Banner Utama</label>
                                    @if($banner = \App\Models\Configuration::getBy('app_banner'))
                                        <img src="{{ asset($banner) }}" class="img-fluid rounded mb-2 border" style="max-height: 80px;">
                                    @endif
                                    <input type="file" name="app_banner" class="form-control form-control-sm">
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-header bg-white py-3">
                                <h6 class="fw-bold mb-0 text-dark">Logo Pembayaran (Footer)</h6>
                            </div>
                            <div class="card-body">
                                <p class="small text-muted mb-3">Upload logo bank/e-wallet yang diterima (Max 4).</p>
                                
                                @for ($i = 1; $i <= 4; $i++)
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="me-2 border rounded p-1 bg-light" style="width: 50px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                            @if($img = \App\Models\Configuration::getBy('payment_logo_'.$i))
                                                <img src="{{ asset($img) }}" style="max-width: 100%; max-height: 100%;">
                                            @else
                                                <i class="bi bi-image text-secondary small"></i>
                                            @endif
                                        </div>
                                        <input type="file" name="payment_logo_{{ $i }}" class="form-control form-control-sm">
                                    </div>
                                @endfor
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="pills-pages" role="tabpanel">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="fw-bold mb-0 text-dark">Konten Halaman Footer</h6>
                    </div>
                    <div class="card-body">
                        
                        <div class="mb-4">
                            <label class="fw-bold mb-2 text-primary">Tentang Kami (About Us)</label>
                            <textarea name="page_about" class="form-control" rows="5" placeholder="Tulis deskripsi lengkap toko...">{{ \App\Models\Configuration::getBy('page_about') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="fw-bold mb-2 text-primary">Kebijakan Privasi (Privacy Policy)</label>
                            <textarea name="page_privacy" class="form-control" rows="5">{{ \App\Models\Configuration::getBy('page_privacy') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="fw-bold mb-2 text-primary">Syarat & Ketentuan (Terms)</label>
                            <textarea name="page_terms" class="form-control" rows="5">{{ \App\Models\Configuration::getBy('page_terms') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold mb-2 text-primary">Pertanyaan Umum (FAQ)</label>
                            <textarea name="page_faq" class="form-control" rows="5">{{ \App\Models\Configuration::getBy('page_faq') }}</textarea>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <div class="card border-0 shadow-sm p-3 mt-3 sticky-bottom bg-white">
            <button type="submit" class="btn btn-primary fw-bold w-100 py-2">
                <i class="bi bi-save me-2"></i> SIMPAN SEMUA PERUBAHAN
            </button>
        </div>

    </form>
</div>
@endsection