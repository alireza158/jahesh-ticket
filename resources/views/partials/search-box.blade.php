@props(['placeholder' => 'جستجو...', 'value' => ''])
<div class="card mb-3">
    <div class="card-body p-3">
        <form method="GET" action="{{ url()->current() }}" class="row g-2 align-items-center">
            <div class="col-md">
                <input name="q" value="{{ $value }}" class="form-control" placeholder="{{ $placeholder }}">
            </div>
            <div class="col-md-auto d-flex gap-2">
                <button class="btn btn-primary" type="submit"><i class="bi bi-search ms-1"></i> جستجو</button>
                @if($value)
                    <a href="{{ url()->current() }}" class="btn btn-outline-secondary">حذف فیلتر</a>
                @endif
            </div>
        </form>
    </div>
</div>
