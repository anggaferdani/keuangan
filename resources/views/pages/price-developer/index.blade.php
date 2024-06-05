@extends('templates.pages')
@section('title')
@section('header')
<div class="section-header-back">
  <a href="{{ route('project.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
</div>
<h1>Price Developer {{ $project->nama_project }}</h1>
@endsection
@section('content')
<div class="row">
  <div class="col-12">

    @if(Session::get('success'))
      <div class="alert alert-important alert-primary" role="alert">
        {{ Session::get('success') }}
      </div>
    @endif
  
    <div class="card">
      <div class="card-body">
        <div class="float-left">
          
        </div>
        <div class="float-right">
        </div>

        <div class="clearfix mb-3"></div>

        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="align-items-center text-center text-nowrap">No.</th>
                <th class="align-items-center text-center text-nowrap">Jobdesk</th>
                <th class="align-items-center text-center text-nowrap">Name</th>
                <th class="align-items-center text-center text-nowrap">Price Satuan</th>
                <th class="align-items-center text-center text-nowrap" colspan="2">QTY</th>
                <th class="align-items-center text-center text-nowrap" colspan="2">Discount</th>
                <th class="align-items-center text-center text-nowrap">Final Price</th>
                <th class="align-items-center text-center text-nowrap">Paid</th>
                <th class="align-items-center text-center text-nowrap">Remnant</th>
                <th class="align-items-center">Action</th>
              </tr>
            </thead>
            <tbody>
              <form action="{{ route('price-developer.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <tr>
                  <input type="hidden" class="form-control" name="project_id" value="{{ $project->id }}">
                  <td class="align-items-center text-center text-nowrap"></td>
                  <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="text" class="form-control border border-danger" name="jobdesk" required></td>
                  <td class="align-items-center text-center text-nowrap p-1">
                    <select class="form-control select3" style="width: 200px !important;" name="user_id">
                      <option disabled selected value="">Select</option>
                      @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                      @endforeach
                    </select>
                  </td>
                  <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="text" class="form-control border border-danger" name="price_satuan" required></td>
                  <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="text" class="form-control border border-danger" name="qty" required></td>
                  <td class="align-items-center text-center text-nowrap p-1">
                    <select required class="form-control select3" style="width: 200px !important;" name="category_id">
                      <option disabled selected value="">Select</option>
                      @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                      @endforeach
                    </select>
                  </td>
                  <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="text" class="form-control border border-danger" name="discount_percent"></td>
                  <td class="align-items-center text-center text-nowrap p-1"><input readonly style="min-width: 200px; width: 100%;" type="text" class="form-control border border-danger" name="discount_price"></td>
                  <td class="align-items-center text-center text-nowrap p-1"><input readonly style="min-width: 200px; width: 100%;" type="text" class="form-control border border-danger" name="final_price" required></td>
                  <td class="align-items-center text-center text-nowrap p-1"><input readonly style="min-width: 200px; width: 100%;" type="text" class="form-control border border-danger" name="paid" required></td>
                  <td class="align-items-center text-center text-nowrap p-1"><input readonly style="min-width: 200px; width: 100%;" type="text" class="form-control border border-danger" name="remnant" required></td>
                  <td class="align-items-center text-nowrap">
                    <button type="submit" class="btn btn-icon btn-primary"><i class="fas fa-plus"></i></button>
                  </td>
                </tr>
              </form>
              @foreach($priceDevelopers as $priceDeveloper)
                <form action="{{ route('price-developer.update', $priceDeveloper->id) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')
                  <tr>
                    <input type="hidden" class="form-control" name="project_id" value="{{ $project->id }}">
                    <td class="align-items-center text-center text-nowrap"></td>
                    <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="text" class="form-control" name="jobdesk" value="{{ $priceDeveloper->jobdesk }}" required></td>
                    <td class="align-items-center text-center text-nowrap p-1">
                      <select class="form-control select3" style="width: 200px !important;" name="user_id">
                        <option disabled selected value="">{{ $priceDeveloper->user_id }}</option>
                        @foreach($users as $user)
                          <option value="{{ $user->id }}" @if($priceDeveloper->user_id == $user->id) @selected(true) @endif>{{ $user->name }}</option>
                        @endforeach
                      </select>
                    </td>
                    <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="text" class="form-control" name="price_satuan" value="{{ $priceDeveloper->price_satuan }}" required></td>
                    <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="text" class="form-control" name="qty" value="{{ $priceDeveloper->qty }}" required></td>
                    <td class="align-items-center text-center text-nowrap p-1">
                      <select required class="form-control select3" style="width: 200px !important;" name="category_id">
                        <option disabled selected value="">Select</option>
                        @foreach($categories as $category)
                          <option value="{{ $category->id }}" @if($priceDeveloper->category_id == $category->id) @selected(true) @endif>{{ $category->name }}</option>
                        @endforeach
                      </select>
                    </td>
                    <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="text" class="form-control" name="discount_percent" value="{{ $priceDeveloper->discount_percent }}"></td>
                    <td class="align-items-center text-center text-nowrap p-1"><input readonly style="min-width: 200px; width: 100%;" type="text" class="form-control" name="discount_price" value="{{ $priceDeveloper->discount_price }}"></td>
                    <td class="align-items-center text-center text-nowrap p-1"><input readonly style="min-width: 200px; width: 100%;" type="text" class="form-control" name="final_price" value="{{ $priceDeveloper->final_price }}" required></td>
                    <td class="align-items-center text-center text-nowrap p-1"><input readonly style="min-width: 200px; width: 100%;" type="text" class="form-control" name="paid" value="{{ $priceDeveloper->paidDevelopers->where('status', 1)->sum('nominal_pembayaran') }}" required></td>
                    <td class="align-items-center text-center text-nowrap p-1"><input readonly style="min-width: 200px; width: 100%;" type="text" class="form-control" name="remnant" value="{{ $priceDeveloper->remnant }}" required></td>
                    <td class="align-items-center text-nowrap">
                      @if(auth()->user()->hasPermission('paid-developer-index'))
                        <a href="{{ route('paid-developer.index', ['id' => $priceDeveloper->id]) }}" class="btn btn-icon btn-primary"><i class="fas fa-user"></i> Paid Developer</a>
                      @endif
                      @if(auth()->user()->hasPermission('price-developer-edit'))
                        <button type="submit" class="btn btn-icon btn-primary"><i class="fas fa-check"></i></button>
                      @endif
                      @if(auth()->user()->hasPermission('price-developer-delete'))
                        <a href="{{ route('price-developer.delete', $priceDeveloper->id) }}" class="btn btn-icon btn-danger delete2"><i class="fas fa-trash"></i></a>
                      @endif
                    </td>
                  </tr>
                </form>
              @endforeach
              <tr>
                <td class="align-items-center text-nowrap"></td>
                <td class="align-items-center text-nowrap"></td>
                <td class="align-items-center text-nowrap"></td>
                <td class="align-items-center text-center text-nowrap p-1"><input readonly type="text" class="form-control" name="" id="totalPriceSatuan"></td>
                <td class="align-items-center text-nowrap"></td>
                <td class="align-items-center text-nowrap"></td>
                <td class="align-items-center text-nowrap"></td>
                <td class="align-items-center text-center text-nowrap p-1"><input readonly type="text" class="form-control" name="" id="totalDiscountPrice"></td>
                <td class="align-items-center text-center text-nowrap p-1"><input readonly type="text" class="form-control" name="" id="total"></td>
                <td class="align-items-center text-center text-nowrap p-1"><input readonly type="text" class="form-control" name="" id="totalPaid"></td>
                <td class="align-items-center text-center text-nowrap p-1"><input readonly type="text" class="form-control" name="" id="totalRemnant"></td>
                <td class="align-items-center text-nowrap"></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@push('scripts')
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const priceSatuanInputs = document.querySelectorAll('.form-control[name="price_satuan"]');
    const qtyInputs = document.querySelectorAll('.form-control[name="qty"]');
    const discountPercentInputs = document.querySelectorAll('.form-control[name="discount_percent"]');
    const discountPriceInputs = document.querySelectorAll('.form-control[name="discount_price"]');
    const finalPriceInputs = document.querySelectorAll('.form-control[name="final_price"]');
    const paidInputs = document.querySelectorAll('.form-control[name="paid"]');
    const remnantInputs = document.querySelectorAll('.form-control[name="remnant"]');
    const totalPriceSatuanInput = document.getElementById('totalPriceSatuan');
    const totalDiscountPriceInput = document.getElementById('totalDiscountPrice');
    const totalInput = document.getElementById('total');
    const totalPaidInput = document.getElementById('totalPaid');
    const totalRemnantInput = document.getElementById('totalRemnant');

    const formatter = new Intl.NumberFormat('id-ID', {
      style: 'currency',
      currency: 'IDR'
    });

    function formatCurrencyAndFinalPrice(input) {
      input.value = formatter.format(input.value.replace(/[^\d]/g, '')).replace(',00', '');
      updateFinalPrice(input);
    }

    function updateFinalPrice(input) {
      const parentRow = input.closest('tr');
      const priceSatuanInput = parentRow.querySelector('.form-control[name="price_satuan"]');
      const qtyInput = parentRow.querySelector('.form-control[name="qty"]');
      const discountPercentInput = parentRow.querySelector('.form-control[name="discount_percent"]');
      const discountPriceInput = parentRow.querySelector('.form-control[name="discount_price"]');
      const finalPriceInput = parentRow.querySelector('.form-control[name="final_price"]');
      const paidInput = parentRow.querySelector('.form-control[name="paid"]');
      const remnantInput = parentRow.querySelector('.form-control[name="remnant"]');

      let priceSatuan = parseFloat(priceSatuanInput.value.replace(/[^\d]/g, '')) || 0;
      let qty = parseFloat(qtyInput.value) || 0;
      let discountPercent = parseFloat(discountPercentInput.value) || 0;
      let paid = parseFloat(paidInput.value.replace(/[^\d]/g, '')) || 0;

      const discountPrice = (priceSatuan * discountPercent) / 100;
      const finalPrice = priceSatuan - discountPrice;

      if (paid > finalPrice) {
        paid = finalPrice;
        paidInput.value = formatter.format(paid).replace(',00', '');
      }

      const remnant = finalPrice - paid;

      discountPriceInput.value = formatter.format(discountPrice).replace(',00', '');
      finalPriceInput.value = formatter.format(finalPrice).replace(',00', '');
      remnantInput.value = formatter.format(remnant).replace(',00', '');
      updateTotal();
    }

    function updateTotal() {
      let totalPriceSatuan = 0;
      priceSatuanInputs.forEach((input, index) => {
        if (index > 0) {
          totalPriceSatuan += parseFloat(input.value.replace(/[^\d]/g, '') || 0);
        }
      });
      totalPriceSatuanInput.value = formatter.format(totalPriceSatuan).replace(',00', '');

      let totalDiscountPrice = 0;
      discountPriceInputs.forEach((input, index) => {
        if (index > 0) {
          totalDiscountPrice += parseFloat(input.value.replace(/[^\d]/g, '') || 0);
        }
      });
      totalDiscountPriceInput.value = formatter.format(totalDiscountPrice).replace(',00', '');

      let total = 0;
      finalPriceInputs.forEach((input, index) => {
        if (index > 0) {
          total += parseFloat(input.value.replace(/[^\d]/g, '') || 0);
        }
      });
      totalInput.value = formatter.format(total).replace(',00', '');

      let totalPaid = 0;
      paidInputs.forEach((input, index) => {
        if (index > 0) {
          totalPaid += parseFloat(input.value.replace(/[^\d]/g, '') || 0);
        }
      });
      totalPaidInput.value = formatter.format(totalPaid).replace(',00', '');

      let totalRemnant = 0;
      remnantInputs.forEach((input, index) => {
        if (index > 0) {
          totalRemnant += parseFloat(input.value.replace(/[^\d]/g, '') || 0);
        }
      });
      totalRemnantInput.value = formatter.format(totalRemnant).replace(',00', '');
    }

    priceSatuanInputs.forEach(formatCurrencyAndFinalPrice);
    discountPriceInputs.forEach(formatCurrencyAndFinalPrice);
    finalPriceInputs.forEach(formatCurrencyAndFinalPrice);
    paidInputs.forEach(formatCurrencyAndFinalPrice);
    remnantInputs.forEach(formatCurrencyAndFinalPrice);

    priceSatuanInputs.forEach(input => {
      input.addEventListener('input', function() { formatCurrencyAndFinalPrice(this); });
    });
    qtyInputs.forEach(input => {
      input.addEventListener('input', function() { updateFinalPrice(this); });
    });
    discountPercentInputs.forEach(input => {
      input.addEventListener('input', function() { updateFinalPrice(this); });
    });
    paidInputs.forEach(input => {
      input.addEventListener('input', function() { formatCurrencyAndFinalPrice(this); });
    });
  });
</script>
@endpush