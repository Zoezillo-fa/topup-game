{{-- File: resources/views/admin/products/partials/margin_inputs.blade.php --}}

<h5 class="fw-bold text-primary mb-3 mt-4"><i class="bi bi-cash-coin me-2"></i>Atur Keuntungan (Margin)</h5>

<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="p-3 bg-light rounded-3 border h-100 position-relative overflow-hidden">
            <div class="position-absolute top-0 end-0 p-3 opacity-10">
                <i class="bi bi-person-fill fs-1 text-primary"></i>
            </div>
            <label class="fw-bold text-dark mb-3 d-block">A. Member Reguler</label>
            
            <div class="row">
                <div class="col-6">
                    <label class="small text-muted mb-1">Tipe</label>
                    <select name="profit_type" class="form-select form-select-sm">
                        <option value="percent">Persentase (%)</option>
                        <option value="flat">Rupiah (Rp)</option>
                    </select>
                </div>
                <div class="col-6">
                    <label class="small text-muted mb-1">Nilai Profit</label>
                    <input type="number" name="profit_value" class="form-control form-control-sm fw-bold text-primary" placeholder="Cth: 1000" required>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="p-3 bg-warning bg-opacity-10 rounded-3 border border-warning h-100 position-relative overflow-hidden">
            <div class="position-absolute top-0 end-0 p-3 opacity-25">
                <i class="bi bi-crown-fill fs-1 text-warning"></i>
            </div>
            <label class="fw-bold text-dark mb-3 d-block">
                <span class="badge bg-warning text-dark me-1">VIP</span> Member VIP
            </label>
            
            <div class="row">
                <div class="col-6">
                    <label class="small text-muted mb-1">Tipe VIP</label>
                    <select name="vip_profit_type" class="form-select form-select-sm border-warning">
                        <option value="percent">Persentase (%)</option>
                        <option value="flat">Rupiah (Rp)</option>
                    </select>
                </div>
                <div class="col-6">
                    <label class="small text-muted mb-1">Nilai Profit VIP</label>
                    <input type="number" name="vip_profit_value" class="form-control form-control-sm border-warning fw-bold text-dark" placeholder="Cth: 500" required>
                </div>
            </div>
        </div>
    </div>
</div>